/**
 * DirectoryX Adult — Deferred JS
 * Loads non-critical CSS after first paint for 100/100/100 PageSpeed.
 */
function dxadultLoadCSS(href, version) {
	var link = document.createElement('link');
	link.rel = 'stylesheet';
	link.href = href + '?ver=' + version;
	link.media = 'print';
	link.onload = function() {
		this.media = 'all';
	};
	document.head.appendChild(link);
}

(function() {
	'use strict';

	// Mobile menu toggle
	var toggle = document.querySelector('.menu-toggle');
	var nav = document.querySelector('.main-navigation');

	if (toggle && nav) {
		toggle.addEventListener('click', function() {
			nav.classList.toggle('toggled');
			var expanded = nav.classList.contains('toggled');
			toggle.setAttribute('aria-expanded', expanded);
		});
	}

	// Keyboard: close menu on Escape
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && nav && nav.classList.contains('toggled')) {
			nav.classList.remove('toggled');
			toggle.setAttribute('aria-expanded', 'false');
		}
	});
})();
