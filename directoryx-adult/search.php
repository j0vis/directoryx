<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main" role="main">
	<header class="page-header">
		<h1 class="page-title">
			<?php
			printf(
				esc_html__( 'Search Results for: %s', 'directoryx-adult' ),
				'<span>' . get_search_query() . '</span>'
			);
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="<?php echo 'listing' === get_post_type() ? 'listing-grid' : 'content-list'; ?>" itemscope itemtype="https://schema.org/ItemList">
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
