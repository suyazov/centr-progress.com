# centr-progress.com — Данные проекта

## Сайт
- URL: https://centr-progress.com/
- CMS: 1C-Bitrix 26.250.0
- PHP: 8.4.6 (web), 5.6.40 (CLI)
- Домен зарегистрирован на BeGet

## SSH-доступ
- Хост: progrecw.beget.tech
- Логин: progrecw
- Пароль: V49CLjGgikFB
- Корень сайта: ~/centr-progress.com/public_html/

## MySQL
- Хост: localhost
- База: progrecw_progres
- Пользователь: progrecw_progres
- Пароль: b1abk9p32V49CLjGgikFB

## Конфигурация Bitrix
- dbconn.php: ~/centr-progress.com/public_html/bitrix/php_interface/dbconn.php
- .settings.php: ~/centr-progress.com/public_html/bitrix/.settings.php

## Применённые исправления

### 1. Пагинация (init.php)
**Файл:** `bitrix/php_interface/init.php`
**Проблема:** BeGet nginx не передаёт QUERY_STRING PHP-FPM для SEF-URL, из-за чему $_GET пустой и Bitrix не видит параметры пагинации (PAGEN_N).
**Решение:** Парсинг REQUEST_URI и заполнение $_GET + глобальных переменных.

### 2. Класс Bas\Pict (замена intec.startshop)
**Файл:** `local/php_interface/classes/Bas/Pict.php`
**Проблема:** Модуль intec.startshop не установлен, класс Bas\Pict отсутствует — главная страница отдавала 500.
**Решение:** Создан класс-замена, использующий CFile::ResizeImageGet. Автозагрузка через spl_autoload_register в init.php.

### 3. Выпадающее меню — ширина и z-index (2026-05-21)
**Файлы:** 
- `bitrix/templates/template/css/new_menu.css`
- `bitrix/templates/template/template_styles.css`
- `bitrix/templates/template/styles.css`
- `bitrix/templates/template/styles-min.css`
- `bitrix/templates/template/template_styles-min.css`

**Проблема 1:** Текст в выпадающем меню выходил за пределы подложки из-за фиксированной ширины.
**Решение:** В `new_menu.css` изменено `width: 240px` → `width: auto`, добавлен `white-space: nowrap` к `.MainMenu .Wrapper .dropdown-menu li > a`.

**Проблема 2:** Поисковая иконка перекрывалась выпадающим меню и становилась некликабельной.
**Решение:** Исправлена иерархия z-index:
- `.HeaderBlock`: `z-index: 100` → `z-index: 101`
- `.HeaderBlock .Search`: добавлен `z-index: 610`
- `.MainMenu .Wrapper .dropdown-menu`: `z-index: 602` → `z-index: 50`

**Примечание:** После изменений очищен кеш Bitrix (`bitrix/cache/*`, `bitrix/managed_cache/*`).

## Выполненные изменения (2026-05-27)

### 1. Переименовка раздела "О центре"
**Файл:** `o-tsentre/.section.php`
**Изменение:** `$sSectionName = "О центре"` → `$sSectionName = "Сведения об образовательной организации"`

### 2. Изменение заголовка на странице оценки условий труда
**Проблема:** H1 формировался как "Повышение квалификации по профессии «Специальная оценка условий труда»"
**Решение:** 
1. В базе данных `b_iblock_section_iprop` для SECTION_ID=5, IPROP_ID=114 изменено:
   - БЫЛО: ` по профессии «Повышение квалификации»`
   - СТАЛО: `«Специальная оценка условий труда»`
2. Создан файл `bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/result_modifier.php` для переопределения ELEMENT_PAGE_TITLE для элемента с кодом "otsenka-usloviy-truda"

### 3. Изменение заголовка в index.php "О центре"
**Файл:** `o-tsentre/index.php`
**Изменение:** `$APPLICATION->SetTitle("О центре")` → `$APPLICATION->SetTitle("Сведения об образовательной организации")`

### 4. Обновление названия в меню
**Файлы:** 
- `.top.menu.php`
- `.mobile.menu.php`
**Изменение:** Меню-ссылка "О центре" → "Сведения об образовательной организации"

**Примечание:** Послеразмещения изменений в подвале (`footer.php`) удалён блок:
`<div class="Developer"><a href="http://artex-studio.ru">Создание сайта</a> - <span>Артекс</span></div>`

### 5. Изменение ширины контейнера
**Файлы:** 
- `bitrix/templates/template/template_styles.css`  
- `bitrix/templates/template/special-min.css`
**Изменение:** `.Wrapper { max-width: 1180px; }` → `.Wrapper { max-width: 1305px; }`

### 6. Исправление H1 на странице оценки условий труда
**Файл:** `bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/template.php`
**Изменение:** Изменён вывод H1 с `$APPLICATION->ShowTitle(true)` на прямой вывод `$arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]`
- `bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/result_modifier.php` (новый файл)
- `o-tsentre/.section.php` (изменён)
- `o-tsentre/index.php` (изменён)
- `.top.menu.php` (изменён)
- `.mobile.menu.php` (изменён)

## Выполненные изменения (2026-06-09)

### 1. Исправление поиска (z-index)
**Файлы:** 
- `bitrix/templates/template/template_styles.css`
- `public_html/bitrix/templates/template/template_styles.css`

**Проблема:** При клике на поисковую иконку окно поиска уходило вниз / перекрывалось другими элементами.
**Решение:** Исправлена иерархия z-index в соответствии с предыдущим исправлением:
- `.HeaderBlock`: `z-index: 100` → `z-index: 101`
- `.HeaderBlock .Search`: добавлен `z-index: 610`

### 2. Блок лицензий на странице "О центре"
**Файлы:** 
- `o-tsentre/index.php`
- `public_html/o-tsentre/index.php`

**Изменение:** Скопирован блок лицензий (`<div class="block_licmin">`) с главной страницы на страницу "О центре" (перед подвалом).

### 3. Удаление слова "профессии" из H1 каталога
**Файлы:** 
- `bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/result_modifier.php`
- `public_html/bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/result_modifier.php`
- `bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/template.php`
- `public_html/bitrix/templates/template/components/bitrix/catalog/catalog/bitrix/catalog.element/.default/template.php`

**Проблема:** На страницах элементов каталога (например, "Специальная оценка условий труда") заголовок формировался как "Повышение квалификации по профессии «...»".
**Решение:** 
1. В `result_modifier.php` добавлена замена `str_replace(' по профессии ', ' ', ...)` для `ELEMENT_PAGE_TITLE` с последующим `$APPLICATION->SetTitle()`.
2. В `template.php` изменён вывод H1 с `$APPLICATION->ShowTitle(true)` на прямой вывод `$arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]` (с fallback на `ShowTitle`).

**Важно:** при деплое был случайно залит обрезанный `template.php` (887 байт вместо полного ~21 КБ), из-за чего пропал весь контент на карточках товаров. Исправлено — восстановлен полный шаблон из git + внесено изменение H1.

### 4. Исправление поиска — перекрытие верхним меню
**Файлы:** 
- `bitrix/templates/template/template_styles.css`
- `bitrix/templates/template/template_styles-min.css`
- `public_html/bitrix/templates/template/template_styles.css`
- `public_html/bitrix/templates/template/template_styles-min.css`

**Проблема:** При клике на поиск окно `.PopupSearch` перекрывалось верхним меню `.TopPanel` (z-index 200).
**Решение:** `.PopupSearch { z-index: 100 }` → `z-index: 300`.

### 5. Исправление табов "Направления обучения" на главной
**Файлы:** (те же CSS-файлы, что и в п.4)

**Проблема:** Последний таб в блоке "Направления обучения" переносился на вторую строку.
**Решение:** Для `.ServicesTabs ul.Tabs` добавлен `display: flex; flex-wrap: nowrap;`. Для `.ServicesTabs ul.Tabs li` изменено `display: inline-block` → `display: block` + добавлены `text-align: center; white-space: nowrap; flex: 1 1 auto;`.