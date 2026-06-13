<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Directory Home (home.php).
 *
 * This is the theme's blog-posts index template. In a directory theme we use
 * it as the landing page: the front page shows page content (if the user
 * assigned a static front page in Settings → Reading) + Popular Categories
 * + Latest Listings. The same layout is also exposed via the
 * [dxadult_home] shortcode and the `home` block.
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
	<?php
	// If a static front page is set, render its content first.
	while ( have_posts() ) :
		the_post();
		if ( get_the_content() ) :
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'directory-home' ); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endif;
	endwhile;
	?>

	<?php
	$featured_categories = get_terms(
		array(
			'taxonomy'   => 'listing_category',
			'hide_empty' => false,
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
			<?php
			foreach ( $featured_categories as $category ) :
				get_template_part( 'template-parts/content', 'category-card', array( 'category' => $category ) );
			endforeach;
			?>
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
		<?php
		$archive_url = get_post_type_archive_link( 'listing' );
		if ( $archive_url ) :
			?>
			<p class="directory-home__more">
				<a href="<?php echo esc_url( $archive_url ); ?>" class="button">
					<?php esc_html_e( 'Browse all listings', 'directoryx-adult' ); ?>
					<?php dxadult_icon( 'arrow-right', '14' ); ?>
				</a>
			</p>
			<?php
		endif;
	else :
		?>
		<section class="section">
			<div class="no-results">
				<p><?php esc_html_e( 'No listings yet. Check back soon!', 'directoryx-adult' ); ?></p>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();
