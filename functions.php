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
	wp_enqueue_script( 'dxadult-mainjs', DXADULT_URI . '/assets/js/main.js', array(), DXADULT_VERSION, true );

	wp_localize_script(
		'dxadult-mainjs',
		'dxadultData',
		array(
			'cssUrl'      => DXADULT_URI . '/assets/css/main.css',
			'cssVersion'  => DXADULT_VERSION,
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'restUrl'     => esc_url_raw( rest_url( 'directoryx/v1/' ) ),
			'nonce'       => wp_create_nonce( 'dxadult_nonce' ),
			'searchNonce' => wp_create_nonce( 'dxadult_search_nonce' ),
			'clickNonce'  => wp_create_nonce( 'dxadult_click_nonce' ),
		)
	);

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
 * AJAX search handler.
 */
function dxadult_ajax_search() {
	// Verify nonce.
	if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'dxadult_search_nonce' ) ) {
		wp_die( '<div class="search-no-results">' . esc_html__( 'Invalid request.', 'directoryx-adult' ) . '</div>' );
	}

	// Rate limiting: 10 requests per minute per IP.
	$ip        = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rate_key  = 'dxadult_search_' . md5( $ip );
	$attempts  = (int) get_transient( $rate_key );
	if ( $attempts > 10 ) {
		wp_die( '<div class="search-no-results">' . esc_html__( 'Too many requests. Please slow down.', 'directoryx-adult' ) . '</div>' );
	}
	set_transient( $rate_key, $attempts + 1, MINUTE_IN_SECONDS );

	$q = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
	if ( strlen( $q ) < 2 ) {
		wp_die( '<div class="search-no-results">' . esc_html__( 'Type at least 2 characters.', 'directoryx-adult' ) . '</div>' );
	}

	$args = array(
		'post_type'      => array( 'listing', 'post', 'page' ),
		'posts_per_page' => 6,
		's'              => $q,
		'no_found_rows'  => true,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			?>
			<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'search-result-thumb', 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<span class="search-result-thumb" style="background:var(--divider)"></span>
				<?php endif; ?>
				<span class="search-result-title"><?php the_title(); ?></span>
				<span class="search-result-type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ?? get_post_type() ); ?></span>
			</a>
			<?php
		endwhile;
	else :
		echo '<div class="search-no-results">' . esc_html__( 'No results found.', 'directoryx-adult' ) . '</div>';
	endif;

	wp_reset_postdata();
	wp_die();
}
add_action( 'wp_ajax_dxadult_ajax_search', 'dxadult_ajax_search' );
add_action( 'wp_ajax_nopriv_dxadult_ajax_search', 'dxadult_ajax_search' );

/**
 * Report listing handler.
 */
function dxadult_handle_report_listing() {
	if ( ! isset( $_POST['dxadult_report_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dxadult_report_nonce'] ) ), 'dxadult_report' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'directoryx-adult' ), '', array( 'response' => 403 ) );
	}
	$listing_id = isset( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : 0;
	$reason     = isset( $_POST['report_reason'] ) ? sanitize_key( wp_unslash( $_POST['report_reason'] ) ) : '';
	$details    = isset( $_POST['report_details'] ) ? sanitize_textarea_field( wp_unslash( $_POST['report_details'] ) ) : '';

	if ( ! $listing_id || ! $reason ) {
		wp_die( esc_html__( 'Invalid submission.', 'directoryx-adult' ) );
	}

	$reasons = array( 'broken', 'inappropriate', 'spam', 'other' );
	if ( ! in_array( $reason, $reasons, true ) ) {
		wp_die( esc_html__( 'Invalid reason.', 'directoryx-adult' ) );
	}

	$reports   = get_post_meta( $listing_id, 'listing_reports', true );
	$reports   = is_array( $reports ) ? $reports : array();
	$raw_ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$reports[] = array(
		'reason'  => $reason,
		'details' => $details,
		'time'    => time(),
		'ip'      => $raw_ip ? wp_hash( $raw_ip . AUTH_SALT ) : '',
	);
	update_post_meta( $listing_id, 'listing_reports', $reports );

	wp_safe_redirect( add_query_arg( 'reported', '1', get_permalink( $listing_id ) ) );
	exit;
}
add_action( 'admin_post_dxadult_report_listing', 'dxadult_handle_report_listing' );
add_action( 'admin_post_nopriv_dxadult_report_listing', 'dxadult_handle_report_listing' );

/**
 * Custom REST API endpoint for filtering listings.
 */
/**
 * Track recently viewed listings via cookie.
 *
 * Runs on the 'wp' hook after the main query is set so we can read
 * `get_queried_object_id()` reliably. The cookie is HttpOnly and same-site Lax
 * for CSRF mitigation.
 */
function dxadult_track_recently_viewed() {
	if ( ! is_singular( 'listing' ) ) {
		return;
	}
	$current_id = get_queried_object_id();
	if ( ! $current_id ) {
		return;
	}
	$cookie = isset( $_COOKIE['dxadult_recent'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['dxadult_recent'] ) ) : '';
	$recent = array_filter( array_map( 'intval', explode( ',', $cookie ) ) );
	$recent = array_values( array_unique( array_merge( array( $current_id ), array_diff( $recent, array( $current_id ) ) ) ) );
	$recent = array_slice( $recent, 0, 20 );

	if ( headers_sent() ) {
		return;
	}
	setcookie(
		'dxadult_recent',
		implode( ',', $recent ),
		array(
			'expires'  => time() + 30 * DAY_IN_SECONDS,
			'path'     => COOKIEPATH,
			'domain'   => COOKIE_DOMAIN,
			'secure'   => is_ssl(),
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);
}
add_action( 'wp', 'dxadult_track_recently_viewed' );

function dxadult_register_rest_routes() {
	register_rest_route(
		'directoryx/v1',
		'/listings',
		array(
			'methods'             => 'GET',
			'callback'            => 'dxadult_rest_listings',
			'permission_callback' => '__return_true',
			'args'                => array(
				'category'   => array( 'sanitize_callback' => 'absint' ),
				'status'     => array( 'sanitize_callback' => 'sanitize_key' ),
				'min_rating' => array( 'sanitize_callback' => 'floatval' ),
				'sort'       => array( 'sanitize_callback' => 'sanitize_key' ),
				'per_page'   => array( 'sanitize_callback' => 'absint' ),
			),
		)
	);
}
add_action( 'rest_api_init', 'dxadult_register_rest_routes' );

function dxadult_rest_listings( WP_REST_Request $request ) {
	$args = array(
		'post_type'      => 'listing',
		'posts_per_page' => min( 50, max( 1, (int) $request->get_param( 'per_page' ) ?: 12 ) ),
		'no_found_rows'  => true,
	);
	$cat = (int) $request->get_param( 'category' );
	if ( $cat ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'listing_category',
				'field'    => 'term_id',
				'terms'    => $cat,
			),
		);
	}
	$status = $request->get_param( 'status' );
	$min    = (float) $request->get_param( 'min_rating' );
	$sort   = $request->get_param( 'sort' );
	$meta   = array();
	if ( $status ) {
		$meta[] = array( 'key' => 'listing_status', 'value' => $status );
	}
	if ( $min > 0 ) {
		$meta[] = array( 'key' => 'listing_rating', 'value' => $min, 'compare' => '>=', 'type' => 'NUMERIC' );
	}
	if ( ! empty( $meta ) ) {
		$args['meta_query'] = $meta;
	}
	switch ( $sort ) {
		case 'rating':
			$args['meta_key'] = 'listing_rating';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'popular':
			$args['meta_key'] = 'listing_view_count';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'alpha':
			$args['orderby'] = 'title';
			$args['order']   = 'ASC';
			break;
	}
	$query = new WP_Query( $args );
	$items = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$items[] = array(
			'id'        => get_the_ID(),
			'title'     => get_the_title(),
			'url'       => get_permalink(),
			'excerpt'   => get_the_excerpt(),
			'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'medium' ) : '',
			'rating'    => (float) get_post_meta( get_the_ID(), 'listing_rating', true ),
			'status'    => get_post_meta( get_the_ID(), 'listing_status', true ),
			'featured'  => (bool) get_post_meta( get_the_ID(), 'listing_featured', true ),
		);
	}
	wp_reset_postdata();
	return rest_ensure_response( $items );
}

/**
 * Load modular includes.
 */
require_once DXADULT_DIR . '/inc/svg-icons.php';
require_once DXADULT_DIR . '/inc/template-tags.php';
require_once DXADULT_DIR . '/inc/template-functions.php';
require_once DXADULT_DIR . '/inc/customizer.php';
require_once DXADULT_DIR . '/inc/post-types.php';
