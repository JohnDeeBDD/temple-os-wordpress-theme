<?php
/**
 * A page's content, in one big window titled with its path.
 *
 * @package Temple
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'tos-window tos-window--doc tos-border-purple' ); ?>>
	<div class="tos-window__title tos-window__title--path"><?php echo esc_html( temple_doc_path() ); ?></div>
	<?php temple_window_close(); ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php temple_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'temple' ) . '"><span class="tos-key">' . esc_html__( 'Pages:', 'temple' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php temple_entry_footer(); ?>
		</footer>
	<?php endif; ?>
</article>
