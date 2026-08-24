<?php
// Пример защищённой конфигурации квиза. Скопируйте в quiz_config.php (не попадает в Git)
// и укажите входящий вебхук Bitrix24 вида https://<портал>.bitrix24.ru/rest/<user>/<key>/.
// Альтернатива — переменная окружения BITRIX24_WEBHOOK_URL.
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

// define('CENTR_PROGRESS_B24_WEBHOOK', 'https://example.bitrix24.ru/rest/0/xxxxxxxxxxxxxxxx/');
