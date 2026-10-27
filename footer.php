<?php
/**
 * The footer: footer widgets, footer menu and the tribute line.
 *
 * @package Temple
 */

?>
	</div><!-- #content -->

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<aside class="footer-widgets" aria-label="<?php esc_attr_e( 'Footer widgets', 'temple' ); ?>">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</aside>
	<?php endif; ?>

	<footer id="colophon" class="site-footer">
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 'temple' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'tos-menu tos-menu--footer',
						'container'      => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
		<?php endif; ?>

		<div class="site-info">
			<?php
			$temple_footer_text = get_theme_mod( 'temple_footer_text', '' );
			if ( $temple_footer_text ) :
				echo wp_kses_post( wpautop( $temple_footer_text ) );
			else :
				?>
				<p>
					<span class="tos-fg-blue">640x480</span>
					<span class="tos-fg-purple">16 colors</span>
					<span class="tos-fg-green">1 voice</span>
					<span class="tos-fg-red">Ring-0</span>
					<span class="tos-sep">&middot;</span>
					<?php esc_html_e( 'In memory of Terry A. Davis (1969-2018), who built TempleOS by himself.', 'temple' ); ?>
				</p>
				<p class="tos-dim">
					&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
					<span class="tos-sep">&middot;</span>
					<?php
					printf(
						/* translators: %s: WordPress link. */
						esc_html__( 'Runs on %s', 'temple' ),
						'<a href="' . esc_url( __( 'https://wordpress.org/', 'temple' ) ) . '">WordPress</a>'
					);
					?>
				</p>
			<?php endif; ?>
			<p class="tos-prompt" aria-hidden="true">C:/Home&gt;<span class="tos-cursor"></span></p>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
