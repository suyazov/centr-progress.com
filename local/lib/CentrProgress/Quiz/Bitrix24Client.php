<?php
namespace CentrProgress\Quiz;

/**
 * Опциональная интеграция с Bitrix24 через входящий вебхук.
 * URL берётся из защищённой конфигурации (env BITRIX24_WEBHOOK_URL или
 * local/php_interface/include/quiz_config.php), никогда не хранится в коде.
 * Таймаут ограничен, при любой ошибке — graceful fallback (false), заявка не теряется.
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
				$client->post($url, $payload);
				$status = (int)$client->getStatus();
				return $status >= 200 && $status < 300;
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
				curl_exec($ch);
				$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				return $status >= 200 && $status < 300;
			}
		} catch (\Exception $e) {
			if (function_exists('AddMessage2Log')) {
				AddMessage2Log('CentrProgress Quiz Bitrix24 error: ' . $e->getMessage(), 'centrprogress.quiz');
			}
		}
		return false;
	}
}
