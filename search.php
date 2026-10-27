<?php
/**
 * Search results.
 *
 * @package Temple
 */

get_header();
?>

<div class="tos-desktop">
	<main id="primary" class="site-main">

		<header class="page-header tos-window tos-border-red">
			<div class="tos-window__title tos-window__title--path"><?php esc_html_e( 'Find', 'temple' ); ?></div>
			<?php temple_window_close(); ?>
			<h1 class="page-title">
				<span class="tos-fg-dkgray">C:/Home&gt;</span>
				<?php
				printf(
					/* translators: %s: Search query. */
					esc_html__( 'Find("%s");', 'temple' ),
					'<span class="tos-fg-red">' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
			<p class="archive-description">
				<?php
				global $wp_query;
				printf(
					/* translators: %d: Number of results. */
					esc_html( _n( '%d file found.', '%d files found.', (int) $wp_query->found_posts, 'temple' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>
		</header>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'search' );
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
