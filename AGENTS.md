# DirectoryX Adult — AI Agents

This document defines the AI agents used for developing, maintaining, and enhancing the DirectoryX Adult WordPress theme.

## Core Agents

### Theme Architect
- **Role**: Oversees the overall theme structure, file organization, and WordPress best practices
- **Responsibilities**: Ensures compliance with WordPress Coding Standards, theme review requirements, and PHP 8.0+ compatibility
- **Focus**: `functions.php`, `style.css`, `index.php`, file hierarchy, `ABSPATH` guards, text domain usage

### UI/UX Designer
- **Role**: Designs and refines visual components, glassmorphic effects, per-scheme full-palette tokens, and responsive layouts
- **Responsibilities**: Design token architecture (~35 tokens per scheme), color scheme design, glassmorphism (layered shadows + top inner highlight), animated mesh background, gradient text treatments, accessibility (WCAG AA), animation, mobile-first responsive patterns
- **Focus**: `assets/css/critical.css`, `assets/css/main.css`, `assets/css/editor-style.css`, `theme.json`, inline SVG icons

### Frontend Engineer
- **Role**: Implements vanilla JavaScript functionality for theme interactivity
- **Responsibilities**: Light/dark theme toggling, AJAX search, mobile navigation, IntersectionObserver entrance animations, image lightbox, toast notifications, performance optimization
- **Focus**: `assets/js/main.js`, deferred loading patterns, localStorage management, keyboard accessibility, click tracking via `sendBeacon`

### Accessibility Specialist
- **Role**: Ensures the theme meets WCAG 2.1 AA standards and is usable by all visitors
- **Responsibilities**: ARIA labels, screen reader support, keyboard navigation, color contrast (especially per-scheme text-on-bg ratios), reduced motion, semantic HTML, focus rings
- **Focus**: `header.php`, `footer.php`, template parts, `aria-*` attributes, skip links, focus indicators, gradient-text contrast (must read in both light and dark mode)

### Content Integrator
- **Role**: Connects WordPress content APIs with theme templates
- **Responsibilities**: Custom post types, taxonomies, meta fields, template tags, Customizer integration (webmaster-only scheme picker), widget areas
- **Focus**: `inc/post-types.php`, `inc/template-tags.php`, `inc/template-functions.php`, `inc/customizer.php`, page templates

## Specialty Agents

### Performance Optimizer
- **Role**: Maintains 100/100/100 PageSpeed scores
- **Responsibilities**: Critical CSS inlining, deferred asset loading, lazy loading, removal of WordPress bloat, image optimization, GPU-accelerated animations
- **Focus**: `functions.php` (script/style enqueuing), `header.php` (critical CSS), `assets/js/main.js` (deferred CSS loader), `background-position` animation (composited, no repaints)

### Security Auditor
- **Role**: Validates all security practices in the theme
- **Responsibilities**: Input sanitization, output escaping, nonce verification, capability checks, XSS prevention, hashed report IPs
- **Focus**: All PHP files, AJAX handlers, meta box saves, form submissions, REST endpoints

### i18n/L10n Coordinator
- **Role**: Ensures full translatability of the theme
- **Responsibilities**: Text domain usage, `__()` / `_e()` / `esc_html__()` consistency, POT file generation, RTL support
- **Focus**: All PHP files, `languages/directoryx-adult.pot`, `readme.txt`

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

**Shadows:** `--glass-shadow`, `--glass-shadow-lg` (layered with top inner highlight + outer drop-shadows)

**Text:** `--text-primary`, `--text-secondary`, `--text-muted`, `--text-subtle`

**Surfaces:** `--card-bg`, `--card-bg-strong`, `--card-border`, `--card-border-hover`

**Dividers:** `--divider`, `--divider-strong`

**Inputs:** `--input-bg`, `--input-border`

**Highlights:** `--highlight`, `--highlight-strong` (top-edge "lit" gradient)

**Accent:** `--accent`, `--accent-hover`, `--accent-active`, `--accent-glow`, `--accent-glow-strong`, `--accent-soft`

**Mesh:** `--mesh-1`, `--mesh-2`, `--mesh-3`, `--mesh-4` (4 radial-gradient stops for the page background)

### Global Tokens (Not Per-Scheme)

- **Typography:** `--font-sans`, `--font-display`, `--font-mono`, `--text-xs` … `--text-5xl`
- **Radii:** `--radius-sm`, `--radius`, `--radius-lg`, `--radius-xl`
- **Easing:** `--ease-smooth`, `--ease-spring`, `--ease-out`
- **Duration:** `--duration-fast` (150ms), `--duration` (250ms), `--duration-slow` (400ms)
- **Letter spacing:** `--tracking-tight`, `--tracking-tighter`, `--tracking-normal`, `--tracking-wide`, `--tracking-wider`
- **z-index:** `--z-base`, `--z-header`, `--z-overlay`, `--z-modal`, `--z-toast`
- **Utility shadows:** `--glow-ring`, `--glow-text`

### Visual Treatments (v1.2.0+)

- **Animated mesh background** — 4 radial gradients drift via `background-position` over 24s. Paused for `prefers-reduced-motion`. No new HTTP requests, fully composited.
- **3-stop gradient text** — `h1`, `.site-title`, `.page-title`, `.entry-title` use `linear-gradient(135deg, var(--text-primary) 0%, var(--accent) 50%, var(--accent-hover) 100%)` clipped to text.
- **Glowing scrollbar** (Webkit) — Thumb picks up `--accent` with glow on hover.
- **Bolder focus rings** — 2px outline + 3px accent glow (`var(--glow-ring)`).
- **Bolder card hovers** — `-8px` lift, 1px accent border via `mask-composite`, 40px accent glow.

### User-Facing vs Webmaster Controls

| Control | User (public) | Webmaster (Customizer) |
|---------|:-------------:|:----------------------:|
| Light/Dark mode toggle | ✅ (header button) | ✅ (default setting) |
| Accent color scheme | ❌ | ✅ (site-wide setting) |

The 8 color schemes are a **webmaster-only** setting. Visitors can only toggle light/dark via the theme toggle in the header. The `data-scheme` attribute is set server-side from the Customizer value; the inline pre-paint script in `header.php` only reads the theme toggle state from `localStorage`.

## Agent Workflow

1. **Theme Architect** defines the structural change
2. **UI/UX Designer** provides visual specifications (which tokens change, which stay)
3. **Content Integrator** wires data to templates
4. **Frontend Engineer** implements interactivity
5. **Accessibility Specialist** reviews for compliance (especially per-scheme contrast)
6. **Security Auditor** validates all user-facing code
7. **Performance Optimizer** ensures PageSpeed targets are met
8. **SVG Icon Specialist** maintains icon consistency

## Version

- **Theme Version**: 1.2.0
- **Last Updated**: 2026-06-13
- **WordPress Compatibility**: 6.0–7.0
- **PHP Requirement**: 8.0+
- **Files (v1.2.0)**: 2 modified (critical.css, theme.json), 1 new (per-scheme design system)
- **Screenshot**: `screenshot.png` (1200×900) — WordPress.org compliant theme preview
- **Contributing**: See `CONTRIBUTING.md` for open-source contributor guidelines
