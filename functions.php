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
	require_once( trailingslashit( get_template_directory() ) . 'inc/init.php' );

	// Registered a static areas.
	cherry_register_static_area( array(
		'id'            => 'top',
		'before'        => '<div class="container"><div class="row">',
		'after'         => '</div></div>',
		'before_static' => '<div class="static %s">',
		'after_static'  => '</div>',
		'priority'      => 5,
	) );
	cherry_register_static_area( array(
		'id'            => 'middle',
		'before'        => '',
		'after'         => '',
		'before_static' => '<div class="static %s">',
		'after_static'  => '</div>',
		'priority'      => 2,
	) );
	cherry_register_static_area( array(
		'id'            => 'bottom',
		'before'        => '',
		'after'         => '',
		'before_static' => '<div class="static %s">',
		'after_static'  => '</div>',
		'priority'      => 1,
	) );

	// Registered a static elements.
	cherry_register_static( array(
		'id'       => 'logo',
		'name'     => 'Logo',
		'callback' => '',
		'options'  => array(
			'column'   => 5,
			'class'    => 'custom_logo',
			'priority' => 1,
			'area'     => 'top',
		)
	) );
	cherry_register_static( array(
		'id'       => 'mainmenu',
		'name'     => 'Main Menu',
		'callback' => '',
		'options'  => array(
			'column'   => 7,
			'class'    => 'custom_mainmenu',
			'priority' => 2,
			'area'     => 'top',
		)
	) );

	// Registered a static elements.
	// cherry_register_statics( array(
	// 	'logo' => array(
	// 		'name'     => __( 'Logo', 'cherry' ),
	// 		'col'      => 6,
	// 		'class'    => 'custom_logo',
	// 		'priority' => 1,
	// 		// 'output_callback'     => 'foo',
	// 		'area'     => 'top',
	// 	),
	// 	'mainmenu' => array(
	// 		'name'     => __( 'Main Menu', 'cherry' ),
	// 		'col'      => 6,
	// 		'class'    => 'custom_mainmenu',
	// 		'priority' => 2,
	// 		// 'output_callback'     => '',
	// 		'area'     => 'bottom',
	// 	),
	// 	'banner' => array(
	// 		'output_callback' => 'foo'
	// 	),
	// ) );
	// cherry_register_static( array(
	// 	'id'       => 'mainmenu',
	// 	'name'     => __( 'Main Menu', 'cherry' ),
	// 	'col'      => 6,
	// 	'class'    => 'custom_mainmenu',
	// 	'priority' => 2,
	// 	'func'     => '',
	// 	'area'     => 'top',
	// ) );

	// Enable support a Header statics.
	add_theme_support( 'cherry-header-statics', array(
		'logo' => array(), 'menu' => array(), 'searchform' => array(),
	) );

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
		'drop-downs', 'parent', 'style',
	) );

	// Loads shortcodes.
	add_theme_support( 'cherry-shortcodes' );

	// Enable support SCSS compiler.
	add_theme_support( 'cherry-scss-compiler' );

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