<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current_sort  = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : 'date';
$current_cat   = isset( $_GET['cat'] ) ? absint( $_GET['cat'] ) : 0;
$current_min_r = isset( $_GET['min_rating'] ) ? floatval( $_GET['min_rating'] ) : 0;
$current_status = isset( $_GET['status'] ) ? sanitize_key( wp_unslash( $_GET['status'] ) ) : '';

$valid_sorts = array(
	'date'    => __( 'Newest', 'directoryx-adult' ),
	'rating'  => __( 'Top Rated', 'directoryx-adult' ),
	'popular' => __( 'Most Popular', 'directoryx-adult' ),
	'alpha'   => __( 'A–Z', 'directoryx-adult' ),
);
$valid_statuses = array( 'active', 'reviewed', 'new' );

$all_categories = get_terms( array(
	'taxonomy'   => 'listing_category',
	'hide_empty' => true,
	'orderby'    => 'name',
) );
?>

<main id="primary" class="site-main" role="main">

	<div class="archive-toolbar">
		<form class="archive-filters" method="get">
		<?php wp_nonce_field( 'dxadult_archive_filter', 'dxadult_archive_filter_nonce' ); ?>
			<div class="archive-filters__group">
				<label for="sort-select"><?php esc_html_e( 'Sort:', 'directoryx-adult' ); ?></label>
				<select id="sort-select" name="sort" class="archive-filters__auto-submit">
					<?php foreach ( $valid_sorts as $key => $label ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current_sort, $key ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<?php if ( ! empty( $all_categories ) && ! is_wp_error( $all_categories ) ) : ?>
			<div class="archive-filters__group">
				<label for="cat-select"><?php esc_html_e( 'Category:', 'directoryx-adult' ); ?></label>
				<select id="cat-select" name="cat" class="archive-filters__auto-submit">
					<option value="0"><?php esc_html_e( 'All', 'directoryx-adult' ); ?></option>
					<?php foreach ( $all_categories as $cat ) : ?>
						<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $current_cat, $cat->term_id ); ?>><?php echo esc_html( $cat->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php endif; ?>

			<div class="archive-filters__group">
				<label for="status-select"><?php esc_html_e( 'Status:', 'directoryx-adult' ); ?></label>
				<select id="status-select" name="status" class="archive-filters__auto-submit">
					<option value=""><?php esc_html_e( 'All', 'directoryx-adult' ); ?></option>
					<?php foreach ( $valid_statuses as $st ) : ?>
						<option value="<?php echo esc_attr( $st ); ?>" <?php selected( $current_status, $st ); ?>><?php echo esc_html( ucfirst( $st ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="archive-filters__group">
				<label for="min-rating"><?php esc_html_e( 'Min rating:', 'directoryx-adult' ); ?></label>
				<select id="min-rating" name="min_rating" class="archive-filters__auto-submit">
					<option value="0"><?php esc_html_e( 'Any', 'directoryx-adult' ); ?></option>
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $current_min_r, $i ); ?>>★ <?php echo esc_html( $i ); ?>+</option>
					<?php endfor; ?>
				</select>
			</div>
		</form>
	</div>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<?php
		// Featured listings pinned at top.
		$featured = new WP_Query( array(
			'post_type'      => 'listing',
			'posts_per_page' => 3,
			'meta_query'     => array(
				array(
					'key'     => 'listing_featured',
					'value'   => '1',
					'compare' => '=',
				),
			),
			'no_found_rows'  => true,
		) );

		if ( $featured->have_posts() ) : ?>
			<section class="featured-listings section">
				<h2 class="section-title"><?php esc_html_e( 'Featured', 'directoryx-adult' ); ?></h2>
				<div class="listing-grid">
					<?php
					while ( $featured->have_posts() ) :
						$featured->the_post();
						get_template_part( 'template-parts/content', 'listing-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<div class="listing-grid" itemscope itemtype="https://schema.org/ItemList">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			?>
		</div>

		<?php get_template_part( 'template-parts/pagination' ); ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();
