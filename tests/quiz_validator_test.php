<?php
// Unit-проверки CentrProgress\Quiz\Validator без ядра Bitrix.
// Запуск: php tests/quiz_validator_test.php

require __DIR__ . '/../local/lib/CentrProgress/Quiz/Validator.php';

use CentrProgress\Quiz\Validator;

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

// CSRF/session-токен
$token = Validator::makeToken('sess123');
check('token verifies for same session', Validator::checkToken($token, 'sess123'));
check('token rejected for other session', !Validator::checkToken($token, 'other'));
check('empty token rejected', !Validator::checkToken('', 'sess123'));

// Honeypot
check('empty honeypot passes', !Validator::isHoneypotFilled(''));
check('filled honeypot detected', Validator::isHoneypotFilled('spammy'));

// Имя
check('normal name valid', Validator::validateName('Иван'));
check('one-char name invalid', !Validator::validateName('И'));
check('empty name invalid', !Validator::validateName(''));

// Телефон
check('masked phone valid', Validator::validatePhone('+7 (999) 123-45-67'));
check('short phone invalid', !Validator::validatePhone('12345'));
check('phone digits normalized', Validator::normalizePhone('+7 (999) 123-45-67') === '79991234567');

// E-mail (необязателен)
check('empty email allowed', Validator::validateEmail(''));
check('valid email allowed', Validator::validateEmail('a@b.ru'));
check('invalid email rejected', !Validator::validateEmail('not-an-email'));

// Ответы
$answers = Validator::validateAnswers(array('Вопрос 1' => 'Вариант', 'Вопрос 2' => 'Другое'));
check('answers validated', is_array($answers) && count($answers) === 2);
check('empty answers rejected', Validator::validateAnswers(array()) === false);
check('empty answer value rejected', Validator::validateAnswers(array('Q' => '')) === false);
$tooMany = array();
for ($i = 0; $i < 25; $i++) { $tooMany["q$i"] = 'a'; }
check('too many answers rejected', Validator::validateAnswers($tooMany) === false);
check('non-array answers rejected', Validator::validateAnswers('string') === false);

// cleanString: переносы и обрезка
check('cleanString strips newlines', Validator::cleanString("a\r\nb\0c") === 'a bc');
check('cleanString trims and limits', Validator::cleanString('  abc  ', 2) === 'ab');

// Rate-limit
list($ok1, $b1) = Validator::rateLimitAllow(array('start' => 0, 'count' => 0), 1000);
check('first submit allowed', $ok1 && $b1['count'] === 1);
list($ok2, $b2) = Validator::rateLimitAllow($b1, 1100);
list($ok3, $b3) = Validator::rateLimitAllow($b2, 1200);
list($ok4, $b4) = Validator::rateLimitAllow($b3, 1300);
check('limit blocks 4th submit in window', $ok2 && $ok3 && !$ok4);
list($ok5, $b5) = Validator::rateLimitAllow($b3, 1300 + Validator::RATE_LIMIT_WINDOW);
check('window resets limit', $ok5 && $b5['count'] === 1);

echo $failures === 0 ? "ALL PASS\n" : "FAILURES: $failures\n";
exit($failures === 0 ? 0 : 1);
