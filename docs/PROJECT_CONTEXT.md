<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2517-ED5A78A145A8 -->
- Result: The named occupational-safety course renders one copy when its stored curriculum contains two identical tables.
- Current state: PR #30 merged on 14.09.2026. The separately authorized production task #2522 reached VERIFIED_DONE; live read-back then returned HTTP 200 and one complete curriculum table totaling 16 hours. This is a historical verification, not a fresh read of today's site.
- Next action: For any new course change, recheck the exact production element and current repository head before editing.

<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2553-58CFA5EECC39 -->
- Result: Pasted content tables inside the .Content workarea render with uniform site typography; foreign inline font-family, font-size and line-height declarations on cells and nested elements (span, p, font) are normalized in all four mirrored stylesheets.
- Current state: The typography-only correction and its PHP regression contract passed independent semantic review and the required verify check. PR #33 merged into the repository as 32bdc4c2257d0967051642858ea21aa5a0b0c6ec; Bridge task #2553 reached VERIFIED_DONE. Client production was not changed.
- Next action: If the site change should go live, authorize a separate production deployment with exact target and live read-back.

<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2707-8C0A823D24A8 -->
- Result: Client request verified against the repository: course prices are rendered from Bitrix iblock properties, and every template maps them consistently — PRICE to "Очно", DISTANSE_PRICE to "Дистанционно", DIST_PRICE to "Очная с применением электронного обучения" — in bitrix/templates and its public_html mirror (catalog.element, catalog.section table and related). No repository defect swaps or mislabels the очно/дистанционно values; no price is hardcoded anywhere in the codebase.
- Current state: The requested values (очно 18000 ₽, дистанционное 15000 ₽) live in the Bitrix database as element property values, i.e. production content outside repository scope. This task changes no code because no code cause is confirmed; the finding is recorded here as the repository artifact.
- Next action: An authorized editor updates the course element properties in the Bitrix admin (PRICE = 18000, DISTANSE_PRICE = 15000) under a separate production-content authority; no deployment or code change is required.

## Historical production handoff — contacts form, 26.08.2026

- The old `/kontakty/` form was connected to Bitrix24. Name, phone and consent validation were added.
- The Bitrix24 open line was configured with off-hours and busy auto-replies. Exact customer-facing text and account access remain outside Git.
- The site code was pushed as commit `43faf49ea63c3760a69e319537ecabdc2e6f93a8`, but that commit is not an ancestor of current `main`. A subsequent production/repository reconciliation is needed before changing the form; this note does not claim the current live form still matches the old session.

## Direct Bitrix24 repairs — 01.10.2026

- Owner explicitly authorized direct Codex execution without Bridge, then separately authorized production updates limited to templates 94 and 54 and test document generation.
- Invoice template 94 now uses native PaymentQrCode instead of a static 5000 RUB image. IP act template 54 now reads IP surname/name/patronymic instead of RQ_DIRECTOR, which is absent from the IP preset.
- Fresh originals matched protected backups before upload. Production read-back matched the candidates canonically; ID, names, permissions, sort, bindings, numerator and other settings stayed unchanged.
- Live document 12160 encoded 1500 RUB and document 12162 encoded 2500 RUB. QR recipient and banking fields matched the original Kislovodsk code. Document 12164 rendered a synthetic full IP signer name. All three are private test documents in existing deal 66 “Тестовая”; its data remained unchanged.
- INN lookup was already working in the verified unsaved scenario: use the search field, lookup button and company selection. Ordinary RQ_INN entry alone did not fill names.
- Existing customer documents, customer records, payments, banking settings, regional template 72 and the site were not changed. The exact template/requisite behind complaint 128 remains unconfirmed; the proven defect in general template 54 is fixed.
- Evidence, operator instructions, protected backups, read-back hashes and rollback: docs/BITRIX24_DIAGNOSTICS.md. Offline repair utility: tools/b24_template_repair.py. No secrets or client DOCX are stored in Git.
- Next action: generate new customer documents with the corrected templates and filled IP requisites; investigate any recurrence against the exact template, requisite and INN. Historical incorrect documents require a separate owner decision.

## Regional documents — 01.10.2026, pending production scope

- Progress meeting `_avWH_9kaF` / node `dt448AS8QZcPYOPrYmyoN` is under AFFiNE `Сказка / 03 Встречи / 2026 / Сентябрь`. No relocation or registry row confirmed.
- Latest 23.09 Gmail contract examples match adapted templates 80, 82 and 88; all three are inactive. No contract files replaced in this stage; enabling is proposed.
- Static QR confirmed in invoices 70 (14000 RUB), 84/86/92 (5000 RUB), 96 (17000 RUB). Native PaymentQrCode candidates prepared and checked offline. Source banking fields match original 94.
- Concrete pending package: enable three contracts, update five invoices, sort city sets 9/6/9, prefix Stavropol labels, retain DOT64 separately, disable old invoice68 with undecodable JPEG QR. Earlier live repairs94/54 remain completed; expanded scope not applied.
- Evidence: docs/BITRIX24_DIAGNOSTICS.md; protected originals, candidates and exact plan outside Git.
- Next: exact owner approval for expanded production package, then targeted read-back/private synthetic tests. Corporate mailbox names/count and DNS authority remain unspecified. Leader handles old deal reconciliation.
