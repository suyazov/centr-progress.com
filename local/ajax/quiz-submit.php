<?php
// Точка входа AJAX-отправки квиза centr-progress.com.
define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_CHECK', true);
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

header('Content-Type: application/json; charset=UTF-8');

$libDir = $_SERVER['DOCUMENT_ROOT'] . '/local/lib/CentrProgress/Quiz/';
require_once $libDir . 'Validator.php';
require_once $libDir . 'Bitrix24Client.php';
require_once $libDir . 'SubmitHandler.php';

// Защищённая конфигурация (вебхук Bitrix24 и т.п.), не хранится в Git.
$configPath = $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/quiz_config.php';
if (is_file($configPath)) {
	require_once $configPath;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo \Bitrix\Main\Web\Json::encode(array('success' => false, 'error' => 'Method not allowed'));
	require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
	die();
}

$result = \CentrProgress\Quiz\SubmitHandler::handle($_POST, $_SESSION, bitrix_sessid(), SITE_ID);
echo \Bitrix\Main\Web\Json::encode($result);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
