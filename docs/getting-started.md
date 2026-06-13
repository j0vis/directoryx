# Getting Started with DirectoryX Adult

## Quick Start

### 1. Install the Theme

**Via WordPress Admin:**
1. Download the theme as a ZIP file
2. Go to **Appearance > Themes > Add New > Upload Theme**
3. Activate the theme

**Via FTP:**
1. Upload the `directoryx-adult` folder to `/wp-content/themes/`
2. Go to **Appearance > Themes** and activate it

### 2. Configure Your Directory

**Create Categories:**
1. Go to **Listings > Categories**
2. Add categories like "Free Sites", "Premium", "Videos", etc.
3. Add descriptions and featured images for category cards

**Add Listings:**
1. Go to **Listings > Add New**
2. Fill in the title and description
3. Set the **Listing Details** meta box:
   - **URL:** The external site link
   - **Rating:** 1.0 to 5.0 stars
   - **Status:** Active, Reviewed, or New
   - **Featured:** Tick to pin to the top of archives with a gold badge
4. Assign to one or more categories
5. Add a featured image (recommended: 800x600)
6. Publish

### 3. Set Up Page Templates

**Directory Home Page:**
1. Create a new page (e.g., "Home")
2. Set the template to **Directory Home**
3. This page displays featured categories and latest listings
4. Set this as your front page in **Settings > Reading**

**Categories Page:**
1. Create a new page (e.g., "All Categories")
2. Set the template to **Directory Categories**
3. This shows all categories in a grid

**Top Rated & Most Popular:**
1. Create two new pages
2. Set one template to **Top Rated** and the other to **Most Popular**
3. Each shows listings sorted by `listing_rating` or `listing_view_count` respectively

**Full Width Page:**
1. Create any page
2. Set the template to **Full Width** for content without sidebar

### 4. Customize the Theme

Go to **Appearance > Customize** to configure:

- **Default Theme Mode** — Dark or Light. Visitors can override with the toggle in the header.
- **Accent Color Scheme (site-wide)** — Choose from 8 schemes. This is a **webmaster-only** setting; visitors can only toggle light/dark via the header button.
- **Site Identity** — Logo, title, tagline
- **Menus** — Primary and footer navigation
- **Widgets** — Sidebar content

> **Important:** Each color scheme rewires the **entire theme** — page background, surface elevations, glass tints, text tints, and the mesh gradient all change. The same component looks completely different in Midnight (deep navy with blue mesh) vs Ruby (deep wine with red mesh) vs Amber (warm brown with gold mesh). The selected scheme is applied via the `data-scheme` attribute on `<html>` server-side.

### 5. Color Schemes (Webmaster Only)

The 8 color schemes are configurable in **Appearance > Customize > Colors > Accent Color Scheme (site-wide)**:

| Scheme | Mood | Accent (Dark) | Accent (Light) |
|--------|------|:-------------:|:--------------:|
| **Midnight Blue** | Cool, professional | `#58a6ff` | `#0969da` |
| **Emerald Green** | Natural, fresh | `#3fb950` | `#1a7f37` |
| **Ruby Red** | Sensual, deep wine | `#f85149` | `#cf222e` |
| **Amethyst Purple** | Mystical, cosmic | `#bc8cff` | `#8250df` |
| **Amber Gold** | Luxurious, warm | `#e3b341` | `#9a6700` |
| **Coral Orange** | Vibrant, terracotta | `#ff7b72` | `#cf4a3a` |
| **Ocean Teal** | Refreshing, deep sea | `#39d0d8` | `#0d7d7d` |
| **Slate Indigo** | Refined, sophisticated | `#a5b4fc` | `#6366f1` |

All accents are WCAG AA compliant against their respective dark/light backgrounds. The theme remembers the light/dark mode preference in `localStorage`; the color scheme is server-rendered from the Customizer default.

### 6. Mobile Navigation

On mobile devices (under 768px), a fixed bottom navigation bar appears with:
- **Home** — Link to front page
- **Search** — Toggle search overlay
- **Listings** — Link to listing archive

The bottom nav respects `safe-area-inset` for notched devices.

## Performance Tips

The theme is optimized for 100/100/100 PageSpeed scores:

- **Do not add** heavy plugins or page builders
- **Do not add** Google Fonts — use the system font stack
- **Keep images optimized** — use WebP when possible
- **Minify critical.css** for production (remove line breaks)
- **Use a caching plugin** like WP Rocket or W3 Total Cache

## SEO

The theme includes Schema.org structured data:
- **Thing + AggregateRating** on single listings
- **BreadcrumbList** for navigation
- **ItemList** on listing grids (auto-generated)

Install **Yoast SEO** or **Rank Math** for enhanced SEO features.

## Troubleshooting

**Color scheme not changing the look as expected:**
- The scheme is set server-side in the Customizer; visitors cannot override it
- Clear server-side caching (WP Rocket, W3 Total Cache, Cloudflare) after changing the scheme
- The `data-scheme` attribute is rendered on `<html>` — inspect the page source to confirm

**Light/dark mode not persisting:**
- The toggle uses `localStorage`; ensure cookies/localStorage are enabled
- Browser private/incognito mode resets the preference on session close

**Missing thumbnails:**
- Ensure featured images are set on listings
- Check that `dxadult-grid` image size is available (regenerate thumbnails after theme activation)

**Search not working:**
- The AJAX search requires the theme JS to be loaded
- Check that `dxadultData` is present in the page source
- Verify the nonce is being sent (check Network tab in dev tools)

## Design System

The theme uses a **per-scheme full-palette design system** (v1.2.0+). Each of the 8 schemes defines ~35 design tokens that rewire the entire theme:

- **Backgrounds** (`--bg-page`, `--bg-elevated`, `--bg-overlay`)
- **Glass** (`--glass-bg`, `--glass-bg-strong`, `--glass-bg-subtle`, `--glass-border`, `--glass-border-strong`)
- **Text** (`--text-primary`, `--text-secondary`, `--text-muted`, `--text-subtle`)
- **Surfaces** (`--card-bg`, `--card-bg-strong`, `--card-border`, `--card-border-hover`)
- **Dividers** (`--divider`, `--divider-strong`)
- **Inputs** (`--input-bg`, `--input-border`)
- **Accent** (`--accent`, `--accent-hover`, `--accent-active`, `--accent-glow`, `--accent-glow-strong`, `--accent-soft`)
- **Mesh** (`--mesh-1`, `--mesh-2`, `--mesh-3`, `--mesh-4` — 4 radial gradient stops for the page background)

Visual treatments include an **animated mesh background** (24s drift, reduced-motion aware), **3-stop gradient text** on titles (`text-primary` → `accent` → `accent-hover`), a **glowing scrollbar**, and **bolder hovers** (cards lift, emit a 40px accent glow, and get a 1px accent border).

For the full token reference, see `CHANGELOG.md` (v1.2.0 entry) and the comments at the top of `assets/css/critical.css`.

## Support

For issues or feature requests, visit the [GitHub repository](https://github.com/j0vis/directoryx).
