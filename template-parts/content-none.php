<?php
/**
 * Shown when a query finds nothing.
 *
 * @package Temple
 */

?>

<section class="no-results not-found tos-window tos-border-red">
	<div class="tos-window__title"><?php esc_html_e( 'Error', 'temple' ); ?></div>

	<header class="page-header">
		<h2 class="page-title"><?php esc_html_e( 'File not found.', 'temple' ); ?></h2>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: Link to the new post screen. */
						__( 'The disk is empty. <a href="%s">Write your first post</a>.', 'temple' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p><?php esc_html_e( 'Nothing matched. Try other words.', 'temple' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing here yet. Searching might help.', 'temple' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
