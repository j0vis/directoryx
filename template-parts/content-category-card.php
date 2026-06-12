<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$category = $args['category'] ?? false;
if ( ! $category ) {
	return;
}
?>
<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-card">
	<div class="category-card__icon" aria-hidden="true"><?php dxadult_icon( 'folder', '18', 'category-icon' ); ?></div>
	<span class="category-name"><?php echo esc_html( $category->name ); ?></span>
	<span class="category-count"><?php echo esc_html( sprintf( _n( '%s site', '%s sites', $category->count, 'directoryx-adult' ), number_format_i18n( $category->count ) ) ); ?></span>
	<?php if ( ! empty( $args['show_description'] ) && $category->description ) : ?>
	<span class="category-description"><?php echo esc_html( $category->description ); ?></span>
	<?php endif; ?>
</a>
