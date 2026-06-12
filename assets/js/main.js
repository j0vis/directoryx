/**
 * DirectoryX Adult — Deferred JS
 * Loads non-critical CSS after first paint for 100/100/100 PageSpeed.
 * Light/dark theme toggle + mobile bottom nav.
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
	var schemeColors = {
		midnight: { dark: '#0d1117', light: '#f6f8fa' },
		emerald:  { dark: '#3fb950', light: '#1a7f37' },
		ruby:     { dark: '#f85149', light: '#cf222e' },
		amethyst: { dark: '#bc8cff', light: '#8250df' },
		amber:    { dark: '#e3b341', light: '#9a6700' },
		coral:    { dark: '#ff7b72', light: '#cf4a3a' },
		ocean:    { dark: '#39d0d8', light: '#0d7d7d' },
		slate:    { dark: '#a5b4fc', light: '#6366f1' }
	};

	function updateMetaThemeColor(theme, scheme) {
		if (metaThemeColor) {
			var colors = schemeColors[scheme] || schemeColors['midnight'];
			metaThemeColor.setAttribute('content', colors[theme]);
		}
	}

	function applyScheme(scheme) {
		document.documentElement.setAttribute('data-scheme', scheme);
		localStorage.setItem('dxadult-scheme', scheme);
		dots.forEach(function(d) {
			d.classList.toggle('active', d.getAttribute('data-scheme') === scheme);
		});
		var currentTheme = document.documentElement.getAttribute('data-theme') || localStorage.getItem('dxadult-theme') || 'dark';
		updateMetaThemeColor(currentTheme, scheme);
	}

	if (dots.length) {
		applyScheme(currentScheme);
		dots.forEach(function(dot) {
			dot.addEventListener('click', function() {
				applyScheme(this.getAttribute('data-scheme'));
			});
		});
	}

	// Light/dark theme toggle
	var themeToggle = document.getElementById('theme-toggle');
	var metaThemeColor = document.getElementById('meta-theme-color');
	var currentTheme = localStorage.getItem('dxadult-theme') || 'dark';

	function applyTheme(theme) {
		document.documentElement.setAttribute('data-theme', theme);
		localStorage.setItem('dxadult-theme', theme);
		if (themeToggle) {
			themeToggle.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
		}
		var activeScheme = document.documentElement.getAttribute('data-scheme') || currentScheme;
		updateMetaThemeColor(theme, activeScheme);
	}

	if (themeToggle) {
		applyTheme(currentTheme);
		themeToggle.addEventListener('click', function() {
			var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
			applyTheme(next);
		});
	} else {
		applyTheme(currentTheme);
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

	// AJAX search
	var searchForm = document.querySelector('.search-form');
	var searchField = searchForm ? searchForm.querySelector('.search-field') : null;
	var searchResults = document.getElementById('search-results');
	var searchTimer = null;

	if (searchField && searchResults && typeof dxadultData !== 'undefined') {
		searchField.addEventListener('input', function() {
			var q = this.value.trim();
			clearTimeout(searchTimer);
			if (q.length < 2) {
				searchResults.classList.remove('active');
				searchResults.innerHTML = '';
				return;
			}
			searchTimer = setTimeout(function() {
				var xhr = new XMLHttpRequest();
				xhr.open('GET', dxadultData.ajaxUrl + '?action=dxadult_ajax_search&q=' + encodeURIComponent(q), true);
				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4 && xhr.status === 200) {
						searchResults.innerHTML = xhr.responseText;
						searchResults.classList.add('active');
					}
				};
				xhr.send();
			}, 300);
		});

		document.addEventListener('click', function(e) {
			if (!searchForm.contains(e.target)) {
				searchResults.classList.remove('active');
			}
		});

		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				searchResults.classList.remove('active');
			}
		});
	}

	// Load deferred CSS after all event listeners are attached
	if (typeof dxadultData !== 'undefined') {
		dxadultLoadCSS(dxadultData.cssUrl, dxadultData.cssVersion);
	}
})();
