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
	echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '" rel="nofollow noopener" target="_blank">';
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
