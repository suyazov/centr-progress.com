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

- The old `/kontakty/` form was connected to the shared Bitrix24 handler instead of its missing endpoint. Name, phone and consent validation were added. Desktop and mobile checks passed; no test deal was created.
- The Bitrix24 open line was configured with weekday business hours and off-hours/busy auto-replies. Exact customer-facing text and account access remain outside Git.
- The site code was pushed as commit `43faf49ea63c3760a69e319537ecabdc2e6f93a8`, but that commit is not an ancestor of current `main`. A subsequent production/repository reconciliation is needed before changing the form; this note does not claim the current live form still matches the old session.
