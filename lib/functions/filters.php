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
add_filter( 'body_class',                 'cherry_add_control_classes' );

// Filters the `.cherry-container` class.
add_filter( 'cherry_get_container_class', 'cherry_get_container_classes' );

// Filters a sidebar visibility.
add_filter( 'cherry_display_sidebar',     'cherry_hide_sidebar', 9, 2 );

// Prints option styles.
add_action( 'wp_head', 'cherry_add_extra_styles', 9999 );


// Add specific CSS class by filter.
function cherry_add_control_classes( $classes ) {
	$layout    = get_post_meta( get_queried_object_id(), 'cherry_layout', true );
	$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );

	if ( empty( $layout ) || ( 'default-layout' == $layout ) ) {
		$layout = cherry_get_option( 'page-layout' );
	}

	if ( empty( $grid_type ) || ( 'default-grid-type' == $grid_type ) ) {
		$grid_type = cherry_get_option( 'grid-type' );
	}

	// Responsive.
	if ( 'true' == cherry_get_option( 'grid-responsive' ) ) {
		$classes[] = 'cherry-responsive';
	} else {
		$classes[] = 'cherry-no-responsive';
	}

	// Sidebar Position.
	$classes[] = sanitize_html_class( 'cherry-blog-layout-' . $layout );

	// Grid type.
	$classes[] = sanitize_html_class( 'cherry-' . $grid_type );

	// Sidebar.
	if ( cherry_display_sidebar( 'sidebar-main' ) ) {
		$classes[] = 'cherry-with-sidebar';
	} else {
		$classes[] = 'cherry-no-sidebar';
	}

	return $classes;
}

function cherry_get_container_classes( $class ) {
	$classes   = array();
	$classes[] = $class;

	$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );

	// var_dump($grid_type);

	if ( empty( $grid_type ) || ( 'default-grid-type' == $grid_type ) ) {
		$grid_type = cherry_get_option( 'grid-type' );
	}

	if ( 'wide' == $grid_type ) {
		$classes[] = 'container-fluid';
	} elseif ( 'boxed' == $grid_type ) {
		$classes[] = 'container';
	}
	$classes[] = 'clearfix';

	$classes = apply_filters( 'cherry_get_container_classes', $classes, $class );
	$classes = array_unique( $classes );

	return join( ' ', $classes );
}

function cherry_hide_sidebar( $display, $id ) {
	$layout = false;

	if ( is_singular() ) {
		$layout = get_post_meta( get_queried_object_id(), 'cherry_layout', true );
	}

	if ( !$layout || ( 'default-layout' == $layout ) ) :

		$layout = cherry_get_option('page-layout');

	endif;

	if ( 'no-sidebar' == $layout ) {
		return false;
	}

	if ( ( ( '1-left' == $layout ) || ( '1-right' == $layout ) ) && ( 'sidebar-secondary' == $id ) ) {
		return false;
	}

	return $display;
}

function cherry_add_extra_styles() {
	$responsive        = cherry_get_option('grid-responsive');
	$container_width   = intval( cherry_get_option('page-layout-container-width') );
	$grid_gutter_width = intval( apply_filters( 'cherry_grid_gutter_width', 30 ) );
	$grid_type         = false;
	$output            = '';

	if ( is_singular() ) {
		$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );
	}

	if ( !$grid_type || ( 'default-grid-type' == $grid_type ) ) :

		$grid_type = cherry_get_option( 'grid-type' );

	endif;

	if ( !$container_width ) {
		$container_width = 1170; // get default value
	}

	// Check a layout type option.
	if ( 'grid-boxed' == $grid_type || 'false' == $responsive ) {
		$output .= ".cherry-container.container { max-width : {$container_width}px; }\n";
	}

	// Check a container width option.
	// if ( $container_width < 1170 ) {
		$output .= ".cherry-container.container,\n";
		$output .= ".cherry-grid-boxed .site-header .container,\n";
		$output .= ".cherry-grid-boxed .site-footer .container,\n";
		$output .= ".cherry-no-responsive .site-header .container,\n";
		$output .= ".cherry-no-responsive .site-footer .container { max-width : {$container_width}px; width : auto; }\n";
	// }

	$output .= ".cherry-no-responsive .cherry-container .container { max-width : " . ( $container_width - $grid_gutter_width ) . "px; }\n";

	if ( 'false' == $responsive ) {
		$output .= "body { min-width : {$container_width}px; }\n";
	}

	// Prepare a string with a styles.
	$output = trim( $output );

	if ( !empty( $output ) ) {

		// Print style if $output not empty.
		printf( "<style type='text/css'>\n%s\n</style>\n", $output );
	}
}