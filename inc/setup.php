<?php
/**
 * Theme setup: supports, menus, content width, small filters.
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and menus.
 */
function temple_setup() {
	load_theme_textdomain( 'temple', TEMPLE_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 64,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	set_post_thumbnail_size( 960, 480, true );

	register_nav_menus(
		array(
			'primary' => __( 'Menu Bar (top)', 'temple' ),
			'footer'  => __( 'Footer Menu', 'temple' ),
		)
	);

	// Styles the Classic Editor (TinyMCE) so posts look like they will on the site.
	add_editor_style( array( 'assets/css/fonts.css', 'assets/css/editor-style.css' ) );
}
add_action( 'after_setup_theme', 'temple_setup' );

/**
 * Content width in pixels, for embeds and images.
 */
function temple_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'temple_content_width', 760 );
}
add_action( 'after_setup_theme', 'temple_content_width', 0 );

/**
 * Body classes for the layout and the Customizer toggles.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function temple_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( temple_has_sidebar() ) {
		$classes[] = 'has-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	if ( ! get_theme_mod( 'temple_enable_blink', true ) ) {
		$classes[] = 'tos-no-blink';
	}

	if ( get_theme_mod( 'temple_pixel_cursor', true ) ) {
		$classes[] = 'tos-pixel-cursor';
	}

	return $classes;
}
add_filter( 'body_class', 'temple_body_classes' );

/**
 * Whether the current view shows the sidebar column.
 *
 * @return bool
 */
function temple_has_sidebar() {
	if ( is_page_template( 'templates/full-width.php' ) || is_404() ) {
		return false;
	}

	return (bool) apply_filters( 'temple_has_sidebar', true );
}

/**
 * Replace the "[...]" excerpt suffix with a DolDoc-style link.
 *
 * @return string
 */
function temple_excerpt_more() {
	if ( is_admin() ) {
		return ' [&hellip;]';
	}

	return sprintf(
		' <a class="more-link" href="%1$s">%2$s<span class="screen-reader-text"> %3$s</span></a>',
		esc_url( get_permalink() ),
		esc_html__( '[Run More]', 'temple' ),
		esc_html( get_the_title() )
	);
}
add_filter( 'excerpt_more', 'temple_excerpt_more' );

/**
 * Shorter excerpts. The 640x480 screen is small.
 *
 * @return int
 */
function temple_excerpt_length() {
	return 40;
}
add_filter( 'excerpt_length', 'temple_excerpt_length' );

/**
 * Pingback header on single posts that accept pings.
 */
function temple_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'temple_pingback_header' );
