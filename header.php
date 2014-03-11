<?php
/**
 * The template for displaying theme header.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Cherry Framework
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="site_wrapper" class="hfeed site">

		<header id="header" class="site-header" role="banner">
			<div class="container">

				<!-- Branding -->
				<div class="site-branding">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>

				<!-- Navigation -->
				<nav id="navigation" class="main-navigation" role="navigation">
					<?php if ( has_nav_menu( 'header' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'header',
								'container'      => false,
								'menu_class'     => 'sf-menu',
								)
							);
					} ?>
				</nav>

			</div>
		</header>