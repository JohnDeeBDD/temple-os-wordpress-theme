<?php
/**
 * Search form, written as a command line: C:/Home> Find("...");
 *
 * @package Temple
 */

$temple_id = wp_unique_id( 'search-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $temple_id ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'temple' ); ?></span>
		<span class="search-form__cmd" aria-hidden="true">Find("</span>
	</label>
	<input type="search" id="<?php echo esc_attr( $temple_id ); ?>" class="search-field" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_attr_e( 'words', 'temple' ); ?>">
	<span class="search-form__cmd" aria-hidden="true">");</span>
	<button type="submit" class="search-submit tos-button"><?php echo esc_html_x( 'Run', 'submit button', 'temple' ); ?></button>
</form>
