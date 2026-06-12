# DirectoryX Adult

A high-performance adult site directory WordPress theme built on DirectoryX. Glassmorphic design with light/dark mode toggle and 8 accessible accent schemes. Optimized for 100/100/100 PageSpeed.

![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-purple.svg)
![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)
![Version](https://img.shields.io/badge/Version-1.1.0-orange.svg)

## Features

### Design & Theming
- **Glassmorphic Design** — Frosted glass cards with backdrop-filter blur, subtle glow effects, and smooth hover animations
- **8 Accessible Color Schemes** — Midnight Blue, Emerald Green, Ruby Red, Amethyst Purple, Amber Gold, Coral Orange, Ocean Teal, Slate Indigo. All WCAG AA compliant
- **Dark/Light Mode Toggle** — Persisted in localStorage with smooth transitions
- **100/100/100 PageSpeed** — Critical CSS inlined, deferred assets, lazy loading, zero bloat
- **SVG Icon System** — 30+ inline SVG icons, themeable via CSS `currentColor`
- **Scroll Progress Bar & Back-to-Top** — Floating UI helpers with reduced-motion support

### Content & Listings
- **Custom Listing Post Type** — With URL, rating, status, **featured flag**, **view counter**, and **click counter** meta fields
- **Admin Columns & Quick Edit** — Sortable Featured, Rating, Status, URL, Views, Clicks columns; inline-edit rating/status/featured
- **Category Taxonomy** — `listing_category` with archive templates
- **Featured Listings** — Pin to top of archives with a gold badge
- **Related Listings** — Auto-shown on single listings by shared category
- **Recently Viewed** — Cookie-tracked, shown on single listings
- **Top Rated & Most Popular Templates** — Drop-in page templates for curated discovery
- **Report Listing Form** — Frontend broken / inappropriate / spam reporting with admin-post handler
- **Social Share** — X (Twitter) share + copy-link button

### Discovery & Filtering
- **Archive Filter Bar** — Sort, category, status, and min-rating selectors on `archive.php`
- **Sort Options** — Newest, Top Rated, Most Popular (by views), A–Z
- **AJAX Search** — Live dropdown with debounced input, keyboard navigation (↑/↓/Enter/Esc)
- **REST API Endpoint** — `GET /wp-json/directoryx/v1/listings` with `category`, `status`, `min_rating`, `sort`, `per_page` params
- **Click & View Tracking** — `navigator.sendBeacon` for outbound clicks, server-side view increments

### Frontend UX
- **Image Lightbox** — Fullscreen modal for listing thumbnails
- **Toast Notifications** — Bottom-center glassmorphic toasts
- **Loading Skeletons** — Shimmer placeholders for AJAX content
- **IntersectionObserver Animations** — Cards fade-in on scroll (class-driven, reduced-motion aware)
- **Instant Prefetch** — `requestIdleCallback` + `mouseover` link prefetching
- **Focus Trap** — Mobile menu traps focus; Escape closes
- **Mobile Bottom Navigation** — Fixed bottom nav with safe-area-inset support

### SEO & Social
- **Open Graph & Twitter Cards** — Auto-generated meta on singular pages
- **Canonical URLs** — `<link rel="canonical">` on all pages
- **JSON-LD Schema** — `Thing` + `AggregateRating` per listing, `BreadcrumbList` for navigation
- **Pagination rel=prev/next** — On paginated archives

### Block Editor
- **theme.json** — Gutenberg color palette, typography scale, and spacing matching the theme

### Accessibility
- Skip links, ARIA labels, semantic HTML5, keyboard navigation, reduced motion support, `aria-live` search results

### Internationalization
- Full i18n support with POT file (`directoryx-adult` text domain)

### Security
- Nonces on all forms, AJAX, and quick-edit
- Hashed report IPs (`wp_hash( $ip . AUTH_SALT )`)
- Rate limiting on AJAX search (10 req/min/IP)
- HttpOnly + SameSite=Lax cookies
- Capability checks on all admin saves

## Screenshots

![Theme Screenshot](screenshot.png)

The screenshot shows the DirectoryX Adult theme's glassmorphic design with the default Midnight Blue color scheme in dark mode.

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme through **Appearance > Themes** in WordPress
3. Go to **Appearance > Customize** to set the default color scheme
4. Create "listing" posts and assign them to "listing_category" terms
5. (Optional) Create pages using the **Top Rated** or **Most Popular** templates for curated discovery

## PageSpeed Optimization

This theme achieves 100/100/100 out of the box by:

1. **Inlining critical CSS** — All above-the-fold styles in `assets/css/critical.css` inlined via `require()` in `header.php`
2. **Deferred non-critical CSS** — `main.css` loaded via `dxadultLoadCSS()` using `media="print"` swap pattern
3. **Deferred JavaScript** — All theme JS uses the `defer` attribute via `script_loader_tag` filter
4. **Removed bloat** — Emoji scripts, block library CSS, global styles, REST API links, oEmbed, shortlink, RSD, WLW manifest, generator tag
5. **Lazy loading** — All images use `loading="lazy"`
6. **System font stack** — Zero external font requests
7. **`will-change` on entrance animations** — GPU-accelerated transitions, no layout thrash

## Custom Post Types & Taxonomies

The theme registers these automatically on activation:

- **Post Type:** `listing` (slug: `listing`)
- **Taxonomy:** `listing_category` (slug: `category`)

### Custom Meta Fields

| Field | Type | Description |
|-------|------|-------------|
| `listing_url` | URL | External site URL (used for "Visit Site" button and click tracking) |
| `listing_rating` | Number | 1.0 to 5.0 star rating |
| `listing_status` | String | `active`, `reviewed`, or `new` |
| `listing_featured` | Boolean | When `1`, listing is pinned to archive tops with a gold "Featured" badge |
| `listing_view_count` | Integer | Auto-incremented on single listing page views |
| `listing_click_count` | Integer | Auto-incremented when users click the outbound "Visit Site" link |
| `listing_reports` | Array | User-submitted reports (reason, details, time, hashed IP) |

## Page Templates

| Template | File | Purpose |
|----------|------|---------|
| Directory Home | `template-directory-home.php` | Featured categories + latest listings |
| Directory Categories | `template-directory-categories.php` | Full A–Z category grid |
| Top Rated | `template-top-rated.php` | Listings sorted by `listing_rating` (DESC) |
| Most Popular | `template-most-popular.php` | Listings sorted by `listing_view_count` (DESC) |
| Full Width | `template-full-width.php` | Edge-to-edge layout for landing pages |

## REST API

The theme exposes a custom REST endpoint for headless or AJAX use:

```http
GET /wp-json/directoryx/v1/listings?category=12&sort=rating&min_rating=4&per_page=20
```

**Response shape:**

```json
[
  {
    "id": 42,
    "title": "Example Site",
    "url": "https://example.com/listing/example-site/",
    "excerpt": "…",
    "thumbnail": "https://…/listing-thumb.jpg",
    "rating": 4.5,
    "status": "active",
    "featured": true
  }
]
```

**Available params:** `category` (term_id), `status` (active/reviewed/new), `min_rating` (float), `sort` (rating/popular/alpha), `per_page` (1–50, default 12).

## Color Schemes

| Scheme | Dark Accent | Light Accent |
|--------|-------------|--------------|
| Midnight Blue | `#58a6ff` | `#0969da` |
| Emerald Green | `#3fb950` | `#1a7f37` |
| Ruby Red | `#f85149` | `#cf222e` |
| Amethyst Purple | `#bc8cff` | `#8250df` |
| Amber Gold | `#e3b341` | `#9a6700` |
| Coral Orange | `#ff7b72` | `#cf4a3a` |
| Ocean Teal | `#39d0d8` | `#0d7d7d` |
| Slate Indigo | `#a5b4fc` | `#6366f1` |

## File Structure

```
directoryx-adult/
├── style.css              # Theme header + base styles
├── index.php              # Ultimate fallback template
├── functions.php          # Theme setup, hooks, custom functions
├── theme.json             # Gutenberg block editor config
├── screenshot.png         # Theme screenshot
├── readme.txt             # WordPress.org readme
├── languages/             # .pot, .po, .mo files
├── inc/                   # PHP classes & modular includes
│   ├── svg-icons.php        # SVG icon helper functions
│   ├── template-functions.php   # Meta registration, admin columns, quick edit, view tracker
│   ├── template-tags.php    # Related listings, social share, report form, schema
│   ├── customizer.php
│   └── post-types.php
├── template-parts/          # Reusable template partials
│   ├── content.php
│   ├── content-listing-card.php
│   ├── content-category-card.php
│   ├── content-none.php
│   ├── content-page.php
│   ├── breadcrumbs.php
│   └── pagination.php
├── page-templates/          # Custom page templates
│   ├── template-directory-home.php
│   ├── template-directory-categories.php
│   ├── template-top-rated.php
│   ├── template-most-popular.php
│   └── template-full-width.php
├── assets/
│   ├── css/
│   │   ├── critical.css     # Inlined critical CSS (entrance animations, toasts, lightbox, filters…)
│   │   ├── main.css         # Deferred styles
│   │   ├── editor-style.css
│   │   └── print.css
│   └── js/
│       └── main.js          # Deferred JS (search, lightbox, IO, focus trap, prefetch…)
└── AGENTS.md                # AI agent documentation
```

## Development

### Requirements

- WordPress 6.0+
- PHP 8.0+
- Node.js (optional, for CSS minification)

### SVG Icons

The theme includes 30+ inline SVG icons via `inc/svg-icons.php`. Use them in templates:

```php
<?php dxadult_icon( 'external-link', '14' ); ?>
<?php echo dxadult_get_icon( 'folder', '18', 'my-class' ); ?>
```

All icons use `currentColor` for stroke/fill, so they inherit the theme's accent color automatically.

### Adding a Color Scheme

1. Add CSS variables in `assets/css/critical.css`:
   ```css
   [data-scheme="myscheme"] {
       --accent: #hexcode;
       --accent-hover: #hexcode;
       --accent-glow: rgba(...);
       --card-hover-border: rgba(...);
   }
   [data-theme="light"][data-scheme="myscheme"] { ... }
   ```
2. Add dot colors in `critical.css`:
   ```css
   .scheme-dot[data-scheme="myscheme"] { --dot-color: #hexcode; }
   ```
3. Add to `assets/js/main.js` `schemeColors` object
4. Add to `inc/customizer.php` choices array
5. Add button to `header.php` scheme picker

### Adding a New Meta Field

1. Register in `inc/template-functions.php` (`dxadult_register_listing_meta()`):
   ```php
   register_post_meta( 'listing', 'my_field', array(
       'type'              => 'string',
       'single'            => true,
       'sanitize_callback' => 'sanitize_text_field',
       'auth_callback'     => function () { return current_user_can( 'edit_posts' ); },
       'show_in_rest'      => true,
   ) );
   ```
2. Add UI in `dxadult_listing_meta_box_callback()` and save in `dxadult_save_listing_meta()`.
3. Optionally add an admin column in `dxadult_listing_columns()` and `dxadult_listing_custom_column()`.
4. Display in `template-parts/content-listing-card.php` or a new template tag in `inc/template-tags.php`.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the full release history.

### 1.1.0 — Feature Release

- Featured listings with admin badge and archive pinning
- Admin columns + sortable + quick edit for all listing meta
- Top Rated and Most Popular page templates
- Archive filter bar (sort, category, status, min-rating) with nonce protection
- Related listings and recently-viewed on single listings
- Social share (X, copy link) and report listing form
- Image lightbox, back-to-top, scroll progress, toasts, loading skeletons
- AJAX search with keyboard navigation and rate limiting
- Click tracking via `sendBeacon` and custom REST endpoint
- Open Graph, Twitter Cards, canonical URLs, expanded JSON-LD
- `theme.json` for Gutenberg block editor
- Security hardening: hashed IPs, nonces everywhere, HttpOnly cookies
- IntersectionObserver refactored to CSS class toggle

### 1.0.0 — Initial Release

- Glassmorphic design with 8 color schemes
- Directory home page template
- Listing grid with glass cards
- Category taxonomy support
- 100/100/100 PageSpeed optimization
- Color scheme picker with localStorage persistence
- Mobile bottom navigation bar
- Schema.org structured data
- Breadcrumbs with Yoast SEO fallback
- Customizer settings
- SVG icon system
- Translation ready

## License

GPL v2 or later — [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

## Contributing

We welcome contributions! Please read [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines on code standards, pull requests, and the development workflow.

## Credits

- Built by [j0vis](https://github.com/j0vis)
- Based on the DirectoryX project
