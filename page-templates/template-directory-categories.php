<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Template Name: Directory Categories
 *
 * Full-page directory categories listing.
 */

get_header();
?>

<main id="primary" class="site-main site-main--full-width" role="main">
	<article <?php post_class( 'directory-categories-page' ); ?>>
		<header class="page-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>

		<?php
		$all_categories = get_terms(
			array(
				'taxonomy'   => 'listing_category',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			)
		);

		if ( ! empty( $all_categories ) && ! is_wp_error( $all_categories ) ) :
			?>
		<div class="category-grid category-grid--all">
			<?php foreach ( $all_categories as $category ) : ?>
			<?php get_template_part( 'template-parts/content', 'category-card', array( 'category' => $category, 'show_description' => true ) ); ?>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
		<p><?php esc_html_e( 'No categories found.', 'directoryx-adult' ); ?></p>
		<?php endif; ?>
	</article>
</main>

<?php
get_footer();
