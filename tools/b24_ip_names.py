"""Fill missing names of Russian IP requisites; default is a read-only preview.

Uses the owner's existing protected portal login, never creates API credentials.
Only the fixed portal and its verified IP preset (3) are supported.
"""
from __future__ import annotations
import argparse
import json
import os
import re
import time
from pathlib import Path

PORTAL = 'https://anoucdpoprogress.bitrix24.ru'
ACCESS = Path('/root/.config/client-access/centr-progress.com/bitrix24.env')
STATE = Path('/var/lib/centr-progress-ip-names')
SELECT = ['ID', 'ENTITY_TYPE_ID', 'ENTITY_ID', 'PRESET_ID', 'NAME', 'ACTIVE',
          'ADDRESS_ONLY', 'RQ_INN', 'RQ_FIRST_NAME', 'RQ_LAST_NAME',
          'RQ_SECOND_NAME', 'RQ_COMPANY_NAME', 'RQ_COMPANY_FULL_NAME']


def missing_names(row):
    if (str(row.get('PRESET_ID')) != '3' or str(row.get('ENTITY_TYPE_ID')) not in {'3', '4'}
            or row.get('ACTIVE') != 'Y' or row.get('ADDRESS_ONLY') == 'Y'
            or not re.fullmatch(r'[0-9]{12}', str(row.get('RQ_INN', '')))):
        return {}
    parts = [str(row.get(k) or '').strip() for k in
             ('RQ_LAST_NAME', 'RQ_FIRST_NAME', 'RQ_SECOND_NAME')]
    if not parts[0] or not parts[1] or any(len(p) > 100 or '\n' in p or '\r' in p for p in parts):
        return {}
    full_name = ' '.join(p for p in parts if p)
    values = {'RQ_COMPANY_NAME': 'ИП ' + full_name,
              'RQ_COMPANY_FULL_NAME': 'Индивидуальный предприниматель ' + full_name}
    return {k: v for k, v in values.items() if not str(row.get(k) or '').strip()}


def repair(api, record_id, *, apply=False):
    before = api('crm.requisite.get', {'id': int(record_id)})
    fields = missing_names(before)
    if not fields or not apply:
        return {'id': int(record_id), 'state': 'PREVIEW' if fields else 'UNCHANGED',
                'fields': sorted(fields)}
    fresh = api('crm.requisite.get', {'id': int(record_id)})
    if fresh != before:
        raise ValueError('record_changed_before_write')
    # Update only the two verified blank names; no automatic retry of writes.
    api('crm.requisite.update', {'id': int(record_id), 'fields': fields})
    after = api('crm.requisite.get', {'id': int(record_id)})
    if any(after.get(k) != v for k, v in fields.items()):
        raise ValueError('name_readback_failed')
    return {'id': int(record_id), 'state': 'VERIFIED', 'fields': sorted(fields)}


class Portal:
    def __enter__(self):
        from playwright.sync_api import sync_playwright
        access = {k: v.strip().strip('\"\'') for line in ACCESS.read_text().splitlines()
                  if '=' in line and not line.lstrip().startswith('#')
                  for k, v in [line.split('=', 1)]}
        if 'https://' + access['CENTR_PROGRESS_B24_PORTAL'].removeprefix('https://').rstrip('/') != PORTAL:
            raise ValueError('portal_identity_invalid')
        self.pw = sync_playwright().start()
        self.browser = self.pw.chromium.launch(executable_path='/usr/local/bin/chromium',
                                             headless=True, args=['--no-sandbox'])
        self.page = self.browser.new_page()
        try:
            self.page.goto(PORTAL, wait_until='domcontentloaded')
            self.page.locator('#login').fill(access['CENTR_PROGRESS_B24_LOGIN'])
            self.page.get_by_role('button', name='Продолжить', exact=True).click()
            self.page.locator('input[type=password]').fill(access['CENTR_PROGRESS_B24_PASSWORD'])
            self.page.get_by_role('button', name='Продолжить', exact=True).click()
            self.page.wait_for_url(PORTAL + '/**', wait_until='domcontentloaded', timeout=30000)
        except Exception:
            self.browser.close(); self.pw.stop()
            raise ValueError('portal_login_failed') from None
        return self

    def __exit__(self, *args):
        self.browser.close(); self.pw.stop()

    def __call__(self, method, params):
        allowed = {'crm.requisite.get', 'crm.requisite.list', 'crm.requisite.update'}
        if method not in allowed or not self.page.url.startswith(PORTAL + '/'):
            raise ValueError('method_or_portal_invalid')
        try:
            result = self.page.evaluate('''async({method,params})=>{
                const r=await fetch('/rest/'+method+'.json?'+new URLSearchParams({sessid:BX.bitrix_sessid()}),
                  {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(params)});
                return await r.json();}''', {'method': method, 'params': params})
        except Exception:
            raise ValueError('portal_transport_failed') from None
        if result.get('error') or 'result' not in result:
            raise ValueError('portal_method_failed')
        return result['result']


def poll(api, *, initialize=False):
    """Only new IP records after the explicit activation boundary; no backfill."""
    STATE.mkdir(mode=0o700, parents=True, exist_ok=True)
    checkpoint = STATE / 'cursor.json'
    if initialize:
        if checkpoint.exists():
            raise ValueError('already_initialized')
        rows = api('crm.requisite.list', {'filter': {'PRESET_ID': 3},
                   'order': {'ID': 'DESC'}, 'select': ['ID'], 'start': 0})
        cursor = max((int(r['ID']) for r in rows), default=0)
        checkpoint.write_text(json.dumps({'cursor': cursor, 'pending': {}}))
        return {'state': 'INITIALIZED', 'cursor': cursor}
    if not checkpoint.exists():
        raise ValueError('activation_boundary_missing')
    state = json.loads(checkpoint.read_text())
    rows = api('crm.requisite.list', {'filter': {'PRESET_ID': 3, '>ID': state['cursor']},
               'order': {'ID': 'ASC'}, 'select': ['ID'], 'start': 0})
    now = int(time.time())
    for row in rows:
        rid = int(row['ID'])
        state['pending'].setdefault(str(rid), now)
        state['cursor'] = max(state['cursor'], rid)
    verified = 0
    for rid, first_seen in list(state['pending'].items()):
        before = api('crm.requisite.get', {'id': int(rid)})
        fields = missing_names(before)
        if not fields:
            # Incomplete new entries may acquire their INN/FIO shortly after creation.
            if (before.get('RQ_COMPANY_NAME') and before.get('RQ_COMPANY_FULL_NAME')) or now-first_seen > 1800:
                del state['pending'][rid]
            continue
        operation = STATE / f'operation-{rid}.json'
        if operation.exists():
            saved = json.loads(operation.read_text())
            if saved['state'] == 'SENDING':
                # An interrupted write is never replayed; only resolve by read-back.
                if all(before.get(k) == v for k, v in saved['fields'].items()):
                    operation.write_text(json.dumps({'state': 'VERIFIED'}))
                    del state['pending'][rid]
                continue
        backup = STATE / f'{rid}-{time.time_ns()}.json'
        backup.write_text(json.dumps(before, ensure_ascii=False))
        operation.write_text(json.dumps({'state': 'SENDING', 'fields': fields}, ensure_ascii=False))
        receipt = repair(api, rid, apply=True)
        operation.write_text(json.dumps({'state': receipt['state']}))
        if receipt['state'] == 'VERIFIED':
            verified += 1
        del state['pending'][rid]
    staged = STATE / 'cursor.next'
    staged.write_text(json.dumps(state))
    staged.replace(checkpoint)
    return {'state': 'POLL_VERIFIED', 'updated': verified, 'pending': len(state['pending'])}


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--record-id', type=int)
    parser.add_argument('--poll', action='store_true')
    parser.add_argument('--initialize', action='store_true')
    parser.add_argument('--apply', action='store_true')
    args = parser.parse_args()
    if sum((args.record_id is not None, args.poll, args.initialize)) != 1:
        parser.error('choose record-id, poll or initialize')
    if args.record_id is not None and args.record_id <= 0:
        parser.error('record-id must be positive')
    os.umask(0o077)
    try:
        with Portal() as api:
            if args.poll or args.initialize:
                receipt = poll(api, initialize=args.initialize)
                print(json.dumps(receipt))
                return
            if args.apply:
                STATE.mkdir(mode=0o700, parents=True, exist_ok=True)
                # Preserve the exact pre-write state privately, never in Git/output.
                backup = STATE / f'{args.record_id}-{time.time_ns()}.json'
                backup.write_text(json.dumps(api('crm.requisite.get', {'id': args.record_id}), ensure_ascii=False))
            receipt = repair(api, args.record_id, apply=args.apply)
        print(json.dumps(receipt))
    except Exception:
        print('{"state":"FAILED_REQUIRES_REVIEW"}')
        raise SystemExit(1) from None


if __name__ == '__main__':
    main()
