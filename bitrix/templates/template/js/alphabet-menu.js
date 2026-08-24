(function () {
	'use strict';
	function init() {
		var nodes = document.querySelectorAll('.alphabet-dropdown');
		Array.prototype.forEach.call(nodes, function (dropdown) {
			var toggle = dropdown.querySelector('a[aria-haspopup="true"]');
			if (!toggle) return;
			function close() { dropdown.classList.remove('open'); toggle.setAttribute('aria-expanded', 'false'); }
			function open() { dropdown.classList.add('open'); toggle.setAttribute('aria-expanded', 'true'); }
			toggle.addEventListener('click', function (event) {
				event.preventDefault();
				if (dropdown.classList.contains('open')) close(); else open();
			});
			document.addEventListener('keydown', function (event) {
				if ((event.key === 'Escape' || event.keyCode === 27) && dropdown.classList.contains('open')) { close(); toggle.focus(); }
			});
			document.addEventListener('click', function (event) {
				if (dropdown.classList.contains('open') && !dropdown.contains(event.target)) close();
			});
			dropdown.addEventListener('focusout', function (event) {
				if (!dropdown.contains(event.relatedTarget)) close();
			});
		});
	}
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
