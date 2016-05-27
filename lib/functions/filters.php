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

// Filter the classes that are assigned to the body HTML element.
add_filter( 'body_class', 'cherry_add_body_control_classes', 10, 2 );

// Filter the list of CSS classes for the current page.
add_filter( 'post_class', 'cherry_add_page_control_classes', 10, 3 );

// Filter the containers class.
add_filter( 'cherry_get_header_class',    'cherry_get_header_classes' );
add_filter( 'cherry_get_content_class',   'cherry_get_content_classes' );
add_filter( 'cherry_get_footer_class',    'cherry_get_footer_classes' );
add_filter( 'cherry_get_container_class', 'cherry_get_container_classes' );

// Filter a sidebar visibility.
add_filter( 'cherry_display_sidebar',      'cherry_hide_sidebar', 9, 2 );
add_filter( 'cherry_display_sidebar_args', 'cherry_add_display_sidebar_args', 9, 2 );

// Filter an excerpt params.
add_filter( 'excerpt_length', 'cherry_excerpt_length', 999 );
add_filter( 'excerpt_more',   '__return_empty_string', 999 );

add_filter( 'cherry_pre_get_the_post_date',     'cherry_option_post_date',     10, 2 );
add_filter( 'cherry_pre_get_the_post_author',   'cherry_option_post_author',   10, 2 );
add_filter( 'cherry_pre_get_the_post_comments', 'cherry_option_post_comments', 10, 2 );
add_filter( 'cherry_pre_get_the_post_taxonomy', 'cherry_option_post_taxonomy', 10, 2 );
add_filter( 'cherry_pre_get_the_post_button',   'cherry_option_post_button',   10, 2 );

add_filter( 'cherry_pre_get_the_post_thumbnail', 'cherry_option_post_thumbnail', 10, 2 );
add_filter( 'cherry_pre_get_the_post_image',     'cherry_option_post_image',     10, 2 );
add_filter( 'cherry_pre_get_the_post_gallery',   'cherry_option_post_gallery',   10, 2 );
add_filter( 'cherry_pre_get_the_post_audio',     'cherry_option_post_audio',     10, 2 );
add_filter( 'cherry_pre_get_the_post_video',     'cherry_option_post_video',     10, 2 );
add_filter( 'cherry_pre_get_the_post_avatar',    'cherry_option_post_avatar',    10, 2 );

// Removed a live chats.
remove_filter( 'after_setup_theme', array( 'Cherry_Live_Chat_Class',    'get_instance' ), 11 );
remove_filter( 'after_setup_theme', array( 'Monstroid_Live_Chat_Class', 'get_instance' ), 11 );

// Add favicon tags to page
add_action( 'wp_head', 'cherry_favicon_tags' );

// Add popup video and image classes to embeded images into editor.
add_filter( 'media_send_to_editor', 'cherry_add_popup_classes_to_media', 10, 3 );

// Add mobile menu trigger to `Primary` nav menu.
add_filter( 'wp_nav_menu', 'cherry_add_mobile_menu_trigger', 10, 2 );

// Removed a live chats.
remove_filter( 'after_setup_theme', array( 'Cherry_Live_Chat_Class',    'get_instance' ), 11 );
remove_filter( 'after_setup_theme', array( 'Monstroid_Live_Chat_Class', 'get_instance' ), 11 );


function cherry_add_body_control_classes( $classes, $class ) {

	// Responsive.
	if ( 'true' == cherry_get_option( 'grid-responsive' ) ) {
		$classes[] = 'cherry-responsive';
	} else {
		$classes[] = 'cherry-no-responsive';
	}

	// Sidebar.
	if ( cherry_display_sidebar( apply_filters( 'cherry_get_main_sidebar', 'sidebar-main' ) ) ) {
		$classes[] = 'cherry-with-sidebar';
	} else {
		$classes[] = 'cherry-no-sidebar';
	}

	// Navigation Arrow.
	if ( 'true' == cherry_get_option( 'navigation-arrow' ) ) {
		$classes[] = 'cherry-navigation-arrow';
	}

	return $classes;
}

function cherry_add_page_control_classes( $classes, $class, $post_id ) {

	if ( ! is_page( $post_id ) ) {
		return $classes;
	}

	// Featured images?
	if ( 'true' == cherry_get_option( 'page-featured-images' ) ) {
		$classes[] = 'cherry-page-featured-images-on';
	}

	// Page comments?
	if ( 'true' == cherry_get_option( 'page-comments-status' ) ) {
		$classes[] = 'cherry-page-comments-on';
	}

	return $classes;
}

/**
 * Get header container class
 *
 * @since  4.0.0
 * @param  string $class user-defined container class.
 * @return string
 */
function cherry_get_header_classes( $class ) {

	$classes      = array();
	$classes[]    = $class;

	$grid_classes = cherry_prepare_grid_classes( 'header' );
	$classes      = array_merge( $classes, $grid_classes );

	$classes      = apply_filters( 'cherry_get_header_classes', $classes, $class );
	$classes      = array_unique( $classes );

	return join( ' ', $classes );
}

/**
 * Get main content container class
 *
 * @since  4.0.0
 * @param  string $class user-defined container class.
 * @return string
 */
function cherry_get_content_classes( $class ) {

	$classes      = array();
	$classes[]    = $class;

	$grid_classes = cherry_prepare_grid_classes( 'content' );
	$classes      = array_merge( $classes, $grid_classes );

	$classes      = apply_filters( 'cherry_get_content_classes', $classes, $class );
	$classes      = array_unique( $classes );

	return join( ' ', $classes );
}

/**
 * Get footer container class
 *
 * @since  4.0.0
 * @param  string $class user-defined container class.
 * @return string
 */
function cherry_get_footer_classes( $class ) {

	$classes      = array();
	$classes[]    = $class;

	$grid_classes = cherry_prepare_grid_classes( 'footer' );
	$classes      = array_merge( $classes, $grid_classes );

	$classes      = apply_filters( 'cherry_get_footer_classes', $classes, $class );
	$classes      = array_unique( $classes );

	return join( ' ', $classes );
}

/**
 * Prepare grid-related classes for container by location
 *
 * @since  4.0.5
 * @param  string $location currrent location (header, content or footer).
 * @return array
 */
function cherry_prepare_grid_classes( $location = null ) {

	$classes = array();

	if ( ! $location ) {
		return $classes;
	}

	$grid_type = cherry_current_page()->get_property( 'grid', $location );

	switch ( $grid_type ) {

		case 'wide':
			$classes[] = 'wide';
			break;

		case 'boxed':
			$classes[] = 'boxed';

			// Boxed & Container width.
			$container_width = intval( cherry_get_option( 'grid-container-width' ) );
			$boxed_width     = intval( cherry_get_option( $location . '-boxed-width' ) );

			if ( $boxed_width >= $container_width ) {
				$classes[] = 'extra-boxed';
			}

			break;

		default:
			break;
	}

	return $classes;
}

function cherry_get_container_classes( $class ) {
	$classes = array();

	$grid_type = cherry_current_page()->get_property( 'grid', 'content' );

	switch ( $grid_type ) {
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
	if ( did_action( 'cherry_footer' ) ) {
		return $display;
	}

	$sidebar_main      = apply_filters( 'cherry_get_main_sidebar', 'sidebar-main' );
	$sidebar_secondary = apply_filters( 'cherry_get_secondary_sidebar', 'sidebar-secondary' );

	$allowed_sidebars = array( $sidebar_main, $sidebar_secondary );
	$allowed_sidebars = apply_filters( 'cherry_hide_allowed_sidebars', $allowed_sidebars, $display, $id );

	if ( ! in_array( $id, $allowed_sidebars ) ) {
		return $display;
	}

	$layout = cherry_current_page()->get_property( 'layout' );

	if ( 'no-sidebar' == $layout ) {
		return false;
	}

	if ( $sidebar_main == $sidebar_secondary ) {
		static $cherry_sidebar_counter = 0;
	}

	if ( ( ( 'sidebar-content' == $layout ) || ( 'content-sidebar' == $layout ) )
		&& ( apply_filters( 'cherry_get_secondary_sidebar', 'sidebar-secondary' ) == $id )
		) {

		if ( isset( $cherry_sidebar_counter ) && ! $cherry_sidebar_counter ) {
			$cherry_sidebar_counter++;

			return $display;
		}

		return false;
	}

	return $display;
}

function cherry_add_display_sidebar_args( $sidebars, $id ) {

	if ( ! isset( $sidebars[ $id ] ) ) {
		$sidebars = array_merge( $sidebars, array( $id => new Cherry_Sidebar() ) );
	}

	return $sidebars;
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

function cherry_option_post_button( $display, $args ) {
	if ( ! is_singular() && ( 'false' == cherry_get_option( 'blog-button' ) ) ) {
		return '';
	}

	if ( ! is_singular() && ( '' == cherry_get_option( 'blog-button-text' ) ) ) {
		return '';
	}

	return $display;
}

function cherry_option_post_thumbnail( $display, $args ) {
	$post_id   = get_the_ID();
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

	if ( ! is_singular() ) {
		$args['size'] = cherry_get_option( 'blog-featured-images-size' );
	}

	return $display;
}

function cherry_option_post_image( $display, $args ) {
	return _cherry_post_media_visibility( $display, $args );
}

function cherry_option_post_gallery( $display, $args ) {
	return _cherry_post_media_visibility( $display, $args );
}

function cherry_option_post_audio( $display, $args ) {
	return _cherry_post_media_visibility( $display, $args );
}

function cherry_option_post_video( $display, $args ) {
	return _cherry_post_media_visibility( $display, $args );
}

function cherry_option_post_avatar( $display, $args ) {
	return _cherry_post_media_visibility( $display, $args );
}

function _cherry_post_media_visibility( $display, $args ) {

	if ( is_single( get_the_ID() ) && ( 'false' == cherry_get_option( 'blog-post-featured-image' ) ) ) {
		return '';
	}

	if ( ! is_single() && ( 'false' == cherry_get_option( 'blog-featured-images' ) ) ) {
		return '';
	}

	return $display;
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

/**
 * Add mobile triger for standard menu.
 *
 * @since 4.0.0
 * @since 4.0.5 Added the `aria-controls` attribute.
 *
 * @param string $menu Menu output.
 * @param object $args Menu arguments object.
 */
function cherry_add_mobile_menu_trigger( $menu, $args ) {

	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	if ( is_a( $args->walker, 'cherry_mega_menu_walker' ) ) {
		return $menu;
	}

	$label   = apply_filters( 'cherry_menu_mobile_label', __( 'Menu', 'cherry' ) );
	$trigger = '<button class="menu-primary_trigger" aria-expanded="false" aria-controls="menu-primary-items">' . esc_textarea( $label ) . '</button>';

	return $trigger . $menu;
}
