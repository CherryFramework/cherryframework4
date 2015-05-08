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

// Filters the containers class.
add_filter( 'cherry_get_header_class',   'cherry_get_header_classes' );
add_filter( 'cherry_get_content_class',  'cherry_get_content_classes' );
add_filter( 'cherry_get_footer_class',   'cherry_get_footer_classes' );
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

// Add popup videa and image classes to embeded images into editor
add_filter( 'media_send_to_editor', 'cherry_add_popup_classes_to_media', 10, 3 );


// Add specific CSS class by filter.
function cherry_add_control_classes( $classes ) {
	$object_id = get_queried_object_id();

	$layout = get_post_meta( $object_id, 'cherry_layout', true );

	if ( empty( $layout ) || ( 'default-layout' == $layout ) ) {
		$layout = cherry_get_option( 'page-layout' );
	}

	// $defaults   = array( 'header' => '', 'content' => '', 'footer' => '' );
	// $grid_types = get_post_meta( $object_id, 'cherry_grid_type', true );
	// $grid_types = wp_parse_args( $grid_types, $defaults );

	// foreach ( $grid_types as $key => $grid_type ) {
	// 	if ( empty( $grid_type ) || ( 'default-grid-type' == $grid_type ) ) {
	// 		$grid_types[ $key ] = cherry_get_option( "{$key}-grid-type" );
	// 	}
	// }

	// Responsive.
	if ( 'true' == cherry_get_option( 'grid-responsive' ) ) {
		$classes[] = 'cherry-responsive';
	} else {
		$classes[] = 'cherry-no-responsive';
	}

	// Sidebar Position.
	$classes[] = sanitize_html_class( 'cherry-blog-layout-' . $layout );

	// Sidebar.
	if ( cherry_display_sidebar( 'sidebar-main' ) ) {
		$classes[] = 'cherry-with-sidebar';
	} else {
		$classes[] = 'cherry-no-sidebar';
	}

	// // Grid type.
	// foreach ( $grid_types as $key => $grid_type ) {
	// 	$classes[] = sanitize_html_class( "cherry-{$key}-{$grid_type}" );
	// }

	return $classes;
}

function cherry_get_header_classes( $class ) {
	$classes   = array();
	$classes[] = $class;

	// Gets a single value.
	$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );

	if ( empty( $grid_type['header'] ) || ( 'default-grid-type' == $grid_type['header'] ) ) {
		$grid_type['header'] = cherry_get_option( 'header-grid-type' );
	}

	switch ( $grid_type['header'] ) {
		case 'wide':
			$classes[] = 'wide';
			break;

		case 'boxed':
			$classes[] = 'boxed';

			// Boxed & Container width.
			$container_width = intval( cherry_get_option( 'grid-container-width' ) );
			$boxed_width     = intval( cherry_get_option( 'header-boxed-width' ) );

			if ( $boxed_width < $container_width ) {
				$boxed_width = $container_width;
			} else {
				$classes[] = 'extra-boxed';
			}

			break;

		default:
			break;
	}

	$classes = apply_filters( 'cherry_get_header_classes', $classes, $class );
	$classes = array_unique( $classes );

	return join( ' ', $classes );
}

function cherry_get_content_classes( $class ) {
	$classes   = array();
	$classes[] = $class;

	// Gets a single value.
	$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );

	if ( empty( $grid_type['content'] ) || ( 'default-grid-type' == $grid_type['content'] ) ) {
		$grid_type['content'] = cherry_get_option( 'content-grid-type' );
	}

	switch ( $grid_type['content'] ) {
		case 'wide':
			$classes[] = 'wide';
			break;

		case 'boxed':
			$classes[] = 'boxed';

			// Boxed & Container width.
			$container_width = intval( cherry_get_option( 'grid-container-width' ) );
			$boxed_width     = intval( cherry_get_option( 'content-boxed-width' ) );

			if ( $boxed_width < $container_width ) {
				$boxed_width = $container_width;
			} else {
				$classes[] = 'extra-boxed';
			}

			break;

		default:
			break;
	}

	$classes = apply_filters( 'cherry_get_content_classes', $classes, $class );
	$classes = array_unique( $classes );

	return join( ' ', $classes );
}

function cherry_get_footer_classes( $class ) {
	$classes   = array();
	$classes[] = $class;

	// Gets a single value.
	$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );

	if ( empty( $grid_type['footer'] ) || ( 'default-grid-type' == $grid_type['footer'] ) ) {
		$grid_type['footer'] = cherry_get_option( 'footer-grid-type' );
	}

	switch ( $grid_type['footer'] ) {
		case 'wide':
			$classes[] = 'wide';
			break;

		case 'boxed':
			$classes[] = 'boxed';

			// Boxed & Container width.
			$container_width = intval( cherry_get_option( 'grid-container-width' ) );
			$boxed_width     = intval( cherry_get_option( 'footer-boxed-width' ) );

			if ( $boxed_width < $container_width ) {
				$boxed_width = $container_width;
			} else {
				$classes[] = 'extra-boxed';
			}

			break;

		default:
			break;
	}

	$classes = apply_filters( 'cherry_get_footer_classes', $classes, $class );
	$classes = array_unique( $classes );

	return join( ' ', $classes );
}

function cherry_get_container_classes( $class ) {
	$classes = array();

	// Gets a single value.
	$grid_type = get_post_meta( get_queried_object_id(), 'cherry_grid_type', true );

	if ( empty( $grid_type['content'] ) || ( 'default-grid-type' == $grid_type['content'] ) ) {
		$grid_type['content'] = cherry_get_option( 'content-grid-type' );
	}

	switch ( $grid_type['content'] ) {
		case 'wide':
			$classes[] = 'container-fluid';
			break;

		case 'boxed':
			$classes[] = 'container';
			break;

		default:
			$classes[] = $class;
			break;
	}

	$classes = apply_filters( 'cherry_get_container_classes', $classes, $class );
	$classes = array_unique( $classes );

	return join( ' ', $classes );
}

function cherry_hide_sidebar( $display, $id ) {
	$skip_sidebars = apply_filters( 'cherry_skip_hidden_sidebars', array(
		'sidebar-footer-1',
		'sidebar-footer-2',
		'sidebar-footer-3',
		'sidebar-footer-4',
	), $display, $id );

	if ( in_array( $id, $skip_sidebars ) ) {
		return $display;
	}

	$layout = get_post_meta( get_queried_object_id(), 'cherry_layout', true );

	if ( !$layout || ( 'default-layout' == $layout ) ) {
		$layout = cherry_get_option( 'page-layout' );
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
		if ( is_page( $post_id ) && ( 'false' == cherry_get_option( 'page-featured-images' ) ) ) {
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
	$responsive = cherry_get_option( 'grid-responsive' );
	$output     = '';

	// Boxed & Container width.
	$container_width     = intval( cherry_get_option( 'grid-container-width' ) );
	$header_boxed_width  = intval( cherry_get_option( 'header-boxed-width' ) );
	$content_boxed_width = intval( cherry_get_option( 'content-boxed-width' ) );
	$footer_boxed_width  = intval( cherry_get_option( 'footer-boxed-width' ) );

	$header_boxed_width  = ( $header_boxed_width < $container_width ) ? $container_width : $header_boxed_width;
	$content_boxed_width = ( $content_boxed_width < $container_width ) ? $container_width : $content_boxed_width;
	$footer_boxed_width  = ( $footer_boxed_width < $container_width ) ? $container_width : $footer_boxed_width;

	$output .= ".site-header.boxed { max-width: {$header_boxed_width}px; }\n";
	$output .= ".site-content.boxed { max-width: {$content_boxed_width}px; }\n";
	$output .= ".site-footer.boxed { max-width: {$footer_boxed_width}px; }\n";

	$output .= ".site-header .container,\n";
	$output .= ".site-content > .container,\n";
	$output .= ".site-footer .container { max-width: {$container_width}px; width: auto; }\n";

	if ( 'false' == $responsive ) {
		$output .= "body { min-width: {$container_width}px; }\n";
	} else {
		$output = "@media (min-width: {$container_width}px) {\n" . $output;
		$output .= "}\n";
	}

	// Prepare a string with a styles.
	$output = trim( $output );

	if ( !empty( $output ) ) {

		// Print style if $output not empty.
		printf( "<style type='text/css'>\n%s\n</style>\n", $output );
	}
}

/**
 * Add popup classes to media links in editor
 *
 * @since  4.0.0
 *
 * @param  string $html       media markup to indert
 * @param  int    $id         media ID
 * @param  array  $attachment media data
 */
function cherry_add_popup_classes_to_media( $html, $id, $attachment ) {

	$img_reg   = '/[\'\"]{1}[^\s]+(\.(?i)(jpe?g|png|gif|bmp))[\'\"]{1}/';
	$video_reg = '/(https?:\/\/www\.youtube\.com\/watch\?v=[a-zA-Z0-9-_]+)|(https?:\/\/vimeo\.com\/[a-zA-Z0-9-_]+)/';

	$link_reg = "/<a[^>]*>/";
	$found    = preg_match( $link_reg, $html, $a_elem );

	// If no link, do nothing
	if ( ! $found ) {
		return $html;
	}

	$a_elem = $a_elem[0];

	if ( preg_match( $img_reg, $a_elem ) ) { // Check if is direct link to image
		$html = cherry_safe_add_class( $html, $a_elem, 'single-popup-image' );
	} elseif ( preg_match( $video_reg, $a_elem ) ) { // Check if is direct link to youtube or vimeo video
		$html = cherry_safe_add_class( $html, $a_elem, 'single-popup-video' );
	}

	return $html;

}

/**
 * Servise function to add CSS class to link
 *
 * @since  4.0.0
 *
 * @param  string $html  input HTML
 * @param  string $link  child link HTML to add class
 * @param  string $class CSS class to add
 */
function cherry_safe_add_class( $html, $link, $class ) {

	if ( ! $html || ! $class ) {
		return false;
	}

	if ( false !== strstr( $link, "class=\"" ) ) {
		// If link already has class defined inject it to attribute
		$link_new = str_replace( "class=\"", "class=\"$class ", $link );
		$html     = str_replace( $link, $link_new, $html );
	} else {
		// If no class defined, just add class attribute
		$html = str_replace( "<a ", "<a class=\"$class\" ", $html );
	}

	return $html;

}