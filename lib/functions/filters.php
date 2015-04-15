<?php
/**
 * Filters.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Filters the body class.
add_filter( 'body_class', 'cherry_add_control_classes' );

// Filters the `.cherry-container` class.
add_filter( 'cherry_get_container_class', 'cherry_get_container_classes' );

// Filters a sidebar visibility.
add_filter( 'cherry_display_sidebar', 'cherry_hide_sidebar', 9, 2 );

// Filters an excerpt params.
add_filter( 'excerpt_length', 'cherry_excerpt_length', 999 );
add_filter( 'excerpt_more',   '__return_empty_string', 999 );

add_filter( 'cherry_pre_get_the_post_date',     'cherry_option_post_date',     10, 2 );
add_filter( 'cherry_pre_get_the_post_author',   'cherry_option_post_author',   10, 2 );
add_filter( 'cherry_pre_get_the_post_comments', 'cherry_option_post_comments', 10, 2 );
add_filter( 'cherry_pre_get_the_post_taxonomy', 'cherry_option_post_taxonomy', 10, 2 );
add_filter( 'cherry_pre_get_the_post_content',  'cherry_option_post_content',  10, 2 );
add_filter( 'cherry_pre_get_the_post_button',   'cherry_option_post_button',   10, 2 );

add_filter( 'cherry_pre_get_the_post_thumbnail', 'cherry_option_post_thumbnail', 10, 2 );
add_filter( 'cherry_pre_get_the_post_gallery',   'cherry_option_post_gallery',   10, 2 );
add_filter( 'cherry_pre_get_the_post_audio',     'cherry_option_post_audio',     10, 2 );
add_filter( 'cherry_pre_get_the_post_video',     'cherry_option_post_video',     10, 2 );
add_filter( 'cherry_pre_get_the_post_avatar',    'cherry_option_post_avatar',    10, 2 );

// Prints option styles.
add_action( 'wp_head', 'cherry_add_extra_styles', 9999 );

// Add favicon tags to page
add_action( 'wp_head', 'cherry_favicon_tags' );


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
	$layout = get_post_meta( get_queried_object_id(), 'cherry_layout', true );

	if ( !$layout || ( 'default-layout' == $layout ) ) {
		$layout = cherry_get_option('page-layout');
	}

	if ( 'no-sidebar' == $layout ) {
		return false;
	}

	if ( ( ( '1-left' == $layout ) || ( '1-right' == $layout ) ) && ( 'sidebar-secondary' == $id ) ) {
		return false;
	}

	return $display;
}

function cherry_excerpt_length( $length ) {
	return cherry_get_option( 'blog-excerpt-length' );
}

function cherry_option_post_date( $display, $args ) {
	if ( 'false' == cherry_get_option( 'blog-post-date' ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_author( $display, $args ) {
	if ( 'false' == cherry_get_option( 'blog-post-author' ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_comments( $display, $args ) {
	if ( 'false' == cherry_get_option( 'blog-post-comments' ) ) {
		return '';
	}

	if ( 'false' == cherry_get_option( 'blog-comment-status' ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_taxonomy( $display, $args ) {
	if ( ( 'category' == $args['name'] )
		&& ( 'false' == cherry_get_option( 'blog-categories' ) )
		) {
		return '';
	}

	if ( ( 'post_tag' == $args['name'] )
		&& ( 'false' == cherry_get_option( 'blog-tags' ) )
		) {
		return '';
	}

	return $display;
}

function cherry_option_post_content( $display, $args ) {
	if ( !is_single() && ( 'none' == cherry_get_option( 'blog-content-type' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_button( $display, $args ) {
	if ( !is_single() && ( 'false' == cherry_get_option( 'blog-button' ) ) ) {
		return '';
	}

	if ( !is_single() && ( '' == cherry_get_option( 'blog-button-text' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_thumbnail( $display, $args ) {
	$post_id = get_the_ID();
	$post_type = get_post_type( $post_id );

	if ( is_singular() ) {

		// On post.
		if ( is_single( $post_id ) && ( 'false' == cherry_get_option( 'blog-post-featured-image' ) ) ) {
			return '';
		}

		// On page.
		if ( is_page( $post_id ) && ( 'false' == cherry_get_option( 'general-page-featured-images' ) ) ) {
			return '';
		}

	} else {

		// On blog.
		if ( 'false' == cherry_get_option( 'blog-featured-images' ) ) {
			return '';
		}

	}

	if ( !is_singular() ) {
		$args['size'] = cherry_get_option( 'blog-featured-images-size' );
	}

	return $display;
}

function cherry_option_post_gallery( $display, $args ) {
	$post_id = get_the_ID();

	if ( is_single( $post_id ) && ( 'false' == cherry_get_option( 'blog-post-featured-image' ) ) ) {
		return '';
	}

	if ( !is_single() && ( 'false' == cherry_get_option( 'blog-featured-images' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_audio( $display, $args ) {
	$post_id = get_the_ID();

	if ( is_single( $post_id ) && ( 'false' == cherry_get_option( 'blog-post-featured-image' ) ) ) {
		return '';
	}

	if ( !is_single() && ( 'false' == cherry_get_option( 'blog-featured-images' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_video( $display, $args ) {
	$post_id = get_the_ID();

	if ( is_single( $post_id ) && ( 'false' == cherry_get_option( 'blog-post-featured-image' ) ) ) {
		return '';
	}

	if ( !is_single() && ( 'false' == cherry_get_option( 'blog-featured-images' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_avatar( $display, $args ) {
	$post_id = get_the_ID();

	if ( is_single( $post_id ) && ( 'false' == cherry_get_option( 'blog-post-featured-image' ) ) ) {
		return '';
	}

	if ( !is_single() && ( 'false' == cherry_get_option( 'blog-featured-images' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_add_extra_styles() {
	$responsive        = cherry_get_option( 'grid-responsive' );
	$container_width   = intval( cherry_get_option( 'grid-container-width' ) );
	$grid_gutter_width = intval( apply_filters( 'cherry_grid_gutter_width', 30 ) );
	$grid_type         = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );
	$output            = '';

	if ( !$grid_type || ( 'default-grid-type' == $grid_type ) ) {
		$grid_type = cherry_get_option( 'grid-type' );
	}

	if ( 'false' == $responsive ) {
		$output .= "body { min-width: {$container_width}px; }\n";
		$output .= ".cherry-no-responsive .cherry-container .container { max-width: " . ( $container_width - $grid_gutter_width ) . "px; }\n";
	}

	$output .= ".cherry-container.container,\n";
	$output .= ".cherry-boxed .site-header .container,\n";
	$output .= ".cherry-boxed .site-footer .container { max-width: {$container_width}px; width: auto; }\n";

	// Prepare a string with a styles.
	$output = trim( $output );

	if ( !empty( $output ) ) {

		// Print style if $output not empty.
		printf( "<style type='text/css'>\n%s\n</style>\n", $output );
	}
}