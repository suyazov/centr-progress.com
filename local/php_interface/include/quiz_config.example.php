<?php
// Пример защищённой конфигурации квиза. Скопируйте в quiz_config.php (не попадает в Git)
// и укажите входящий вебхук Bitrix24 вида https://<портал>.bitrix24.ru/rest/<user>/<key>/.
// Альтернатива — переменная окружения BITRIX24_WEBHOOK_URL.
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

// define('CENTR_PROGRESS_B24_WEBHOOK', 'https://example.bitrix24.ru/rest/0/xxxxxxxxxxxxxxxx/');

// Бесплатная альтернатива вебхуку — существующая CRM-форма Bitrix24, создающая сделку.
// Все значения берутся из кода формы в Bitrix24 и хранятся только в quiz_config.php.
// define('CENTR_PROGRESS_B24_FORM_ENDPOINT', 'https://example.bitrix24.ru/bitrix/services/main/ajax.php?action=crm.site.form.fill');
// define('CENTR_PROGRESS_B24_FORM_ID', '2');
// define('CENTR_PROGRESS_B24_FORM_SEC', 'xxxxxx');
// define('CENTR_PROGRESS_B24_FORM_SECURITY_SIGN', 'xxxxxxxxx');
// define('CENTR_PROGRESS_B24_FORM_CONSENT_ID', 'AGREEMENT_2');
