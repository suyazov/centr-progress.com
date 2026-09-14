# AGENTS.md — centr-progress.com

This repository is onboarded through the Bridge control plane.

Before any technical task, read the canonical Bridge regulations from:

- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/Регламенты/README.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/1. Архитектура AFFiNE GitHub Bridge.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/2. Клиентский workflow.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/3. Автоматизация задач ChatGPT GitHub Kimi.md`
- `/var/lib/bridge-sy9/affine-pages-backup/affine/infrastructure/Регламент/4. Работа с Kimi.md`

Current capability is `php-repository`; default task kind is `product`. Bridge may
perform bounded repository-only work through a reviewed PR and the required
`verify` check. Delivery is disabled: this capability never writes the live
1C-Bitrix installation, DNS, credentials, or other production state.
