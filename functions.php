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
	require_once( trailingslashit( PARENT_DIR ) . 'inc/init.php' );

	// Registered a static areas.
	cherry_register_static_area( array(
		'id'             => 'header-top',
		'name'           => __( 'Header Top', 'cherry' ),
		// 'before'         => '',
		// 'after'          => '',
		// 'before_static'  => '<div class="static clearfix">',
		// 'after_static'   => '</div>',
		// 'container_wrap' => true,
		// 'row_wrap'       => true,
	) );
	cherry_register_static_area( array(
		'id'             => 'header-left',
		'name'           => __( 'Header Left', 'cherry' ),
		'before'         => '<div class="col-md-7">',
		'after'          => '</div>',
		'container_wrap' => false,
	) );
	cherry_register_static_area( array(
		'id'             => 'header-right',
		'name'           => __( 'Header Right', 'cherry' ),
		'before'         => '<div class="col-md-5">',
		'after'          => '</div>',
		'container_wrap' => false,
	) );
	cherry_register_static_area( array(
		'id'             => 'header-bottom',
		'name'           => __( 'Header Bottom', 'cherry' ),
		'container_wrap' => false,
		)
	);
	cherry_register_static_area( array(
		'id'             => 'footer-top',
		'name'           => __( 'Footer Top', 'cherry' ),
	) );
	cherry_register_static_area( array(
		'id'             => 'footer-bottom',
		'name'           => __( 'Footer Bottom', 'cherry' ),
	) );

	// Registered a static elements.
	cherry_register_static( array(
		'id'      => 'header_logo',
		'name'    => __( 'Logo', 'cherry4' ),
		'options' => array(
			'col-xs'   => 'col-xs-12',
			'col-sm'   => 'col-sm-12',
			'col-md'   => 'col-md-4',
			'col-lg'   => 'col-lg-4',
			'class'    => 'custom-logo',
			'area'     => 'header-top',
			'priority' => 1,
		)
	) );
	cherry_register_static( array(
		'id'      => 'header_menu',
		'name'    => __( 'Header Menu', 'cherry4' ),
		'options' => array(
			'col-lg'   => 'col-lg-8',
			'col-md'   => 'col-md-8',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'class'    => 'custom-mainmenu',
			'priority' => 2,
			'area'     => 'header-top',
		)
	) );
	cherry_register_static( array(
		'id'       => 'banner',
		'name'     => __( 'Banner', 'cherry4' ),
		'callback' => 'banner_callback',
		'options'  => array(
			'col-lg'   => 'col-lg-6',
			'col-md'   => 'col-md-6',
			'col-sm'   => 'col-sm-6',
			'col-xs'   => 'col-xs-6',
			'class'    => 'custom-banner',
			'priority' => 1,
			'area'     => 'header-left',
		)
	) );
	cherry_register_static( array(
		'id'       => 'loginout',
		'name'     => __( 'Log In/Out', 'cherry4' ),
		'options'  => array(
			'col-lg'   => 'col-lg-6',
			'col-md'   => 'col-md-6',
			'col-sm'   => 'col-sm-6',
			'col-xs'   => 'col-xs-6',
			'class'    => 'custom-loginout',
			'priority' => 2,
			'area'     => 'header-left',
		)
	) );
	cherry_register_static( array(
		'id'      => 'searchform',
		'name'    => __( 'Search Form', 'cherry4' ),
		'options' => array(
			'col-lg'   => 'col-lg-12',
			'col-md'   => 'col-md-12',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'class'    => 'custom-searchform',
			'priority' => 1,
			'area'     => 'header-right',
		)
	) );
	cherry_register_static( array(
		'id'       => 'info',
		'callback' => 'info_callback',
		'options'  => array(
			'col-lg'   => 'col-lg-2',
			'col-md'   => 'col-md-2',
			'col-sm'   => 'col-sm-2',
			'col-xs'   => 'col-xs-2',
			'priority' => 1,
			'area'     => 'header-bottom',
		)
	) );
	cherry_register_static( array(
		'id'       => 'info2',
		'callback' => 'info2_callback',
		'options'  => array(
			'priority' => 2,
			'area'     => 'header-bottom',
		)
	) );
	cherry_register_static( array(
		'name'    => __( 'Header Sidebar', 'cherry4' ),
		'id'      => 'header_sidebar',
		'options' => array(
			'priority' => 3,
			'area'     => 'header-bottom',
		)
	) );

	cherry_register_static( array(
		'name'    => __( 'Footer Sidebar', 'cherry4' ),
		'id'      => 'footer_sidebar',
		'options' => array(
			'priority' => 1,
			'area'     => 'footer-top',
		)
	) );
	cherry_register_static( array(
		'id'      => 'footer_menu',
		'name'    => __( 'Footer Menu', 'cherry4' ),
		'options' => array(
			'col-lg'   => 'col-lg-8',
			'col-md'   => 'col-md-8',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'priority' => 2,
			'area'     => 'footer-bottom',
		)
	) );
	cherry_register_static( array(
		'id'      => 'footer_info',
		'name'    => __( 'Footer Info', 'cherry4' ),
		'options' => array(
			'col-lg'   => 'col-lg-4',
			'col-md'   => 'col-md-4',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'priority' => 3,
			'area'     => 'footer-bottom',
		)
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