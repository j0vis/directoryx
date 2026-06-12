# DirectoryX Adult

A high-performance adult site directory WordPress theme built on DirectoryX. Glassmorphic design with light/dark mode toggle and 8 accessible accent schemes. Optimized for 100/100/100 PageSpeed.

![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-purple.svg)
![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)

## Features

- **Glassmorphic Design** — Frosted glass cards with backdrop-filter blur, subtle glow effects, and smooth hover animations
- **8 Accessible Color Schemes** — Midnight Blue, Emerald Green, Ruby Red, Amethyst Purple, Amber Gold, Coral Orange, Ocean Teal, Slate Indigo. All WCAG AA compliant
- **Dark/Light Mode Toggle** — Persisted in localStorage with smooth transitions
- **100/100/100 PageSpeed** — Critical CSS inlined, deferred assets, lazy loading, zero bloat
- **Custom Listing Post Type** — URL, rating, and status meta fields with admin meta box
- **Category Taxonomy** — `listing_category` with archive templates
- **Responsive Grid Layout** — CSS Grid with mobile-first breakpoints
- **Mobile Bottom Navigation** — Fixed bottom nav with safe-area-inset support
- **Schema.org Markup** — ItemList, SiteNavigationElement, BreadcrumbList
- **Accessibility** — Skip links, ARIA labels, semantic HTML5, keyboard navigation, reduced motion support
- **Translation Ready** — Full i18n support with POT file included
- **SVG Icon System** — 30+ inline SVG icons, themeable via CSS `currentColor`

## Screenshots

*Coming soon*

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme through **Appearance > Themes** in WordPress
3. Go to **Appearance > Customize** to set the default color scheme
4. Create "listing" posts and assign them to "listing_category" terms

## PageSpeed Optimization

This theme achieves 100/100/100 out of the box by:

1. **Inlining critical CSS** — All above-the-fold styles in `assets/css/critical.css` inlined via `require()` in `header.php`
2. **Deferred non-critical CSS** — `main.css` loaded via `dxadultLoadCSS()` using `media="print"` swap pattern
3. **Deferred JavaScript** — All theme JS uses the `defer` attribute via `script_loader_tag` filter
4. **Removed bloat** — Emoji scripts, block library CSS, global styles, REST API links, oEmbed, shortlink, RSD, WLW manifest, generator tag
5. **Lazy loading** — All images use `loading="lazy"`
6. **System font stack** — Zero external font requests

## Custom Post Types & Taxonomies

The theme registers these automatically on activation:

- **Post Type:** `listing` (slug: `listing`)
- **Taxonomy:** `listing_category` (slug: `category`)

### Custom Meta Fields

| Field | Type | Description |
|-------|------|-------------|
| `listing_url` | URL | External site URL |
| `listing_rating` | Number | 1.0 to 5.0 star rating |
| `listing_status` | String | `active`, `reviewed`, or `new` |

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
├── screenshot.png         # Theme screenshot
├── readme.txt             # WordPress.org readme
├── languages/             # .pot, .po, .mo files
├── inc/                     # PHP classes & modular includes
│   ├── svg-icons.php        # SVG icon helper functions
│   ├── template-functions.php
│   ├── template-tags.php
│   ├── customizer.php
│   └── post-types.php
├── template-parts/          # Reusable template partials
│   ├── content.php
│   ├── content-listing-card.php
│   ├── content-category-card.php
│   ├── content-none.php
│   ├── content-page.php
│   └── breadcrumbs.php
├── page-templates/          # Custom page templates
│   ├── template-directory-home.php
│   ├── template-directory-categories.php
│   └── template-full-width.php
├── assets/
│   ├── css/
│   │   ├── critical.css     # Inlined critical CSS
│   │   ├── main.css         # Deferred styles
│   │   ├── editor-style.css
│   │   └── print.css
│   └── js/
│       └── main.js          # Deferred JS
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

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the full release history.

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

## Credits

- Built by [j0vis](https://github.com/j0vis)
- Based on the DirectoryX project
