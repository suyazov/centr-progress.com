<?php
namespace CentrProgress\Quiz;

/**
 * Интеграция квиза с Bitrix24 через входящий вебхук или штатную CRM-форму.
 * Все идентификаторы и подписи берутся только из защищённой конфигурации вне Git.
 */
class Bitrix24Client
{
	const TIMEOUT = 5;

	/**
	 * @return string|null
	 */
	public static function resolveWebhookUrl()
	{
		$env = getenv('BITRIX24_WEBHOOK_URL');
		if (is_string($env) && $env !== '') {
			return $env;
		}
		if (defined('CENTR_PROGRESS_B24_WEBHOOK') && CENTR_PROGRESS_B24_WEBHOOK !== '') {
			return CENTR_PROGRESS_B24_WEBHOOK;
		}
		return null;
	}

	/** @return array|null */
	public static function resolveCrmFormConfig()
	{
		$endpoint = self::setting('BITRIX24_FORM_ENDPOINT', 'CENTR_PROGRESS_B24_FORM_ENDPOINT');
		$id = self::setting('BITRIX24_FORM_ID', 'CENTR_PROGRESS_B24_FORM_ID');
		$sec = self::setting('BITRIX24_FORM_SEC', 'CENTR_PROGRESS_B24_FORM_SEC');
		$sign = self::setting('BITRIX24_FORM_SECURITY_SIGN', 'CENTR_PROGRESS_B24_FORM_SECURITY_SIGN');
		$consent = self::setting('BITRIX24_FORM_CONSENT_ID', 'CENTR_PROGRESS_B24_FORM_CONSENT_ID');

		if (!preg_match('#^https://#i', $endpoint) || (int)$id < 1 || $sec === '' || $sign === '') {
			return null;
		}

		return array(
			'endpoint' => $endpoint,
			'id' => (int)$id,
			'sec' => $sec,
			'security_sign' => $sign,
			'consent_id' => $consent !== '' ? $consent : 'AGREEMENT_2',
		);
	}

	private static function setting($envName, $constantName)
	{
		$value = getenv($envName);
		if (is_string($value) && $value !== '') {
			return $value;
		}
		if (defined($constantName)) {
			$value = constant($constantName);
			return is_scalar($value) ? (string)$value : '';
		}
		return '';
	}

	/**
	 * Передаёт контакты в существующую CRM-форму, которая создаёт сделку.
	 * Успех возвращается только при receipt resultId от Bitrix24.
	 */
	public static function sendCrmForm(array $config, array $submission)
	{
		if (!function_exists('curl_init')) {
			return array('success' => false, 'error' => 'curl_unavailable');
		}

		$values = array(
			'CONTACT_NAME' => array(isset($submission['name']) ? $submission['name'] : ''),
			'CONTACT_LAST_NAME' => array(),
			'CONTACT_PHONE' => array(isset($submission['phone']) ? $submission['phone'] : ''),
			'CONTACT_EMAIL' => !empty($submission['email']) ? array($submission['email']) : array(),
		);
		$post = array(
			'properties' => '{}',
			'consents' => self::json(array($config['consent_id'] => 'Y')),
			'recaptcha' => '[]',
			'yandexSmartCaptcha' => '[]',
			'timeZoneOffset' => '180',
			'values' => self::json($values),
			'id' => (string)$config['id'],
			'sec' => $config['sec'],
			'lang' => 'ru',
			'trace' => '{}',
			'entities' => '[]',
			'security_sign' => $config['security_sign'],
		);

		$ch = curl_init($config['endpoint']);
		curl_setopt_array($ch, array(
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $post,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => self::TIMEOUT,
			CURLOPT_CONNECTTIMEOUT => self::TIMEOUT,
		));
		$body = curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError = curl_error($ch);
		curl_close($ch);

		$data = is_string($body) ? json_decode($body, true) : null;
		$result = is_array($data) && isset($data['result']) && is_array($data['result']) ? $data['result'] : null;
		if ($status >= 200 && $status < 300 && is_array($result) && !empty($result['resultId'])) {
			return array('success' => true, 'channel' => 'crm_form', 'id' => (string)$result['resultId']);
		}

		self::logError('CRM form rejected request; HTTP ' . $status . ($curlError !== '' ? '; ' . $curlError : ''));
		return array('success' => false, 'error' => 'crm_form_rejected');
	}

	private static function json(array $value)
	{
		$options = defined('JSON_UNESCAPED_UNICODE') ? JSON_UNESCAPED_UNICODE : 0;
		return json_encode($value, $options);
	}

	private static function logError($message)
	{
		if (function_exists('AddMessage2Log')) {
			AddMessage2Log('CentrProgress Quiz Bitrix24: ' . $message, 'centrprogress.quiz');
		}
	}

	/**
	 * Создаёт лид через crm.lead.add. Возвращает true при успехе, false при отказе/ошибке.
	 */
	public static function sendLead($webhookUrl, array $fields)
	{
		if (!is_string($webhookUrl) || !preg_match('#^https://#i', $webhookUrl)) {
			return false;
		}
		$url = rtrim($webhookUrl, '/') . '/crm.lead.add.json';
		$payload = http_build_query(array('fields' => $fields), '', '&');
		try {
			if (class_exists('\\Bitrix\\Main\\Web\\HttpClient')) {
				$client = new \Bitrix\Main\Web\HttpClient(array(
					'timeout' => self::TIMEOUT,
					'socketTimeout' => self::TIMEOUT,
					'streamTimeout' => self::TIMEOUT,
				));
				$body = $client->post($url, $payload);
				$status = (int)$client->getStatus();
				$data = json_decode($body, true);
				return $status >= 200 && $status < 300 && is_array($data) && !empty($data['result']);
			}
			if (function_exists('curl_init')) {
				$ch = curl_init($url);
				curl_setopt_array($ch, array(
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $payload,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_TIMEOUT => self::TIMEOUT,
					CURLOPT_CONNECTTIMEOUT => self::TIMEOUT,
				));
				$body = curl_exec($ch);
				$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				$data = is_string($body) ? json_decode($body, true) : null;
				return $status >= 200 && $status < 300 && is_array($data) && !empty($data['result']);
			}
		} catch (\Exception $e) {
			self::logError($e->getMessage());
		}
		return false;
	}
}
