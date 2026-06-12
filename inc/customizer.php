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
			'label'       => __( 'Default Color Scheme', 'directoryx-adult' ),
			'description' => __( 'Users can override this via the theme color picker.', 'directoryx-adult' ),
			'section'     => 'colors',
			'type'        => 'select',
			'choices'     => array(
				'midnight' => __( 'Midnight Blue', 'directoryx-adult' ),
				'emerald'  => __( 'Emerald Green', 'directoryx-adult' ),
				'ruby'     => __( 'Ruby Red', 'directoryx-adult' ),
				'amethyst' => __( 'Amethyst Purple', 'directoryx-adult' ),
			),
		)
	);
}
add_action( 'customize_register', 'dxadult_customize_register' );

/**
 * Output customizer styles.
 */
function dxadult_customizer_css() {
	$scheme = get_theme_mod( 'dxadult_default_scheme', 'midnight' );
	if ( 'midnight' === $scheme ) {
		return;
	}
	$accent_map = array(
		'emerald'  => '#3fb950',
		'ruby'     => '#f85149',
		'amethyst' => '#bc8cff',
	);
	$accent = isset( $accent_map[ $scheme ] ) ? $accent_map[ $scheme ] : '';
	if ( ! $accent ) {
		return;
	}
	?>
	<style>
		:root { --accent: <?php echo esc_attr( $accent ); ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'dxadult_customizer_css', 20 );
