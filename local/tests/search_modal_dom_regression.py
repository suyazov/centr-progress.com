#!/usr/bin/env python3
"""Browser regression for the production course DOM with local modal assets."""

import base64
import json
import os
from pathlib import Path
import subprocess
import sys
import time
import urllib.request

import websocket


ROOT = Path(__file__).resolve().parents[2]
URL = os.environ.get(
    "COURSE_URL",
    "https://centr-progress.com/napravleniya-obucheniya/professionalnoe-obuchenie/lifter/",
)
EXPECTED = "Лифтер 1-2 разряд"
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
        if devtools.evaluate(expression):
            return
        time.sleep(0.25)
    raise AssertionError(f"Timed out waiting for: {expression}")


def browser_qa(devtools, width, height, label, css, javascript):
    devtools.command(
        "Emulation.setDeviceMetricsOverride",
        {"width": width, "height": height, "deviceScaleFactor": 1, "mobile": width < 768},
    )
    devtools.command("Page.navigate", {"url": URL})
    wait_for(devtools, "document.readyState === 'complete'")
    wait_for(devtools, "window.jQuery && document.querySelector('.PopupSearch')")

    devtools.evaluate(
        """(() => {
            window.jQuery('.SearchPopup,.SearchClose').off('click');
            const style=document.createElement('style');
            style.id='task-812-local-css';
            style.textContent=%s;
            document.head.appendChild(style);
            (0,eval)(%s);
            return true;
        })()""" % (json.dumps(css), json.dumps(javascript))
    )
    time.sleep(0.5)

    initial = devtools.evaluate(
        """(() => {
            window.scrollTo(0, 500);
            const target=document.querySelector('.TopPanel');
            const rect=target.getBoundingClientRect();
            return {scrollY, bodyStyle:document.body.getAttribute('style'), rect:[rect.top,rect.bottom]};
        })()"""
    )
    devtools.evaluate("document.querySelector('.SearchPopup').click()")
    time.sleep(0.2)
    devtools.evaluate(
        """(() => {
            document.querySelectorAll('div.title-search-result').forEach(node=>node.remove());
            const result=document.createElement('div');
            result.className='title-search-result';
            result.style.display='block';
            result.innerHTML='<a href="/napravleniya-obucheniya/professionalnoe-obuchenie/lifter/">%s</a>';
            document.body.appendChild(result);
            const input=document.querySelector('#title-search-input');
            input.value='лифт';
            input.dispatchEvent(new Event('input',{bubbles:true}));
        })()""" % EXPECTED
    )
    time.sleep(0.2)

    opened = devtools.evaluate(
        """(() => {
            const popup=document.querySelector('.PopupSearch');
            const rect=popup.getBoundingClientRect();
            const style=getComputedStyle(popup);
            const under=document.querySelector('.TopPanel');
            const result=popup.querySelector('div.title-search-result');
            const link=[...(result?.querySelectorAll('a')||[])].find(a=>a.textContent.trim()===%s);
            let clicked=false;
            link?.addEventListener('click',event=>{event.preventDefault();clicked=true},{once:true});
            link?.click();
            return {
                position:style.position,
                rect:[rect.left,rect.top,rect.right,rect.bottom],
                viewport:[innerWidth,innerHeight],
                opaque:style.backgroundColor==='rgb(255, 255, 255)',
                resultInside:!!result && result.parentElement===popup.querySelector('.Search'),
                resultVisible:!!result && result.getClientRects().length>0 && getComputedStyle(result).visibility==='visible',
                resultRight:result?.getBoundingClientRect().right,
                linkText:link?.textContent.trim()||null,
                linkClicked:clicked,
                underPointer:getComputedStyle(under).pointerEvents,
                underInert:under.closest('body > *')?.inert===true,
                bodyLocked:getComputedStyle(document.body).position==='fixed'
            };
        })()""" % json.dumps(EXPECTED)
    )

    assert opened["position"] == "fixed", opened
    assert opened["rect"][0] <= 0 and opened["rect"][1] <= 0, opened
    assert opened["rect"][2] >= opened["viewport"][0], opened
    assert opened["rect"][3] >= opened["viewport"][1], opened
    assert opened["opaque"] and opened["resultInside"] and opened["resultVisible"], opened
    assert opened["resultRight"] <= opened["viewport"][0], opened
    assert opened["linkText"] == EXPECTED and opened["linkClicked"], opened
    assert opened["underPointer"] == "none" and opened["underInert"], opened
    assert opened["bodyLocked"], opened

    screenshot = devtools.command("Page.captureScreenshot", {"format": "png"})["data"]
    evidence = ROOT / "local" / "tests" / "evidence"
    evidence.mkdir(exist_ok=True)
    (evidence / f"search-modal-{label}.png").write_bytes(base64.b64decode(screenshot))

    devtools.evaluate("document.querySelector('.SearchClose').click()")
    time.sleep(0.2)
    closed = devtools.evaluate(
        """(() => {const r=document.querySelector('.TopPanel').getBoundingClientRect();
        return {scrollY,bodyStyle:document.body.getAttribute('style'),rect:[r.top,r.bottom],open:document.body.classList.contains('PopupSearchOpen')};})()"""
    )
    assert not closed["open"] and abs(closed["scrollY"] - initial["scrollY"]) <= 1, closed
    assert closed["bodyStyle"] == initial["bodyStyle"] and closed["rect"] == initial["rect"], closed

    devtools.evaluate("document.querySelector('.SearchPopup').click()")
    time.sleep(0.1)
    devtools.evaluate("document.dispatchEvent(new KeyboardEvent('keydown',{key:'Escape',bubbles:true}))")
    time.sleep(0.2)
    escaped = devtools.evaluate(
        """(() => ({scrollY,bodyStyle:document.body.getAttribute('style'),open:document.body.classList.contains('PopupSearchOpen')}))()"""
    )
    assert not escaped["open"] and abs(escaped["scrollY"] - initial["scrollY"]) <= 1, escaped
    assert escaped["bodyStyle"] == initial["bodyStyle"], escaped
    print(f"{label}: passed")


def main():
    css = (ROOT / "bitrix/templates/template/template_styles.css").read_text()
    javascript = (ROOT / "bitrix/templates/template/js/scripts-min.js").read_text()
    temp_root = ROOT / ".codex-tmp"
    profile = temp_root / "chrome-regression"
    profile.mkdir(parents=True, exist_ok=True)
    # /proc keeps Chromium's singleton socket short while all files stay in this worktree.
    short_root = f"/proc/{os.getpid()}/cwd/.codex-tmp"
    port = 9231
    env = os.environ.copy()
    env["NO_PROXY"] = "127.0.0.1,localhost"
    env["TMPDIR"] = short_root
    process = subprocess.Popen(
        [
            "chromium-browser", "--headless=new", "--no-sandbox", "--disable-gpu",
            "--disable-crash-reporter", "--disable-background-networking",
            "--remote-debugging-address=127.0.0.1", f"--remote-debugging-port={port}",
            f"--user-data-dir={short_root}/chrome-regression", "about:blank",
        ],
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
            browser_qa(devtools, width, height, label, css, javascript)
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
