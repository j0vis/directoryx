<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Template Name: Top Rated
 *
 * @package DirectoryX_Adult
 */

get_header();
?>

<main id="primary" class="site-main site-main--full-width" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'top-rated-page' ); ?>>
			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php if ( get_the_content() ) : ?>
					<div class="archive-description"><?php the_content(); ?></div>
				<?php else : ?>
					<p class="archive-description"><?php esc_html_e( 'Browse the highest-rated listings in our directory.', 'directoryx-adult' ); ?></p>
				<?php endif; ?>
			</header>
		</article>
	<?php endwhile; ?>

	<?php
	$top_rated = new WP_Query( array(
		'post_type'      => 'listing',
		'posts_per_page' => 24,
		'meta_key'       => 'listing_rating',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	) );

	if ( $top_rated->have_posts() ) :
		?>
		<section class="section">
			<div class="listing-grid" itemscope itemtype="https://schema.org/ItemList">
				<?php
				while ( $top_rated->have_posts() ) :
					$top_rated->the_post();
					get_template_part( 'template-parts/content', 'listing-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php else : ?>
		<div class="no-results">
			<h2 class="page-title"><?php esc_html_e( 'No rated listings yet', 'directoryx-adult' ); ?></h2>
			<p><?php esc_html_e( 'Check back soon!', 'directoryx-adult' ); ?></p>
		</div>
	<?php endif; ?>
</main>

<?php
get_footer();
