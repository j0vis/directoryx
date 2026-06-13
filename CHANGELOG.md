# Changelog

All notable changes to the DirectoryX Adult theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned
- Static HTML preview generator for all 8 schemes × 2 themes
- Category archive (`taxonomy-listing_category.php`) sync with the new list/grid toggle
- Screenshot regeneration with the new list view
- Admin dashboard widget for quick listing stats
- Automated POT file generation via GitHub Actions

## [1.3.0] — 2026-06-13

### Added

#### 100 Default Adult Site Categories
- **`inc/categories.php`** — New file shipping **100 top adult site categories** out of the box: Amateur, Anal, Anime, Asian, BBW, BDSM, Big Ass, Big Dick, Big Tits, Black, Blonde, Blowjob, Bondage, Brazilian, British, Brunette, Bukkake, Cam Girls, Cartoon, Casting, Celebrity, CFNM, Chubby, Clips, Compilation, Cosplay, Couples, Creampie, Cumshot, Cunnilingus, Deep Throat, Double Penetration, Ebony, European, Exotic, Facial, Fetish, Fingering, Fisting, Foot Fetish, Foursome, French, Gangbang, German, Group Sex, Gyno, Hairy, Handjob, Hardcore, Hentai, Homemade, Indian, Interracial, Japanese, Latina, Lesbian, Massage, Masturbation, Mature, MILF, Mom, Nudist, Old+Young, Orgy, Outdoor, Panties, Party, Pissing, Pornstar, POV, Pregnant, Public, Redhead, Russian, Schoolgirl, Sex Toys, Shower, Solo, Spanking, Squirt, Stockings, Strap-on, Strip, Swinger, Teen, Threesome, Toons, Toys, Twink, Uncensored, Uniform, Vintage, Virtual Reality, Webcam, Young, 3D, Amateur Wife, Arab, Ass, Babe, Orgasm, Romance, Voyeur, Twerking, Shemale.
- **Auto-import on theme activation** — `after_switch_theme` hook imports any missing categories (idempotent: skips slugs that already exist).
- **Admin notice** — After activation, a dismissible admin notice shows the count of categories imported and points to **Listings → Categories** to rename or remove any.
- **SEO descriptions** — Each category ships with a one-line description for archive page meta and search results.
- **Re-importable** — Call `dxadult_import_default_categories()` manually, or deactivate/reactivate the theme to re-trigger.

#### List/Grid View Toggle for Archives
- **List view (default)** — Archives now default to a true **link-list** layout: each listing is a row inside a single glass container with: 88×64 thumbnail | title + categories + status badge | star rating | "Visit" button. Row dividers separate entries; hover highlights the row with `var(--accent-soft)`.
- **Grid view** — The original card grid is preserved as an alternate view.
- **Toolbar toggle** — A segmented pill control in the archive toolbar lets visitors switch between List and Grid with SVG icons. `aria-pressed` and `aria-label` for a11y.
- **URL parameter** — `?view=list` (default) or `?view=grid` controls the view server-side (so the right template part is loaded).
- **localStorage persistence** — The chosen view persists across pages and sessions.
- **New template part** — `template-parts/content-listing-row.php` for the row layout; the existing `template-parts/content-listing-card.php` is used for the grid view.
- **Mobile-responsive** — Below 640px, the row stacks: thumb + title in the first row, then rating + Visit button indented under the title.

#### Listing Meta Box UX
- **"External link / URL" field description** — The Listing Details meta box now shows a description under the URL field explaining exactly where the link appears on the frontend: *"The full URL of the site you are listing. Shown as a 'Visit' button on the listing card and as a 'Visit Site' button on the single-listing page. Outbound clicks are tracked."*
- **Relabeled field** — The field is now labeled "External link / URL:" (was "Listing URL:") for clearer intent.

### Changed
- **`archive.php`** — Added `?view=` parameter handling (defaults to `list`); wraps the loop in `<div class="listing-archive view--{list|grid}">` and picks the template part based on the view; added the view toggle HTML in the toolbar.
- **`functions.php`** — `require_once` for the new `inc/categories.php`.
- **`assets/css/critical.css`** — New section **30.5. Archive list view** with `.listing-archive.view--list`, `.listing-row` (4-column grid), `.listing-row__thumb/body/title/meta/rating/action`, mobile breakpoint, and `.archive-view-toggle` segmented pill control.
- **`assets/js/main.js`** — View toggle handler: persists preference in `localStorage`, updates `aria-pressed`, reloads with `?view=list|grid` so the PHP template picks the right part.

### Security
- **`$_GET['view']` sanitization** — `sanitize_key()` + whitelist to `list`/`grid` in `archive.php`.
- **All new template output escaped** — `esc_url`, `esc_attr`, `esc_html` throughout the new row template and view toggle HTML.

---

## [1.2.0] — 2026-06-13

### Changed — Design System Overhaul

The biggest change in this release is the **per-scheme full-palette design system**: each of the 8 accent schemes now rewires the **entire theme** (page background, surface elevations, glass tints, text tints, mesh gradient), not just the accent color. Switching from Midnight to Ruby no longer only changes link colors — it changes the whole page to a deep wine background with red-tinted glass, red-tinted text, and a vibrant red mesh gradient.

### Added

- **Animated mesh background** — Subtle 24s `background-position` drift across 4 radial gradient stops. Paused for `prefers-reduced-motion`. No new HTTP requests.
- **3-stop gradient text** on `h1`, `.site-title`, `.page-title`, and `.entry-title` — flows from `var(--text-primary)` → `var(--accent)` → `var(--accent-hover)` via `background-clip: text`. Logo, page titles, and entry titles all glow with the active scheme.
- **Glowing scrollbar** (Webkit) — Scrollbar thumb lights up to `--accent` with a glow on hover. Falls back to default in Firefox.
- **Bolder focus rings** — 2px outline + `var(--glow-ring)` (3px accent glow) for keyboard nav.
- **Bolder card hovers** — `.listing-card:hover` now lifts `-8px`, gets a 1px accent border, and emits a 40px accent glow. `.category-card:hover` gets a 1px accent border and a 32px glow.
- **7 new light-mode scheme variants** — Each non-default light scheme now has a tinted pastel `--bg-page` and per-scheme mesh stops.
- **4th mesh gradient stop** (`--mesh-4`) for richer backgrounds. Each scheme block overrides all 4 stops.
- **8 per-scheme mesh gradients in `theme.json`** — One for each scheme so block-editor gradients match the frontend feel.
- **Utility tokens** — `--glow-ring: 0 0 0 3px var(--accent-glow)` and `--glow-text: 0 0 24px var(--accent-glow)` for consistent glow treatments.

### Changed

- **Per-scheme full palette** — Every `[data-scheme="X"]` block now defines `--bg-page`, `--bg-elevated`, `--glass-bg`, `--glass-bg-strong`, `--glass-bg-subtle`, `--glass-border`, `--glass-border-strong`, `--text-primary`, `--text-secondary`, `--text-muted`, `--text-subtle`, `--card-bg`, `--card-border`, `--divider`, `--input-bg`, `--highlight`, and all 4 `--mesh-N` stops. Previously schemes only set `--accent` and `--mesh-N`.
- **Mesh opacity bumped** from 0.14 to 0.32+ so the gradient is actually visible (and tinted) per scheme.
- **Default `--bg-page`** darkened from `#08090c` to `#050a1a` for more scheme-tint headroom.
- **Body `animation` consolidated** into a single `body { ... }` block (was two).
- **`.entry-content a`** — Underline moved to hover/focus only (matches global `a` behaviour).
- **`inc/customizer.php`** — Description for `dxadult_default_scheme` now explicitly states that each scheme changes the **entire theme** look, not just accent.

---

## [1.1.0] — 2026-06-13

### Added

#### Meta Fields & Admin UX
- **`listing_featured` meta** — Boolean flag to pin listings at the top of archives with a gold "Featured" badge.
- **`listing_view_count` meta** — Auto-incremented on single listing page views.
- **`listing_click_count` meta** — Auto-incremented when users click the "Visit Site" outbound link.
- **Admin columns** — Featured (★), Rating, Status, URL (with parsed host), Views, Clicks columns on the listing list table.
- **Sortable admin columns** — Click column headers to sort by rating, views, clicks, status, or featured.
- **Quick edit** — Inline-edit rating, status, and featured flag from the list table (no page reload).
- **Listing details meta box** — URL, rating (1.0–5.0), status, and featured checkbox in the post editor.

#### Frontend Listing Features
- **Related listings** — Up to 6 listings sharing `listing_category` terms, shown below single-listing content.
- **Recently viewed cookie** — Tracks last 20 listing IDs in a HttpOnly + SameSite=Lax cookie; renders a "Recently Viewed" grid.
- **Social share buttons** — X (Twitter) share + copy-link button on single listings. Copy uses `navigator.clipboard` with `execCommand` fallback.
- **Report listing form** — Frontend form (broken / inappropriate / spam / other) that posts to `admin-post.php` and stores reports in `listing_reports` meta.
- **Placeholder image** — Random-color SVG placeholder for listings without a featured image.

#### Page Templates
- **Top Rated** (`template-top-rated.php`) — Sortable archive of listings ordered by `listing_rating`.
- **Most Popular** (`template-most-popular.php`) — Sortable archive ordered by `listing_view_count`.
- **Featured listings section** — Pinned to top of `archive.php` and category archives when featured listings exist.

#### Archive Filtering & Sorting
- **Filter sidebar** — Sort (Newest, Top Rated, Most Popular, A–Z), category, status, and min-rating selectors.
- **Nonce-protected form** — `wp_nonce_field( 'dxadult_archive_filter' )` for CSRF mitigation.
- **Progressive enhancement** — Auto-submit on select change; degrades gracefully if JS is disabled.
- **Server-side filtering** — `pre_get_posts` hook filters the main query by sort, category, status, and min rating.

#### AJAX & API
- **AJAX search** — Live dropdown with debounced input, `aria-live` result region, and rate limiting (10 req/min/IP).
- **Click tracking** — `navigator.sendBeacon` POSTs to `wp_ajax_dxadult_click_track`; nonce-verified.
- **Keyboard search navigation** — ↑/↓ arrow keys cycle through results, Enter activates focused link, Escape closes dropdown.
- **Custom REST endpoint** — `GET /wp-json/directoryx/v1/listings` with `category`, `status`, `min_rating`, `sort`, `per_page` params.

#### Frontend UX Enhancements
- **Back-to-top button** — Appears after 400px scroll, smooth-scrolls to top, respects `prefers-reduced-motion`.
- **Scroll progress bar** — Fixed 3px bar at top of viewport showing read progress.
- **Image lightbox** — Click any listing thumbnail to open a fullscreen modal; Esc / overlay-click to close.
- **Toast notifications** — Bottom-center glassmorphic toasts for "Link copied" and "Report submitted" success states.
- **Loading skeletons** — Shimmer placeholders (with reduced-motion guard) for AJAX content.
- **IntersectionObserver entrance animations** — Cards fade-in as they scroll into view (class-toggled, no inline JS).
- **Instant prefetch** — `<link rel="prefetch">` injected on `mouseover` for same-origin links (uses `requestIdleCallback`).
- **Focus trap** — Keyboard focus trapped inside open mobile menu; Escape closes.
- **Image placeholder** — Random-color SVG generated in PHP for listings without a featured image.

#### SEO & Social
- **Open Graph meta tags** — `og:title`, `og:description`, `og:url`, `og:type`, `og:image`, `og:site_name`.
- **Twitter Card meta** — `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`.
- **Canonical URL** — `<link rel="canonical">` on singular pages and archives.
- **JSON-LD Schema** — `Thing` + `AggregateRating` per listing, `BreadcrumbList` for navigation.
- **Pagination prev/next** — `rel="prev"` / `rel="next"` on paginated archives.

#### Block Editor
- **theme.json** — Gutenberg block editor color palette, typography scale, and spacing matching the theme.

#### Security
- **AJAX nonce on search** — `wp_verify_nonce( 'dxadult_search_nonce' )` for all search requests.
- **AJAX nonce on click tracking** — `wp_verify_nonce( 'dxadult_click_nonce' )` for outbound click logging.
- **Nonce on report form** — `wp_verify_nonce( 'dxadult_report' )` on `admin-post.php` handler.
- **Nonce on archive filter form** — `wp_nonce_field( 'dxadult_archive_filter' )`.
- **Hashed report IPs** — `wp_hash( $ip . AUTH_SALT )` instead of raw IPs for privacy.
- **Rate limiting on search** — 10 requests/minute/IP via transient, returns "Too many requests" message.
- **HttpOnly + SameSite cookies** — Recently-viewed cookie uses HttpOnly + SameSite=Lax to mitigate XSS and CSRF.
- **Capability checks on quick edit** — `current_user_can( 'edit_post', $post_id )` and inline-edit nonce verification.
- **REST permission callback** — Explicit `permission_callback` on the `directoryx/v1/listings` route.

### Changed
- **Recently-viewed cookie logic** — Moved from `single-listing.php` template into `dxadult_track_recently_viewed()` hooked on `wp` for proper template-context timing.
- **IntersectionObserver** — Refactored to toggle `.is-visible` CSS class instead of mutating inline `animationPlayState` (cleaner separation of JS and CSS).
- **Archive filter form** — Replaced inline `onchange="this.form.submit()"` with class-based progressive enhancement.
- **Report IP storage** — Switched from raw IP to `wp_hash( $ip . AUTH_SALT )` for privacy compliance.

### Fixed
- IntersectionObserver now properly respects `prefers-reduced-motion` via CSS guards.
- Cookie set in `single-listing.php` no longer risks "headers already sent" warnings (moved to `wp` hook with `headers_sent()` guard).
- Auto-submit filter form no longer breaks for users with JavaScript disabled (progressive enhancement).

### Security
- **wp_hash for report IPs** — Prevents raw IP storage in `listing_reports` meta; logs the hash with `AUTH_SALT` salt.
- **SameSite=Lax on recently-viewed cookie** — CSRF mitigation for the cookie-based tracking.

---

## [1.0.0] — 2026-06-12

### Added
- **Glassmorphic design** — Frosted glass cards with `backdrop-filter` blur, subtle glow effects, and smooth hover animations.
- **8 accessible color schemes** — Midnight Blue, Emerald Green, Ruby Red, Amethyst Purple, Amber Gold, Coral Orange, Ocean Teal, and Slate Indigo. All WCAG AA compliant.
- **Color scheme picker** — In-header color dots with `localStorage` persistence. Default scheme configurable via Customizer.
- **SVG icon system** — 30+ inline SVG icons (`inc/svg-icons.php`), themeable via CSS `currentColor`, used throughout the theme.
- **Dark/light mode toggle** — Persisted in `localStorage` with smooth CSS transitions. Meta theme color syncs on switch.
- **Custom `listing` post type** — With URL, rating, and status meta fields. Admin meta box included.
- **`listing_category` taxonomy** — For organizing listings with archive templates.
- **Directory page templates** — Directory Home (featured categories + latest listings), Directory Categories (A-Z), and Full Width.
- **Responsive grid layout** — CSS Grid with mobile-first breakpoints.
- **Mobile bottom navigation** — Fixed bottom nav with safe-area-inset support and SVG icons.
- **100/100/100 PageSpeed** — Critical CSS inlined, deferred assets, lazy loading, bloat removal.
- **Schema.org structured data** — ItemList, SiteNavigationElement, and BreadcrumbList.
- **Breadcrumbs** — Auto-generated with Yoast SEO fallback.
- **Accessibility** — Skip links, ARIA labels, semantic HTML5 landmarks, keyboard navigation, reduced motion support.
- **Translation ready** — All strings use `esc_html__()` / `_e()` with `directoryx-adult` text domain. POT file included.
- **AGENTS.md** — AI agent documentation and color palette reference.
- **Documentation** — `docs/getting-started.md` with installation and customization guide.

### Fixed
- Meta theme color (`meta-theme-color`) now syncs correctly when switching themes or color schemes.
- `aria-pressed` state on theme toggle button now initializes correctly on page load.
- Color scheme dots now receive the correct `active` class on initial load.

### Security
- All output escaped with `esc_html()`, `esc_url()`, `esc_attr()`, and `wp_kses_post()`.
- SVG icons use unique auto-generated IDs for `clipPath` elements to prevent duplicate ID conflicts.

---

## Release Notes Template

When creating a new GitHub release, use this template:

```markdown
## What's New

### Added
-

### Changed
-

### Fixed
-

### Removed
-

### Security
-

**Full Changelog**: https://github.com/j0vis/directoryx/compare/vPREVIOUS...vCURRENT
```

[Unreleased]: https://github.com/j0vis/directoryx/compare/v1.3.0...HEAD
[1.3.0]: https://github.com/j0vis/directoryx/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/j0vis/directoryx/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/j0vis/directoryx/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/j0vis/directoryx/releases/tag/v1.0.0
