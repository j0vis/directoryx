<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get listing category links for the current post.
 *
 * @since 1.0.0
 * @param string $taxonomy Taxonomy slug. Default 'listing_category'.
 * @return string[] Array of HTML anchor tags.
 */
function dxadult_get_category_links( $taxonomy = 'listing_category' ) {
	$terms = get_the_terms( get_the_ID(), $taxonomy );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return array();
	}
	$links = array();
	foreach ( $terms as $t ) {
		$links[] = '<a href="' . esc_url( get_term_link( $t ) ) . '">' . esc_html( $t->name ) . '</a>';
	}
	return $links;
}

/**
 * Display the listing URL visit button if one exists.
 *
 * @since 1.0.0
 * @param string $label Button text. Default 'Visit Site'.
 * @param string $class CSS class string. Default 'button button--visit'.
 * @param bool   $wrap  Whether to wrap in a div.listing-actions. Default true.
 */
function dxadult_listing_url_button( $label = '', $class = 'button button--visit', $wrap = true ) {
	$url = get_post_meta( get_the_ID(), 'listing_url', true );
	if ( ! $url ) {
		return;
	}
	if ( ! $label ) {
		$label = __( 'Visit Site', 'directoryx-adult' );
	}
	if ( $wrap ) {
		echo '<div class="listing-actions">';
	}
	echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . ' dxadult-outbound-link" rel="nofollow noopener" target="_blank" data-post-id="' . esc_attr( get_the_ID() ) . '">';
	echo esc_html( $label );
	echo dxadult_get_icon( 'external-link', '14' );
	echo '</a>';
	if ( $wrap ) {
		echo '</div>';
	}
}

/**
 * Display listing rating stars.
 *
 * @since 1.0.0
 * @param int $post_id Post ID. Defaults to current post.
 */
function dxadult_listing_rating( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$rating = (float) get_post_meta( $post_id, 'listing_rating', true );
	if ( $rating <= 0 ) {
		return;
	}

	$full  = floor( $rating );
	$half  = ( $rating - $full ) >= 0.5;
	$empty = 5 - $full - ( $half ? 1 : 0 );

	echo '<span class="listing-rating" role="img" aria-label="' . esc_attr( sprintf( __( 'Rated %s out of 5', 'directoryx-adult' ), $rating ) ) . '">';
	for ( $i = 0; $i < $full; $i++ ) {
		echo '<span class="star star--full" aria-hidden="true">' . dxadult_get_icon( 'star-full', '14' ) . '</span>';
	}
	if ( $half ) {
		echo '<span class="star star--half" aria-hidden="true">' . dxadult_get_icon( 'star-half', '14' ) . '</span>';
	}
	for ( $i = 0; $i < $empty; $i++ ) {
		echo '<span class="star star--empty" aria-hidden="true">' . dxadult_get_icon( 'star-empty', '14' ) . '</span>';
	}
	echo ' <span class="rating-value">' . esc_html( number_format_i18n( $rating, 1 ) ) . '</span>';
	echo '</span>';
}

/**
 * Display listing status badge.
 *
 * @since 1.0.0
 * @param int $post_id Post ID. Defaults to current post.
 */
function dxadult_listing_status( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$status = get_post_meta( $post_id, 'listing_status', true );
	if ( ! $status ) {
		return;
	}

	$labels = array(
		'active'   => __( 'Active', 'directoryx-adult' ),
		'reviewed' => __( 'Reviewed', 'directoryx-adult' ),
		'new'      => __( 'New', 'directoryx-adult' ),
	);

	$label = isset( $labels[ $status ] ) ? $labels[ $status ] : $status;

	echo '<span class="listing-status listing-status--' . esc_attr( $status ) . '">' . esc_html( $label ) . '</span>';
}

/**
 * Display featured badge.
 *
 * @since 1.0.0
 * @param int $post_id Post ID. Defaults to current post.
 */
function dxadult_listing_featured_badge( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	if ( ! get_post_meta( $post_id, 'listing_featured', true ) ) {
		return;
	}
	echo '<span class="listing-featured-badge">' . esc_html__( 'Featured', 'directoryx-adult' ) . '</span>';
}

/**
 * Get related listings.
 *
 * @since 1.0.0
 * @param int    $post_id    Post ID. Defaults to current post.
 * @param int    $count      Number of listings. Default 6.
 * @return WP_Query|null
 */
function dxadult_get_related_listings( $post_id = 0, $count = 6 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$terms = get_the_terms( $post_id, 'listing_category' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return null;
	}
	$term_ids = wp_list_pluck( $terms, 'term_id' );
	$args = array(
		'post_type'      => 'listing',
		'posts_per_page' => $count,
		'post__not_in'   => array( $post_id ),
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'listing_category',
				'field'    => 'term_id',
				'terms'    => $term_ids,
			),
		),
	);
	return new WP_Query( $args );
}

/**
 * Display related listings section.
 *
 * @since 1.0.0
 * @param int $post_id Post ID.
 * @param int $count   Number of listings.
 */
function dxadult_related_listings( $post_id = 0, $count = 6 ) {
	$query = dxadult_get_related_listings( $post_id, $count );
	if ( ! $query || ! $query->have_posts() ) {
		return;
	}
	?>
	<section class="related-listings section">
		<h2 class="section-title"><?php esc_html_e( 'Related Listings', 'directoryx-adult' ); ?></h2>
		<div class="listing-grid">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				get_template_part( 'template-parts/content', 'listing-card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
}

/**
 * Display social share buttons.
 *
 * @since 1.0.0
 * @param int $post_id Post ID.
 */
function dxadult_social_share( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$url   = get_permalink( $post_id );
	$title = get_the_title( $post_id );
	?>
	<div class="social-share">
		<span class="social-share-label"><?php esc_html_e( 'Share:', 'directoryx-adult' ); ?></span>
		<a class="social-share-btn" href="https://twitter.com/intent/tweet?url=<?php echo esc_url( $url ); ?>&text=<?php echo esc_attr( $title ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on X', 'directoryx-adult' ); ?>">
			<?php dxadult_icon( 'share', '16' ); ?>
		</a>
		<button class="social-share-btn copy-link" type="button" aria-label="<?php esc_attr_e( 'Copy link', 'directoryx-adult' ); ?>" data-url="<?php echo esc_url( $url ); ?>">
			<?php dxadult_icon( 'bookmark', '16' ); ?>
		</button>
	</div>
	<?php
}

/**
 * Display recently viewed listings.
 *
 * @since 1.0.0
 * @param int $count Number of listings.
 */
function dxadult_recently_viewed( $count = 6 ) {
	$ids = isset( $_COOKIE['dxadult_recent'] ) ? array_map( 'intval', explode( ',', sanitize_text_field( wp_unslash( $_COOKIE['dxadult_recent'] ) ) ) ) : array();
	$ids = array_slice( array_filter( $ids ), 0, $count );
	if ( empty( $ids ) ) {
		return;
	}
	$args = array(
		'post_type'      => 'listing',
		'posts_per_page' => $count,
		'post__in'       => $ids,
		'orderby'        => 'post__in',
		'no_found_rows'  => true,
	);
	$query = new WP_Query( $args );
	if ( ! $query->have_posts() ) {
		return;
	}
	?>
	<section class="recently-viewed section">
		<h2 class="section-title"><?php esc_html_e( 'Recently Viewed', 'directoryx-adult' ); ?></h2>
		<div class="listing-grid">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				get_template_part( 'template-parts/content', 'listing-card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
}

/**
 * Display report listing form.
 *
 * @since 1.0.0
 */
function dxadult_report_form() {
	?>
	<details class="listing-report">
		<summary><?php esc_html_e( 'Report this listing', 'directoryx-adult' ); ?></summary>
		<form class="report-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'dxadult_report', 'dxadult_report_nonce' ); ?>
			<input type="hidden" name="action" value="dxadult_report_listing">
			<input type="hidden" name="listing_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
			<p>
				<label for="report_reason"><?php esc_html_e( 'Reason:', 'directoryx-adult' ); ?></label>
				<select id="report_reason" name="report_reason" required>
					<option value=""><?php esc_html_e( '— Select —', 'directoryx-adult' ); ?></option>
					<option value="broken"><?php esc_html_e( 'Broken link', 'directoryx-adult' ); ?></option>
					<option value="inappropriate"><?php esc_html_e( 'Inappropriate content', 'directoryx-adult' ); ?></option>
					<option value="spam"><?php esc_html_e( 'Spam', 'directoryx-adult' ); ?></option>
					<option value="other"><?php esc_html_e( 'Other', 'directoryx-adult' ); ?></option>
				</select>
			</p>
			<p>
				<label for="report_details"><?php esc_html_e( 'Details (optional):', 'directoryx-adult' ); ?></label>
				<textarea id="report_details" name="report_details" rows="3"></textarea>
			</p>
			<p>
				<button type="submit" class="button"><?php esc_html_e( 'Submit Report', 'directoryx-adult' ); ?></button>
			</p>
		</form>
	</details>
	<?php
}

/**
 * Get a placeholder image with category color.
 *
 * @since 1.0.0
 * @param string $size Image size.
 * @return string HTML img tag.
 */
function dxadult_get_placeholder_image( $size = 'dxadult-grid' ) {
	$colors = array( '#58a6ff', '#3fb950', '#f85149', '#bc8cff', '#e3b341', '#ff7b72', '#39d0d8', '#a5b4fc' );
	$color = $colors[ array_rand( $colors ) ];
	$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300"><rect width="400" height="300" fill="' . esc_attr( $color ) . '" opacity="0.15"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="' . esc_attr( $color ) . '" opacity="0.4" font-family="sans-serif" font-size="48">No Image</text></svg>';
	$src = 'data:image/svg+xml;base64,' . base64_encode( $svg );
	return '<img src="' . esc_attr( $src ) . '" alt="' . esc_attr__( 'No image', 'directoryx-adult' ) . '" class="listing-card__placeholder" loading="lazy" />';
}

/**
 * Display JSON-LD Schema.org for a single listing.
 *
 * @since 1.0.0
 * @param int $post_id Post ID.
 */
function dxadult_listing_schema_jsonld( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$url     = get_permalink( $post_id );
	$title   = get_the_title( $post_id );
	$rating  = (float) get_post_meta( $post_id, 'listing_rating', true );
	$listing_url = get_post_meta( $post_id, 'listing_url', true );
	$schema  = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Thing',
		'name'     => $title,
		'url'      => $url,
	);
	if ( $listing_url ) {
		$schema['sameAs'] = $listing_url;
	}
	if ( $rating > 0 ) {
		$schema['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => $rating,
			'bestRating'  => 5,
			'worstRating' => 1,
		);
	}
	if ( has_post_thumbnail( $post_id ) ) {
		$schema['image'] = get_the_post_thumbnail_url( $post_id, 'full' );
	}
	?>
	<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ); ?></script>
	<?php
}

/**
 * Display BreadcrumbList Schema.org JSON-LD.
 *
 * @since 1.0.0
 */
function dxadult_breadcrumb_schema_jsonld() {
	if ( ! function_exists( 'yoast_breadcrumb' ) ) {
		return;
	}
	$items = array();
	$items[] = array(
		'@type'    => 'ListItem',
		'position' => 1,
		'name'     => __( 'Home', 'directoryx-adult' ),
		'item'     => home_url( '/' ),
	);
	$position = 2;
	if ( is_singular( 'listing' ) ) {
		$terms = get_the_terms( get_the_ID(), 'listing_category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => __( 'Listings', 'directoryx-adult' ),
				'item'     => get_post_type_archive_link( 'listing' ),
			);
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => $terms[0]->name,
				'item'     => get_term_link( $terms[0] ),
			);
		}
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_tax( 'listing_category' ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => __( 'Listings', 'directoryx-adult' ),
			'item'     => get_post_type_archive_link( 'listing' ),
		);
		$term = get_queried_object();
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => $term->name,
			'item'     => get_term_link( $term ),
		);
	}
	if ( count( $items ) > 1 ) {
		$schema = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);
		?>
		<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ); ?></script>
		<?php
	}
}
