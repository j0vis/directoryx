<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb( '<nav class="breadcrumbs" itemprop="breadcrumb">', '</nav>' );
	return;
}

$breadcrumbs = array();
$breadcrumbs[] = array(
	'url'  => home_url( '/' ),
	'name' => __( 'Home', 'directoryx-adult' ),
);

if ( is_tax( 'listing_category' ) ) {
	$term = get_queried_object();
	if ( $term && ! is_wp_error( $term ) ) {
		$breadcrumbs[] = array(
			'url'  => get_term_link( $term ),
			'name' => $term->name,
		);
	}
} elseif ( is_singular( 'listing' ) ) {
	$breadcrumbs[] = array(
		'url'  => get_post_type_archive_link( 'listing' ),
		'name' => __( 'Listings', 'directoryx-adult' ),
	);
	$categories = get_the_terms( get_the_ID(), 'listing_category' );
	if ( $categories && ! is_wp_error( $categories ) ) {
		$top = $categories[0];
		$breadcrumbs[] = array(
			'url'  => get_term_link( $top ),
			'name' => $top->name,
		);
	}
	$breadcrumbs[] = array(
		'url'  => get_permalink(),
		'name' => get_the_title(),
	);
}

if ( count( $breadcrumbs ) <= 1 ) {
	return;
}
?>
<nav class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
	<?php
	$count = count( $breadcrumbs );
	foreach ( $breadcrumbs as $i => $crumb ) :
		$position = $i + 1;
		?>
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<?php if ( $position < $count ) : ?>
				<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $crumb['name'] ); ?></span>
				</a>
				<span class="breadcrumb-sep" aria-hidden="true"> / </span>
			<?php else : ?>
				<span itemprop="name"><?php echo esc_html( $crumb['name'] ); ?></span>
			<?php endif; ?>
			<meta itemprop="position" content="<?php echo (int) $position; ?>">
		</span>
	<?php endforeach; ?>
</nav>
