<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Template Name: Directory Home
 *
 * Full-width directory landing page with featured categories and latest listings.
 */

get_header();
?>

<main id="primary" class="site-main site-main--full-width" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'directory-home' ); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>

	<?php
	$featured_categories = get_terms(
		array(
			'taxonomy'   => 'listing_category',
			'hide_empty' => true,
			'number'     => 8,
			'orderby'    => 'count',
			'order'      => 'DESC',
		)
	);

	if ( ! empty( $featured_categories ) && ! is_wp_error( $featured_categories ) ) :
		?>
	<section class="featured-categories section">
		<h2 class="section-title"><?php esc_html_e( 'Popular Categories', 'directoryx-adult' ); ?></h2>
		<div class="category-grid">
			<?php foreach ( $featured_categories as $category ) : ?>
			<?php get_template_part( 'template-parts/content', 'category-card', array( 'category' => $category ) ); ?>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php
	$latest_listings = new WP_Query(
		array(
			'post_type'      => 'listing',
			'posts_per_page' => 12,
			'no_found_rows'  => true,
		)
	);

	if ( $latest_listings->have_posts() ) :
		?>
	<section class="latest-listings section">
		<h2 class="section-title"><?php esc_html_e( 'Latest Listings', 'directoryx-adult' ); ?></h2>
		<div class="listing-grid" itemscope itemtype="https://schema.org/ItemList">
			<?php
			while ( $latest_listings->have_posts() ) :
				$latest_listings->the_post();
				get_template_part( 'template-parts/content', 'listing-card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php endif; ?>

	<?php
	if ( ( empty( $featured_categories ) || is_wp_error( $featured_categories ) ) && ! $latest_listings->have_posts() ) :
		?>
	<section class="section">
		<div class="no-results">
			<p><?php esc_html_e( 'No listings yet. Check back soon!', 'directoryx-adult' ); ?></p>
		</div>
	</section>
	<?php endif; ?>
</main>

<?php
get_footer();
