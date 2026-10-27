<?php
/**
 * Customizer options under Appearance > Customize > TempleOS.
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the TempleOS section and its settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function temple_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'temple_options',
		array(
			'title'       => __( 'TempleOS', 'temple' ),
			'description' => __( 'Turn the crazier parts of the theme on and off.', 'temple' ),
			'priority'    => 30,
		)
	);

	$toggles = array(
		'temple_show_status_bar' => __( 'Show the status bar (clock, memory, CPU meters)', 'temple' ),
		'temple_rainbow_title'   => __( 'Rainbow site title', 'temple' ),
		'temple_enable_blink'    => __( 'Blinking text and cursor', 'temple' ),
		'temple_pixel_cursor'    => __( 'Pixel mouse pointer', 'temple' ),
	);

	foreach ( $toggles as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => true,
				'sanitize_callback' => 'temple_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'temple_options',
				'type'    => 'checkbox',
			)
		);
	}

	$wp_customize->add_setting(
		'temple_footer_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'temple_footer_text',
		array(
			'label'       => __( 'Footer text', 'temple' ),
			'description' => __( 'Leave empty for the default tribute line.', 'temple' ),
			'section'     => 'temple_options',
			'type'        => 'textarea',
		)
	);

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'temple_site_title_html',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => function () {
					bloginfo( 'description' );
				},
			)
		);
	}
}
add_action( 'customize_register', 'temple_customize_register' );

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function temple_sanitize_checkbox( $value ) {
	return (bool) $value;
}
