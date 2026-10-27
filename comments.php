<?php
/**
 * Comments, in their own window.
 *
 * @package Temple
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area tos-window tos-border-green">
	<div class="tos-window__title"><?php esc_html_e( 'Messages', 'temple' ); ?></div>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$temple_comment_count = get_comments_number();
			printf(
				/* translators: 1: Number of comments, 2: Post title. */
				esc_html( _nx( '%1$s message on &ldquo;%2$s&rdquo;', '%1$s messages on &ldquo;%2$s&rdquo;', $temple_comment_count, 'comments title', 'temple' ) ),
				esc_html( number_format_i18n( $temple_comment_count ) ),
				'<span>' . esc_html( get_the_title() ) . '</span>'
			);
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
					'reply_text'  => __( '[Reply]', 'temple' ),
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Messages are closed.', 'temple' ); ?></p>
			<?php
		endif;
	endif;

	comment_form(
		array(
			'title_reply'        => __( 'Leave a Message', 'temple' ),
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'label_submit'       => __( 'Send', 'temple' ),
			'class_submit'       => 'submit tos-button',
		)
	);
	?>
</section>
