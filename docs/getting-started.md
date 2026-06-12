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

**Full Width Page:**
1. Create any page
2. Set the template to **Full Width** for content without sidebar

### 4. Customize the Theme

Go to **Appearance > Customize** to configure:

- **Default Theme Mode:** Dark or Light (users can override with the toggle)
- **Default Accent Scheme:** Choose from 8 color schemes
- **Site Identity:** Logo, title, tagline
- **Menus:** Primary and footer navigation
- **Widgets:** Sidebar content

### 5. Color Scheme Picker

The header includes a color scheme picker (dots) that lets users choose their accent color:

- **Midnight Blue** — Classic blue (#58a6ff)
- **Emerald Green** — Fresh green (#3fb950)
- **Ruby Red** — Bold red (#f85149)
- **Amethyst Purple** — Elegant purple (#bc8cff)
- **Amber Gold** — Warm gold (#e3b341)
- **Coral Orange** — Energetic orange (#ff7b72)
- **Ocean Teal** — Cool teal (#39d0d8)
- **Slate Indigo** — Professional indigo (#a5b4fc)

All colors are WCAG AA accessible and persist in the user's browser via localStorage.

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
- **ItemList** on listing grids
- **ListItem** on individual cards
- **SiteNavigationElement** on menus
- **BreadcrumbList** when Yoast SEO is active

Install **Yoast SEO** or **Rank Math** for enhanced SEO features.

## Troubleshooting

**Color scheme not saving:**
- The theme uses `localStorage` for user preferences
- Clear browser cache and localStorage if needed
- The Customizer default is the fallback

**Missing thumbnails:**
- Ensure featured images are set on listings
- Check that `dxadult-grid` image size is available

**Search not working:**
- The AJAX search requires the theme JS to be loaded
- Check that `dxadultData` is present in the page source

## Support

For issues or feature requests, visit the [GitHub repository](https://github.com/j0vis/directoryx).
