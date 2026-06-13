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
			'description' => __( 'Initial mode for new visitors. Visitors can toggle between light and dark mode via the theme toggle button in the header.', 'directoryx-adult' ),
			'section'     => 'colors',
			'type'        => 'select',
			'choices'     => array(
				'dark'  => __( 'Dark Mode', 'directoryx-adult' ),
				'light' => __( 'Light Mode', 'directoryx-adult' ),
			),
		)
	);

	$wp_customize->add_setting(
		'dxadult_default_scheme',
		array(
			'default'           => 'midnight',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'dxadult_default_scheme',
		array(
			'label'       => __( 'Accent Color Scheme (site-wide)', 'directoryx-adult' ),
			'description' => __( 'Site-wide accent color. This is a webmaster setting — visitors can only toggle between light and dark mode via the theme toggle in the header.', 'directoryx-adult' ),
			'section'     => 'colors',
			'type'        => 'select',
			'choices'     => array(
				'midnight' => __( 'Midnight Blue', 'directoryx-adult' ),
				'emerald'  => __( 'Emerald Green', 'directoryx-adult' ),
				'ruby'     => __( 'Ruby Red', 'directoryx-adult' ),
				'amethyst' => __( 'Amethyst Purple', 'directoryx-adult' ),
				'amber'    => __( 'Amber Gold', 'directoryx-adult' ),
				'coral'    => __( 'Coral Orange', 'directoryx-adult' ),
				'ocean'    => __( 'Ocean Teal', 'directoryx-adult' ),
				'slate'    => __( 'Slate Indigo', 'directoryx-adult' ),
			),
		)
	);
}
add_action( 'customize_register', 'dxadult_customize_register' );
