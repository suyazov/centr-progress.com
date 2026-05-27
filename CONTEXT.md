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