<?php
/**
 * The functions file is used to initialize everything in the theme. It controls how the theme is loaded and
 * sets up the supported features, default actions, and default filters. If making customizations, users
 * should create a child theme and make changes to its functions.php file (not this one).
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features. Use a priority of 9 if wanting to run before the parent theme.
 */

// Load the core Cherry Framework.
require_once( trailingslashit( get_template_directory() ) . 'lib/class-cherry-framework.php' );
new Cherry_Framework();

// Sets up theme defaults and registers support for various WordPress features.
add_action( 'after_setup_theme', 'cherry_theme_setup' );
function cherry_theme_setup() {

	// Load files.
	require_once( trailingslashit( PARENT_DIR ) . 'init/init.php' );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video',
	) );

	// Loads scripts.
	add_theme_support( 'cherry-scripts', array(
		'comment-reply', 'drop-downs',
	) );

	// Loads styles.
	add_theme_support( 'cherry-styles', array(
		'grid-base', 'grid-responsive', 'drop-downs', 'main', 'add-ons',
	) );

	// Loads shortcodes.
	add_theme_support( 'cherry-shortcodes' );

	/* Theme layouts. */
	// add_theme_support(
	// 	'theme-layouts',
	// 	array(
	// 		'1c'        => __( '1 Column Wide',                'stargazer' ),
	// 		'1c-narrow' => __( '1 Column Narrow',              'stargazer' ),
	// 		'2c-l'      => __( '2 Columns: Content / Sidebar', 'stargazer' ),
	// 		'2c-r'      => __( '2 Columns: Sidebar / Content', 'stargazer' )
	// 	),
	// 	array( 'default' => is_rtl() ? '2c-r' :'2c-l' )
	// );
	// add_theme_support( 'theme-layouts' );

	// Handle content width for embeds and images.
	cherry_set_content_width( 780 );

	add_filter( 'cherry_wrap_base', 'cherry_wrap_base_cpts' );
	function cherry_wrap_base_cpts( $templates ) {
		$cpt = get_post_type(); // Get the current post type
		if ( $cpt && ( 'page' !== $cpt ) ) {
			array_unshift( $templates, 'base-single-' . $cpt . '.php' ); // Shift the template to the front of the array
		}
		return $templates; // Return modified array with base-$cpt.php at the front of the queue
	}
}

function banner_callback() {
	echo '<img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image">';
}
function info_callback() {
	echo "Static 6";
}
function info2_callback() {
	echo "Static 7";
}