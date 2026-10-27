<?php
/**
 * Temple functions and definitions.
 *
 * @package Temple
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TEMPLE_VERSION', '1.0.0' );
define( 'TEMPLE_DIR', get_template_directory() );
define( 'TEMPLE_URI', get_template_directory_uri() );

require TEMPLE_DIR . '/inc/classic-editor.php';
require TEMPLE_DIR . '/inc/setup.php';
require TEMPLE_DIR . '/inc/enqueue.php';
require TEMPLE_DIR . '/inc/template-tags.php';
require TEMPLE_DIR . '/inc/widgets.php';
require TEMPLE_DIR . '/inc/customizer.php';
