<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DXADULT_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'DXADULT_DIR', get_template_directory() );
define( 'DXADULT_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function dxadult_setup() {
	load_theme_textdomain( 'directoryx-adult', DXADULT_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);
	add_theme_support( 'responsive-embeds' );
	// Note: wp-block-styles not added — block library CSS is removed below for PageSpeed.
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-background',
		array(
			'default-color' => '0d1117',
		)
	);

	set_post_thumbnail_size( 320, 240, true );
	add_image_size( 'dxadult-grid', 400, 300, true );
	add_image_size( 'dxadult-single', 800, 600, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'directoryx-adult' ),
			'footer'  => __( 'Footer Menu', 'directoryx-adult' ),
		)
	);
}
add_action( 'after_setup_theme', 'dxadult_setup' );

/**
 * Set content width.
 */
function dxadult_content_width() {
	$GLOBALS['content_width'] = 800;
}
add_action( 'after_setup_theme', 'dxadult_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function dxadult_scripts() {
	// Critical CSS is inlined in header.php.
	// Deferred main stylesheet — loaded via JS after paint.
	wp_register_style( 'dxadult-main', DXADULT_URI . '/assets/css/main.css', array(), DXADULT_VERSION );
	wp_register_script( 'dxadult-loadcss', DXADULT_URI . '/assets/js/main.js', array(), DXADULT_VERSION, true );

	wp_add_inline_script(
		'dxadult-loadcss',
		'dxadultLoadCSS("' . esc_js( DXADULT_URI . '/assets/css/main.css' ) . '","' . esc_js( DXADULT_VERSION ) . '");'
	);

	wp_enqueue_script( 'dxadult-loadcss' );

	wp_enqueue_style( 'dxadult-print', DXADULT_URI . '/assets/css/print.css', array(), DXADULT_VERSION, 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dxadult_scripts' );

/**
 * Defer parsing of JS.
 */
function dxadult_defer_js( $tag, $handle ) {
	if ( is_admin() ) {
		return $tag;
	}
	$skip = array( 'comment-reply' );
	if ( in_array( $handle, $skip, true ) ) {
		return $tag;
	}
	return str_replace( ' src', ' defer src', $tag );
}
add_filter( 'script_loader_tag', 'dxadult_defer_js', 10, 2 );

/**
 * Remove emoji scripts and DNS prefetch.
 */
function dxadult_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'dxadult_disable_emoji' );

/**
 * Remove all unnecessary core styles for PageSpeed.
 */
function dxadult_remove_core_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'dxadult_remove_core_styles', 100 );

/**
 * Remove REST API link from head.
 */
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * Add custom image sizes to media library.
 */
function dxadult_custom_image_sizes( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'dxadult-grid'   => __( 'Grid Thumbnail', 'directoryx-adult' ),
			'dxadult-single' => __( 'Single Large', 'directoryx-adult' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'dxadult_custom_image_sizes' );

/**
 * Custom body classes.
 */
function dxadult_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'has-sidebar';
	}
	$theme = get_theme_mod( 'dxadult_default_theme', 'dark' );
	$scheme = get_theme_mod( 'dxadult_default_scheme', 'midnight' );
	$classes[] = 'theme--' . esc_attr( $theme );
	$classes[] = 'scheme--' . esc_attr( $scheme );
	return $classes;
}
add_filter( 'body_class', 'dxadult_body_classes' );

/**
 * Register widget area.
 */
function dxadult_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'directoryx-adult' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here.', 'directoryx-adult' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dxadult_widgets_init' );

/**
 * Load modular includes.
 */
require_once DXADULT_DIR . '/inc/template-tags.php';
require_once DXADULT_DIR . '/inc/template-functions.php';
require_once DXADULT_DIR . '/inc/customizer.php';
require_once DXADULT_DIR . '/inc/post-types.php';
