<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="dark">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#0d1117" id="meta-theme-color">
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

				<button class="theme-toggle" id="theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle theme', 'directoryx-adult' ); ?>" aria-pressed="false">
					<span class="theme-toggle-icon" aria-hidden="true">
						<span class="icon-sun">☀️</span>
						<span class="icon-moon">🌙</span>
					</span>
				</button>
			</div>
		</div>
	</header>
