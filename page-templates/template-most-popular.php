<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Template Name: Most Popular
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
		<article <?php post_class( 'most-popular-page' ); ?>>
			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php if ( get_the_content() ) : ?>
					<div class="archive-description"><?php the_content(); ?></div>
				<?php else : ?>
					<p class="archive-description"><?php esc_html_e( 'The most-viewed listings in our directory.', 'directoryx-adult' ); ?></p>
				<?php endif; ?>
			</header>
		</article>
	<?php endwhile; ?>

	<?php
	$popular = new WP_Query( array(
		'post_type'      => 'listing',
		'posts_per_page' => 24,
		'meta_key'       => 'listing_view_count',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	) );

	if ( $popular->have_posts() ) :
		?>
		<section class="section">
			<div class="listing-grid" itemscope itemtype="https://schema.org/ItemList">
				<?php
				while ( $popular->have_posts() ) :
					$popular->the_post();
					get_template_part( 'template-parts/content', 'listing-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
	<?php else : ?>
		<div class="no-results">
			<h2 class="page-title"><?php esc_html_e( 'No listings yet', 'directoryx-adult' ); ?></h2>
			<p><?php esc_html_e( 'Check back soon!', 'directoryx-adult' ); ?></p>
		</div>
	<?php endif; ?>
</main>

<?php
get_footer();
