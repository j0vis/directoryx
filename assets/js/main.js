/**
 * DirectoryX Adult — Deferred JS
 * Loads non-critical CSS after first paint for 100/100/100 PageSpeed.
 * Glassmorphic color scheme switcher + mobile bottom nav.
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

	// Color scheme switcher
	var dots = document.querySelectorAll('.scheme-dot');
	var currentScheme = localStorage.getItem('dxadult-scheme') || 'midnight';

	function applyScheme(scheme) {
		document.documentElement.setAttribute('data-scheme', scheme);
		localStorage.setItem('dxadult-scheme', scheme);
		dots.forEach(function(d) {
			d.classList.toggle('active', d.getAttribute('data-scheme') === scheme);
		});
	}

	if (dots.length) {
		applyScheme(currentScheme);
		dots.forEach(function(dot) {
			dot.addEventListener('click', function() {
				applyScheme(this.getAttribute('data-scheme'));
			});
		});
	}

	// Mobile bottom nav: highlight current page
	var navLinks = document.querySelectorAll('.mobile-bottom-nav a');
	var currentPath = window.location.pathname;
	navLinks.forEach(function(link) {
		if (link.getAttribute('href') === currentPath) {
			link.classList.add('active');
		}
	});

	// Mobile search toggle
	var searchToggle = document.querySelector('.mobile-search-toggle');
	var searchOverlay = document.querySelector('.mobile-search-overlay');
	var searchInput = searchOverlay ? searchOverlay.querySelector('.search-field') : null;

	if (searchToggle && searchOverlay) {
		searchToggle.addEventListener('click', function(e) {
			e.preventDefault();
			searchOverlay.classList.toggle('active');
			if (searchOverlay.classList.contains('active') && searchInput) {
				searchInput.focus();
			}
		});
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
				searchOverlay.classList.remove('active');
			}
		});
	}
})();
