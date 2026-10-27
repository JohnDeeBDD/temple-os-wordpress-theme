<?php
/**
 * Archives: categories, tags, authors, dates and custom taxonomies.
 *
 * @package Temple
 */

get_header();
?>

<div class="tos-desktop">
	<main id="primary" class="site-main">

		<header class="page-header tos-window tos-border-green">
			<div class="tos-window__title tos-window__title--path"><?php echo esc_html( temple_doc_path() ); ?></div>
			<?php temple_window_close(); ?>
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content' );
			endwhile;

			temple_pagination();
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>

	</main>

	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
