<?php
/**
 * Styles and scripts.
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets. Fonts are bundled with the theme; nothing is loaded from
 * a third-party CDN.
 */
function temple_enqueue_assets() {
	wp_enqueue_style( 'temple-fonts', TEMPLE_URI . '/assets/css/fonts.css', array(), TEMPLE_VERSION );
	wp_enqueue_style( 'temple-main', TEMPLE_URI . '/assets/css/main.css', array( 'temple-fonts' ), TEMPLE_VERSION );

	wp_enqueue_script( 'temple-os', TEMPLE_URI . '/assets/js/templeos.js', array(), TEMPLE_VERSION, true );
	wp_localize_script(
		'temple-os',
		'templeOS',
		array(
			'oracleWords' => temple_oracle_words(),
			'i18n'        => array(
				'menu'  => __( 'Menu', 'temple' ),
				'close' => __( 'Close', 'temple' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'temple_enqueue_assets' );

/**
 * Preload the body font so the first paint is already pixelated.
 */
function temple_preload_fonts() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( TEMPLE_URI . '/assets/fonts/vt323/vt323-latin-400-normal.woff2' )
	);
}
add_action( 'wp_head', 'temple_preload_fonts', 1 );
