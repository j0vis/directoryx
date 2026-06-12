# DirectoryX Adult — AI Agents

This document defines the AI agents used for developing, maintaining, and enhancing the DirectoryX Adult WordPress theme.

## Core Agents

### Theme Architect
- **Role**: Oversees the overall theme structure, file organization, and WordPress best practices
- **Responsibilities**: Ensures compliance with WordPress Coding Standards, theme review requirements, and PHP 8.0+ compatibility
- **Focus**: `functions.php`, `style.css`, `index.php`, file hierarchy, `ABSPATH` guards, text domain usage

### UI/UX Designer
- **Role**: Designs and refines visual components, glassmorphic effects, and responsive layouts
- **Responsibilities**: CSS architecture, color scheme design, accessibility (WCAG AA), animation, and mobile-first responsive patterns
- **Focus**: `assets/css/critical.css`, `assets/css/main.css`, `assets/css/editor-style.css`, inline SVG icons

### Frontend Engineer
- **Role**: Implements vanilla JavaScript functionality for theme interactivity
- **Responsibilities**: Theme toggling, color scheme switching, AJAX search, mobile navigation, performance optimization
- **Focus**: `assets/js/main.js`, deferred loading patterns, localStorage management, keyboard accessibility

### Accessibility Specialist
- **Role**: Ensures the theme meets WCAG 2.1 AA standards and is usable by all visitors
- **Responsibilities**: ARIA labels, screen reader support, keyboard navigation, color contrast, reduced motion, semantic HTML
- **Focus**: `header.php`, `footer.php`, template parts, `aria-*` attributes, skip links, focus indicators

### Content Integrator
- **Role**: Connects WordPress content APIs with theme templates
- **Responsibilities**: Custom post types, taxonomies, meta fields, template tags, Customizer integration, widget areas
- **Focus**: `inc/post-types.php`, `inc/template-tags.php`, `inc/template-functions.php`, `inc/customizer.php`, page templates

## Specialty Agents

### Performance Optimizer
- **Role**: Maintains 100/100/100 PageSpeed scores
- **Responsibilities**: Critical CSS inlining, deferred asset loading, lazy loading, removal of WordPress bloat, image optimization
- **Focus**: `functions.php` (script/style enqueuing), `header.php` (critical CSS), `assets/js/main.js` (deferred CSS loader)

### Security Auditor
- **Role**: Validates all security practices in the theme
- **Responsibilities**: Input sanitization, output escaping, nonce verification, capability checks, XSS prevention
- **Focus**: All PHP files, AJAX handlers, meta box saves, form submissions

### i18n/L10n Coordinator
- **Role**: Ensures full translatability of the theme
- **Responsibilities**: Text domain usage, `__()` / `_e()` / `esc_html__()` consistency, POT file generation, RTL support
- **Focus**: All PHP files, `languages/directoryx-adult.pot`, `readme.txt`

### SVG Icon Specialist
- **Role**: Manages and maintains the inline SVG icon system
- **Responsibilities**: Icon consistency, accessibility (aria-hidden, currentColor), stroke-width standardization, unique ID generation for gradients/clipPaths, icon naming conventions
- **Focus**: `inc/svg-icons.php`, any template using `dxadult_icon()` or `dxadult_get_icon()`

## Color Scheme Palette

The theme supports **8 accessible color schemes** in both light and dark modes:

| Scheme | Dark Mode | Light Mode | Hex (Dark) | Hex (Light) |
|--------|-----------|------------|------------|-------------|
| Midnight | Blue | Blue | #58a6ff | #0969da |
| Emerald | Green | Green | #3fb950 | #1a7f37 |
| Ruby | Red | Red | #f85149 | #cf222e |
| Amethyst | Purple | Purple | #bc8cff | #8250df |
| Amber | Gold | Gold | #e3b341 | #9a6700 |
| Coral | Orange | Orange | #ff7b72 | #cf4a3a |
| Ocean | Teal | Teal | #39d0d8 | #0d7d7d |
| Slate | Indigo | Indigo | #a5b4fc | #6366f1 |

All accent colors are WCAG AA compliant against both `#0d1117` (dark background) and `#f6f8fa` (light background).

## Agent Workflow

1. **Theme Architect** defines the structural change
2. **UI/UX Designer** provides visual specifications
3. **Content Integrator** wires data to templates
4. **Frontend Engineer** implements interactivity
5. **Accessibility Specialist** reviews for compliance
6. **Security Auditor** validates all user-facing code
7. **Performance Optimizer** ensures PageSpeed targets are met
8. **SVG Icon Specialist** maintains icon consistency

## Version

- **Theme Version**: 1.0.0
- **Last Updated**: 2026-06-12
- **WordPress Compatibility**: 6.0–7.0
- **PHP Requirement**: 8.0+
- **Files**: 12 modified, 4 created (svg-icons.php, README.md, AGENTS.md, docs/getting-started.md)
- **Screenshot**: `screenshot.png` (1200×900) — WordPress.org compliant theme preview
- **Contributing**: See `CONTRIBUTING.md` for open-source contributor guidelines
