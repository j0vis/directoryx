<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer settings.
 */
function dxadult_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'dxadult_footer_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'dxadult_footer_text',
		array(
			'label'       => __( 'Footer Text', 'directoryx-adult' ),
			'description' => __( 'Custom footer text (HTML allowed).', 'directoryx-adult' ),
			'section'     => 'title_tagline',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'dxadult_accent_color',
		array(
			'default'           => DXADULT_DEFAULT_ACCENT,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'dxadult_accent_color',
			array(
				'label'   => __( 'Accent Color', 'directoryx-adult' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'dxadult_grid_columns',
		array(
			'default'           => 3,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'dxadult_grid_columns',
		array(
			'label'       => __( 'Grid Columns', 'directoryx-adult' ),
			'description' => __( 'Number of columns in the listing grid (2-5).', 'directoryx-adult' ),
			'section'     => 'title_tagline',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 2,
				'max'  => 5,
				'step' => 1,
			),
		)
	);
}
add_action( 'customize_register', 'dxadult_customize_register' );

/**
 * Output customizer styles.
 */
function dxadult_customizer_css() {
	$accent = get_theme_mod( 'dxadult_accent_color', DXADULT_DEFAULT_ACCENT );
	if ( DXADULT_DEFAULT_ACCENT === $accent ) {
		return;
	}
	?>
	<style>
		a, .button, .site-title a { color: <?php echo esc_attr( $accent ); ?>; }
		.button, .listing-status--active { border-color: <?php echo esc_attr( $accent ); ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'dxadult_customizer_css', 20 );
