<?php
/**
 * A single post.
 *
 * @package Temple
 */

get_header();
?>

<div class="tos-desktop">
	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'single' );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( '<< Prev', 'temple' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next >>', 'temple' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		endwhile;
		?>

	</main>

	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
