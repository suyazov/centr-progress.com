<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2517-ED5A78A145A8 -->
- Result: The named occupational-safety course renders one copy when its stored curriculum contains two identical tables.
- Current state: The public course template extracts one complete verified curriculum table for the specified course, including historical nested or serialized Bitrix values; unrelated courses remain unchanged.
- Next action: Merge the verified scoped change and perform the separately authorized production deployment with live read-back.

<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2553-58CFA5EECC39 -->
- Result: Pasted content tables inside the .Content workarea render with uniform site typography; foreign inline font-family, font-size and line-height declarations on cells and nested elements (span, p, font) are normalized in all four mirrored stylesheets.
- Current state: The typography-only correction and its PHP regression contract passed independent semantic review and the required verify check. PR #33 merged into the repository as 32bdc4c2257d0967051642858ea21aa5a0b0c6ec; Bridge task #2553 reached VERIFIED_DONE. Client production was not changed.
- Next action: If the site change should go live, authorize a separate production deployment with exact target and live read-back.
