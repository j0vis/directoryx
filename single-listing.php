<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-listing' ); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-meta">
					<span class="entry-categories"><?php echo implode( ', ', dxadult_get_category_links() ); ?></span>
					<?php dxadult_listing_status(); ?>
					<?php dxadult_listing_rating(); ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'dxadult-single', array( 'loading' => 'lazy' ) ); ?>
			</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php dxadult_listing_url_button(); ?>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

	<?php endwhile; ?>
</main>

<?php
get_sidebar();
get_footer();
