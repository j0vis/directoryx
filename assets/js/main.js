/**
 * DirectoryX Adult — Deferred JS
 * Loads non-critical CSS after first paint for 100/100/100 PageSpeed.
 * Theme toggle, AJAX search, mobile bottom nav, back-to-top, lightbox, toasts,
 * click tracking, keyboard navigation, focus trap, IntersectionObserver.
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

	/* ── Helpers ── */
	function $(s, c) { return (c || document).querySelector(s); }
	function $$(s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); }

	/* ── Mobile menu toggle (with focus trap) ── */
	var toggle = $('.menu-toggle');
	var nav = $('.main-navigation');
	var navList = nav ? $('ul', nav) : null;

	if (toggle && nav) {
		toggle.addEventListener('click', function() {
			var open = nav.classList.toggle('toggled');
			toggle.setAttribute('aria-expanded', open);
			if (open && navList) {
				var firstLink = $('a', navList);
				if (firstLink) firstLink.focus();
			}
		});
	}

	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && nav && nav.classList.contains('toggled')) {
			nav.classList.remove('toggled');
			if (toggle) toggle.setAttribute('aria-expanded', 'false');
			if (toggle) toggle.focus();
		}
		if (e.key === 'Tab' && nav && nav.classList.contains('toggled') && navList) {
			// Simple focus trap.
			var items = $$('a, button', navList);
			if (!items.length) return;
			var first = items[0], last = items[items.length - 1];
			if (e.shiftKey && document.activeElement === first) {
				e.preventDefault();
				last.focus();
			} else if (!e.shiftKey && document.activeElement === last) {
				e.preventDefault();
				first.focus();
			}
		}
	});

	/* ── Color scheme switcher ── */
	var dots = $$('.scheme-dot');
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
	var metaThemeColor = $('#meta-theme-color');

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
		var currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
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

	/* ── Light/dark theme toggle ── */
	var themeToggle = $('#theme-toggle');

	function applyTheme(theme) {
		document.documentElement.setAttribute('data-theme', theme);
		localStorage.setItem('dxadult-theme', theme);
		if (themeToggle) themeToggle.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
		var activeScheme = document.documentElement.getAttribute('data-scheme') || currentScheme;
		updateMetaThemeColor(theme, activeScheme);
	}

	applyTheme(localStorage.getItem('dxadult-theme') || 'dark');
	if (themeToggle) {
		themeToggle.addEventListener('click', function() {
			var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
			applyTheme(next);
		});
	}

	/* ── Mobile bottom nav active state ── */
	$$('.mobile-bottom-nav a').forEach(function(link) {
		if (link.getAttribute('href') === window.location.pathname) link.classList.add('active');
	});

	/* ── Mobile search toggle ── */
	var searchToggle = $('.mobile-search-toggle');
	var searchOverlay = $('.mobile-search-overlay');
	var searchInput = searchOverlay ? $('.search-field', searchOverlay) : null;

	if (searchToggle && searchOverlay) {
		searchToggle.addEventListener('click', function(e) {
			e.preventDefault();
			searchOverlay.classList.toggle('active');
			if (searchOverlay.classList.contains('active') && searchInput) searchInput.focus();
		});
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
				searchOverlay.classList.remove('active');
			}
		});
	}

	/* ── AJAX search with keyboard nav ── */
	var searchForm = $('.search-form');
	var searchField = searchForm ? $('.search-field', searchForm) : null;
	var searchResults = $('#search-results');
	var searchTimer = null;
	var searchFocusIdx = -1;

	function setSearchFocus(items) {
		if (!items.length) return;
		items.forEach(function(i) { i.classList.remove('is-focused'); });
		if (searchFocusIdx < 0) searchFocusIdx = 0;
		if (searchFocusIdx >= items.length) searchFocusIdx = items.length - 1;
		var el = items[searchFocusIdx];
		if (el) {
			el.classList.add('is-focused');
			el.scrollIntoView({ block: 'nearest' });
		}
	}

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
				xhr.open('GET', dxadultData.ajaxUrl + '?action=dxadult_ajax_search&nonce=' + encodeURIComponent(dxadultData.searchNonce) + '&q=' + encodeURIComponent(q), true);
				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4 && xhr.status === 200) {
						searchResults.innerHTML = xhr.responseText;
						searchResults.classList.add('active');
						searchFocusIdx = -1;
					}
				};
				xhr.send();
			}, 300);
		});

		searchField.addEventListener('keydown', function(e) {
			var items = $$('a', searchResults);
			if (e.key === 'ArrowDown') { e.preventDefault(); searchFocusIdx++; setSearchFocus(items); }
			else if (e.key === 'ArrowUp') { e.preventDefault(); searchFocusIdx--; setSearchFocus(items); }
			else if (e.key === 'Enter' && searchFocusIdx >= 0 && items[searchFocusIdx]) { e.preventDefault(); window.location.href = items[searchFocusIdx].href; }
		});

		document.addEventListener('click', function(e) {
			if (!searchForm.contains(e.target)) searchResults.classList.remove('active');
		});

		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && searchResults.classList.contains('active')) {
				searchResults.classList.remove('active');
				searchFocusIdx = -1;
			}
		});
	}

	/* ── Outbound click tracking ── */
	document.addEventListener('click', function(e) {
		var link = e.target.closest('.dxadult-outbound-link');
		if (!link) return;
		var postId = link.getAttribute('data-post-id');
		if (!postId || typeof dxadultData === 'undefined') return;
		try {
			var data = new FormData();
			data.append('action', 'dxadult_click_track');
			data.append('post_id', postId);
			data.append('nonce', dxadultData.clickNonce);
			navigator.sendBeacon(dxadultData.ajaxUrl, data);
		} catch (err) { /* silent */ }
	});

	/* ── Back to top ── */
	var backToTop = $('.back-to-top');
	if (backToTop) {
		var ticking = false;
		window.addEventListener('scroll', function() {
			if (!ticking) {
				window.requestAnimationFrame(function() {
					backToTop.classList.toggle('visible', window.scrollY > 400);
					ticking = false;
				});
				ticking = true;
			}
		}, { passive: true });
		backToTop.addEventListener('click', function() {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}

	/* ── Scroll progress ── */
	var scrollProgress = $('.scroll-progress');
	if (scrollProgress) {
		var pTicking = false;
		window.addEventListener('scroll', function() {
			if (!pTicking) {
				window.requestAnimationFrame(function() {
					var h = document.documentElement.scrollHeight - window.innerHeight;
					var p = h > 0 ? (window.scrollY / h) * 100 : 0;
					scrollProgress.style.width = p + '%';
					pTicking = false;
				});
				pTicking = true;
			}
		}, { passive: true });
	}

	/* ── Lightbox ── */
	var lightbox = $('.lightbox');
	var lightboxImg = lightbox ? $('.lightbox__image', lightbox) : null;
	if (lightbox && lightboxImg) {
		$$('.listing-card__thumbnail img, .post-thumbnail img').forEach(function(img) {
			img.style.cursor = 'zoom-in';
			img.addEventListener('click', function(e) {
				if (e.target.closest('a')) return;
				e.preventDefault();
				lightboxImg.src = img.src;
				lightboxImg.alt = img.alt || '';
				lightbox.classList.add('active');
				lightbox.setAttribute('aria-hidden', 'false');
				var close = $('.lightbox__close', lightbox);
				if (close) close.focus();
			});
		});
		var closeLightbox = function() {
			lightbox.classList.remove('active');
			lightbox.setAttribute('aria-hidden', 'true');
		};
		$('.lightbox__close', lightbox).addEventListener('click', closeLightbox);
		lightbox.addEventListener('click', function(e) {
			if (e.target === lightbox) closeLightbox();
		});
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && lightbox.classList.contains('active')) closeLightbox();
		});
	}

	/* ── Toast notifications (global) ── */
	window.dxadultToast = function(msg, type) {
		var container = $('.toast-container');
		if (!container) return;
		var toast = document.createElement('div');
		toast.className = 'toast' + (type ? ' toast--' + type : '');
		toast.textContent = msg;
		container.appendChild(toast);
		requestAnimationFrame(function() { toast.classList.add('visible'); });
		setTimeout(function() {
			toast.classList.remove('visible');
			setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
		}, 3000);
	};

	/* ── Copy link to clipboard (social share) ── */
	document.addEventListener('click', function(e) {
		var btn = e.target.closest('.copy-link');
		if (!btn) return;
		var url = btn.getAttribute('data-url');
		if (!url) return;
		if (navigator.clipboard && window.isSecureContext) {
			navigator.clipboard.writeText(url).then(function() {
				window.dxadultToast && window.dxadultToast('Link copied!', 'success');
			});
		} else {
			var ta = document.createElement('textarea');
			ta.value = url;
			document.body.appendChild(ta);
			ta.select();
			try { document.execCommand('copy'); window.dxadultToast && window.dxadultToast('Link copied!', 'success'); } catch (err) { /* */ }
			document.body.removeChild(ta);
		}
	});

	/* ── IntersectionObserver for card entrance animations (CSS-class driven) ── */
	if ('IntersectionObserver' in window) {
		var io = new IntersectionObserver(function(entries) {
			entries.forEach(function(en) {
				if (en.isIntersecting) {
					en.target.classList.add('is-visible');
					io.unobserve(en.target);
				}
			});
		}, { rootMargin: '50px' });
		$$('.listing-card, .category-card').forEach(function(el) {
			io.observe(el);
		});
	}

	/* ── Archive filter auto-submit (progressive enhancement) ── */
	$$('.archive-filters__auto-submit').forEach(function(sel) {
		sel.addEventListener('change', function() {
			var form = sel.closest('form');
			if (form) form.submit();
		});
	});

	/* ── Instant prefetch (hover/touchstart) ── */
	if ('requestIdleCallback' in window) {
		var prefetched = {};
		document.addEventListener('mouseover', function(e) {
			var a = e.target.closest('a[href]');
			if (!a || prefetched[a.href]) return;
			if (a.origin !== location.origin) return;
			prefetched[a.href] = true;
			var l = document.createElement('link');
			l.rel = 'prefetch';
			l.href = a.href;
			document.head.appendChild(l);
		});
	}

	/* ── Reported success message ── */
	var reported = new URLSearchParams(window.location.search).get('reported');
	if (reported === '1') {
		window.dxadultToast && window.dxadultToast('Report submitted. Thank you!', 'success');
	}

	/* ── Load deferred CSS ── */
	if (typeof dxadultData !== 'undefined') {
		dxadultLoadCSS(dxadultData.cssUrl, dxadultData.cssVersion);
	}
})();
