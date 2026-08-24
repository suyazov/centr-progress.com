<?php
namespace CentrProgress\Quiz;

/**
 * Серверная обработка отправки квиза: CSRF/session-токен, honeypot,
 * rate-limit, валидация, email через штатный CEvent и опциональный Bitrix24.
 */
class SubmitHandler
{
	const EVENT_TYPE = 'CENTR_PROGRESS_QUIZ';
	const SESSION_KEY = 'CP_QUIZ_RATE_LIMIT';

	/**
	 * @param array $request $_POST
	 * @param array $session $_SESSION
	 * @param string $sessId результат bitrix_sessid()
	 * @param string $siteId SITE_ID
	 * @return array ['success' => bool, 'error' => string|null]
	 */
	public static function handle(array $request, array &$session, $sessId, $siteId)
	{
		if (!Validator::checkToken(isset($request['token']) ? $request['token'] : '', $sessId)) {
			return array('success' => false, 'error' => 'Сессия устарела. Обновите страницу и попробуйте снова.');
		}
		if (Validator::isHoneypotFilled(isset($request['company']) ? $request['company'] : '')) {
			// Бот: отвечаем успехом, но ничего не отправляем.
			return array('success' => true, 'error' => null);
		}
		if (!isset($session[self::SESSION_KEY]) || !is_array($session[self::SESSION_KEY])) {
			$session[self::SESSION_KEY] = array('start' => 0, 'count' => 0);
		}
		list($allowed, $bucket) = Validator::rateLimitAllow($session[self::SESSION_KEY], time());
		if (!$allowed) {
			return array('success' => false, 'error' => 'Слишком много отправок. Попробуйте позже.');
		}

		$name = Validator::cleanString(isset($request['name']) ? $request['name'] : '', 100);
		$phone = Validator::cleanString(isset($request['phone']) ? $request['phone'] : '', 32);
		$email = Validator::cleanString(isset($request['email']) ? $request['email'] : '', 100);
		$page = Validator::cleanString(isset($request['page']) ? $request['page'] : '', 500);
		$answers = Validator::validateAnswers(isset($request['answers']) ? $request['answers'] : array());

		if (!Validator::validateName($name)) {
			return array('success' => false, 'error' => 'Укажите имя.');
		}
		if (!Validator::validatePhone($phone)) {
			return array('success' => false, 'error' => 'Укажите корректный телефон.');
		}
		if (!Validator::validateEmail($email)) {
			return array('success' => false, 'error' => 'Укажите корректный e-mail.');
		}
		if ($answers === false) {
			return array('success' => false, 'error' => 'Ответьте на вопросы квиза.');
		}

		$session[self::SESSION_KEY] = $bucket;

		$answersText = '';
		foreach ($answers as $question => $answer) {
			$answersText .= $question . ': ' . $answer . "\n";
		}

		// Email через штатный механизм почтовых событий Bitrix.
		// Тип события CENTR_PROGRESS_QUIZ и его шаблон создаются в административной части.
		$sent = \CEvent::Send(self::EVENT_TYPE, $siteId, array(
			'NAME' => $name,
			'PHONE' => $phone,
			'EMAIL' => $email,
			'ANSWERS' => $answersText,
			'PAGE' => $page,
			'DATE' => date('d.m.Y H:i'),
		));

		if (!$sent) {
			return array('success' => false, 'error' => 'Не удалось отправить заявку. Попробуйте позже.');
		}

		// Опциональная интеграция Bitrix24; отказ не влияет на принятие заявки.
		$webhookUrl = Bitrix24Client::resolveWebhookUrl();
		if ($webhookUrl !== null) {
			Bitrix24Client::sendLead($webhookUrl, array(
				'TITLE' => 'Квиз с сайта ' . $siteId,
				'NAME' => $name,
				'PHONE' => array(array('VALUE' => Validator::normalizePhone($phone), 'VALUE_TYPE' => 'WORK')),
				'EMAIL' => $email !== '' ? array(array('VALUE' => $email, 'VALUE_TYPE' => 'WORK')) : array(),
				'COMMENTS' => $answersText . "\nСтраница: " . $page,
				'SOURCE_DESCRIPTION' => 'Квиз на сайте',
			));
		}

		return array('success' => true, 'error' => null);
	}
}
