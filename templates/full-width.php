<?php
/**
 * Template Name: Full Width (No Sidebar)
 * Template Post Type: page, post
 *
 * One wide window, no sidebar.
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

			get_template_part( 'template-parts/content', is_page() ? 'page' : 'single' );

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		endwhile;
		?>

	</main>
</div>

<?php
get_footer();
