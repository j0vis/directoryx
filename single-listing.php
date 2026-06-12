<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Track recently viewed in cookie.
$recent = isset( $_COOKIE['dxadult_recent'] ) ? array_map( 'intval', explode( ',', sanitize_text_field( wp_unslash( $_COOKIE['dxadult_recent'] ) ) ) ) : array();
$current_id = get_the_ID();
$recent = array_values( array_unique( array_merge( array( $current_id ), array_diff( $recent, array( $current_id ) ) ) ) );
$recent = array_slice( $recent, 0, 20 );
setcookie( 'dxadult_recent', implode( ',', $recent ), time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
?>

<main id="primary" class="site-main" role="main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

		<?php dxadult_listing_schema_jsonld(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-listing' ); ?> itemscope itemtype="https://schema.org/Thing">
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
				<div class="entry-meta">
					<span class="entry-categories"><?php echo implode( ', ', dxadult_get_category_links() ); ?></span>
					<?php dxadult_listing_featured_badge(); ?>
					<?php dxadult_listing_status(); ?>
					<?php dxadult_listing_rating(); ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-thumbnail" itemprop="image">
				<?php the_post_thumbnail( 'dxadult-single', array( 'loading' => 'lazy' ) ); ?>
			</div>
			<?php endif; ?>

			<div class="entry-content" itemprop="description">
				<?php the_content(); ?>
			</div>

			<?php dxadult_listing_url_button(); ?>
			<?php dxadult_social_share(); ?>
			<?php dxadult_report_form(); ?>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

		<?php dxadult_related_listings(); ?>
		<?php dxadult_recently_viewed(); ?>

	<?php endwhile; ?>
</main>

<?php
get_sidebar();
get_footer();
