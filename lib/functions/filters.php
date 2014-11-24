<?php
/**
 * Filters.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Filters the body class.
add_filter( 'body_class', 'cherry_add_layout_class' );

// Prints option styles.
add_action( 'wp_head', 'cherry_add_option_styles', 9999 );


// Add specific CSS class by filter.
function cherry_add_layout_class( $classes ) {
	$layout_type = cherry_get_option('grid-type');

	// Layout.
	if ( 'grid-wide' === $layout_type ) {
		$classes[] = 'cherry-wide';
	} elseif ( 'grid-boxed' === $layout_type ) {
		$classes[] = 'cherry-boxed';
	}

	// Sidebar.
	if ( cherry_display_sidebar( 'sidebar-main' ) ) {
		$classes[] = 'cherry-with-sidebar';
	} else {
		$classes[] = 'cherry-no-sidebar';
	}

	return $classes;
}

function cherry_add_option_styles() {
	$layout          = cherry_get_option('grid-type');
	$container_width = intval( cherry_get_option('page-layout-container-width') );
	$output          = '';

	if ( !$container_width ) {
		$container_width = 1170; // get default value
	}

	// Check a layout type option.
	if ( 'grid-boxed' === $layout ) {
		$output .= ".cherry-container { max-width : {$container_width}px; }\n";
	}

	// Check a container width option.
	if ( $container_width < 1170 ) {
		$output .= ".cherry-no-sidebar .container,\n";
		$output .= ".cherry-with-sidebar .site-header .container,\n";
		$output .= ".cherry-with-sidebar .site-footer .container { max-width : {$container_width}px; }\n";
	}

	// Prepare a string with a styles.
	$output = trim( $output );

	if ( !empty( $output ) ) {

		// Print style if $output not empty.
		printf( "<style type='text/css'>\n%s\n</style>\n", $output );
	}
}