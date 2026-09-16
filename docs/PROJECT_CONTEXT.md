<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2517-ED5A78A145A8 -->
- Result: The named occupational-safety course renders one copy when its stored curriculum contains two identical tables.
- Current state: The public course template extracts one complete verified curriculum table for the specified course, including historical nested or serialized Bitrix values; unrelated courses remain unchanged.
- Next action: Merge the verified scoped change and perform the separately authorized production deployment with live read-back.

<!-- bridge:project-context-current task=CODEX-TASK-BRIDGE-MINIMAL-I2553-58CFA5EECC39 -->
- Result: Pasted content tables inside the .Content workarea render with uniform site typography; foreign inline font-family, font-size and line-height declarations on cells and nested elements (span, p, font) are normalized in all four mirrored stylesheets.
- Current state: The correction is scoped to typography only; table layout (width, border collapsing, padding, vertical alignment) is no longer overridden, and a PHP regression contract plus a pasted-markup fixture covering nested inline styles and unequal column structures guard the fix.
- Next action: Re-run the sealed review on the corrected PR head and merge once the required verify check passes.
