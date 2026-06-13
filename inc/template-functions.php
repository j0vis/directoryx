<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Modify the main query for listing archives.
 */
function dxadult_modify_listing_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( is_post_type_archive( 'listing' ) || is_tax( 'listing_category' ) ) {
		$query->set( 'posts_per_page', 24 );
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
	}

	if ( ( is_post_type_archive( 'listing' ) || is_tax( 'listing_category' ) ) && ! is_admin() ) {
		$sort = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : 'date';
		switch ( $sort ) {
			case 'rating':
				$query->set( 'meta_key', 'listing_rating' );
				$query->set( 'orderby', 'meta_value_num' );
				$query->set( 'order', 'DESC' );
				break;
			case 'popular':
				$query->set( 'meta_key', 'listing_view_count' );
				$query->set( 'orderby', 'meta_value_num' );
				$query->set( 'order', 'DESC' );
				break;
			case 'alpha':
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'ASC' );
				break;
			default:
				$query->set( 'orderby', 'date' );
				$query->set( 'order', 'DESC' );
		}

		$meta_query = (array) $query->get( 'meta_query' );

		$cat = isset( $_GET['cat'] ) ? absint( $_GET['cat'] ) : 0;
		if ( $cat && is_post_type_archive( 'listing' ) ) {
			$tax_query = (array) $query->get( 'tax_query' );
			$tax_query[] = array(
				'taxonomy' => 'listing_category',
				'field'    => 'term_id',
				'terms'    => $cat,
			);
			$query->set( 'tax_query', $tax_query );
		}

		$min_r = isset( $_GET['min_rating'] ) ? floatval( $_GET['min_rating'] ) : 0;
		if ( $min_r > 0 ) {
			$meta_query[] = array(
				'key'     => 'listing_rating',
				'value'   => $min_r,
				'compare' => '>=',
				'type'    => 'NUMERIC',
			);
		}

		$status = isset( $_GET['status'] ) ? sanitize_key( wp_unslash( $_GET['status'] ) ) : '';
		if ( $status ) {
			$meta_query[] = array(
				'key'   => 'listing_status',
				'value' => $status,
			);
		}

		if ( ! empty( $meta_query ) ) {
			$query->set( 'meta_query', $meta_query );
		}
	}
}
add_action( 'pre_get_posts', 'dxadult_modify_listing_query' );

/**
 * Add custom meta fields to listings.
 */
function dxadult_register_listing_meta() {
	$auth_cb = function () {
		return current_user_can( 'edit_posts' );
	};

	register_post_meta(
		'listing',
		'listing_url',
		array(
			'type'              => 'string',
			'description'       => __( 'External URL for the listing', 'directoryx-adult' ),
			'single'            => true,
			'sanitize_callback' => 'esc_url_raw',
			'auth_callback'     => $auth_cb,
			'show_in_rest'      => true,
		)
	);

	register_post_meta(
		'listing',
		'listing_rating',
		array(
			'type'              => 'number',
			'description'       => __( 'Rating from 1.0 to 5.0', 'directoryx-adult' ),
			'single'            => true,
			'sanitize_callback' => 'floatval',
			'auth_callback'     => $auth_cb,
			'show_in_rest'      => true,
		)
	);

	register_post_meta(
		'listing',
		'listing_status',
		array(
			'type'              => 'string',
			'description'       => __( 'Listing status: active, reviewed, new', 'directoryx-adult' ),
			'single'            => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth_cb,
			'show_in_rest'      => true,
		)
	);

	register_post_meta(
		'listing',
		'listing_featured',
		array(
			'type'              => 'boolean',
			'description'       => __( 'Featured listing', 'directoryx-adult' ),
			'single'            => true,
			'sanitize_callback' => function( $v ) { return (bool) $v; },
			'auth_callback'     => $auth_cb,
			'show_in_rest'      => true,
			'default'           => false,
		)
	);

	register_post_meta(
		'listing',
		'listing_view_count',
		array(
			'type'              => 'integer',
			'description'       => __( 'Number of views', 'directoryx-adult' ),
			'single'            => true,
			'sanitize_callback' => 'intval',
			'auth_callback'     => $auth_cb,
			'show_in_rest'      => true,
			'default'           => 0,
		)
	);

	register_post_meta(
		'listing',
		'listing_click_count',
		array(
			'type'              => 'integer',
			'description'       => __( 'Number of outbound clicks', 'directoryx-adult' ),
			'single'            => true,
			'sanitize_callback' => 'intval',
			'auth_callback'     => $auth_cb,
			'show_in_rest'      => true,
			'default'           => 0,
		)
	);
}
add_action( 'init', 'dxadult_register_listing_meta' );/**
 * Shortcode: [dxadult_home] — renders the directory home layout
 * (Popular Categories + Latest Listings) on any page.
 *
 * Optional attributes:
 *  - categories="8"   number of category cards (default 8)
 *  - listings="12"    number of listing cards (default 12)
 *  - show_cats="1"    show categories section (default 1)
 *  - show_listings="1" show listings section (default 1)
 */
function dxadult_home_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'categories'   => 8,
			'listings'     => 12,
			'show_cats'    => 1,
			'show_listings' => 1,
		),
		$atts,
		'dxadult_home'
	);

	ob_start();

	if ( (int) $atts['show_cats'] ) :
		$cats = get_terms(
			array(
				'taxonomy'   => 'listing_category',
				'hide_empty' => false,
				'number'     => max( 1, (int) $atts['categories'] ),
				'orderby'    => 'count',
				'order'      => 'DESC',
			)
		);
		if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) :
			?>
		<section class="featured-categories section">
			<h2 class="section-title"><?php esc_html_e( 'Popular Categories', 'directoryx-adult' ); ?></h2>
			<div class="category-grid">
				<?php
				foreach ( $cats as $category ) :
					get_template_part( 'template-parts/content', 'category-card', array( 'category' => $category ) );
				endforeach;
				?>
			</div>
		</section>
			<?php
		endif;
	endif;

	if ( (int) $atts['show_listings'] ) :
		$listings = new WP_Query(
			array(
				'post_type'      => 'listing',
				'posts_per_page' => max( 1, (int) $atts['listings'] ),
				'no_found_rows'  => true,
			)
		);
		if ( $listings->have_posts() ) :
			?>
		<section class="latest-listings section">
			<h2 class="section-title"><?php esc_html_e( 'Latest Listings', 'directoryx-adult' ); ?></h2>
			<div class="listing-grid" itemscope itemtype="https://schema.org/ItemList">
				<?php
				while ( $listings->have_posts() ) :
					$listings->the_post();
					get_template_part( 'template-parts/content', 'listing-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
			<?php
		endif;
	endif;

	return (string) ob_get_clean();
}
add_shortcode( 'dxadult_home', 'dxadult_home_shortcode' );

/**
 * Enqueue admin-only assets for the listing edit screen.
 */
function dxadult_enqueue_admin( $hook ) {
	$screen = get_current_screen();
	if ( ! $screen || 'listing' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_style(
		'dxadult-admin',
		DXADULT_URI . '/assets/css/admin.css',
		array(),
		DXADULT_VERSION
	);

	wp_enqueue_script(
		'dxadult-admin',
		DXADULT_URI . '/assets/js/admin.js',
		array(),
		DXADULT_VERSION,
		true
	);

	wp_localize_script(
		'dxadult-admin',
		'dxadultAdmin',
		array(
			'invalidUrl' => __( 'Please enter a valid http(s) URL (including https://).', 'directoryx-adult' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'dxadult_enqueue_admin' );

/**
 * Add meta boxes for listings.
 *
 * Two meta boxes are added so the URL is impossible to miss:
 *  - "External Link" (side, high) — URL field with visual prominence + Test button.
 *  - "Listing Details" (normal, high) — rating, status, featured.
 */
function dxadult_add_listing_meta_boxes() {
	add_meta_box(
		'dxadult_listing_link',
		__( 'External Link', 'directoryx-adult' ),
		'dxadult_listing_link_meta_box_callback',
		'listing',
		'side', // right column — most visible
		'high'  // above other side meta boxes (e.g. Publish)
	);

	add_meta_box(
		'dxadult_listing_details',
		__( 'Listing Details', 'directoryx-adult' ),
		'dxadult_listing_meta_box_callback',
		'listing',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'dxadult_add_listing_meta_boxes' );

/**
 * Sidebar meta box: External Link (URL field + test button).
 */
function dxadult_listing_link_meta_box_callback( $post ) {
	wp_nonce_field( 'dxadult_listing_meta', 'dxadult_listing_meta_nonce' );

	$url = get_post_meta( $post->ID, 'listing_url', true );
	$has_url = ! empty( $url );
	$host    = $has_url ? wp_parse_url( $url, PHP_URL_HOST ) : '';
	?>
	<div class="dxadult-link-box">
		<label for="listing_url" class="dxadult-link-box__label">
			<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
			<?php esc_html_e( 'Listing URL', 'directoryx-adult' ); ?>
			<span class="dxadult-link-box__required" aria-hidden="true">*</span>
		</label>
		<input
			type="url"
			id="listing_url"
			name="listing_url"
			value="<?php echo esc_attr( $url ); ?>"
			class="widefat dxadult-link-box__input"
			placeholder="https://example.com"
			required
			aria-describedby="listing_url_description"
		>
		<?php if ( $has_url ) : ?>
			<p class="dxadult-link-box__host" id="listing_url_description">
				<span class="dashicons dashicons-globe" aria-hidden="true"></span>
				<code><?php echo esc_html( $host ); ?></code>
			</p>
			<button type="button" id="dxadult-test-link" class="button button-secondary dxadult-link-box__test" data-url="<?php echo esc_url( $url ); ?>">
				<span class="dashicons dashicons-external" aria-hidden="true"></span>
				<?php esc_html_e( 'Test link (open in new tab)', 'directoryx-adult' ); ?>
			</button>
		<?php else : ?>
			<p class="dxadult-link-box__empty description" id="listing_url_description">
				<span class="dashicons dashicons-warning" aria-hidden="true"></span>
				<?php esc_html_e( 'No URL set — this listing will not have a Visit button.', 'directoryx-adult' ); ?>
			</p>
		<?php endif; ?>
		<p class="description dxadult-link-box__help">
			<?php esc_html_e( 'The full URL of the site you are listing. Shown as a "Visit" button on the listing card and as a "Visit Site" button on the single-listing page. Outbound clicks are tracked.', 'directoryx-adult' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Main meta box: Listing Details (rating, status, featured).
 */
function dxadult_listing_meta_box_callback( $post ) {
	wp_nonce_field( 'dxadult_listing_meta', 'dxadult_listing_meta_nonce' );

	$rating   = get_post_meta( $post->ID, 'listing_rating', true );
	$status   = get_post_meta( $post->ID, 'listing_status', true );
	$featured = get_post_meta( $post->ID, 'listing_featured', true );
	?>
	<p>
		<label for="listing_rating"><?php esc_html_e( 'Rating (1.0 - 5.0):', 'directoryx-adult' ); ?></label><br>
		<input type="number" id="listing_rating" name="listing_rating" value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" step="0.1" class="widefat">
	</p>
	<p>
		<label for="listing_status"><?php esc_html_e( 'Status:', 'directoryx-adult' ); ?></label><br>
		<select id="listing_status" name="listing_status" class="widefat">
			<option value=""><?php esc_html_e( '— Select —', 'directoryx-adult' ); ?></option>
			<option value="active" <?php selected( $status, 'active' ); ?>><?php esc_html_e( 'Active', 'directoryx-adult' ); ?></option>
			<option value="reviewed" <?php selected( $status, 'reviewed' ); ?>><?php esc_html_e( 'Reviewed', 'directoryx-adult' ); ?></option>
			<option value="new" <?php selected( $status, 'new' ); ?>><?php esc_html_e( 'New', 'directoryx-adult' ); ?></option>
		</select>
	</p>
	<p>
		<label for="listing_featured">
			<input type="checkbox" id="listing_featured" name="listing_featured" value="1" <?php checked( $featured, 1 ); ?>>
			<?php esc_html_e( 'Featured listing', 'directoryx-adult' ); ?>
		</label>
	</p>
	<?php
}

/**
 * Save listing meta box data.
 */
function dxadult_save_listing_meta( $post_id ) {
	if ( ! isset( $_POST['dxadult_listing_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_key( $_POST['dxadult_listing_meta_nonce'] ), 'dxadult_listing_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['listing_url'] ) ) {
		update_post_meta( $post_id, 'listing_url', esc_url_raw( sanitize_text_field( wp_unslash( $_POST['listing_url'] ) ) ) );
	}
	if ( isset( $_POST['listing_rating'] ) ) {
		update_post_meta( $post_id, 'listing_rating', floatval( $_POST['listing_rating'] ) );
	}
	if ( isset( $_POST['listing_status'] ) ) {
		update_post_meta( $post_id, 'listing_status', sanitize_text_field( wp_unslash( $_POST['listing_status'] ) ) );
	}
	if ( isset( $_POST['listing_featured'] ) ) {
		update_post_meta( $post_id, 'listing_featured', 1 );
	} else {
		update_post_meta( $post_id, 'listing_featured', 0 );
	}
}
add_action( 'save_post_listing', 'dxadult_save_listing_meta' );

/**
 * Admin columns for listings.
 */
function dxadult_listing_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $value ) {
		$new[ $key ] = $value;
		if ( 'title' === $key ) {
			$new['featured']    = __( 'Featured', 'directoryx-adult' );
			$new['rating']      = __( 'Rating', 'directoryx-adult' );
			$new['status']      = __( 'Status', 'directoryx-adult' );
			$new['url']         = __( 'URL', 'directoryx-adult' );
			$new['view_count']  = __( 'Views', 'directoryx-adult' );
			$new['click_count'] = __( 'Clicks', 'directoryx-adult' );
		}
	}
	return $new;
}
add_filter( 'manage_listing_posts_columns', 'dxadult_listing_columns' );

function dxadult_listing_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'featured':
			$featured = get_post_meta( $post_id, 'listing_featured', true );
			echo $featured ? '<span class="dashicons dashicons-star-filled" style="color:#d29922"></span>' : '<span class="dashicons dashicons-star-empty" style="opacity:0.3"></span>';
			break;
		case 'rating':
			$rating = (float) get_post_meta( $post_id, 'listing_rating', true );
			echo $rating > 0 ? esc_html( number_format_i18n( $rating, 1 ) ) . ' / 5' : '—';
			break;
		case 'status':
			$status = get_post_meta( $post_id, 'listing_status', true );
			$labels = array(
				'active'   => __( 'Active', 'directoryx-adult' ),
				'reviewed' => __( 'Reviewed', 'directoryx-adult' ),
				'new'      => __( 'New', 'directoryx-adult' ),
			);
			echo esc_html( $labels[ $status ] ?? $status ?? '—' );
			break;
		case 'url':
			$url = get_post_meta( $post_id, 'listing_url', true );
			if ( $url ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" title="' . esc_attr( $url ) . '">' . esc_html( wp_parse_url( $url, PHP_URL_HOST ) ) . '</a>';
			} else {
				echo '—';
			}
			break;
		case 'view_count':
			echo esc_html( number_format_i18n( (int) get_post_meta( $post_id, 'listing_view_count', true ) ) );
			break;
		case 'click_count':
			echo esc_html( number_format_i18n( (int) get_post_meta( $post_id, 'listing_click_count', true ) ) );
			break;
	}
}
add_action( 'manage_listing_posts_custom_column', 'dxadult_listing_custom_column', 10, 2 );

function dxadult_listing_sortable_columns( $columns ) {
	$columns['featured']    = 'listing_featured';
	$columns['rating']      = 'listing_rating';
	$columns['status']      = 'listing_status';
	$columns['view_count']  = 'listing_view_count';
	$columns['click_count'] = 'listing_click_count';
	return $columns;
}
add_filter( 'manage_edit-listing_sortable_columns', 'dxadult_listing_sortable_columns' );

function dxadult_listing_sort_orderby( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$orderby = $query->get( 'orderby' );
	$map = array(
		'listing_featured'    => 'listing_featured',
		'listing_rating'      => 'listing_rating',
		'listing_status'      => 'listing_status',
		'listing_view_count'  => 'listing_view_count',
		'listing_click_count' => 'listing_click_count',
	);
	if ( isset( $map[ $orderby ] ) ) {
		$query->set( 'meta_key', $map[ $orderby ] );
		$query->set( 'orderby', 'meta_value' );
		if ( in_array( $orderby, array( 'listing_rating', 'listing_view_count', 'listing_click_count' ), true ) ) {
			$query->set( 'orderby', 'meta_value_num' );
		}
	}
}
add_action( 'pre_get_posts', 'dxadult_listing_sort_orderby' );

/**
 * Quick edit fields for listings.
 */
function dxadult_listing_quick_edit_fields( $column_name, $post_type ) {
	if ( 'listing' !== $post_type ) {
		return;
	}
	if ( 'rating' === $column_name ) {
		?>
		<fieldset class="inline-edit-col-right">
			<div class="inline-edit-col">
				<label>
					<span class="title"><?php esc_html_e( 'Rating', 'directoryx-adult' ); ?></span>
					<input type="number" name="listing_rating" value="" min="1" max="5" step="0.1" class="inline-edit-rating">
				</label>
				<label>
					<span class="title"><?php esc_html_e( 'Status', 'directoryx-adult' ); ?></span>
					<select name="listing_status">
						<option value=""><?php esc_html_e( '— Select —', 'directoryx-adult' ); ?></option>
						<option value="active"><?php esc_html_e( 'Active', 'directoryx-adult' ); ?></option>
						<option value="reviewed"><?php esc_html_e( 'Reviewed', 'directoryx-adult' ); ?></option>
						<option value="new"><?php esc_html_e( 'New', 'directoryx-adult' ); ?></option>
					</select>
				</label>
				<label>
					<span class="title"><?php esc_html_e( 'Featured', 'directoryx-adult' ); ?></span>
					<input type="checkbox" name="listing_featured" value="1">
				</label>
			</div>
		</fieldset>
		<?php
	}
}
add_action( 'quick_edit_custom_box', 'dxadult_listing_quick_edit_fields', 10, 2 );

function dxadult_listing_quick_edit_save( $post_id ) {
	if ( ! isset( $_POST['post_type'] ) || 'listing' !== $_POST['post_type'] ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['_inline_edit'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_inline_edit'] ), 'inlineeditnonce' ) ) {
		return;
	}
	if ( isset( $_POST['listing_rating'] ) ) {
		update_post_meta( $post_id, 'listing_rating', floatval( $_POST['listing_rating'] ) );
	}
	if ( isset( $_POST['listing_status'] ) ) {
		update_post_meta( $post_id, 'listing_status', sanitize_text_field( wp_unslash( $_POST['listing_status'] ) ) );
	}
	if ( isset( $_POST['listing_featured'] ) ) {
		update_post_meta( $post_id, 'listing_featured', 1 );
	} else {
		update_post_meta( $post_id, 'listing_featured', 0 );
	}
}
add_action( 'save_post_listing', 'dxadult_listing_quick_edit_save' );

/**
 * Track listing views on single listing pages.
 */
function dxadult_track_listing_view() {
	if ( ! is_singular( 'listing' ) ) {
		return;
	}
	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}
	$count = (int) get_post_meta( $post_id, 'listing_view_count', true );
	update_post_meta( $post_id, 'listing_view_count', $count + 1 );
}
add_action( 'wp', 'dxadult_track_listing_view' );

/**
 * AJAX click tracker for outbound links.
 */
function dxadult_ajax_click_track() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dxadult_click_nonce' ) ) {
		wp_send_json_error( __( 'Invalid nonce.', 'directoryx-adult' ) );
	}
	$post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
	if ( ! $post_id ) {
		wp_send_json_error( __( 'Invalid post ID.', 'directoryx-adult' ) );
	}
	$count = (int) get_post_meta( $post_id, 'listing_click_count', true );
	update_post_meta( $post_id, 'listing_click_count', $count + 1 );
	wp_send_json_success( array( 'count' => $count + 1 ) );
}
add_action( 'wp_ajax_dxadult_click_track', 'dxadult_ajax_click_track' );
add_action( 'wp_ajax_nopriv_dxadult_click_track', 'dxadult_ajax_click_track' );
