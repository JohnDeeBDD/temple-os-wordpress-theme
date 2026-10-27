<?php
/**
 * The sidebar column. Each widget is a small window.
 *
 * With no widgets assigned yet, a default set is shown so the theme looks
 * complete out of the box.
 *
 * @package Temple
 */

if ( ! temple_has_sidebar() ) {
	return;
}
?>

<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'temple' ); ?>">
	<?php
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		dynamic_sidebar( 'sidebar-1' );
	} else {
		the_widget( 'WP_Widget_Search', array( 'title' => __( 'Find', 'temple' ) ), temple_widget_args( 'red', true ) );
		the_widget( 'Temple_Oracle_Widget', array(), temple_widget_args( 'purple', true ) );
		the_widget( 'WP_Widget_Recent_Posts', array( 'title' => __( 'Recent Docs', 'temple' ) ), temple_widget_args( 'blue', true ) );
		the_widget( 'WP_Widget_Categories', array( 'title' => __( 'Directories', 'temple' ) ), temple_widget_args( 'green', true ) );
	}
	?>
</aside>
