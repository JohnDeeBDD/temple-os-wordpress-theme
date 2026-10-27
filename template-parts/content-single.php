<?php
/**
 * A single post's full content, in one big window titled with its path.
 *
 * @package Temple
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tos-window tos-window--doc tos-border-blue' ); ?>>
	<div class="tos-window__title tos-window__title--path"><?php echo esc_html( temple_doc_path() ); ?></div>
	<?php temple_window_close(); ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php temple_entry_meta(); ?>
	</header>

	<?php temple_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				/* translators: %s: Post title. Only visible to screen readers. */
				esc_html__( '[Run More]%s', 'temple' ),
				'<span class="screen-reader-text"> ' . esc_html( get_the_title() ) . '</span>'
			)
		);

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'temple' ) . '"><span class="tos-key">' . esc_html__( 'Pages:', 'temple' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php temple_entry_footer(); ?>
	</footer>
</article>
