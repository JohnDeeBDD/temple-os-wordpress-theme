<?php
/**
 * The main template file: the blog index and the fallback for every view.
 *
 * @package Temple
 */

get_header();
?>

<div class="tos-desktop">
	<main id="primary" class="site-main">

		<header class="page-header tos-window tos-border-blue">
			<div class="tos-window__title tos-window__title--path"><?php echo esc_html( temple_doc_path() ); ?></div>
			<?php temple_window_close(); ?>
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			<?php else : ?>
				<h1 class="page-title"><?php esc_html_e( 'Dir', 'temple' ); ?> <span class="tos-fg-red">C:/Home</span><span class="tos-cursor" aria-hidden="true"></span></h1>
				<?php
				$temple_description = get_bloginfo( 'description', 'display' );
				if ( $temple_description ) :
					?>
					<p class="archive-description"><?php echo esc_html( $temple_description ); ?></p>
				<?php endif; ?>
			<?php endif; ?>
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
