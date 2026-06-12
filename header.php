<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#0d1117">
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
			</div>
		</div>
	</header>
