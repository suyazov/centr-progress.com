<?php
// Smoke-проверки интеграции квиза: разметка, ассеты, endpoint, gitignore, lint.
// Запуск: php tests/quiz_smoke_test.php

$root = dirname(__DIR__);
$failures = 0;
function check($label, $cond) {
	global $failures;
	if ($cond) {
		echo "OK   $label\n";
	} else {
		$failures++;
		echo "FAIL $label\n";
	}
}

$footer = file_get_contents($root . '/bitrix/templates/template/footer.php');

// Marquiz и Jivo удалены
check('no marquiz markup/script', stripos($footer, 'marquiz') === false);
check('no jivo widget script', stripos($footer, 'jivo') === false);

// Квиз подключён
check('quiz modal markup present', strpos($footer, 'id="cp-quiz"') !== false);
check('quiz open button present', strpos($footer, 'data-cp-quiz-open') !== false);
check('quiz.js added via Asset', strpos($footer, "/js/quiz.js") !== false);
check('quiz config exposed', strpos($footer, 'window.CP_QUIZ') !== false && strpos($footer, 'bitrix_sessid()') !== false);
check('honeypot field present', strpos($footer, 'data-cp-quiz-hp') !== false);
check('openlines include guarded', strpos($footer, 'openlines.php') !== false && strpos($footer, 'is_file($cpOpenLines)') !== false);

// Аналитика не тронута
check('yandex metrika kept', strpos($footer, 'mc.yandex.ru/metrika/tag.js') !== false);
check('vk retargeting kept', strpos($footer, 'VK.Retargeting') !== false);
check('existing popup form kept', strpos($footer, 'iblock.element.add.form') !== false);

// Ассеты и серверные файлы
check('quiz.js exists', is_file($root . '/bitrix/templates/template/js/quiz.js'));
$css = file_get_contents($root . '/bitrix/templates/template/template_styles.css');
check('quiz styles present', strpos($css, '.CpQuizOpen') !== false && strpos($css, '.CpQuizHp') !== false);
check('ajax endpoint exists', is_file($root . '/local/ajax/quiz-submit.php'));
check('Validator exists', is_file($root . '/local/lib/CentrProgress/Quiz/Validator.php'));
check('SubmitHandler exists', is_file($root . '/local/lib/CentrProgress/Quiz/SubmitHandler.php'));
check('Bitrix24Client exists', is_file($root . '/local/lib/CentrProgress/Quiz/Bitrix24Client.php'));
check('quiz_config example exists', is_file($root . '/local/php_interface/include/quiz_config.example.php'));
check('openlines example exists', is_file($root . '/local/php_interface/include/openlines.example.php'));

// Endpoint: защита и контракт
$ajax = file_get_contents($root . '/local/ajax/quiz-submit.php');
check('endpoint requires POST check', strpos($ajax, "REQUEST_METHOD") !== false);
check('endpoint loads protected config', strpos($ajax, 'quiz_config.php') !== false && strpos($ajax, 'is_file($configPath)') !== false);

// Секреты не в коде
$handler = file_get_contents($root . '/local/lib/CentrProgress/Quiz/Bitrix24Client.php');
check('webhook from env/define only', strpos($handler, 'BITRIX24_WEBHOOK_URL') !== false && strpos($handler, 'bitrix24.ru/rest/1') === false);
check('webhook has timeout', strpos($handler, 'TIMEOUT') !== false);

// gitignore защищает конфиги
$gitignore = file_get_contents($root . '/.gitignore');
check('gitignore covers quiz_config.php', strpos($gitignore, 'quiz_config.php') !== false);
check('gitignore covers openlines.php', strpos($gitignore, 'openlines.php') !== false);

// PHP lint изменённых/новых PHP-файлов
$phpFiles = array(
	'bitrix/templates/template/footer.php',
	'local/ajax/quiz-submit.php',
	'local/lib/CentrProgress/Quiz/Validator.php',
	'local/lib/CentrProgress/Quiz/SubmitHandler.php',
	'local/lib/CentrProgress/Quiz/Bitrix24Client.php',
	'local/php_interface/include/quiz_config.example.php',
	'local/php_interface/include/openlines.example.php',
);
foreach ($phpFiles as $file) {
	$out = array();
	$code = 0;
	exec(sprintf('php -l %s 2>&1', escapeshellarg($root . '/' . $file)), $out, $code);
	check("php -l $file", $code === 0);
}

// JS синтаксис, если доступен node
$node = trim((string)@shell_exec('command -v node 2>/dev/null'));
if ($node !== '') {
	$out = array();
	$code = 0;
	exec(sprintf('node --check %s 2>&1', escapeshellarg($root . '/bitrix/templates/template/js/quiz.js')), $out, $code);
	check('node --check quiz.js', $code === 0);
} else {
	echo "SKIP node --check quiz.js (node not installed)\n";
}

echo $failures === 0 ? "ALL PASS\n" : "FAILURES: $failures\n";
exit($failures === 0 ? 0 : 1);
