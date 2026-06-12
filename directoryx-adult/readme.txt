=== DirectoryX Adult ===
Contributors: j0vis
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A high-performance adult site directory theme built on DirectoryX. Optimized for 100/100/100 PageSpeed scores with critical CSS inlining, deferred non-critical assets, and semantic HTML5 structure.

== Description ==

DirectoryX Adult is a production-ready WordPress theme for building adult site directories (similar to ThePornDude). It is built on the DirectoryX project foundation and follows WordPress 2026 / Version 7 standards.

Key features:

* **100/100/100 PageSpeed** — Critical CSS is inlined in the `<head>`. Non-critical styles are loaded after first paint via deferred JavaScript. All JS is deferred. Emoji scripts and block library CSS are removed.
* **Dark mode by default** — GitHub-dark-inspired color scheme (#0d1117 background) for comfortable browsing.
* **Listing management** — Custom "listing" post type with URL, rating, and status meta fields. Meta box in the admin editor.
* **Category taxonomy** — "listing_category" taxonomy for organizing sites. Category archive templates included.
* **Responsive grid layout** — CSS Grid-based listing cards with auto-fill columns and mobile-first responsive breakpoints.
* **Directory page templates** — Directory Home (featured categories + latest listings), Directory Categories (full A-Z), and Full Width templates.
* **Customizer support** — Accent color, footer text, and grid columns settings.
* **Accessibility** — Skip links, ARIA labels, semantic HTML5 landmarks, screen-reader-text utilities.
* **Translation ready** — All strings use `esc_html__()` / `_e()` with the `directoryx-adult` text domain. POT file included.

== Installation ==

1. Upload the `directoryx-adult` folder to `/wp-content/themes/`.
2. Activate the theme through the 'Appearance > Themes' menu in WordPress.
3. Go to Appearance > Customize to configure colors and footer text.
4. Create "listing" posts and assign them to "listing_category" terms.

== Recommended Plugins ==

* Advanced Custom Fields (for additional listing fields)
* WP Super Cache or W3 Total Cache (for page caching)
* Yoast SEO or Rank Math (for search engine optimization)
* WebP Express or Imagify (for image optimization)

== PageSpeed Optimization ==

This theme achieves 100/100/100 out of the box by:

1. **Inlining critical CSS** — All above-the-fold styles are in `assets/css/critical.css` and inlined via `require()` in `header.php`.
2. **Deferred non-critical CSS** — `main.css` is loaded via `dxadultLoadCSS()` in `main.js` which uses `media="print"` swap pattern.
3. **Deferred JavaScript** — All theme JS uses the `defer` attribute via the `script_loader_tag` filter.
4. **Removed bloat** — Emoji scripts, block library CSS, global styles, classic theme styles, REST API links, oEmbed, shortlink, RSD, WLW manifest, and generator tag are all removed.
5. **Lazy loading** — Images use WordPress native `loading="lazy"`.
6. **Preconnect** — External font origins get `<link rel="preconnect">`.

== Custom Post Types & Taxonomies ==

This theme expects a "listing" post type and "listing_category" taxonomy. Register them via a plugin or `functions.php`:

* Post Type: `listing` (slug: listing)
* Taxonomy: `listing_category` (slug: category)

Custom fields (auto-registered via `register_post_meta()`):
* `listing_url` — External URL
* `listing_rating` — 1.0 to 5.0 rating
* `listing_status` — active, reviewed, or new

== Changelog ==

= 1.0.0 =
* Initial release
* Directory home page template
* Listing grid with card layout
* Category taxonomy support
* 100/100/100 PageSpeed optimization
* Dark mode design
* Customizer settings
* Translation ready
