(function () {
    'use strict';

    var dropdowns = Array.prototype.slice.call(document.querySelectorAll('.service-mega-dropdown'));
    if (!dropdowns.length) return;

    function close(dropdown) {
        dropdown.classList.remove('open');
        var toggle = dropdown.querySelector('.service-mega-toggle');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
    }

    function closeAll(except) {
        dropdowns.forEach(function (dropdown) {
            if (dropdown !== except) close(dropdown);
        });
    }

    dropdowns.forEach(function (dropdown) {
        var toggle = dropdown.querySelector('.service-mega-toggle');
        if (!toggle) return;

        toggle.addEventListener('click', function (event) {
            if (window.matchMedia('(max-width: 1024px)').matches) return;
            event.preventDefault();
            var willOpen = !dropdown.classList.contains('open');
            closeAll(dropdown);
            dropdown.classList.toggle('open', willOpen);
            toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });

        dropdown.addEventListener('mouseenter', function () {
            if (window.matchMedia('(max-width: 1024px)').matches) return;
            closeAll(dropdown);
            dropdown.classList.add('open');
            toggle.setAttribute('aria-expanded', 'true');
        });

        dropdown.addEventListener('mouseleave', function () {
            if (!dropdown.contains(document.activeElement)) close(dropdown);
        });

        dropdown.addEventListener('focusout', function (event) {
            if (!dropdown.contains(event.relatedTarget)) close(dropdown);
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.service-mega-dropdown')) closeAll();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' || event.keyCode === 27) {
            closeAll();
        }
    });
}());
