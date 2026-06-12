# Changelog

All notable changes to the DirectoryX Adult theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned
- Screenshot images for theme preview
- Additional page templates (e.g., featured listings, top rated)
- Admin dashboard widget for quick listing stats
- REST API endpoints for listing data
- Automated POT file generation via GitHub Actions

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

[Unreleased]: https://github.com/j0vis/directoryx/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/j0vis/directoryx/releases/tag/v1.0.0
