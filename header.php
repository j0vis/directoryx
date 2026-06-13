<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr( get_theme_mod( 'dxadult_default_theme', 'dark' ) ); ?>" data-scheme="<?php echo esc_attr( get_theme_mod( 'dxadult_default_scheme', 'midnight' ) ); ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#0d1117" id="meta-theme-color">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open() ) { ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php } ?>
<?php
// Open Graph meta tags.
if ( is_singular() ) {
	$og_title       = get_the_title();
	$og_url         = get_permalink();
	$og_description = wp_strip_all_tags( get_the_excerpt() );
	$og_image       = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'full' ) : '';
	$og_type        = 'article';
} else {
	$og_title       = get_bloginfo( 'name' );
	$og_url         = home_url( '/' );
	$og_description = get_bloginfo( 'description' );
	$og_image       = '';
	$og_type        = 'website';
}
?>
<meta property="og:title" content="<?php echo esc_attr( $og_title ); ?>">
<meta property="og:url" content="<?php echo esc_url( $og_url ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>">
<meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>">
<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
<?php if ( $og_image ) : ?>
<meta property="og:image" content="<?php echo esc_url( $og_image ); ?>">
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo esc_attr( $og_title ); ?>">
<meta name="twitter:description" content="<?php echo esc_attr( $og_description ); ?>">
<?php if ( $og_image ) : ?>
<meta name="twitter:image" content="<?php echo esc_url( $og_image ); ?>">
<?php endif; ?>
<?php
$canonical = is_singular() ? get_permalink() : home_url( '/' );
?>
<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
<script>(function(){var t=localStorage.getItem('dxadult-theme')||'dark';document.documentElement.setAttribute('data-theme',t);var m=document.querySelector('#meta-theme-color');if(m)m.setAttribute('content',t==='light'?'#f6f8fa':'#0d1117');})();</script>
<?php wp_head(); ?>
<style><?php require DXADULT_DIR . '/assets/css/critical.css'; ?></style>
</head>
<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'directoryx-adult' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-inner">
			<div class="header-left">
				<div class="site-branding">
					<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>
					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description ) :
					?>
					<p class="site-description"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="header-center">
				<?php get_search_form(); ?>
			</div>

			<div class="header-right">
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'directoryx-adult' ); ?>" itemscope itemtype="https://schema.org/SiteNavigationElement">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'directoryx-adult' ); ?>">
						<span class="menu-toggle-icon"></span>
					</button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>

				<?php
				// The accent color scheme is configured by the webmaster in
				// Appearance > Customize > Colors. Visitors only get the
				// light/dark theme toggle below; they cannot change the accent.
				?>

				<button class="theme-toggle" id="theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle theme', 'directoryx-adult' ); ?>" aria-pressed="false">
					<span class="theme-toggle-icon" aria-hidden="true">
						<svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
						<svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
					</span>
				</button>
			</div>
		</div>
	</header>
