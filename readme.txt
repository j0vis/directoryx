=== DirectoryX Adult ===
Contributors: j0vis
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A high-performance adult site directory theme built on DirectoryX. Glassmorphic design with 8 accessible color schemes and SVG icons. Optimized for 100/100/100 PageSpeed.

== Description ==

DirectoryX Adult is a production-ready WordPress theme for building adult site directories (similar to ThePornDude). Built on the DirectoryX project foundation, following WordPress 2026 / Version 7 standards.

Key features:

* **Glassmorphic design** — Frosted glass cards with backdrop-filter blur, subtle glow effects, and smooth hover animations.
* **8 accessible color schemes** — Midnight Blue (default), Emerald Green, Ruby Red, Amethyst Purple, Amber Gold, Coral Orange, Ocean Teal, and Slate Indigo. Persisted in localStorage. WCAG AA compliant contrast ratios.
* **Color scheme picker** — In-header color dots. Users choose their preference; site owners set the default via Customizer.
* **SVG icon system** — 30+ inline SVG icons, themeable via CSS currentColor, used throughout the theme.
* **100/100/100 PageSpeed** — Critical CSS inlined in `<head>`. Non-critical styles loaded after first paint via deferred JS. All JS deferred. Emoji scripts and block library CSS removed.
* **Dark mode by default** — GitHub-dark-inspired color scheme (#0d1117 background) for comfortable browsing.
* **Listing management** — Custom "listing" post type with URL, rating, status, featured flag, view counter, and click counter meta fields. Admin columns, sortable columns, and quick edit included.
* **Featured listings** — Pin listings to the top of archives with a gold "Featured" badge.
* **Category taxonomy** — "listing_category" taxonomy for organizing sites. Category archive templates included.
* **Related & recently viewed** — Single-listing pages show related listings by category and a "Recently Viewed" grid (cookie-tracked, HttpOnly + SameSite=Lax).
* **Social share & report** — X (Twitter) share, copy-link, and a "Report this listing" form for broken / inappropriate / spam content.
* **Archive filtering** — Sort (Newest, Top Rated, Most Popular, A–Z), category, status, and min-rating filters on archive pages. Nonce-protected form.
* **Top Rated & Most Popular page templates** — Drop-in templates for curated discovery.
* **AJAX search** — Live dropdown with debounced input, keyboard navigation (arrow keys, Enter, Escape), `aria-live` results, and rate limiting (10 req/min/IP).
* **REST API** — `GET /wp-json/directoryx/v1/listings` with category, status, min_rating, sort, and per_page params.
* **Click & view tracking** — `navigator.sendBeacon` for outbound clicks, server-side view increments on single-listing pages.
* **Image lightbox** — Fullscreen modal for listing thumbnails. Esc / overlay-click to close.
* **UX helpers** — Back-to-top button, scroll progress bar, toast notifications, loading skeletons, intersection-observer entrance animations (reduced-motion aware), instant prefetch on hover, mobile menu focus trap.
* **Responsive grid layout** — CSS Grid-based glass cards with auto-fill columns and mobile-first responsive breakpoints.
* **Mobile bottom nav** — Fixed bottom navigation bar on mobile with Home, Search, and Listings links. Respects safe-area-inset.
* **Directory page templates** — Directory Home, Directory Categories, Top Rated, Most Popular, and Full Width templates.
* **Block editor support** — `theme.json` with color palette, typography, and spacing matching the theme.
* **Open Graph & Twitter Cards** — Auto-generated social meta on singular pages. Canonical URLs and JSON-LD schema (Thing + AggregateRating + BreadcrumbList).
* **Customizer support** — Default color scheme setting.
* **Accessibility** — Skip links, ARIA labels, semantic HTML5 landmarks, screen-reader-text utilities, reduced motion support, focus trap on mobile menu.
* **Translation ready** — All strings use `esc_html__()` / `_e()` with the `directoryx-adult` text domain. POT file included.
* **Security** — Nonces on all forms and AJAX, hashed report IPs (`wp_hash( $ip . AUTH_SALT )`), rate-limited search, HttpOnly + SameSite cookies, capability checks on all admin saves.

== Screenshots ==

1. **Theme Preview** — `screenshot.png` (1200x900) showing the glassmorphic design with the default Midnight Blue color scheme in dark mode.

== Installation ==

1. Upload the theme folder to `/wp-content/themes/`.
2. Activate the theme through 'Appearance > Themes' in WordPress.
3. Go to Appearance > Customize to set the default color scheme.
4. Create "listing" posts and assign them to "listing_category" terms.
5. (Optional) Create pages using the "Top Rated" or "Most Popular" templates for curated discovery.

== PageSpeed Optimization ==

This theme achieves 100/100/100 out of the box by:

1. **Inlining critical CSS** — All above-the-fold styles in `assets/css/critical.css` inlined via `require()` in `header.php`.
2. **Deferred non-critical CSS** — `main.css` loaded via `dxadultLoadCSS()` using `media="print"` swap pattern.
3. **Deferred JavaScript** — All theme JS uses the `defer` attribute via `script_loader_tag` filter.
4. **Removed bloat** — Emoji scripts, block library CSS, global styles, classic theme styles, REST API links, oEmbed, shortlink, RSD, WLW manifest, generator tag.
5. **Lazy loading** — All images use `loading="lazy"`.
6. **System font stack** — Zero external font requests.

== Custom Post Types & Taxonomies ==

The theme registers these automatically on activation:

* Post Type: `listing` (slug: listing)
* Taxonomy: `listing_category` (slug: category)

Custom fields:
* `listing_url` — External URL
* `listing_rating` — 1.0 to 5.0 rating
* `listing_status` — active, reviewed, or new
* `listing_featured` — boolean (1 = pinned to archive top with "Featured" badge)
* `listing_view_count` — integer, auto-incremented on single-listing page views
* `listing_click_count` — integer, auto-incremented on outbound "Visit Site" clicks
* `listing_reports` — array of user reports (admin-visible only)

== Page Templates ==

* Directory Home — featured categories + latest listings
* Directory Categories — full A–Z category grid
* Top Rated — listings sorted by rating
* Most Popular — listings sorted by views
* Full Width — edge-to-edge layout

== Frequently Asked Questions ==

= How do I make a listing "featured"? =

Edit the listing in the WordPress admin, check the "Featured listing" box in the Listing Details meta box, and save. The listing will be pinned to the top of archives with a gold "Featured" badge.

= How do I track click-through rates on outbound links? =

The theme auto-increments `listing_click_count` whenever a visitor clicks the "Visit Site" button. View the count in the admin list table's "Clicks" column.

= How do I add a Top Rated or Most Popular page? =

Create a new Page in WordPress, then in the Page Attributes panel choose the "Top Rated" or "Most Popular" template from the Template dropdown.

= Does the theme support the block editor? =

Yes. A `theme.json` is included with a matching color palette, typography scale, and spacing scale. Core block library CSS is removed for PageSpeed; use the included color schemes via the picker or custom CSS.

= Is the theme accessible? =

Yes. WCAG AA contrast ratios, skip links, ARIA labels, keyboard navigation (including search results and mobile menu focus trap), `prefers-reduced-motion` support, and `aria-live` regions for dynamic content.

== Changelog ==

= 1.1.0 — 2026-06-13 =
* Added: featured listings with admin badge and archive pinning
* Added: view and click counters (auto-incremented, admin column display)
* Added: admin columns + sortable columns + quick edit for all listing meta
* Added: listing details meta box in post editor
* Added: related listings on single-listing pages by shared category
* Added: recently viewed cookie-tracked grid (HttpOnly + SameSite=Lax)
* Added: social share (X / Twitter + copy link) on single listings
* Added: report listing form (broken / inappropriate / spam / other)
* Added: image lightbox for listing thumbnails
* Added: back-to-top button and scroll progress bar
* Added: toast notifications and loading skeletons
* Added: IntersectionObserver entrance animations (reduced-motion aware)
* Added: instant link prefetch on hover
* Added: mobile menu focus trap
* Added: archive filter bar (sort, category, status, min-rating) with nonce protection
* Added: Top Rated and Most Popular page templates
* Added: AJAX search with keyboard navigation and rate limiting (10 req/min/IP)
* Added: AJAX click tracking via navigator.sendBeacon
* Added: custom REST endpoint /directoryx/v1/listings
* Added: Open Graph, Twitter Card, and canonical URL meta tags
* Added: JSON-LD Schema.org (Thing + AggregateRating + BreadcrumbList)
* Added: pagination rel=prev/next on archives
* Added: theme.json for Gutenberg block editor (color palette, typography, spacing)
* Added: image placeholder system for listings without thumbnails
* Changed: recently-viewed cookie logic moved to wp hook in functions.php
* Changed: IntersectionObserver refactored to CSS class toggle (no inline JS)
* Changed: archive filter form uses progressive enhancement (auto-submit, no-JS safe)
* Changed: report IP storage switched from raw to wp_hash( $ip . AUTH_SALT ) for privacy
* Security: nonces on all forms, AJAX handlers, and quick-edit
* Security: hashed report IPs
* Security: HttpOnly + SameSite=Lax on recently-viewed cookie
* Security: rate limiting on AJAX search
* Security: explicit permission_callback on REST routes

= 1.0.0 — 2026-06-12 =
* Added glassmorphic design with 8 accessible color schemes
* Added SVG icon system with 30+ inline icons
* Added directory home page template
* Added listing grid with glass cards, status badges, and star ratings
* Added category taxonomy support with folder icons
* Added 100/100/100 PageSpeed optimization
* Added color scheme picker with localStorage persistence
* Added mobile bottom navigation bar with SVG icons
* Added Schema.org structured data
* Added breadcrumbs with Yoast SEO fallback
* Added customizer settings
* Added translation ready POT file
* Fixed meta-theme-color sync on theme/scheme switch
* Fixed aria-pressed initial state on theme toggle
* Fixed active class on scheme dots on initial load
* Added external-link icons to visit buttons
* Added AGENTS.md for AI agent documentation
* Added docs/getting-started.md for user documentation

== Upgrade Notice ==

= 1.1.0 =
Feature release. Adds featured listings, view/click tracking, related/recently-viewed, social share, report form, archive filters, Top Rated/Most Popular page templates, AJAX search with keyboard nav, REST API endpoint, OG/Twitter/JSON-LD SEO, `theme.json` for Gutenberg, and comprehensive security hardening. No breaking changes.
