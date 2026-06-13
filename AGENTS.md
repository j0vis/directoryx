# DirectoryX Adult — AI Agents

This document defines the AI agents used for developing, maintaining, and enhancing the DirectoryX Adult WordPress theme.

## Core Agents

### Theme Architect
- **Role**: Oversees the overall theme structure, file organization, and WordPress best practices
- **Responsibilities**: Ensures compliance with WordPress Coding Standards, theme review requirements, and PHP 8.0+ compatibility
- **Focus**: `functions.php`, `style.css`, `index.php`, file hierarchy, `ABSPATH` guards, text domain usage

### UI/UX Designer
- **Role**: Designs and refines visual components, glassmorphic effects, per-scheme full-palette tokens, and responsive layouts
- **Responsibilities**: Design token architecture (~35 tokens per scheme), color scheme design, glassmorphism (layered shadows + top inner highlight), animated mesh background, gradient text treatments, list/grid view toggle, accessibility (WCAG AA), animation, mobile-first responsive patterns
- **Focus**: `assets/css/critical.css`, `assets/css/main.css`, `assets/css/editor-style.css`, `theme.json`, inline SVG icons

### Frontend Engineer
- **Role**: Implements vanilla JavaScript functionality for theme interactivity
- **Responsibilities**: Light/dark theme toggling, AJAX search, mobile navigation, IntersectionObserver entrance animations, image lightbox, toast notifications, **list/grid view toggle with localStorage persistence**, performance optimization
- **Focus**: `assets/js/main.js`, deferred loading patterns, localStorage management, keyboard accessibility, click tracking via `sendBeacon`

### Accessibility Specialist
- **Role**: Ensures the theme meets WCAG 2.1 AA standards and is usable by all visitors
- **Responsibilities**: ARIA labels, screen reader support, keyboard navigation, color contrast (especially per-scheme text-on-bg ratios), reduced motion, semantic HTML, focus rings, `aria-pressed`/`aria-label` on view toggle
- **Focus**: `header.php`, `footer.php`, template parts, `aria-*` attributes, skip links, focus indicators, gradient-text contrast

### Content Integrator
- **Role**: Connects WordPress content APIs with theme templates
- **Responsibilities**: Custom post types, taxonomies, meta fields, **100 default taxonomy terms with auto-import on activation**, template tags, Customizer integration (webmaster-only scheme picker), widget areas, row/card template parts
- **Focus**: `inc/post-types.php`, `inc/template-tags.php`, `inc/template-functions.php`, `inc/categories.php`, `inc/customizer.php`, `template-parts/content-listing-{card,row}.php`

## Specialty Agents

### Performance Optimizer
- **Role**: Maintains 100/100/100 PageSpeed scores
- **Responsibilities**: Critical CSS inlining, deferred asset loading, lazy loading, removal of WordPress bloat, image optimization, GPU-accelerated animations
- **Focus**: `functions.php` (script/style enqueuing), `header.php` (critical CSS), `assets/js/main.js` (deferred CSS loader), `background-position` animation (composited, no repaints)

### Security Auditor
- **Role**: Validates all security practices in the theme
- **Responsibilities**: Input sanitization, output escaping, nonce verification, capability checks, XSS prevention, hashed report IPs, `$_GET['view']` whitelist sanitization
- **Focus**: All PHP files, AJAX handlers, meta box saves, form submissions, REST endpoints, archive template (view param)

### i18n/L10n Coordinator
- **Role**: Ensures full translatability of the theme
- **Responsibilities**: Text domain usage, `__()` / `_e()` / `esc_html__()` consistency, POT file generation, RTL support
- **Focus**: All PHP files (including the new `template-parts/content-listing-row.php` and `inc/categories.php`), `languages/directoryx-adult.pot`, `readme.txt`

### SVG Icon Specialist
- **Role**: Manages and maintains the inline SVG icon system
- **Responsibilities**: Icon consistency, accessibility (aria-hidden, currentColor), stroke-width standardization, unique ID generation for gradients/clipPaths, icon naming conventions
- **Focus**: `inc/svg-icons.php`, any template using `dxadult_icon()` or `dxadult_get_icon()`

## Design System (v1.2.0+)

### Per-Scheme Full-Palette Architecture

Since v1.2.0, each of the 8 color schemes rewires the **entire theme** (background, surface elevations, glass tints, text tints, 4-stop mesh gradient) — not just the accent. Every `[data-scheme="X"]` block defines **~35 design tokens** that the rest of the theme references through `var(--token-name)`. The result: switching from Midnight to Ruby transforms the page into a deep wine background with red-tinted glass and a vibrant red mesh.

### Color Scheme Reference

| Scheme | Accent (Dark) | Dark BG | Accent (Light) | Light BG | Mood |
|--------|:-------------:|:-------:|:--------------:|:--------:|------|
| Midnight | `#58a6ff` | `#050a1a` | `#0969da` | `#f0f4fa` | Cool, professional |
| Emerald | `#3fb950` | `#03140c` | `#1a7f37` | `#eaf6ee` | Natural, fresh |
| Ruby | `#f85149` | `#1a0710` | `#cf222e` | `#faeef0` | Sensual, deep wine |
| Amethyst | `#bc8cff` | `#120822` | `#8250df` | `#f4eefb` | Mystical, cosmic |
| Amber | `#e3b341` | `#1a1104` | `#9a6700` | `#fbf4e0` | Luxurious, warm |
| Coral | `#ff7b72` | `#1d0908` | `#cf4a3a` | `#fdeee9` | Vibrant, terracotta |
| Ocean | `#39d0d8` | `#021418` | `#0d7d7d` | `#e5f6f8` | Refreshing, deep sea |
| Slate | `#a5b4fc` | `#08081e` | `#6366f1` | `#eef0fb` | Refined, sophisticated |

All accents are WCAG AA compliant against both their dark and light backgrounds.

### Tokens Defined Per Scheme

**Backgrounds:** `--bg-page`, `--bg-elevated`, `--bg-overlay`
**Glass:** `--glass-bg`, `--glass-bg-strong`, `--glass-bg-subtle`, `--glass-border`, `--glass-border-strong`, `--glass-blur`, `--glass-blur-lg`
**Shadows:** `--glass-shadow`, `--glass-shadow-lg`
**Text:** `--text-primary`, `--text-secondary`, `--text-muted`, `--text-subtle`
**Surfaces:** `--card-bg`, `--card-bg-strong`, `--card-border`, `--card-border-hover`
**Dividers:** `--divider`, `--divider-strong`
**Inputs:** `--input-bg`, `--input-border`
**Highlights:** `--highlight`, `--highlight-strong`
**Accent:** `--accent`, `--accent-hover`, `--accent-active`, `--accent-glow`, `--accent-glow-strong`, `--accent-soft`
**Mesh:** `--mesh-1`, `--mesh-2`, `--mesh-3`, `--mesh-4`

### Global Tokens (Not Per-Scheme)

Typography (`--font-sans`, `--font-display`, `--font-mono`, `--text-xs` … `--text-5xl`), Radii (`--radius-sm`, `--radius`, `--radius-lg`, `--radius-xl`), Easing (`--ease-smooth`, `--ease-spring`, `--ease-out`), Duration (`--duration-fast`, `--duration`, `--duration-slow`), Letter spacing, z-index, Utility shadows (`--glow-ring`, `--glow-text`).

### Visual Treatments (v1.2.0+)

- **Animated mesh background** — 4 radial gradients drift via `background-position` over 24s. Paused for `prefers-reduced-motion`.
- **3-stop gradient text** on h1, `.site-title`, `.page-title`, `.entry-title`.
- **Glowing scrollbar** (Webkit) — Thumb picks up `--accent` with glow on hover.
- **Bolder focus rings** — 2px outline + 3px accent glow.
- **Bolder card hovers** — `-10px` lift, 1px accent border via `mask-composite`, 48px accent glow.
- **No link underlines** — Color shift only; inline content links get a pill background on hover.

## Archive Layouts (v1.3.0+)

Since v1.3.0, archives support **two view modes** selected via the toolbar toggle (or `?view=` URL param, default `list`):

### List View (default) — Link-List Feel
- **Wrapper:** `<div class="listing-archive view--list">` — single glass container
- **Row template:** `template-parts/content-listing-row.php`
- **Layout:** 88×64 thumbnail | title + categories + status | star rating | "Visit" button
- **Hover:** row gets `var(--accent-soft)` background, thumbnail scales 1.06
- **Mobile (<640px):** stacks to 2-row layout

### Grid View
- **Wrapper:** `<div class="listing-archive view--grid">` — CSS Grid
- **Card template:** `template-parts/content-listing-card.php`
- **Layout:** repeat(auto-fill, minmax(310px, 1fr)) card grid (unchanged from v1.0)

### View Toggle Implementation
- **HTML:** Segmented pill control in `archive-toolbar` with two `<button data-view="list|grid">` elements
- **JS (`assets/js/main.js`):** Click handler persists preference in `localStorage` and reloads with `?view=` so the PHP template picks the right template part
- **A11y:** `aria-pressed`, `aria-label`, `role="group"` on the toggle
- **Server-side:** `$current_view = sanitize_key( $_GET['view'] )` + whitelist to `list`/`grid`

## Default Categories (v1.3.0+)

Since v1.3.0, the theme ships with **100 top adult site categories** that auto-import on theme activation. See `inc/categories.php` for the full list and `dxadult_get_default_categories()` for the canonical source.

### Architecture
- **Data:** `dxadult_get_default_categories()` returns an array of `['name', 'slug', 'description']` tuples
- **Import:** `dxadult_import_default_categories()` calls `wp_insert_term()` for each, skipping existing slugs (idempotent)
- **Hook:** `add_action( 'after_switch_theme', 'dxadult_import_default_categories' )` runs once on activation
- **Admin notice:** A dismissible notice shows the import count and points users to **Listings → Categories** to manage terms
- **Re-import:** Deactivate/reactivate the theme, or call `dxadult_import_default_categories()` manually

### Categories
Amateur, Anal, Anime, Asian, BBW, BDSM, Big Ass, Big Dick, Big Tits, Black, Blonde, Blowjob, Bondage, Brazilian, British, Brunette, Bukkake, Cam Girls, Cartoon, Casting, Celebrity, CFNM, Chubby, Clips, Compilation, Cosplay, Couples, Creampie, Cumshot, Cunnilingus, Deep Throat, Double Penetration, Ebony, European, Exotic, Facial, Fetish, Fingering, Fisting, Foot Fetish, Foursome, French, Gangbang, German, Group Sex, Gyno, Hairy, Handjob, Hardcore, Hentai, Homemade, Indian, Interracial, Japanese, Latina, Lesbian, Massage, Masturbation, Mature, MILF, Mom, Nudist, Old+Young, Orgy, Outdoor, Panties, Party, Pissing, Pornstar, POV, Pregnant, Public, Redhead, Russian, Schoolgirl, Sex Toys, Shower, Solo, Spanking, Squirt, Stockings, Strap-on, Strip, Swinger, Teen, Threesome, Toons, Toys, Twink, Uncensored, Uniform, Vintage, Virtual Reality, Webcam, Young, 3D, Amateur Wife, Arab, Ass, Babe, Orgasm, Romance, Voyeur, Twerking, Shemale.

## User-Facing vs Webmaster Controls

| Control | User (public) | Webmaster (Customizer) |
|---------|:-------------:|:----------------------:|
| Light/Dark mode toggle | ✅ (header button) | ✅ (default setting) |
| Accent color scheme | ❌ | ✅ (site-wide setting) |
| List/Grid archive view | ✅ (toolbar toggle) | ❌ (visitor preference) |
| Default categories | ❌ (read-only) | ✅ (manage in Listings → Categories) |

## Agent Workflow

1. **Theme Architect** defines the structural change
2. **UI/UX Designer** provides visual specifications (which tokens change, which stay; list vs grid layout decisions)
3. **Content Integrator** wires data to templates (including the 100 default categories and new row template part)
4. **Frontend Engineer** implements interactivity (including the view toggle)
5. **Accessibility Specialist** reviews for compliance (especially per-scheme contrast, view toggle a11y)
6. **Security Auditor** validates all user-facing code (including `$_GET['view']` sanitization)
7. **Performance Optimizer** ensures PageSpeed targets are met
8. **SVG Icon Specialist** maintains icon consistency (including the new view toggle SVG icons)

## Version

- **Theme Version**: 1.3.0
- **Last Updated**: 2026-06-13
- **WordPress Compatibility**: 6.0–7.0
- **PHP Requirement**: 8.0+
- **Files (v1.3.0)**: 2 new (`inc/categories.php`, `template-parts/content-listing-row.php`), 5 modified (`archive.php`, `functions.php`, `inc/template-functions.php`, `assets/css/critical.css`, `assets/js/main.js`)
- **Screenshot**: `screenshot.png` (1200×900) — WordPress.org compliant theme preview
- **Contributing**: See `CONTRIBUTING.md` for open-source contributor guidelines
