/* Собственный многошаговый квиз centr-progress.com, версия 2.
   Универсальный: шаги задаются в CP_QUIZ_STEPS, отправка — на /local/ajax/quiz-submit.php. */
(function () {
	'use strict';

	var STEPS = [
		{
			key: 'direction',
			title: 'Какое направление обучения вас интересует?',
			type: 'radio',
			options: ['Промышленная безопасность', 'Охрана труда', 'Пожарная безопасность', 'Электробезопасность', 'Другое']
		},
		{
			key: 'format',
			title: 'Какой формат обучения вам удобнее?',
			type: 'radio',
			options: ['Дистанционно', 'Очно в учебном центре', 'С выездом на предприятие', 'Нужна консультация']
		},
		{
			key: 'people',
			title: 'Сколько человек планируется обучить?',
			type: 'radio',
			options: ['1', '2–5', '6–20', 'Более 20']
		},
		{
			key: 'timing',
			title: 'Когда планируете начать обучение?',
			type: 'radio',
			options: ['Как можно скорее', 'В ближайший месяц', 'В течение квартала', 'Пока изучаю варианты']
		},
		{
			key: 'contacts',
			title: 'Куда отправить расчёт со скидкой?',
			type: 'contacts'
		}
	];

	function $(sel, root) { return (root || document).querySelector(sel); }

	function reachGoal(goal) {
		var counterId = window.CP_QUIZ && window.CP_QUIZ.metrikaId;
		if (counterId && typeof window.ym === 'function') {
			window.ym(counterId, 'reachGoal', goal);
		}
	}

	function escapeHtml(s) {
		return String(s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}

	function CpQuiz(root) {
		this.root = root;
		this.form = $('#cp-quiz-form', root);
		this.stepsBox = $('[data-cp-quiz-steps]', root);
		this.resultBox = $('[data-cp-quiz-result]', root);
		this.progressBox = $('[data-cp-quiz-progress]', root);
		this.progressLabel = $('[data-cp-quiz-progress-label]', root);
		this.prevBtn = $('[data-cp-quiz-prev]', root);
		this.nextBtn = $('[data-cp-quiz-next]', root);
		this.current = 0;
		this.answers = {};
		this.contacts = { name: '', phone: '', email: '', consent: false };
		this.steps = (window.CP_QUIZ && window.CP_QUIZ.steps) || STEPS;
		this.endpoint = (window.CP_QUIZ && window.CP_QUIZ.endpoint) || '/local/ajax/quiz-submit.php';
		this.token = (window.CP_QUIZ && window.CP_QUIZ.token) || '';
		this.renderStep();
		this.bind();
	}

	CpQuiz.prototype.renderStep = function () {
		var step = this.steps[this.current];
		var html = '<div class="CpQuizStep"><div class="CpQuizStepTitle">' + escapeHtml(step.title) + '</div>';
		var i, name = 'answer_' + step.key;
		if (step.type === 'radio') {
			html += '<div class="CpQuizOptions">';
			for (i = 0; i < step.options.length; i++) {
				var checked = this.answers[step.key] === step.options[i] ? ' checked' : '';
				html += '<label class="CpQuizOption"><input type="radio" name="' + escapeHtml(name) +
					'" value="' + escapeHtml(step.options[i]) + '"' + checked + '><span>' + escapeHtml(step.options[i]) + '</span></label>';
			}
			html += '</div>';
		} else if (step.type === 'contacts') {
			html += '<div class="CpQuizContacts">' +
				'<input type="text" name="name" class="CpQuizInput" placeholder="Ваше имя" maxlength="100" value="' + escapeHtml(this.contacts.name) + '" required>' +
				'<input type="tel" name="phone" class="CpQuizInput inp_tel" placeholder="Телефон" maxlength="32" value="' + escapeHtml(this.contacts.phone) + '" required>' +
				'<input type="email" name="email" class="CpQuizInput" placeholder="E-mail (необязательно)" maxlength="100" value="' + escapeHtml(this.contacts.email) + '">' +
				'<label class="CpQuizConsent"><input type="checkbox" name="consent" value="1"' + (this.contacts.consent ? ' checked' : '') + ' required>' +
				'<span>Согласен на обработку персональных данных</span></label>' +
				'</div>';
		}
		html += '<div class="CpQuizError" data-cp-quiz-error hidden></div></div>';
		this.stepsBox.innerHTML = html;
		this.prevBtn.style.visibility = this.current === 0 ? 'hidden' : 'visible';
		this.nextBtn.textContent = this.current === this.steps.length - 1 ? 'Отправить' : 'Далее';
		this.progressBox.style.width = (((this.current + 1) / this.steps.length) * 100) + '%';
		this.progressLabel.textContent = 'Шаг ' + (this.current + 1) + ' из ' + this.steps.length;
		if (step.type === 'contacts' && window.jQuery && jQuery.fn && jQuery.fn.mask) {
			jQuery(this.stepsBox).find('input[name="phone"]').mask('+7 (999) 999-99-99');
		}
	};

	CpQuiz.prototype.saveCurrent = function () {
		var step = this.steps[this.current];
		if (step.type === 'radio') {
			var checked = this.stepsBox.querySelector('input[type="radio"]:checked');
			if (checked) this.answers[step.key] = checked.value;
		} else if (step.type === 'contacts') {
			this.contacts.name = (this.stepsBox.querySelector('input[name="name"]') || {}).value || '';
			this.contacts.phone = (this.stepsBox.querySelector('input[name="phone"]') || {}).value || '';
			this.contacts.email = (this.stepsBox.querySelector('input[name="email"]') || {}).value || '';
			this.contacts.consent = !!((this.stepsBox.querySelector('input[name="consent"]') || {}).checked);
		}
	};

	CpQuiz.prototype.error = function (msg) {
		var box = $('[data-cp-quiz-error]', this.stepsBox);
		if (box) { box.textContent = msg; box.hidden = !msg; }
	};

	CpQuiz.prototype.validateCurrent = function () {
		var step = this.steps[this.current];
		if (step.type === 'radio') {
			var checked = this.stepsBox.querySelector('input[type="radio"]:checked');
			if (!checked) { this.error('Выберите один из вариантов'); return false; }
		} else if (step.type === 'contacts') {
			var name = this.stepsBox.querySelector('input[name="name"]');
			var phone = this.stepsBox.querySelector('input[name="phone"]');
			var consent = this.stepsBox.querySelector('input[name="consent"]');
			var digits = phone.value.replace(/\D/g, '');
			if (!name.value.trim()) { this.error('Укажите имя'); return false; }
			if (digits.length < 10) { this.error('Укажите корректный телефон'); return false; }
			if (!consent.checked) { this.error('Подтвердите согласие на обработку данных'); return false; }
		}
		this.error('');
		return true;
	};

	CpQuiz.prototype.collect = function () {
		this.saveCurrent();
		var data = { answers: {}, name: '', phone: '', email: '', company: '', token: this.token, page: location.href };
		for (var i = 0; i < this.steps.length; i++) {
			var step = this.steps[i];
			if (step.type === 'radio') {
				data.answers[step.title] = this.answers[step.key] || '';
			}
		}
		data.name = this.contacts.name;
		data.phone = this.contacts.phone;
		data.email = this.contacts.email;
		data.company = (this.form.querySelector('[data-cp-quiz-hp]') || {}).value || '';
		return data;
	};

	CpQuiz.prototype.submit = function () {
		var self = this;
		var payload = this.collect();
		var body = Object.keys(payload).map(function (k) {
			var v = payload[k];
			if (typeof v === 'object') {
				return Object.keys(v).map(function (q) {
					return 'answers[' + encodeURIComponent(q) + ']=' + encodeURIComponent(v[q]);
				}).join('&');
			}
			return encodeURIComponent(k) + '=' + encodeURIComponent(v);
		}).join('&');
		this.nextBtn.disabled = true;
		fetch(this.endpoint, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
			body: body,
			credentials: 'same-origin'
		}).then(function (r) { return r.json(); }).then(function (res) {
			self.nextBtn.disabled = false;
			if (res && res.success) {
				reachGoal('quiz_success');
				self.stepsBox.innerHTML = '';
				self.prevBtn.style.display = 'none';
				self.nextBtn.style.display = 'none';
				self.resultBox.hidden = false;
				self.resultBox.textContent = 'Спасибо! Ваша заявка принята, мы свяжемся с вами в ближайшее время.';
			} else {
				self.error((res && res.error) || 'Не удалось отправить заявку. Попробуйте позже.');
			}
		}).catch(function () {
			self.nextBtn.disabled = false;
			self.error('Не удалось отправить заявку. Попробуйте позже.');
		});
	};

	CpQuiz.prototype.bind = function () {
		var self = this;
		this.nextBtn.addEventListener('click', function () {
			if (!self.validateCurrent()) return;
			self.saveCurrent();
			if (self.current < self.steps.length - 1) {
				self.current++;
				self.renderStep();
			} else {
				self.submit();
			}
		});
		this.prevBtn.addEventListener('click', function () {
			self.saveCurrent();
			if (self.current > 0) { self.current--; self.renderStep(); }
		});
	};

	function openQuiz(quiz, root) {
		if (window.CP_B24_CHAT_WIDGET && typeof window.CP_B24_CHAT_WIDGET.close === 'function') {
			window.CP_B24_CHAT_WIDGET.close();
		}
		root.setAttribute('aria-hidden', 'false');
		root.classList.add('CpQuizActive');
		document.body.classList.add('CpQuizOpenState');
		document.body.style.overflow = 'hidden';
		reachGoal('quiz_open');
		setTimeout(function () {
			var first = root.querySelector('input, button');
			if (first) first.focus();
		}, 30);
	}
	function closeQuiz(root) {
		root.setAttribute('aria-hidden', 'true');
		root.classList.remove('CpQuizActive');
		document.body.classList.remove('CpQuizOpenState');
		document.body.style.overflow = '';
	}

	document.addEventListener('DOMContentLoaded', function () {
		var root = document.getElementById('cp-quiz');
		if (!root) return;
		var quiz = new CpQuiz(root);
		window.addEventListener('onBitrixLiveChat', function (event) {
			var widget = event && event.detail ? event.detail.widget : null;
			if (!widget) return;
			window.CP_B24_CHAT_WIDGET = widget;
			if (widget.subscribe && window.BX && BX.LiveChatWidget && BX.LiveChatWidget.SubscriptionType) {
				widget.subscribe({
					type: BX.LiveChatWidget.SubscriptionType.widgetOpen,
					callback: function () {
						if (root.classList.contains('CpQuizActive')) closeQuiz(root);
					}
				});
			}
		});
		document.querySelectorAll('[data-cp-quiz-open]').forEach(function (btn) {
			btn.addEventListener('click', function () { openQuiz(quiz, root); });
		});
		root.querySelectorAll('[data-cp-quiz-close]').forEach(function (el) {
			el.addEventListener('click', function () { closeQuiz(root); });
		});
		document.addEventListener('keydown', function (event) {
			if ((event.key === 'Escape' || event.keyCode === 27) && root.classList.contains('CpQuizActive')) closeQuiz(root);
		});

		document.querySelectorAll('[data-cp-callback-focus]').forEach(function (button) {
			button.addEventListener('click', function () {
				var field = document.querySelector('#cp-callback-form input[name="name"]');
				if (!field) return;
				document.getElementById('cp-callback').scrollIntoView({ behavior: 'smooth', block: 'center' });
				setTimeout(function () { field.focus(); }, 450);
				reachGoal('callback_open');
			});
		});

		var callbackForm = document.getElementById('cp-callback-form');
		if (callbackForm) {
			callbackForm.addEventListener('submit', function (event) {
				event.preventDefault();
				var result = callbackForm.querySelector('[data-cp-callback-result]');
				var name = callbackForm.querySelector('input[name="name"]');
				var phone = callbackForm.querySelector('input[name="phone"]');
				var consent = callbackForm.querySelector('input[name="consent"]');
				var submit = callbackForm.querySelector('button[type="submit"]');
				var digits = phone.value.replace(/\D/g, '');
				result.className = 'CpCallbackResult CpCallbackResultError';
				if (!name.value.trim()) { result.textContent = 'Укажите имя.'; name.focus(); return; }
				if (digits.length < 10) { result.textContent = 'Укажите корректный телефон.'; phone.focus(); return; }
				if (!consent.checked) { result.textContent = 'Подтвердите согласие на обработку данных.'; consent.focus(); return; }
				var body = [
					'name=' + encodeURIComponent(name.value.trim()),
					'phone=' + encodeURIComponent(phone.value),
					'email=',
					'company=' + encodeURIComponent((callbackForm.querySelector('input[name="company"]') || {}).value || ''),
					'token=' + encodeURIComponent(quiz.token),
					'page=' + encodeURIComponent(location.href),
					'answers[' + encodeURIComponent('Тип заявки') + ']=' + encodeURIComponent('Обратный звонок')
				].join('&');
				submit.disabled = true;
				result.textContent = 'Отправляем заявку…';
				fetch(quiz.endpoint, {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
					body: body,
					credentials: 'same-origin'
				}).then(function (response) { return response.json(); }).then(function (response) {
					submit.disabled = false;
					if (!response || !response.success) throw new Error((response && response.error) || 'Не удалось отправить заявку.');
					result.className = 'CpCallbackResult CpCallbackResultSuccess';
					result.textContent = 'Спасибо! Заявка зарегистрирована, мы скоро перезвоним.';
					callbackForm.reset();
					reachGoal('callback_success');
				}).catch(function (error) {
					submit.disabled = false;
					result.className = 'CpCallbackResult CpCallbackResultError';
					result.textContent = error.message || 'Не удалось отправить заявку. Позвоните нам по номеру в шапке сайта.';
				});
			});
		}
	});
})();
