<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main" role="main">
	<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

	<header class="page-header">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: category name. */
				esc_html__( '%s Listings', 'directoryx-adult' ),
				single_term_title( '', false )
			);
			?>
		</h1>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="listing-grid" itemscope itemtype="https://schema.org/ItemList">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'listing-card' );
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
