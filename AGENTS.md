# Agent scope

This repository is onboarding-only until Bridge returns `PROJECT_ORCHESTRATION_READY`.

Read the current canonical regulations before any technical work:

- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/1. Архитектура AFFiNE GitHub Bridge.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/2. Клиентский workflow.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/3. Автоматизация задач ChatGPT GitHub Kimi.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/4. Работа с Kimi.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/9. Работа с managed Codex.md`

Guardrails:

- Do not create application code, executable product TASKs, DNS, deploy, or direct production writes until onboarding completes; the delivery capability and write path are defined by the Bridge inventory after bootstrap.
- The site runs on 1C-Bitrix (`bitrix/`, `local/`, `public_html/`); treat the current files as the frozen source of truth until Bridge assigns a delivery track.
- Never store raw secrets in this repository.
- Keep future task work on controlled `codex/*` branches and pull requests.
