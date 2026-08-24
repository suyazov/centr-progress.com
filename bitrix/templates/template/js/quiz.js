/* Собственный многошаговый квиз centr-progress.com (замена Marquiz).
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
		this.prevBtn = $('[data-cp-quiz-prev]', root);
		this.nextBtn = $('[data-cp-quiz-next]', root);
		this.current = 0;
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
				html += '<label class="CpQuizOption"><input type="radio" name="' + escapeHtml(name) +
					'" value="' + escapeHtml(step.options[i]) + '"><span>' + escapeHtml(step.options[i]) + '</span></label>';
			}
			html += '</div>';
		} else if (step.type === 'contacts') {
			html += '<div class="CpQuizContacts">' +
				'<input type="text" name="name" class="CpQuizInput" placeholder="Ваше имя" maxlength="100" required>' +
				'<input type="tel" name="phone" class="CpQuizInput inp_tel" placeholder="Телефон" maxlength="32" required>' +
				'<input type="email" name="email" class="CpQuizInput" placeholder="E-mail (необязательно)" maxlength="100">' +
				'<label class="CpQuizConsent"><input type="checkbox" name="consent" value="1" required>' +
				'<span>Согласен на обработку персональных данных</span></label>' +
				'</div>';
		}
		html += '<div class="CpQuizError" data-cp-quiz-error hidden></div></div>';
		this.stepsBox.innerHTML = html;
		this.prevBtn.style.visibility = this.current === 0 ? 'hidden' : 'visible';
		this.nextBtn.textContent = this.current === this.steps.length - 1 ? 'Отправить' : 'Далее';
		this.progressBox.textContent = 'Шаг ' + (this.current + 1) + ' из ' + this.steps.length;
		if (step.type === 'contacts' && window.jQuery && jQuery.fn && jQuery.fn.mask) {
			jQuery(this.stepsBox).find('input[name="phone"]').mask('+7 (999) 999-99-99');
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
		var data = { answers: {}, name: '', phone: '', email: '', company: '', token: this.token, page: location.href };
		for (var i = 0; i < this.steps.length; i++) {
			var step = this.steps[i];
			if (step.type === 'radio') {
				var el = this.form.querySelector('input[name="answer_' + step.key + '"]:checked');
				data.answers[step.title] = el ? el.value : '';
			}
		}
		data.name = (this.form.querySelector('input[name="name"]') || {}).value || '';
		data.phone = (this.form.querySelector('input[name="phone"]') || {}).value || '';
		data.email = (this.form.querySelector('input[name="email"]') || {}).value || '';
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
			if (self.current < self.steps.length - 1) {
				self.current++;
				self.renderStep();
			} else {
				self.submit();
			}
		});
		this.prevBtn.addEventListener('click', function () {
			if (self.current > 0) { self.current--; self.renderStep(); }
		});
	};

	function openQuiz(quiz, root) {
		root.setAttribute('aria-hidden', 'false');
		root.classList.add('CpQuizActive');
		document.body.style.overflow = 'hidden';
	}
	function closeQuiz(root) {
		root.setAttribute('aria-hidden', 'true');
		root.classList.remove('CpQuizActive');
		document.body.style.overflow = '';
	}

	document.addEventListener('DOMContentLoaded', function () {
		var root = document.getElementById('cp-quiz');
		if (!root) return;
		var quiz = new CpQuiz(root);
		document.querySelectorAll('[data-cp-quiz-open]').forEach(function (btn) {
			btn.addEventListener('click', function () { openQuiz(quiz, root); });
		});
		root.querySelectorAll('[data-cp-quiz-close]').forEach(function (el) {
			el.addEventListener('click', function () { closeQuiz(root); });
		});
	});
})();
