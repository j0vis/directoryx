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
<script>(function(){var t=localStorage.getItem('dxadult-theme')||'dark';var s=localStorage.getItem('dxadult-scheme')||'midnight';document.documentElement.setAttribute('data-theme',t);document.documentElement.setAttribute('data-scheme',s);var m=document.querySelector('#meta-theme-color');if(m)m.setAttribute('content',t==='light'?'#f6f8fa':'#0d1117');})();</script>
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

				<div class="scheme-picker" role="radiogroup" aria-label="<?php esc_attr_e( 'Color scheme', 'directoryx-adult' ); ?>">
					<button class="scheme-dot" data-scheme="midnight" type="button" role="radio" aria-label="<?php esc_attr_e( 'Midnight blue', 'directoryx-adult' ); ?>"></button>
					<button class="scheme-dot" data-scheme="emerald" type="button" role="radio" aria-label="<?php esc_attr_e( 'Emerald green', 'directoryx-adult' ); ?>"></button>
					<button class="scheme-dot" data-scheme="ruby" type="button" role="radio" aria-label="<?php esc_attr_e( 'Ruby red', 'directoryx-adult' ); ?>"></button>
					<button class="scheme-dot" data-scheme="amethyst" type="button" role="radio" aria-label="<?php esc_attr_e( 'Amethyst purple', 'directoryx-adult' ); ?>"></button>
				</div>

				<button class="theme-toggle" id="theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle theme', 'directoryx-adult' ); ?>" aria-pressed="false">
					<span class="theme-toggle-icon" aria-hidden="true">
						<svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
						<svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
					</span>
				</button>
			</div>
		</div>
	</header>
