# Changelog

All notable changes to the DirectoryX Adult theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned
- Screenshot images for theme preview
- Admin dashboard widget for quick listing stats
- Automated POT file generation via GitHub Actions
- A/B testing framework for the 8 color schemes

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

[Unreleased]: https://github.com/j0vis/directoryx/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/j0vis/directoryx/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/j0vis/directoryx/releases/tag/v1.0.0
