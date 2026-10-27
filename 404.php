<?php
/**
 * 404: a TempleOS-style crash screen.
 *
 * @package Temple
 */

get_header();
?>

<div class="tos-desktop">
	<main id="primary" class="site-main">

		<section class="error-404 not-found tos-window tos-window--panic tos-border-red">
			<div class="tos-window__title"><?php esc_html_e( 'Debug', 'temple' ); ?></div>
			<?php temple_window_close(); ?>

			<header class="page-header">
				<h1 class="page-title"><span class="tos-blink"><?php esc_html_e( 'Exception: 404', 'temple' ); ?></span></h1>
			</header>

			<div class="page-content">
				<pre class="tos-terminal" aria-hidden="true"><span class="tos-fg-dkgray">C:/Home&gt;</span> Cd("<?php echo esc_html( wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ) ), PHP_URL_PATH ) ); ?>");
<span class="tos-fg-red">ERROR: File not found.</span>
<span class="tos-fg-purple">RIP 0000000000013F2A  RSP 000000000007FE40</span>
<span class="tos-fg-green">  Task:Adam  Seth:0  CPU:0</span>
<span class="tos-fg-dkgray">C:/Home&gt;</span><span class="tos-cursor"></span></pre>

				<p><?php esc_html_e( 'The file you asked for is not on this disk. It may have moved, or it never existed.', 'temple' ); ?></p>

				<p>
					<a class="tos-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Cd("C:/Home");', 'temple' ); ?></a>
				</p>

				<?php get_search_form(); ?>
			</div>
		</section>

	</main>
</div>

<?php
get_footer();
