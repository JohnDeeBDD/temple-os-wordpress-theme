<?php
/**
 * Classic Editor and Classic Widgets by default.
 *
 * The theme turns the block editor off for posts, pages and widgets, and
 * drops the block library styles from the front end. Each piece can be
 * turned back on from a child theme or plugin:
 *
 *     add_filter( 'temple_use_classic_editor', '__return_false' );
 *     add_filter( 'temple_use_classic_widgets', '__return_false' );
 *     add_filter( 'temple_remove_block_styles', '__return_false' );
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wire up the classic editing experience once all plugins have loaded, so the
 * temple_* filters above can be added from anywhere.
 */
function temple_classic_editing() {
	if ( apply_filters( 'temple_use_classic_editor', true ) ) {
		add_filter( 'use_block_editor_for_post', '__return_false', 100 );
		add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
	}

	if ( apply_filters( 'temple_use_classic_widgets', true ) ) {
		add_filter( 'use_widgets_block_editor', '__return_false', 100 );
		add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
		remove_theme_support( 'widgets-block-editor' );
	}
}
add_action( 'after_setup_theme', 'temple_classic_editing', 20 );

/**
 * Remove block library CSS (and global styles) from the front end. Nothing in
 * this theme is built from blocks, so it is dead weight.
 */
function temple_remove_block_styles() {
	if ( ! apply_filters( 'temple_remove_block_styles', true ) ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'core-block-supports' );
}
add_action( 'wp_enqueue_scripts', 'temple_remove_block_styles', 100 );

/**
 * Keep the global styles SVG filters and inline CSS out of the page too.
 */
function temple_remove_global_styles_output() {
	if ( ! apply_filters( 'temple_remove_block_styles', true ) ) {
		return;
	}

	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
}
add_action( 'init', 'temple_remove_global_styles_output' );
