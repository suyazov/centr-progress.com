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

## Regional documents — 01.10.2026, applied and verified

- Progress meeting `_avWH_9kaF` / node `dt448AS8QZcPYOPrYmyoN` is under AFFiNE `Сказка / 03 Встречи / 2026 / Сентябрь`. No relocation or registry row confirmed.
- Latest 23.09 Gmail contract examples match adapted templates 80, 82 and 88; all three were inactive before this repair. The owner-approved package enabled all three, preserving the contract files.
- Static QR confirmed in invoices 70 (14000 RUB), 84/86/92 (5000 RUB), 96 (17000 RUB). Native PaymentQrCode candidates prepared and checked offline. Source banking fields match original 94.
- Owner approved the exact expanded package with «делай, убери эти ограничения». Applied: three contracts enabled, five invoices updated, city sets 9/6/9 sorted, Stavropol labels prefixed, DOT64 active separately, old invoice68 disabled. All 26 metadata read-backs verified; five live invoice QR tests matched 1701/1802/1903/2004/2105 RUB and preserved banking fields. Existing test deal66 remained unchanged; public links disabled. Authorization-wait restriction for this package removed.
- Evidence: docs/BITRIX24_DIAGNOSTICS.md; protected originals, candidates and exact plan outside Git.
- Next: managers can generate new customer documents from the enabled contracts and corrected invoices. Corporate mailbox names/count and DNS authority remain unspecified. Leader handles old deal reconciliation. General access/secrets safeguards remain in effect.

## Входящие материалы и карта доступов — письмо Виктории от 19.08.2026

Сохранено владельцем 05.10.2026. Это частичный пакет исходных материалов, а не полный перечень доступов и не подтверждение текущей работоспособности интеграций. Контакт: Виктория Селюкова, milochka55@mail.ru.

### Сайт и заявки

- Сайт: https://centr-progress.com/; по сообщению владельца, сайт и почта обслуживаются в Beget. Доступ к панели Beget дополнительно получен от Валентины 05.10; см. карту ниже.
- Историческая схема из письма: заявки с сайта отправлялись с info@centr-progress.com на progress61@mail.ru; затем дублировались в Битрикс24, менеджеры распределяли их из почты. На 05.10 эта схема заново не проверена.
- Проверить Jivo и Marquiz; по письму последняя заявка Marquiz была 14 июля с robot@marquiz.ru. Это историческая дата из письма, а не результат свежей диагностики.
- Контекстная реклама: кампания ранее создана; требуется анализ, расчёт бюджета и организация ведения. Расходы и изменение кампаний этим письмом не согласованы.
- Настроить Яндекс Карты.
- Проанализировать конкурента https://ncpo.ru/ и предложить применимые улучшения сайта. Анализ в этом этапе не выполнялся.

### CRM и обучение

| Сервис | URL | Логин / контакт | Владелец доступа и источник | Защищённое хранилище | Статус |
| --- | --- | --- | --- | --- | --- |
| Битрикс24 | https://anoucdpoprogress.bitrix24.ru/ | progress61@mail.ru | Предоставлен Викторией, сохранение разрешил Артём | /root/.config/client-access/centr-progress.com/bitrix24.env | Данные совпали с сохранёнными; новая авторизация в этом этапе не выполнялась |
| Учебная платформа | https://learning.centr-progress.com/ | 1-0-6226; контакт eisot.progress@mail.ru | Предоставлен Викторией, сохранение разрешил Артём | /root/.config/client-access/centr-progress.com/learning.env | Сохранён, вход и роль не проверены |
| Почта info@centr-progress.com | Домен centr-progress.com | info@centr-progress.com | Указана в исходной схеме сайта | Не предоставлено | Наличие ящика и отправка сейчас не проверены |
| Почта progress61@mail.ru | https://mail.ru/ | progress61@mail.ru | Указана как получатель заявок и логин CRM | Не предоставлено | Пароль CRM не считается паролем почты |
| Панель Beget | https://cp.beget.com/ | progrecw; account ID 2594871 | Предоставлен Валентиной, сохранение разрешил Артём | /root/.config/client-access/centr-progress.com/beget.env | Сохранён 05.10; владелец подтвердил вход в панель; отдельный API-доступ успешно проверен |
| Jivo / Marquiz / Яндекс Карты / рекламный кабинет | Не предоставлено | Не предоставлены | Упомянуты в письме | Не предоставлено | Доступы и текущее состояние неизвестны |

Пароли находятся только в защищённом хранилище: каталог 0700, файлы 0600, root:root. Временная OAuth-ссылка из письма с session/state параметрами не сохранена; используется постоянный URL портала. Секреты не копируются в Git, AFFiNE или клиентский чат. После передачи паролей в переписке рекомендуется согласовать их ротацию; текущие пароли не менялись.

### Сопоставление с выполненной работой и следующий шаг

- Исправления QR, общего акта ИП и региональных шаблонов CRM от 01.10 описаны выше; это отдельные завершённые результаты, а не проверка всех пунктов августовского письма.
- По голосовому Виктории в Telegram #133: одному сотруднику нужен отдельный корпоративный ящик; также требуется выяснить лимиты исходящих писем. Бот принял и передал обращение на ручной разбор.
- Предлагаемая схема: отдельный ящик сотруднику в существующей почте Beget, затем IMAP/SMTP-подключение к Битрикс24. Ящик пока не создан и к CRM не подключён.
- Следующий шаг по почте: проверить сохранённый доступ к панели Beget, определить сотрудника, адрес ящика и его учётную запись CRM; выяснить, нужны индивидуальные письма или массовые рассылки. Общий пароль почты из пароля CRM не выводить.
- Этот этап сохраняет материалы и доступы. Изменения сайта, DNS, почты, рекламных бюджетов и учебной платформы не выполнялись.

### Дополнение Beget — 05.10.2026

- Источник: пересланное владельцем письмо Валентины Селюковой с реквизитами Beget. Тариф по письму Bitrix-1: 12 сайтов, дисковая квота 55000 МБ. Значки в строках FTP, MySQL, доменов и ящиков не сохранены как числовые лимиты; фактические ограничения аккаунта ещё не проверены.
- Панель: https://cp.beget.com/; логин progrecw; account ID 2594871; поддержка support@beget.ru. Пароль сохранён только в beget.env.
- FTP/SSH: progrecw.beget.tech, логин progrecw; защищённый файл /root/.config/client-access/centr-progress.com/ssh.env. Данные совпали с существующим защищённым файлом.
- Сохранение доступа не является подтверждением успешного входа. Почтовые ящики, пароли аккаунта, DNS и сайт в этом этапе не менялись. Следующий шаг: проверить почтовый раздел и определить сотрудника и желаемый адрес для подключения к CRM.

### Создание корпоративной почты — 05.10.2026, блокировано доступом

- Владелец разрешил создать нейтральный ящик в личном кабинете Beget, при необходимости выпустить API-доступ и подключить ящик к Битрикс24. Предварительный адрес: office@centr-progress.com, только после проверки его доступности.
- Проверка присланных данных через документированный endpoint авторизации панели https://api.beget.com/v1/auth вернула INCORRECT_CREDENTIALS. Read-only запрос списка ящиков через hosting API также отклонён AUTH_ERROR; это не доказательство настроек или доступности ящиков. Повторные попытки с теми же данными прекращены.
- Ни почтовый ящик, ни API-ключ не созданы; Битрикс24, существующая почта, пароли и DNS не изменены. Исторические credentials сохранены без перезаписи.
- Следующий шаг: владелец обновляет доступ к панели в защищённом /root/.config/client-access/centr-progress.com/beget.env. После успешного входа проверить свободный адрес, создать ящик, подключить IMAP/SMTP к CRM и проверить отправку/получение.

### Почта Beget — уточнённое состояние 05.10.2026

- Владелец подтвердил вход в панель на своём устройстве. Прежний вывод о недействительном пароле панели не подтверждён: отдельный пароль hosting API принят. Он сохранён только в /root/.config/client-access/centr-progress.com/beget-api.env (0600, root:root).
- Обнаружено: входящая почта centr-progress.com направлена в Яндекс (MX mx.yandex.net). Пустой список ящиков Beget не означает отсутствия действующей почты в Яндексе.
- Владелец выбрал office@mail.centr-progress.com и явно разрешил DNS-записи только для mail.centr-progress.com. Поддомен создан (текущий ID 14745770), Beget добавил MX mx1.beget.com (10), mx2.beget.com (20), SPF v=spf1 redirect=beget.com и стандартную A-запись. DNS-записи основного домена сверены с исходным снимком и не изменены.
- Ящик НЕ создан: mail/getMailboxList отклоняет поддомен кодом 1202 Cannot find domain with fqdn, mail/createMailbox возвращает 1202 Failed to create mailbox. Это подтверждённый отказ текущего API-пути, а не доказательство невозможности услуги в целом. Через панель с сервера завершить настройку не удалось.
- Файл /root/.config/client-access/centr-progress.com/mail-office.env содержит подготовленные данные для ещё НЕ созданного ящика, не считается рабочим доступом. Битрикс24 не настроен на этот адрес.
- Защищённые артефакты: /root/.local/state/codex/centr-progress-mail-20261005/receipt.json, dns-root-before.json, support-request.txt. Запрос в поддержку подготовлен; владелец разрешил самостоятельное обращение командой «делай все сам», отправка подтверждена ниже. Следующий шаг: получить подтверждённый способ добавления почтового домена, создать ящик, проверить IMAP/SMTP, подключить CRM и проверить отправку/получение.

### Поддержка Beget — запрос отправлен 05.10.2026

- По команде владельца «делай все сам» отправлено письмо с его подключённого Gmail на support@beget.com. Тема: «Почта на поддомене mail.centr-progress.com — аккаунт 2594871». Gmail messageId/threadId: 1a10c231140f9841. Отправка подтверждена; ответы ещё не проверены.
- Сообщение содержит только account ID, адрес, ID поддомена, MX/SPF и коды отказа API. Пароли не передавались. Запрошен порядок создания ящика на поддомене без переноса почты основного домена; изменения существующих DNS и паролей поддержке не поручались.
- Подтверждение отправки: /root/.local/state/codex/centr-progress-mail-20261005/support-delivery.json (state=SENT). Не дублировать обращение при продолжении. Следующий шаг: прочитать ответ в этой Gmail-переписке, затем продолжить ровно выбранный scope office@mail.centr-progress.com и IMAP/SMTP-интеграцию с CRM.

### Ответ поддержки Beget — 06.10.2026

- Владелец предоставил ответ инженера поддержки Сергея от 06.10: в системе Beget нельзя использовать поддомен для писем; предложены сторонние почтовые записи либо собственный почтовый сервис на VPS. Это подтверждает ограничение выбранного пути, а не проблему API-пароля.
- office@mail.centr-progress.com не создан и к CRM не подключён. Поддомен с MX/SPF оставлен как неиспользуемая подготовка; DNS основного домена не менялись. Подготовленный mail-office.env не является рабочим доступом.
- Предпочтительный следующий вариант: отдельный нейтральный office@centr-progress.com в уже действующей почтовой организации Яндекса, затем IMAP/SMTP-интеграция с CRM. Это рекомендация, новый ящик ещё не создан. Перед записью проверить свободный адрес, тариф и возможную стоимость дополнительного аккаунта.
- В точном каталоге /root/.config/client-access/centr-progress.com/ нет доступа к администрированию Яндекс 360. Нужна защищённая ссылка/авторизация администратора организации; пароли CRM и Beget для этого не использовать.

### Новое обращение Вики — Telegram #154, 06.10.2026

- В сообщении https://t.me/c/4481949872/154 прислан скриншот формы реквизитов ИП: организация найдена через «Поиск реквизитов», ФИО заполнены, сокращённое и полное наименования организации пусты. Это отдельный сценарий ИП; прежняя проверка реквизитов организации на собственном ИНН центра его не покрывает. Исправление не выполнено, причина пока не установлена.
- Найден разрыв intake: normalized_event сохраняет text/caption, а media_from_message принимает только голос/аудио/видео. У фото без подписи сохраняются пустые text и media; для #154 нет ни job, ни l1_request. Не считать сообщение автоматически принятым или решённым.
- Исходное фото восстановлено пересылкой владельцу в личный Telegram (messageId 124, без уведомления). Приватные артефакты /root/.local/state/codex/centr-progress-message154/forward.json и source.jpg, права 0600; персональные данные изображения не копировать в Git/AFFiNE.
- Следующий шаг: проверить exact сценарий поиска в пресете ИП без сохранения чужих реквизитов; отдельно устранить пропуск фото в support intake с защищённым хранением и проверкой результата.

## 2026-10-06 — Mail paused; screenshot request recovered

Owner paused email setup. No mailbox is created or connected to CRM; the shared Beget hosting limitation remains. Support bot release 998a05ab55f362562800967e0874c11d7cf6d434 is deployed and installer verified fresh Telegram polling with all four services running. Authorized Progress photos without captions and image documents now create durable L1 requests, acknowledge once, and escalate with a private original-message link; images do not enter audio transcription. Image interpretation is not implemented. Recovered Vika message154 into L1 request 1bc84b4ee49b5102; acknowledgement sent. The reported blank IP name fields remain unresolved and must not be described as fixed or covered by the earlier organization lookup verification. Next: reproduce the exact unsaved IP lookup and inspect its response/field mapping without changing customer records.

## 2026-10-06 — IP lookup diagnosis completed

Reproduced message154's exact INN in an unsaved new-company IP requisite. Both name fields exist but remain empty after selecting the match; person names and registration fields populate. Captured the selected autocomplete object: RQ_COMPANY_NAME and RQ_COMPANY_FULL_NAME are absent from its fields. This proves missing values in the selected result, not a removed preset field; upstream service versus mapping exclusion is not established. No customer records/settings saved. Manual completion from verified full entrepreneur name is the available workaround; automatic correction is not implemented. Evidence and steps: docs/BITRIX24_DIAGNOSTICS.md. Mail remains paused.

## 2026-10-06 — Names automation prepared, activation pending

Fresh exact-INN query found one saved IP requisite: both names are already filled. A safe live preview confirmed UNCHANGED; no customer write performed. Existing portal session can use official requisite REST methods without a new webhook. Prepared tools/b24_ip_names.py, two-minute service/timer and an installer for future IP records only, blank name fields only, existing protected credentials, no external provider/API spending. Tests: six synthetic scenarios including history exclusion and no replay of uncertain writes; live read-only preview, unit validation and diff check. Installation/write verification has not occurred. Production activation for all future IP records requires an exact owner authorization; docs/IP_NAMES_AUTOMATION.md contains the concrete scope and rollback.

## 2026-10-06 — New IP name autofill activated

Owner explicitly approved activation with «делай». Installed immutable release6d322a69a24af285bbc00ad31d9f1a4cfce50c60 and enabled centr-progress-ip-names.timer. Baseline cursor2748 excludes all earlier requisites. First live run: POLL_VERIFIED, updated0/pending0; systemd Result=success, ExecMainStatus=0, next run scheduled in two minutes. No suitable new record existed, so live update/readback has not yet occurred; the write path passed six synthetic tests. Existing screenshot record2744 remains unchanged and already contains both names. Sent client status159 replying to154. Scope: new active Russian IP requisites, two blank name fields only, preserved existing fields; poll completes after save. Protected runtime state: /var/lib/centr-progress-ip-names; immutable release and rollback: docs/IP_NAMES_AUTOMATION.md. Mail remains paused.

## 2026-10-06 — Invoice complaint160/161 diagnosed, not repaired

Vika's photo160 and text161 became separate L1 requests284082fb/cda10394. Photo was explicitly escalated; text failed before planner startup with generic l1_execution_failed (20 seconds). No planner work directory exists, so failure is before planning; exact exception was not preserved. A fresh read-only login and template snapshot succeeded, so the transient cause is not proven.

Downloaded current regional legal-entity invoices48/70/96. Only96 contains two literal sample paragraphs: static item-count/17000 amount and a sample learner surname. Those are visible beside generated fields on the original photo. Templates48/70 lack these literals; complaint about all invoices is not verified. Prepared protected template96 candidate removing exactly those paragraphs; all other ZIP entries identical, dynamic totals/learner fields and QR preserved. Candidate not uploaded. Photo also shows numeric9000 versus words10000; current TotalSumWords field is dynamic, so that discrepancy needs separate live generation verification. Prior QR checks did not verify removal of sample text or agreement with the amount in words. Artifacts: /root/.local/state/codex/centr-progress-invoices-20261006. Next: exact-scope template96 upload and private test of numeric/words/QR amounts before reporting repaired.

## 2026-10-06 — Invoice96 complaint repaired and verified

Owner approved the prepared invoice repair with «делай». Template96 file updated: removed two literal sample paragraphs and replaced independent TotalSumWords with TotalSum~W=Y, so numeric and written totals share one source. Read-back verified; template metadata and other ZIP parts preserved. Private regression in test deal66: before document12448 reproduced9000 numeric/10000 words; after12450 with the same intentionally conflicting inputs yielded9000 numeric,9000 words and QR900000 kopecks. Example paragraphs absent, banking QR fields identical, public links disabled, deal fields unchanged. Regional legal-entity invoices48/70 have no example paragraphs and were not modified. Existing customer documents/records not changed. Sent client status166 and marked both linked L1 requests VERIFIED with explicit operator/owner-authority receipts. Evidence and rollback: docs/BITRIX24_DIAGNOSTICS.md; protected artefacts in /root/.local/state/codex/centr-progress-invoices-20261006. Bot image interpretation/message grouping remain unimplemented; no claim that the bot itself performed this repair. Mail remains paused.

## 2026-10-08 — Mail resumed; access checks completed

Owner resumed the separate manager-mailbox task. Bitrix24 protected login verified; mail UI already contains progress61@mail.ru. This proves an existing connection is configured, not successful SMTP/IMAP operation: no send/receive test was performed. Beget hosting API access verified; centr-progress.com mailbox list is empty. Fresh public DNS query returns MX10 mx.yandex.net, so the domain's inbound route remains Yandex. No DNS, passwords, existing mailbox or CRM settings changed. office@mail.centr-progress.com remains uncreated because Beget does not support subdomain mail. Prepared mail-office.env is not a working mailbox credential.

Vika's message109 requests a separate mailbox for the acquisition manager; message143 asks whether it would interfere with the main mailbox. Neutral office@centr-progress.com in the existing Yandex mail organization is the current proposed route, subject to checking available address and tariff before creation. The exact protected client directory contains no Yandex360 administrator access. Asked the owner once for a protected access-file path or authenticated administrator session; no cross-service password reuse and no broad credential search performed. Next: obtain administrator access, check cost/address availability, create the separate mailbox, connect to Bitrix24 and verify IMAP/SMTP with controlled mail delivery. Read-only receipt: /root/.local/state/codex/centr-progress-mail-20261008/receipt.json. No status/test messages sent to the client working chat.
