<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer settings.
 */
function dxadult_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'dxadult_default_theme',
		array(
			'default'           => 'dark',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'dxadult_default_theme',
		array(
			'label'       => __( 'Default Theme Mode', 'directoryx-adult' ),
			'description' => __( 'Users can toggle between light and dark mode via the theme toggle button.', 'directoryx-adult' ),
			'section'     => 'colors',
			'type'        => 'select',
			'choices'     => array(
				'dark'  => __( 'Dark Mode', 'directoryx-adult' ),
				'light' => __( 'Light Mode', 'directoryx-adult' ),
			),
		)
	);
}
add_action( 'customize_register', 'dxadult_customize_register' );

/**
 * Output customizer styles.
 */
function dxadult_customizer_css() {
	$theme = get_theme_mod( 'dxadult_default_theme', 'dark' );
	if ( 'dark' === $theme ) {
		return;
	}
	?>
	<style>
		:root { --accent: #0969da; --accent-hover: #0550ae; --accent-glow: rgba(9, 105, 218, 0.15); }
	</style>
	<?php
}
add_action( 'wp_head', 'dxadult_customizer_css', 20 );
