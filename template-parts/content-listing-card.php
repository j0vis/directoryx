<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'listing-card' ); ?> itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="listing-card__thumbnail">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'dxadult-grid', array( 'loading' => 'lazy' ) ); ?></a>
	</div>
	<?php endif; ?>

	<div class="listing-card__body">
		<div class="listing-card__meta">
			<?php dxadult_listing_status(); ?>
			<?php dxadult_listing_rating(); ?>
		</div>

		<h3 class="listing-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<div class="listing-card__categories"><?php echo implode( ', ', dxadult_get_category_links() ); ?></div>

		<div class="listing-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<?php dxadult_listing_url_button( __( 'Visit', 'directoryx-adult' ), 'button button--small', false ); ?>
	</div>
</article>
