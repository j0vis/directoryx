# DirectoryX Adult

A high-performance adult site directory WordPress theme built on DirectoryX. **Per-scheme full-palette design system** — each of the 8 accent schemes rewires the entire theme (background, surfaces, glass tints, text tints, mesh gradient), not just the accent color. Ships with **100 default adult site categories** and a **list/grid view toggle** for archives. Optimized for 100/100/100 PageSpeed.

![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-purple.svg)
![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)
![Version](https://img.shields.io/badge/Version-1.3.0-orange.svg)

## Features

### Design & Theming
- **Per-Scheme Full-Palette Design System** — Each of the 8 accent schemes rewires the **entire theme**: page background, surface elevations, glass tints, text tints, and the 4-stop mesh gradient. Switching from Midnight to Ruby changes the whole page to a deep wine background with red-tinted glass, red-tinted text, and a vibrant red mesh.
- **8 Accessible Color Schemes** — Midnight Blue, Emerald Green, Ruby Red, Amethyst Purple, Amber Gold, Coral Orange, Ocean Teal, Slate Indigo. All WCAG AA compliant.
- **Glassmorphic Design** — Frosted glass cards with `backdrop-filter: blur(24px) saturate(180%)`, layered shadows with inner top-edge highlight (the "glass" tell), and smooth hover animations.
- **Animated Mesh Background** — Subtle 24s drift across 4 radial gradient stops. Paused for `prefers-reduced-motion`. Zero new HTTP requests.
- **3-Stop Gradient Text** — Logo, page titles, and entry titles use a `text → accent → accent-hover` gradient via `background-clip: text`. Each scheme colors them differently.
- **Glowing Scrollbar** — Scrollbar thumb lights up to the active scheme's accent on hover (Webkit).
- **Dark/Light Mode Toggle** — Persisted in localStorage with smooth transitions. Theme toggle is the only user-facing color control.
- **100/100/100 PageSpeed** — Critical CSS inlined, deferred assets, lazy loading, zero bloat.
- **SVG Icon System** — 30+ inline SVG icons, themeable via CSS `currentColor`.
- **Scroll Progress Bar & Back-to-Top** — Floating UI helpers with reduced-motion support.

### Content & Listings
- **100 Default Adult Categories** — Ships with **100 top adult site categories** (Amateur, Anal, MILF, BDSM, etc.) that auto-import on theme activation with SEO descriptions. Rename or remove any under **Listings → Categories**.
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
- **List/Grid View Toggle** — Archives now default to a true **list/row layout** (link-list feel) with a segmented pill toggle in the toolbar. Switch to the original card grid anytime. View persists in `localStorage`.
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
- **theme.json** — Gutenberg color palette (8 schemes + bg/text swatches), 8 per-scheme mesh gradients, typography scale, spacing, `appearanceTools`, `customGradient`

### Accessibility
- Skip links, ARIA labels, semantic HTML5, keyboard navigation, reduced motion support, `aria-live` search results, gradient text retains readable contrast in both light and dark mode

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
3. Go to **Appearance > Customize** to set the default color scheme (the **only** place visitors can't override; they can only toggle light/dark via the theme toggle in the header)
4. On activation, **100 default adult categories are auto-imported** — see the admin notice for the count. Rename or remove any under **Listings → Categories**
5. Create "listing" posts and assign them to "listing_category" terms
6. (Optional) Create pages using the **Top Rated** or **Most Popular** templates for curated discovery

## PageSpeed Optimization

This theme achieves 100/100/100 out of the box by:

1. **Inlining critical CSS** — All above-the-fold styles in `assets/css/critical.css` inlined via `require()` in `header.php`
2. **Deferred non-critical CSS** — `main.css` loaded via `dxadultLoadCSS()` using `media="print"` swap pattern
3. **Deferred JavaScript** — All theme JS uses the `defer` attribute via `script_loader_tag` filter
4. **Removed bloat** — Emoji scripts, block library CSS, global styles, REST API links, oEmbed, shortlink, RSD, WLW manifest, generator tag
5. **Lazy loading** — All images use `loading="lazy"`
6. **System font stack** — Zero external font requests
7. **Pure-CSS animated mesh** — `background-position` animation, no JS or image requests
8. **`will-change` on entrance animations** — GPU-accelerated transitions, no layout thrash

## Custom Post Types & Taxonomies

The theme registers these automatically on activation:

- **Post Type:** `listing` (slug: `listing`)
- **Taxonomy:** `listing_category` (slug: `category`) — ships with 100 default terms

### Custom Meta Fields

| Field | Type | Description |
|-------|------|-------------|
| `listing_url` | URL | External site URL (shown as "Visit" button on cards and "Visit Site" button on single-listing pages; outbound clicks are tracked) |
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

## Archive View Toggle

Archives (`/listings/`) ship with a **List/Grid view toggle** in the toolbar. **List is the default** — it gives a true link-list feel with one row per site (88×64 thumbnail | title + categories + status | star rating | "Visit" button). Switch to **Grid** for the original card grid layout. The chosen view persists in `localStorage` and is reflected in the URL as `?view=list` or `?view=grid`.

## 100 Default Categories

On theme activation, **100 top adult site categories** are auto-imported with SEO descriptions:

Amateur • Anal • Anime • Asian • BBW • BDSM • Big Ass • Big Dick • Big Tits • Black • Blonde • Blowjob • Bondage • Brazilian • British • Brunette • Bukkake • Cam Girls • Cartoon • Casting • Celebrity • CFNM • Chubby • Clips • Compilation • Cosplay • Couples • Creampie • Cumshot • Cunnilingus • Deep Throat • Double Penetration • Ebony • European • Exotic • Facial • Fetish • Fingering • Fisting • Foot Fetish • Foursome • French • Gangbang • German • Group Sex • Gyno • Hairy • Handjob • Hardcore • Hentai • Homemade • Indian • Interracial • Japanese • Latina • Lesbian • Massage • Masturbation • Mature • MILF • Mom • Nudist • Old + Young • Orgy • Outdoor • Panties • Party • Pissing • Pornstar • POV • Pregnant • Public • Redhead • Russian • Schoolgirl • Sex Toys • Shower • Solo • Spanking • Squirt • Stockings • Strap-on • Strip • Swinger • Teen • Threesome • Toons • Toys • Twink • Uncensored • Uniform • Vintage • Virtual Reality • Webcam • Young • 3D • Amateur Wife • Arab • Ass • Babe • Orgasm • Romance • Voyeur • Twerking • Shemale

Rename or remove any under **Listings → Categories**. The import is **idempotent** (skips existing slugs), so re-activating the theme is safe.

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

## Design System

### Per-Scheme Full-Palette Architecture

The 8 color schemes are **not** accent-color overrides — each one is a **complete theme** that rewires the entire visual identity of the site. The same `h1` selector, the same `.listing-card`, the same `.site-title` will look completely different depending on which scheme the webmaster has selected in **Appearance → Customize → Colors**.

**Each scheme block defines ~35 design tokens**, including:

| Category | Tokens |
|----------|--------|
| **Background** | `--bg-page`, `--bg-elevated`, `--bg-overlay` |
| **Glass** | `--glass-bg`, `--glass-bg-strong`, `--glass-bg-subtle`, `--glass-border`, `--glass-border-strong` |
| **Text** | `--text-primary`, `--text-secondary`, `--text-muted`, `--text-subtle` |
| **Surfaces** | `--card-bg`, `--card-bg-strong`, `--card-border`, `--card-border-hover` |
| **Dividers** | `--divider`, `--divider-strong` |
| **Inputs** | `--input-bg`, `--input-border` |
| **Highlights** | `--highlight`, `--highlight-strong` |
| **Accent** | `--accent`, `--accent-hover`, `--accent-active`, `--accent-glow`, `--accent-glow-strong`, `--accent-soft` |
| **Mesh** | `--mesh-1`, `--mesh-2`, `--mesh-3`, `--mesh-4` |

### Color Schemes

| Scheme | Accent (Dark) | Dark BG | Accent (Light) | Light BG | Mood |
|--------|:-------------:|:-------:|:--------------:|:--------:|------|
| Midnight Blue | `#58a6ff` | `#050a1a` | `#0969da` | `#f0f4fa` | Cool, professional, deep space |
| Emerald Green | `#3fb950` | `#03140c` | `#1a7f37` | `#eaf6ee` | Natural, fresh, forest |
| Ruby Red | `#f85149` | `#1a0710` | `#cf222e` | `#faeef0` | Sensual, deep wine |
| Amethyst Purple | `#bc8cff` | `#120822` | `#8250df` | `#f4eefb` | Mystical, cosmic |
| Amber Gold | `#e3b341` | `#1a1104` | `#9a6700` | `#fbf4e0` | Luxurious, warm sunset |
| Coral Orange | `#ff7b72` | `#1d0908` | `#cf4a3a` | `#fdeee9` | Vibrant, terracotta |
| Ocean Teal | `#39d0d8` | `#021418` | `#0d7d7d` | `#e5f6f8` | Refreshing, deep sea |
| Slate Indigo | `#a5b4fc` | `#08081e` | `#6366f1` | `#eef0fb` | Refined, sophisticated |

All accent colors are WCAG AA compliant against their respective dark/light background.

### Visual Treatment

- **Animated mesh** — 4 radial gradient stops drift via `background-position` over 24s. Each scheme tints the mesh with its own color at 0.32+ opacity (visible, not subtle).
- **Gradient text** — `h1`, `.site-title`, `.page-title`, `.entry-title` use a 3-stop gradient (`text-primary` → `accent` → `accent-hover`) via `background-clip: text`.
- **Glowing scrollbar** (Webkit) — Thumb picks up the active scheme's accent on hover.
- **Bolder hovers** — `.listing-card:hover` lifts `-10px` and emits a 48px accent glow + 1px accent border via `mask-composite`.
- **Bolder focus rings** — 2px outline + 3px accent glow.
- **No link underlines** — Links are differentiated by color shift only. Content links get a GitHub-style pill background on hover.

## File Structure

```
directoryx-adult/
├── style.css              # Theme header + base styles
├── index.php              # Ultimate fallback template
├── functions.php          # Theme setup, hooks, custom functions
├── theme.json             # Gutenberg block editor config (palette + 8 mesh gradients)
├── screenshot.png         # Theme screenshot
├── readme.txt             # WordPress.org readme
├── languages/             # .pot, .po, .mo files
├── inc/                   # PHP classes & modular includes
│   ├── svg-icons.php        # SVG icon helper functions
│   ├── template-functions.php   # Meta registration, admin columns, quick edit, view tracker
│   ├── template-tags.php    # Related listings, social share, report form, schema
│   ├── customizer.php
│   ├── post-types.php
│   └── categories.php       # 100 default adult categories + import function
├── template-parts/          # Reusable template partials
│   ├── content.php
│   ├── content-listing-card.php   # Card layout (grid view)
│   ├── content-listing-row.php    # Row layout (list view, default)
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
│   │   ├── critical.css     # Inlined critical CSS (design system + all components)
│   │   ├── main.css         # Deferred styles
│   │   ├── editor-style.css
│   │   └── print.css
│   └── js/
│       └── main.js          # Deferred JS (search, lightbox, IO, focus trap, prefetch, view toggle…)
└── AGENTS.md                # AI agent documentation
```

## Development

### Requirements

- WordPress 6.0+
- PHP 8.0+
- Node.js (optional, for CSS minification)

### Re-importing the 100 Default Categories

The categories are imported automatically on theme activation (skips existing slugs). To re-trigger:

1. **Deactivate and reactivate** the theme under **Appearance → Themes**, or
2. **Call the function manually** from `wp-admin` or WP-CLI:
   ```php
   dxadult_import_default_categories();
   ```

### Adding a Color Scheme

Each scheme is a full palette, so adding one is more involved than just defining an accent. Required steps:

1. **Add the dark full-palette block** in `assets/css/critical.css` (see existing schemes for the ~35-token template).
2. **Add the light-mode override** in the same file.
3. **Add a per-scheme mesh gradient** in `theme.json` under `settings.color.gradients`.
4. **Add to `inc/customizer.php`** in the `dxadult_default_scheme` choices array.
5. **Test contrast** for both dark and light modes against `--bg-page`. Aim for WCAG AA.

### Adding a New Meta Field

1. Register in `inc/template-functions.php` (`dxadult_register_listing_meta()`)
2. Add UI in `dxadult_listing_meta_box_callback()` and save in `dxadult_save_listing_meta()`
3. Optionally add an admin column
4. Display in `template-parts/content-listing-card.php` or `template-parts/content-listing-row.php`

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the full release history.

### 1.3.0 — Default Categories + List/Grid View

- **100 default adult site categories** auto-imported on theme activation with SEO descriptions. Includes Amateur, Anal, Asian, BBW, BDSM, MILF, Teen, Hentai, VR, Shemale, and 80+ more. Idempotent import; admin notice shows the count. Re-importable via `dxadult_import_default_categories()`.
- **List/Grid view toggle** in archive toolbar. **List is the default** — true link-list feel with thumbnail | title + categories + status | rating | Visit button per row. Grid view is the original card layout. View persists in `localStorage` and via `?view=` URL param.
- **New template part** `template-parts/content-listing-row.php` for the row layout.
- **Listing Details meta box** — URL field relabeled "External link / URL:" with a clear description of where the link appears on the frontend.
- **`$_GET['view']`** sanitized via `sanitize_key()` + whitelist to `list`/`grid` in `archive.php`.

### 1.2.0 — Design System Overhaul

- **Per-scheme full-palette** — Each of the 8 schemes now rewires the entire theme (bg, surfaces, glass, text, mesh), not just the accent.
- **Animated mesh background** — Subtle 24s drift across 4 radial gradient stops; reduced-motion aware.
- **3-stop gradient text** on h1, `.site-title`, `.page-title`, `.entry-title`.
- **Glowing scrollbar** (Webkit) that picks up the active scheme on hover.
- **Bolder focus rings** and **bolder card hovers**.
- **Light-mode tinted pastels** for all 7 non-default schemes.
- **`theme.json`** updated with 8 per-scheme mesh gradients.
- **4th mesh gradient stop** (`--mesh-4`) for richer per-scheme backgrounds.

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
