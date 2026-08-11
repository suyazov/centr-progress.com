#!/usr/bin/env python3
"""Fail-closed browser regression against unmodified, server-delivered assets."""

import base64
import hashlib
import json
import os
from pathlib import Path
import subprocess
import time
import urllib.request

import websocket


ROOT = Path(__file__).resolve().parents[2]
URL = os.environ.get(
    "COURSE_URL",
    "https://centr-progress.com/napravleniya-obucheniya/professionalnoe-obuchenie/lifter/",
)
EXPECTED = "Лифтер 1-2 разряд"
EXPECTED_HREF = "/napravleniya-obucheniya/professionalnoe-obuchenie/lifter/lifter-1-2-razryad/"
TERMS = ("лиф", "лифт", "тепл")
VIEWPORTS = ((1440, 900, "desktop"), (390, 844, "mobile"))


class DevTools:
    def __init__(self, port):
        targets = json.load(urllib.request.urlopen(f"http://127.0.0.1:{port}/json"))
        page = next(item for item in targets if item["type"] == "page")
        self.ws = websocket.create_connection(
            page["webSocketDebuggerUrl"], timeout=30, suppress_origin=True
        )
        self.counter = 0

    def command(self, method, params=None):
        self.counter += 1
        request_id = self.counter
        self.ws.send(json.dumps({"id": request_id, "method": method, "params": params or {}}))
        while True:
            message = json.loads(self.ws.recv())
            if message.get("id") == request_id:
                if "error" in message:
                    raise RuntimeError(message["error"])
                return message.get("result", {})

    def evaluate(self, expression):
        response = self.command(
            "Runtime.evaluate",
            {"expression": expression, "returnByValue": True, "awaitPromise": True},
        )
        result = response["result"]
        if result.get("subtype") == "error":
            raise RuntimeError(result.get("description", "browser evaluation failed"))
        return result.get("value")


def wait_for(devtools, expression, timeout=30):
    deadline = time.time() + timeout
    while time.time() < deadline:
        value = devtools.evaluate(expression)
        if value:
            return value
        time.sleep(0.25)
    raise AssertionError(f"Timed out waiting for: {expression}")


def production_assets(devtools):
    assets = devtools.evaluate(
        """(() => ({
            css:[...document.styleSheets].map(s=>s.href).filter(u=>u&&u.includes('/bitrix/cache/css/')),
            js:[...document.scripts].map(s=>s.src).filter(u=>u&&u.includes('/bitrix/cache/js/'))
        }))()"""
    )
    assert len(assets["css"]) == 1 and len(assets["js"]) == 1, assets
    evidence = {}
    for kind in ("css", "js"):
        url = assets[kind][0]
        with urllib.request.urlopen(url, timeout=30) as response:
            body = response.read()
        evidence[kind] = {"url": url, "bytes": len(body), "sha256": hashlib.sha256(body).hexdigest()}

        required = os.environ.get(f"EXPECTED_PRODUCTION_{kind.upper()}_SHA256")
        if os.environ.get("REQUIRE_PRODUCTION_ASSET_HASHES") == "1":
            assert required, f"missing EXPECTED_PRODUCTION_{kind.upper()}_SHA256"
        if required:
            assert evidence[kind]["sha256"] == required, evidence[kind]
    return evidence


def type_term(devtools, term):
    devtools.evaluate(
        """(() => {const input=document.querySelector('#title-search-input');
        input.focus(); input.select(); return document.activeElement===input;})()"""
    )
    devtools.command("Input.dispatchKeyEvent", {"type": "keyDown", "key": "Backspace"})
    devtools.command("Input.dispatchKeyEvent", {"type": "keyUp", "key": "Backspace"})
    devtools.command("Input.insertText", {"text": term})


def browser_qa(devtools, width, height, label):
    devtools.command(
        "Emulation.setDeviceMetricsOverride",
        {"width": width, "height": height, "deviceScaleFactor": 1, "mobile": width < 768},
    )
    devtools.command("Page.navigate", {"url": URL})
    wait_for(devtools, "document.readyState === 'complete'")
    wait_for(devtools, "window.jQuery && document.querySelector('.PopupSearch')")
    page_text = devtools.evaluate("document.body.innerText")
    assert "Профессиональное обучение «Лифтер 1-2 разряд»" in page_text
    assert "Internal Server Error" not in page_text and "Fatal error" not in page_text
    assets = production_assets(devtools)

    initial = devtools.evaluate(
        """(() => {window.scrollTo(0,500); const target=document.querySelector('.TopPanel');
        const r=target.getBoundingClientRect(); return {scrollY,bodyStyle:document.body.getAttribute('style'),rect:[r.top,r.bottom]};})()"""
    )
    devtools.evaluate("document.querySelector('.SearchPopup').click()")
    wait_for(devtools, "document.querySelector('.PopupSearch').getAttribute('aria-hidden') === 'false'")

    opened = devtools.evaluate(
        """(() => {const popup=document.querySelector('.PopupSearch'); const r=popup.getBoundingClientRect();
        const s=getComputedStyle(popup); const names=['.TopPanel','.HeaderBlock','.MainMenu','.Product','.Button','.Btn'];
        const background=names.map(selector=>document.querySelector(selector)).filter(Boolean);
        const hit=document.elementFromPoint(innerWidth/2,innerHeight/2);
        return {position:s.position,rect:[r.left,r.top,r.right,r.bottom],viewport:[innerWidth,innerHeight],
          opaque:s.backgroundColor==='rgb(255, 255, 255)' && Number(s.opacity)===1,
          bodyLocked:getComputedStyle(document.body).position==='fixed',
          backgrounds:background.map(el=>({selector:el.className,pointer:getComputedStyle(el).pointerEvents,
            inert:el.closest('body > *')?.inert===true})), hitInside:popup.contains(hit)};})()"""
    )
    assert opened["position"] == "fixed" and opened["opaque"] and opened["bodyLocked"], opened
    assert opened["rect"][0] <= 0 and opened["rect"][1] <= 0, opened
    assert opened["rect"][2] >= opened["viewport"][0] and opened["rect"][3] >= opened["viewport"][1], opened
    assert opened["hitInside"] and opened["backgrounds"], opened
    assert all(item["pointer"] == "none" and item["inert"] for item in opened["backgrounds"]), opened

    for term in TERMS:
        type_term(devtools, term)
        link = wait_for(
            devtools,
            """(() => {const links=[...document.querySelectorAll('.PopupSearch div.title-search-result a')];
            const a=links.find(node=>node.textContent.trim()===%s); if(!a||!a.getClientRects().length)return null;
            const result=a.closest('div.title-search-result');
            return {text:a.textContent.trim(),href:a.getAttribute('href'),pointer:getComputedStyle(a).pointerEvents,
              hasPayload:!!result?.querySelector('.bx_searche'),polluted:!!result?.querySelector('html,head,body,.TopPanel,.PopupSearch'),
              htmlBytes:new TextEncoder().encode(result?.innerHTML||'').length};})()"""
            % json.dumps(EXPECTED),
        )
        assert link["text"] == EXPECTED and link["href"] == EXPECTED_HREF, {"term": term, "link": link}
        assert link["pointer"] != "none" and link["hasPayload"] and not link["polluted"], {"term": term, "link": link}
        assert 0 < link["htmlBytes"] < 50000, {"term": term, "link": link}
        resources = devtools.evaluate(
            "performance.getEntriesByType('resource').map(r=>r.name).filter(u=>u.includes('ajax_call=y'))"
        )
        assert resources and any("/search/index.php" in item for item in resources), {"term": term, "resources": resources}

    screenshot = devtools.command("Page.captureScreenshot", {"format": "png"})["data"]
    evidence = ROOT / "local" / "tests" / "evidence"
    evidence.mkdir(exist_ok=True)
    (evidence / f"search-modal-{label}.png").write_bytes(base64.b64decode(screenshot))

    devtools.evaluate("document.querySelector('.SearchClose').click()")
    wait_for(devtools, "document.querySelector('.PopupSearch').getAttribute('aria-hidden') === 'true'")
    closed = devtools.evaluate(
        """(() => {const r=document.querySelector('.TopPanel').getBoundingClientRect(); return {
        scrollY,bodyStyle:document.body.getAttribute('style'),rect:[r.top,r.bottom],open:document.body.classList.contains('PopupSearchOpen')};})()"""
    )
    assert not closed["open"] and abs(closed["scrollY"] - initial["scrollY"]) <= 1, closed
    assert closed["bodyStyle"] == initial["bodyStyle"] and closed["rect"] == initial["rect"], closed

    devtools.evaluate("document.querySelector('.SearchPopup').click()")
    devtools.command("Input.dispatchKeyEvent", {"type": "keyDown", "key": "Escape", "code": "Escape"})
    devtools.command("Input.dispatchKeyEvent", {"type": "keyUp", "key": "Escape", "code": "Escape"})
    wait_for(devtools, "document.querySelector('.PopupSearch').getAttribute('aria-hidden') === 'true'")
    escaped = devtools.evaluate(
        """(() => ({scrollY,bodyStyle:document.body.getAttribute('style'),open:document.body.classList.contains('PopupSearchOpen')}))()"""
    )
    assert not escaped["open"] and abs(escaped["scrollY"] - initial["scrollY"]) <= 1, escaped
    assert escaped["bodyStyle"] == initial["bodyStyle"], escaped
    print(json.dumps({"viewport": label, "assets": assets}, ensure_ascii=False))


def main():
    temp_root = ROOT / ".codex-tmp"
    profile = temp_root / f"chrome-regression-{os.getpid()}"
    profile.mkdir(parents=True, exist_ok=True)
    short_root = f"/proc/{os.getpid()}/cwd/.codex-tmp"
    port = 9231
    env = os.environ.copy()
    env["NO_PROXY"] = "127.0.0.1,localhost"
    env["TMPDIR"] = short_root
    process = subprocess.Popen(
        ["chromium-browser", "--headless=new", "--no-sandbox", "--disable-gpu",
         "--disable-crash-reporter", "--disable-background-networking",
         "--remote-debugging-address=127.0.0.1", f"--remote-debugging-port={port}",
         f"--user-data-dir={short_root}/{profile.name}", "about:blank"],
        cwd=ROOT, env=env, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL,
    )
    try:
        deadline = time.time() + 15
        while time.time() < deadline:
            try:
                urllib.request.urlopen(f"http://127.0.0.1:{port}/json/version")
                break
            except Exception:
                time.sleep(0.2)
        else:
            raise RuntimeError("Chromium DevTools did not start")
        devtools = DevTools(port)
        for width, height, label in VIEWPORTS:
            browser_qa(devtools, width, height, label)
        devtools.ws.close()
    finally:
        process.terminate()
        try:
            process.wait(timeout=5)
        except subprocess.TimeoutExpired:
            process.kill()
    print("external-production-local-qa: passed")


if __name__ == "__main__":
    main()
