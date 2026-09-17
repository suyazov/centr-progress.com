<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2517-ED5A78A145A8 -->
- Result: The named occupational-safety course renders one copy when its stored curriculum contains two identical tables.
- Current state: The public course template extracts one complete verified curriculum table for the specified course, including historical nested or serialized Bitrix values; unrelated courses remain unchanged.
- Next action: Merge the verified scoped change and perform the separately authorized production deployment with live read-back.

<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2553-58CFA5EECC39 -->
- Result: Pasted content tables inside the .Content workarea render with uniform site typography; foreign inline font-family, font-size and line-height declarations on cells and nested elements (span, p, font) are normalized in all four mirrored stylesheets.
- Current state: The typography-only correction and its PHP regression contract passed independent semantic review and the required verify check. PR #33 merged into the repository as 32bdc4c2257d0967051642858ea21aa5a0b0c6ec; Bridge task #2553 reached VERIFIED_DONE. Client production was not changed.
- Next action: If the site change should go live, authorize a separate production deployment with exact target and live read-back.

<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2576-A15AA20A20CD -->
- Result: The two mirrored reviews entrypoints order records by ascending Bitrix SORT and then descending ACTIVE_FROM; the supported city sequence is Ставрополь, then Кисловодск, then Пятигорск.
- Current state: Repository code and its regression contract enforce the ordering rule. Content delivery remains outside this repository-only task and does not alter production-managed records.
- Provider obligation: Before a separately authorized content publication, the Bitrix content provider must assign ascending SORT bands to the review records: Ставрополь first, Кисловодск second, Пятигорск third; newer ACTIVE_FROM wins only within an equal SORT band.
- Evidence: instruction.12 is implemented as SORT ascending in both entrypoints; instruction.13 is implemented as ACTIVE_FROM descending tie-breaker in both entrypoints; instruction.14 is covered by the regression test that asserts both mirrored entrypoints use that exact pair.
- Next action: Obtain separate content/deployment authority, assign those SORT values in Bitrix, and perform a live read-back.
