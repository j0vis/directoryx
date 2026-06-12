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

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-meta">
					<span class="posted-on">
						<?php
						printf(
							'<time class="entry-date published" datetime="%1$s">%2$s</time>',
							esc_attr( get_the_date( DATE_W3C ) ),
							esc_html( get_the_date() )
						);
						?>
					</span>
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
