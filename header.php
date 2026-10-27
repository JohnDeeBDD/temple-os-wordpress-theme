<?php
/**
 * The header: status bar, menu bar and the opening of the desktop.
 *
 * @package Temple
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'temple' ); ?></a>

	<?php temple_status_bar(); ?>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php the_custom_logo(); ?>
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo temple_site_title_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in function. ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo temple_site_title_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in function. ?></a></p>
			<?php endif; ?>

			<?php
			$temple_description = get_bloginfo( 'description', 'display' );
			if ( $temple_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo esc_html( $temple_description ); ?></p>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Menu bar', 'temple' ); ?>">
			<button class="menu-toggle tos-button" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( '[Menu]', 'temple' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'tos-menu',
					'container'      => false,
					'fallback_cb'    => 'temple_menu_fallback',
				)
			);
			?>
		</nav>
	</header>

	<div id="content" class="site-content">
