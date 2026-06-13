<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current_view = isset( $_GET['view'] ) ? sanitize_key( wp_unslash( $_GET['view'] ) ) : 'list';
if ( ! in_array( $current_view, array( 'list', 'grid' ), true ) ) {
	$current_view = 'list';
}
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

	<div class="archive-toolbar">
		<div class="archive-view-toggle" role="group" aria-label="<?php esc_attr_e( 'Archive view', 'directoryx-adult' ); ?>">
			<button type="button" class="archive-view-toggle__btn<?php echo 'list' === $current_view ? ' is-active' : ''; ?>" data-view="list" aria-pressed="<?php echo 'list' === $current_view ? 'true' : 'false'; ?>" aria-label="<?php esc_attr_e( 'List view', 'directoryx-adult' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1.5"/><circle cx="4" cy="12" r="1.5"/><circle cx="4" cy="18" r="1.5"/></svg>
				<span><?php esc_html_e( 'List', 'directoryx-adult' ); ?></span>
			</button>
			<button type="button" class="archive-view-toggle__btn<?php echo 'grid' === $current_view ? ' is-active' : ''; ?>" data-view="grid" aria-pressed="<?php echo 'grid' === $current_view ? 'true' : 'false'; ?>" aria-label="<?php esc_attr_e( 'Grid view', 'directoryx-adult' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
				<span><?php esc_html_e( 'Grid', 'directoryx-adult' ); ?></span>
			</button>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="listing-archive view--<?php echo esc_attr( $current_view ); ?>" itemscope itemtype="https://schema.org/ItemList">
			<?php
			while ( have_posts() ) :
				the_post();
				$tmpl = ( 'grid' === $current_view ) ? 'listing-card' : 'listing-row';
				get_template_part( 'template-parts/content', $tmpl );
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
