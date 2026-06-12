# Contributing to DirectoryX Adult

Thank you for your interest in contributing to DirectoryX Adult! This document outlines the guidelines for contributing to this WordPress theme.

## Table of Contents

- [Getting Started](#getting-started)
- [Development Environment](#development-environment)
- [Code Standards](#code-standards)
- [How to Contribute](#how-to-contribute)
- [Commit Messages](#commit-messages)
- [Testing](#testing)
- [Security & Accessibility](#security--accessibility)
- [SVG Icons](#svg-icons)
- [Color Schemes](#color-schemes)
- [Release Process](#release-process)
- [Code of Conduct](#code-of-conduct)

---

## Getting Started

1. **Fork the repository** on GitHub.
2. **Clone your fork** locally:
   ```bash
   git clone https://github.com/YOUR_USERNAME/directoryx.git
   cd directoryx
   ```
3. **Create a branch** for your contribution:
   ```bash
   git checkout -b feature/my-new-feature
   ```

---

## Development Environment

### Requirements

- **WordPress** 6.0 or higher
- **PHP** 8.0 or higher
- **Node.js** (optional, for CSS minification)

### Recommended Setup

1. Install [Local WP](https://localwp.com/), [WP Engine DevKit](https://wpengine.com/devkit/), or use a local Docker environment.
2. Symlink the theme into your WordPress install:
   ```bash
   ln -s $(pwd) /path/to/wordpress/wp-content/themes/directoryx-adult
   ```
3. Activate the theme in **Appearance > Themes**.
4. Create a few `listing` posts and `listing_category` terms to populate the theme.

---

## Code Standards

We follow the **WordPress Coding Standards** (WPCS). All PHP, CSS, and JavaScript must comply.

### PHP

- **Prefix everything** with `dxadult_` to avoid namespace collisions.
- **Start every file** with the `ABSPATH` guard:
  ```php
  <?php
  if ( ! defined( 'ABSPATH' ) ) {
      exit;
  }
  ```
- **Use strict typing** where appropriate (PHP 8.0+):
  ```php
  function dxadult_get_something( string $param ): array {
  ```
- **Escape all output**:
  | Context | Function |
  |---------|----------|
  | HTML | `esc_html()` |
  | Attribute | `esc_attr()` |
  | URL | `esc_url()` |
  | Textarea | `esc_textarea()` |
  | Rich HTML | `wp_kses_post()` |
- **Use `WP_Query`** — never `query_posts()`.
- **Use core APIs** — prefer `wp_nav_menu()`, `get_template_part()`, `the_posts_pagination()` over custom implementations.

### CSS

- **Use CSS custom properties** (variables) for colors, spacing, and shadows.
- **Support both `[data-theme="dark"]` and `[data-theme="light"]`**.
- **Support all 8 color schemes** via `[data-scheme="..."]`.
- **Use `rem` units** for font sizes; `px` is acceptable for borders and small UI elements.
- **Avoid `!important`** unless overriding third-party styles.
- **Mobile-first** responsive breakpoints.

### JavaScript

- **Vanilla JS only** — no jQuery or frameworks.
- **Use `var` consistently** (theme convention) or `const`/`let` if modernizing.
- **Defer all scripts** — the theme uses `defer` on all JS.
- **Use `localStorage`** for user preferences (theme mode, color scheme).
- **Respect `prefers-reduced-motion`** for animations.

---

## How to Contribute

### Reporting Bugs

1. **Check existing issues** before opening a new one.
2. Use the **Bug Report** template (if available) or include:
   - WordPress version
   - PHP version
   - Browser and OS
   - Steps to reproduce
   - Expected vs. actual behavior
   - Screenshots (if applicable)

### Suggesting Features

1. Open a **Feature Request** issue.
2. Describe the feature and its use case.
3. If applicable, include mockups or references.

### Pull Requests

1. **Ensure your PR addresses an existing issue** (or open one first).
2. **Update documentation** if your change affects usage.
3. **Update `CHANGELOG.md`** under the `[Unreleased]` section.
4. **Keep PRs focused** — one feature or fix per PR.
5. **Rebase on `main`** before submitting if there are conflicts.

### PR Review Process

- All PRs require **at least one review** before merging.
- The reviewer will check for:
  - WPCS compliance
  - Security (escaping, nonces)
  - Accessibility (ARIA, contrast, keyboard)
  - Performance (no render-blocking, no bloat)
  - SVG icon consistency

---

## Commit Messages

Use clear, descriptive commit messages. We follow the **Conventional Commits** style:

```
<type>(<scope>): <description>

[optional body]

[optional footer]
```

**Types:**
- `feat` — New feature
- `fix` — Bug fix
- `docs` — Documentation changes
- `style` — CSS/styling changes (no logic change)
- `refactor` — Code restructuring
- `perf` — Performance improvement
- `test` — Adding or updating tests
- `chore` — Build process, dependencies, etc.

**Examples:**
```
feat(customizer): add default color scheme setting

fix(header): correct aria-pressed state on theme toggle

docs(readme): update installation instructions for Local WP

perf(css): minify critical.css for production
```

---

## Testing

### Manual Testing Checklist

Before submitting a PR, verify the following in a clean WordPress install:

- [ ] Theme activates without errors
- [ ] `listing` post type and `listing_category` taxonomy are registered
- [ ] Listing cards display correctly with thumbnails, ratings, and status badges
- [ ] Category cards display with folder icons
- [ ] Color scheme picker works in all 8 schemes
- [ ] Dark/light mode toggle works and persists via `localStorage`
- [ ] Mobile bottom navigation appears below 768px
- [ ] Search overlay works on mobile
- [ ] No console errors in browser DevTools
- [ ] PageSpeed Insights shows 95+ on mobile and desktop
- [ ] All links and buttons are keyboard-navigable
- [ ] Screen reader announces landmarks correctly

### Automated Testing

We currently rely on manual testing. If you add automated tests (e.g., PHPUnit, Playwright), please include them in your PR.

---

## Security & Accessibility

### Security Checklist

- [ ] All user-facing output is escaped (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`).
- [ ] All inputs are sanitized (`sanitize_text_field`, `sanitize_url`, etc.).
- [ ] Nonces are used for form submissions (`wp_nonce_field`, `check_ajax_referer`).
- [ ] Capability checks are used for admin actions (`current_user_can`).
- [ ] No direct DB queries — use `WP_Query` or core APIs.

### Accessibility Checklist

- [ ] All interactive elements have focus indicators.
- [ ] All icons have `aria-hidden="true"` and adjacent text labels.
- [ ] Color contrast meets WCAG AA (4.5:1 for normal text, 3:1 for large text).
- [ ] `prefers-reduced-motion` is respected for animations.
- [ ] Skip links are present and functional.
- [ ] Semantic HTML5 landmarks are used (`<main>`, `<nav>`, `<header>`, `<footer>`).

---

## SVG Icons

The theme uses an inline SVG system in `inc/svg-icons.php`.

### Adding a New Icon

1. Add the SVG path data to the `$icons` array in `inc/svg-icons.php`.
2. Use `currentColor` for stroke/fill so it inherits the theme accent.
3. If the icon uses gradients or clip paths, ensure **unique IDs** are generated via the `$uid` counter.
4. Add a usage example to `README.md`.

### Icon Guidelines

- **Consistent sizing** — default to `viewBox="0 0 24 24"` and `stroke-width="1"`.
- **No hardcoded colors** — always use `currentColor`.
- **Accessible** — icons are decorative, so `aria-hidden="true"` is set by the helper.

---

## Color Schemes

Adding a new color scheme requires updates in **5 files**:

1. **`assets/css/critical.css`** — Add `[data-scheme="newname"]` and `[data-theme="light"][data-scheme="newname"]` blocks.
2. **`assets/css/critical.css`** — Add `.scheme-dot[data-scheme="newname"]` dot color.
3. **`assets/js/main.js`** — Add entry to the `schemeColors` object.
4. **`inc/customizer.php`** — Add choice to the `default_scheme` control.
5. **`header.php`** — Add a `<button class="scheme-dot" data-scheme="newname">` to the picker.

### Accessibility Requirement

All new accent colors must be **WCAG AA compliant** against:
- `#0d1117` (dark background)
- `#f6f8fa` (light background)

Use a contrast checker (e.g., [WebAIM](https://webaim.org/resources/contrastchecker/)) before submitting.

---

## Release Process

Maintainers only:

1. Update `style.css` version header.
2. Update `readme.txt` stable tag.
3. Update `CHANGELOG.md` — move `[Unreleased]` items to a new version section.
4. Update `AGENTS.md` version metadata.
5. Create a GitHub release with notes from `CHANGELOG.md`.
6. Tag the release:
   ```bash
   git tag -a v1.0.0 -m "Release v1.0.0"
   git push origin v1.0.0
   ```

---

## Code of Conduct

This project follows the [Contributor Covenant Code of Conduct](https://www.contributor-covenant.org/version/2/1/code_of_conduct/). By participating, you agree to uphold this code.

---

## Questions?

- Open a [GitHub Discussion](https://github.com/j0vis/directoryx/discussions)
- Read [docs/getting-started.md](docs/getting-started.md)
- Check [AGENTS.md](AGENTS.md) for the project's AI agent documentation

Thank you for contributing!
