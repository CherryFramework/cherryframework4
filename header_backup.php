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
	<?php do_action( 'cherry_body_start' ); ?>
	<div id="site_wrapper" class="hfeed site">

		<?php do_action( 'cherry_header_before' ); ?>
		<header id="header" class="site-header" role="banner">
			<div class="container">
				<?php do_action( 'cherry_header_start' ); ?>

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

				<?php get_search_form(); ?>

			<?php do_action( 'cherry_header_end' ); ?>
			</div>
		</header>
		<?php do_action( 'cherry_header_after' ); ?>