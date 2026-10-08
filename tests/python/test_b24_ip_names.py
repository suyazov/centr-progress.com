import importlib.util
from pathlib import Path
import unittest
import tempfile
import json
from unittest.mock import patch

spec=importlib.util.spec_from_file_location('ip_names',Path(__file__).parents[2]/'tools/b24_ip_names.py')
m=importlib.util.module_from_spec(spec);spec.loader.exec_module(m)

class Names(unittest.TestCase):
    def row(self):
        return {'ID':'1','ENTITY_TYPE_ID':'4','PRESET_ID':'3','ACTIVE':'Y','ADDRESS_ONLY':'N',
                'RQ_INN':'123456789012','RQ_LAST_NAME':'Тестов','RQ_FIRST_NAME':'Тест',
                'RQ_SECOND_NAME':'','RQ_COMPANY_NAME':'','RQ_COMPANY_FULL_NAME':''}
    def test_missing_names_and_preserved_existing(self):
        r=self.row();fields=m.missing_names(r)
        self.assertEqual(fields['RQ_COMPANY_NAME'],'ИП Тестов Тест')
        r['RQ_COMPANY_NAME']='Проверенное наименование'
        self.assertEqual(set(m.missing_names(r)),{'RQ_COMPANY_FULL_NAME'})
        r['RQ_COMPANY_FULL_NAME']='Заполнено';self.assertEqual(m.missing_names(r),{})
    def test_wrong_presets_incomplete_names_and_legal_entities(self):
        for key,value in [('PRESET_ID','1'),('ENTITY_TYPE_ID','2'),('ACTIVE','N'),
                          ('ADDRESS_ONLY','Y'),('RQ_INN','123'),('RQ_LAST_NAME',''),('RQ_FIRST_NAME','')]:
            r=self.row();r[key]=value;self.assertEqual(m.missing_names(r),{})
    def test_readonly_default_and_verified_two_field_write(self):
        r=self.row();calls=[]
        def api(method,params):
            calls.append((method,params))
            if method.endswith('.get'):return dict(r)
            r.update(params['fields']);return True
        self.assertEqual(m.repair(api,1)['state'],'PREVIEW')
        self.assertFalse(any(method.endswith('.update') for method,_ in calls))
        self.assertEqual(m.repair(api,1,apply=True)['state'],'VERIFIED')
        updates=[p['fields'] for method,p in calls if method.endswith('.update')]
        self.assertEqual(len(updates),1);self.assertEqual(set(updates[0]),{'RQ_COMPANY_NAME','RQ_COMPANY_FULL_NAME'})
        self.assertEqual(m.repair(api,1,apply=True)['state'],'UNCHANGED')
    def test_race_and_ambiguous_write_do_not_retry(self):
        count=0
        def changed(method,params):
            nonlocal count
            count+=1;r=self.row()
            if count==2:r['RQ_COMPANY_NAME']='Новое имя'
            if method.endswith('.update'):self.fail('must not update changed record')
            return r
        with self.assertRaisesRegex(ValueError,'record_changed'):m.repair(changed,1,apply=True)
        writes=[]
        def failed(method,params):
            if method.endswith('.update'):writes.append(params);raise TimeoutError()
            return self.row()
        with self.assertRaises(TimeoutError):m.repair(failed,1,apply=True)
        self.assertEqual(len(writes),1)

    def test_poll_activation_excludes_history_and_fills_only_new(self):
        old=self.row();old['ID']='100';new=self.row();new['ID']='101';records={'100':old,'101':new}
        seen=[]
        def api(method,params):
            if method.endswith('.list'):
                if '>ID' not in params['filter']:return [{'ID':'100'}]
                return [{'ID':k} for k in records if int(k)>int(params['filter']['>ID'])]
            r=records[str(params['id'])]
            if method.endswith('.get'):return dict(r)
            seen.append(params['id']);r.update(params['fields']);return True
        with tempfile.TemporaryDirectory() as d,patch.object(m,'STATE',Path(d)):
            m.poll(api,initialize=True)
            self.assertEqual(m.poll(api)['updated'],1)
            self.assertEqual(seen,[101]);self.assertEqual(old['RQ_COMPANY_NAME'],'')
            self.assertEqual(m.poll(api)['updated'],0)
    def test_poll_does_not_replay_uncertain_update_after_restart(self):
        record=self.row();record['ID']='101';writes=[]
        def api(method,params):
            if method.endswith('.list'):return [{'ID':'101'}]
            if method.endswith('.get'):return dict(record)
            writes.append(params);raise TimeoutError()
        with tempfile.TemporaryDirectory() as d,patch.object(m,'STATE',Path(d)):
            (Path(d)/'cursor.json').write_text(json.dumps({'cursor':100,'pending':{}}))
            with self.assertRaises(TimeoutError):m.poll(api)
            m.poll(api)
            self.assertEqual(len(writes),1)

if __name__=='__main__':unittest.main()
