<?php
/**
 * A search result: a compact window with the post type and excerpt.
 *
 * @package Temple
 */

global $wp_query;
$temple_type = get_post_type_object( get_post_type() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tos-window tos-border-' . temple_cycle_color( (int) $wp_query->current_post + 1 ) ); ?>>
	<div class="tos-window__title"><?php echo esc_html( temple_post_filename() ); ?></div>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if ( $temple_type ) : ?>
			<p class="entry-type"><span class="tos-key"><?php esc_html_e( 'Type:', 'temple' ); ?></span> <?php echo esc_html( $temple_type->labels->singular_name ); ?></p>
		<?php endif; ?>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
</article>
