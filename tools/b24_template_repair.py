"""Prepare offline CRM template repairs; never connects to Bitrix24."""
import argparse
import hashlib
import io
import os
import posixpath
import zipfile
from pathlib import Path
from lxml import etree as ET
from PIL import Image

NS = {
    "w": "http://schemas.openxmlformats.org/wordprocessingml/2006/main",
    "wp": "http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing",
    "pic": "http://schemas.openxmlformats.org/drawingml/2006/picture",
    "a": "http://schemas.openxmlformats.org/drawingml/2006/main",
    "r": "http://schemas.openxmlformats.org/officeDocument/2006/relationships",
}
OLD_SIGNER = "{RequisiteRqDirector~Format=#LAST_NAME# #NAME_SHORT# #SECOND_NAME_SHORT#}"
NEW_SIGNER = "{RequisiteRqLastName} {RequisiteRqFirstName~Format=#NAME_SHORT#} {RequisiteRqSecondName~Format=#SECOND_NAME_SHORT#}"

def replace_text(root, old, new):
    count = 0
    for paragraph in root.findall(".//w:p", NS):
        nodes = paragraph.findall(".//w:t", NS)
        text = "".join(node.text or "" for node in nodes)
        if old not in text:
            continue
        if text.count(old) != 1:
            raise ValueError("Ambiguous signer placeholder in paragraph")
        start, end = text.index(old), text.index(old) + len(old)
        offset = 0
        inserted = False
        for node in nodes:
            original = node.text or ""
            left, right = offset, offset + len(original)
            offset = right
            if right <= start or left >= end:
                continue
            prefix = original[:max(0, start-left)]
            suffix = original[max(0, end-left):]
            node.text = prefix + (new if not inserted else "") + suffix
            node.set("{http://www.w3.org/XML/1998/namespace}space", "preserve")
            inserted = True
        count += 1
    if count != 1:
        raise ValueError(f"Expected one signer placeholder, got {count}")

def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("mode", choices=["qr", "signer"])
    parser.add_argument("source", type=Path)
    parser.add_argument("output", type=Path)
    parser.add_argument("--expected-sha256", required=True)
    parser.add_argument("--standard-invoice", type=Path)
    args = parser.parse_args()
    if args.output.exists() or args.output.resolve() == args.source.resolve():
        raise ValueError("Output must be a new file; original is never overwritten")
    data = args.source.read_bytes()
    if hashlib.sha256(data).hexdigest() != args.expected_sha256:
        raise ValueError("Source does not match reviewed template")
    src = zipfile.ZipFile(io.BytesIO(data))
    root = ET.fromstring(src.read("word/document.xml"))
    changed = {}
    if args.mode == "signer":
        replace_text(root, OLD_SIGNER, NEW_SIGNER)
    else:
        if not args.standard_invoice:
            raise ValueError("--standard-invoice required")
        drawings = root.findall(".//w:drawing", NS)
        if len(drawings) != 1:
            raise ValueError("Expected exactly one reviewed QR image")
        drawing = drawings[0]
        for node in drawing.findall(".//wp:docPr", NS) + drawing.findall(".//pic:cNvPr", NS):
            node.set("name", "{PaymentQrCode}")
            node.set("descr", "")
        rels = ET.fromstring(src.read("word/_rels/document.xml.rels"))
        rel_id = drawing.find(".//a:blip", NS).get("{"+NS["r"]+"}embed")
        rel = next(r for r in rels if r.get("Id") == rel_id)
        media = posixpath.normpath(posixpath.join("word", rel.get("Target")))
        if not media.endswith(".png"):
            raise ValueError("Expected the reviewed PNG image")
        standard = zipfile.ZipFile(args.standard_invoice)
        std_root = ET.fromstring(standard.read("word/document.xml"))
        std_drawing = next(d for d in std_root.findall(".//w:drawing", NS)
                           if any(n.get("name") == "{PaymentQrCode}"
                                  for n in d.findall(".//wp:docPr", NS)))
        std_id = std_drawing.find(".//a:blip", NS).get("{"+NS["r"]+"}embed")
        std_rels = ET.fromstring(standard.read("word/_rels/document.xml.rels"))
        std_rel = next(r for r in std_rels if r.get("Id") == std_id)
        std_media = posixpath.normpath(posixpath.join("word", std_rel.get("Target")))
        placeholder = io.BytesIO()
        Image.open(io.BytesIO(standard.read(std_media))).save(placeholder, format="PNG")
        changed[media] = placeholder.getvalue()
    changed["word/document.xml"] = ET.tostring(root, xml_declaration=True, encoding="UTF-8", standalone=True)
    fd = os.open(args.output, os.O_WRONLY | os.O_CREAT | os.O_EXCL, 0o600)
    with os.fdopen(fd, "wb") as handle, zipfile.ZipFile(handle, "w") as target:
        for item in src.infolist():
            target.writestr(item, changed.get(item.filename, src.read(item.filename)))
    print("Prepared", args.mode, "candidate; changed:", ", ".join(sorted(changed)))

if __name__ == "__main__":
    main()
