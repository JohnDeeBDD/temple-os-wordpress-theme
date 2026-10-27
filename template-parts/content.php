<?php
/**
 * A post in a list (blog index, archives). Each post is its own window, and
 * the window border cycles through the VGA palette.
 *
 * @package Temple
 */

global $wp_query;
$temple_color = is_sticky() ? 'yellow' : temple_cycle_color( (int) $wp_query->current_post );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tos-window tos-border-' . $temple_color ); ?>>
	<div class="tos-window__title"><?php echo esc_html( is_sticky() ? '* ' . temple_post_filename() . ' *' : temple_post_filename() ); ?></div>

	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<p class="sticky-label tos-blink"><?php esc_html_e( '[Pinned]', 'temple' ); ?></p>
		<?php endif; ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php temple_entry_meta(); ?>
	</header>

	<?php temple_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
</article>
