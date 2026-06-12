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
}
add_action( 'init', 'dxadult_register_listing_meta' );

/**
 * Add meta box for listing details.
 */
function dxadult_add_listing_meta_boxes() {
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
 * Meta box callback.
 */
function dxadult_listing_meta_box_callback( $post ) {
	wp_nonce_field( 'dxadult_listing_meta', 'dxadult_listing_meta_nonce' );

	$url    = get_post_meta( $post->ID, 'listing_url', true );
	$rating = get_post_meta( $post->ID, 'listing_rating', true );
	$status = get_post_meta( $post->ID, 'listing_status', true );
	?>
	<p>
		<label for="listing_url"><?php esc_html_e( 'Listing URL:', 'directoryx-adult' ); ?></label><br>
		<input type="url" id="listing_url" name="listing_url" value="<?php echo esc_attr( $url ); ?>" class="widefat" placeholder="https://example.com">
	</p>
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
}
add_action( 'save_post_listing', 'dxadult_save_listing_meta' );
