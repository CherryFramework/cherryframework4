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

add_action( 'wp_head', 'cherry_add_option_styles', 9999 );


// Add specific CSS class by filter.
function cherry_add_layout_class( $classes ) {
	global $cherry_layout;

	// Layout.
	if ( 'wide' === $cherry_layout ) {
		$classes[] = 'cherry-wide';
	} elseif ( 'boxed' === $cherry_layout ) {
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
	global $cherry_layout, $cherry_container_width;

	$output = '';

	$cherry_container_width = intval( $cherry_container_width );

	if ( !$cherry_container_width ) {
		$cherry_container_width = 1170; // get default value
	}

	// Check a layout type option.
	// if ( 'boxed' === $cherry_layout ) { // UNCOMMENT AFTER OPTION REALSE
		$output .= ".cherry-container { max-width : {$cherry_container_width}px; }\n";
	// }

	// Check a container width option.
	if ( $cherry_container_width < 1170 ) {
		$output .= ".cherry-no-sidebar .container,\n";
		$output .= ".cherry-with-sidebar .site-header .container,\n";
		$output .= ".cherry-with-sidebar .site-footer .container { max-width : {$cherry_container_width}px; }\n";
	}

	// Prepare a string with a styles.
	$output = trim( $output );

	if ( !empty( $output ) ) {

		// Print style if $output not empty.
		printf( "<style type='text/css'>\n%s\n</style>\n", $output );
	}
}