<?php
namespace CentrProgress\Quiz;

/**
 * Чистые проверки и нормализация для квиза.
 * Не зависит от ядра Bitrix, чтобы быть unit-тестируемым.
 */
class Validator
{
	const MAX_QUESTIONS = 20;
	const RATE_LIMIT_WINDOW = 600; // секунд
	const RATE_LIMIT_MAX = 3;

	public static function makeToken($sessId)
	{
		return substr(md5('cp_quiz' . $sessId), 0, 32);
	}

	public static function checkToken($token, $sessId)
	{
		if (!is_string($token) || $token === '' || !is_string($sessId) || $sessId === '') {
			return false;
		}
		return hash_equals(self::makeToken($sessId), $token);
	}

	public static function cleanString($value, $maxLen = 500)
	{
		if (!is_string($value)) {
			return '';
		}
		$value = str_replace("\0", '', (string)$value);
		$value = trim(preg_replace('/\s+/u', ' ', $value));
		if (function_exists('mb_substr')) {
			$value = mb_substr($value, 0, $maxLen, 'UTF-8');
		} else {
			$value = substr($value, 0, $maxLen);
		}
		return $value;
	}

	public static function validateName($name)
	{
		$len = function_exists('mb_strlen') ? mb_strlen($name, 'UTF-8') : strlen($name);
		return $len >= 2 && $len <= 100;
	}

	public static function normalizePhone($phone)
	{
		return preg_replace('/\D+/', '', (string)$phone);
	}

	public static function validatePhone($phone)
	{
		$digits = self::normalizePhone($phone);
		$len = strlen($digits);
		return $len >= 10 && $len <= 12;
	}

	public static function validateEmail($email)
	{
		if ($email === '' || $email === null) {
			return true; // e-mail необязателен
		}
		return (bool)filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 100;
	}

	public static function isHoneypotFilled($value)
	{
		return trim((string)$value) !== '';
	}

	/**
	 * Нормализует карту ответов {вопрос: ответ}. Возвращает false при невалидном входе.
	 */
	public static function validateAnswers($answers)
	{
		if (!is_array($answers) || count($answers) < 1 || count($answers) > self::MAX_QUESTIONS) {
			return false;
		}
		$clean = array();
		foreach ($answers as $question => $answer) {
			$question = self::cleanString((string)$question, 255);
			$answer = self::cleanString((string)$answer, 500);
			if ($question === '' || $answer === '') {
				return false;
			}
			$clean[$question] = $answer;
		}
		return $clean;
	}

	/**
	 * Rate-limit по окну времени. Чистая функция: принимает и возвращает bucket.
	 *
	 * @param array $bucket ['start' => int, 'count' => int]
	 * @return array [bool $allowed, array $newBucket]
	 */
	public static function rateLimitAllow($bucket, $now, $window = self::RATE_LIMIT_WINDOW, $max = self::RATE_LIMIT_MAX)
	{
		$start = isset($bucket['start']) ? (int)$bucket['start'] : 0;
		$count = isset($bucket['count']) ? (int)$bucket['count'] : 0;
		if ($start <= 0 || ($now - $start) >= $window) {
			return array(true, array('start' => $now, 'count' => 1));
		}
		if ($count >= $max) {
			return array(false, $bucket);
		}
		return array(true, array('start' => $start, 'count' => $count + 1));
	}
}
