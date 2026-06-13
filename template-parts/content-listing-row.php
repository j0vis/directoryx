<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'listing-row' ); ?> itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="listing-row__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'dxadult-grid', array( 'loading' => 'lazy' ) ); ?>
		</a>
	<?php else : ?>
		<a class="listing-row__thumb listing-row__thumb--empty" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"></a>
	<?php endif; ?>

	<div class="listing-row__body">
		<h3 class="listing-row__title">
			<a href="<?php the_permalink(); ?>" itemprop="url"><span itemprop="name"><?php the_title(); ?></span></a>
		</h3>
		<div class="listing-row__meta">
			<?php dxadult_listing_status(); ?>
			<?php if ( ! empty( $category_links = dxadult_get_category_links() ) ) : ?>
				<span class="listing-row__cats"><?php echo implode( ', ', $category_links ); ?></span>
			<?php endif; ?>
		</div>
	</div>

	<div class="listing-row__rating">
		<?php dxadult_listing_rating(); ?>
	</div>

	<div class="listing-row__action">
		<?php dxadult_listing_url_button( __( 'Visit', 'directoryx-adult' ), 'button button--small', false ); ?>
	</div>
</article>
