=== DirectoryX Adult ===
Contributors: j0vis
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 1.0.0
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
* **Listing management** — Custom "listing" post type with URL, rating, and status meta fields. Meta box in the admin editor.
* **Category taxonomy** — "listing_category" taxonomy for organizing sites. Category archive templates included.
* **Responsive grid layout** — CSS Grid-based glass cards with auto-fill columns and mobile-first responsive breakpoints.
* **Mobile bottom nav** — Fixed bottom navigation bar on mobile with Home, Search, and Listings links. Respects safe-area-inset.
* **Directory page templates** — Directory Home (featured categories + latest listings), Directory Categories (full A-Z), and Full Width templates.
* **Customizer support** — Default color scheme setting.
* **Schema.org markup** — ItemList, SiteNavigationElement, and BreadcrumbList structured data.
* **Breadcrumbs** — Auto-generated with Yoast SEO fallback.
* **Accessibility** — Skip links, ARIA labels, semantic HTML5 landmarks, screen-reader-text utilities, reduced motion support.
* **Translation ready** — All strings use `esc_html__()` / `_e()` with the `directoryx-adult` text domain. POT file included.

== Installation ==

1. Upload the theme folder to `/wp-content/themes/`.
2. Activate the theme through 'Appearance > Themes' in WordPress.
3. Go to Appearance > Customize to set the default color scheme.
4. Create "listing" posts and assign them to "listing_category" terms.

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

== Changelog ==

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
