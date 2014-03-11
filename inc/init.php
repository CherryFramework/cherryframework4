<?php
/**
 * Sets up custom filters and actions for the theme. This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 */

// Register custom image sizes.
add_action( 'init', 'cherry_register_image_sizes' );

// Register custom menus.
add_action( 'init', 'cherry_register_menus' );

// Register sidebars.
add_action( 'widgets_init', 'cherry_register_sidebars' );

// Registers custom image sizes for the theme.
function cherry_register_image_sizes() {

	// Sets the 'post-thumbnail' size.
	set_post_thumbnail_size( 200, 150, true );

	// Adds the 'slider-post-thumbnail' image size.
	add_image_size( 'slider-post-thumbnail', 1025, 500, true );
}

// Registers nav menu locations.
function cherry_register_menus() {
	register_nav_menu( 'header', __( 'Header Menu', 'cherry' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'cherry' ) );
}

// Registers sidebars.
function cherry_register_sidebars() {

	cherry_register_sidebar(
		array(
			'id'          => 'main-sidebar',
			'name'        => __( 'Main Sidebar', 'cherry' ),
			'description' => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'footer-sidebar',
			'name'        => __( 'Footer Sidebar', 'cherry' ),
			'description' => __( 'A sidebar located in the footer of the site. Optimized for one, two, or three widgets (and multiples thereof).', 'cherry' )
		)
	);
}

// Added class for default footer sidebar arguments.
add_filter( 'cherry_sidebar_defaults', 'cherry_footer_sidebar_class' );
function cherry_footer_sidebar_class( $defaults ) {
	if ( 'footer-sidebar' === $defaults['id'] ) {
		$defaults['before_widget'] = preg_replace( '/class="/', "class=\"span3 ", $defaults['before_widget'], 1 );
	}
	return $defaults;
}