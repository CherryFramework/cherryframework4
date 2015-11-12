<?php
/**
 * HTML attribute functions and filters. The purposes of this is to provide a way for theme/plugin devs
 * to hook into the attributes for specific HTML elements and create new or modify existing attributes.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2008 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/hybrid-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'cherry_attr_body',    'cherry_attr_body',    9 );
add_filter( 'cherry_attr_header',  'cherry_attr_header',  9 );
add_filter( 'cherry_attr_footer',  'cherry_attr_footer',  9 );
add_filter( 'cherry_attr_content', 'cherry_attr_content', 9 );
add_filter( 'cherry_attr_main',    'cherry_attr_main',    9 );
add_filter( 'cherry_attr_sidebar', 'cherry_attr_sidebar', 9, 2 );
add_filter( 'cherry_attr_menu',    'cherry_attr_menu',    9, 2 );
add_filter( 'cherry_attr_post',    'cherry_attr_post',    9 );

add_filter( 'cherry_attr_entry-terms', 'cherry_attr_entry_terms', 9, 2 );

/**
 * Outputs an HTML element's attributes.
 *
 * @since 4.0.0
 * @param string $slug    The slug/ID of the element (e.g., 'sidebar').
 * @param string $context A specific context (e.g., 'primary').
 */
function cherry_attr( $slug, $context = '' ) {
	echo cherry_get_attr( $slug, $context );
}

/**
 * Gets an HTML element's attributes. The purpose is to allow folks to modify, remove, or add any attributes they
 * want without having to edit every template file in the theme.
 *
 * @since  4.0.0
 * @param  string $slug    The slug/ID of the element (e.g., 'sidebar').
 * @param  string $context A specific context (e.g., 'primary').
 * @return string
 */
function cherry_get_attr( $slug, $context = '' ) {
	$output = '';
	$attr   = apply_filters( "cherry_attr_{$slug}", array(), $context );

	if ( empty( $attr ) ) {
		$attr['class'] = $slug;
	}

	foreach ( $attr as $name => $value ) {
		$output .= !empty( $value ) ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
	}

	return trim( $output );
}

/**
 * <body> element attributes.
 *
 * @since  4.0.0
 * @param  array $attr Set of attributes.
 * @return array
 */
function cherry_attr_body( $attr ) {
	$attr['class'] = implode( ' ', get_body_class() );
	$attr['dir']   = is_rtl() ? 'rtl' : 'ltr';

	return $attr;
}

/**
 * Page <header> element attributes.
 *
 * @since  4.0.0
 * @param  array $attr Set of attributes.
 * @return array
 */
function cherry_attr_header( $attr ) {
	$attr['id']    = 'header';
	$attr['class'] = apply_filters( 'cherry_get_header_class', 'site-header' );
	$attr['role']  = 'banner';

	return $attr;
}

/**
 * Page <footer> element attributes.
 *
 * @since  4.0.0
 * @param  array $attr Set of attributes.
 * @return array
 */
function cherry_attr_footer( $attr ) {
	$attr['id']    = 'footer';
	$attr['class'] = apply_filters( 'cherry_get_footer_class', 'site-footer' );
	$attr['role']  = 'contentinfo';

	return $attr;
}

/**
 * Main content container of the page attributes.
 *
 * @since  4.0.0
 * @param  array $attr Set of attributes.
 * @return array
 */
function cherry_attr_main( $attr ) {
	$attr['id']    = 'main';
	$attr['class'] = 'site-main';
	$attr['role']  = 'main';

	return $attr;
}

/**
 * Main content container of the page attributes.
 *
 * @since  4.0.0
 * @param  array $attr Set of attributes.
 * @return array
 */
function cherry_attr_content( $attr ) {
	$attr['id']    = 'content';
	$attr['class'] = apply_filters( 'cherry_get_content_class', 'site-content' );

	return $attr;
}

/**
 * Sidebar attributes.
 *
 * @since  4.0.0
 * @param  array  $attr    Set of attributes.
 * @param  string $context A specific context (e.g., 'main').
 * @return array
 */
function cherry_attr_sidebar( $attr, $context ) {
	$sidebar_main      = apply_filters( 'cherry_get_main_sidebar', 'sidebar-main' );
	$sidebar_secondary = apply_filters( 'cherry_get_secondary_sidebar', 'sidebar-secondary' );

	$attr['class'] = "{$context} widget-area";
	$attr['role']  = 'complementary';

	if ( did_action( 'cherry_footer' ) ) {
		return $attr;
	}

	switch ( $context ) {
		case $sidebar_main:
			$attr['class'] = "cherry-sidebar-main {$attr['class']}";
			break;

		case $sidebar_secondary:
			$attr['class'] = "cherry-sidebar-secondary {$attr['class']}";
			break;

		default:
			break;
	}

	return $attr;
}

/**
 * Nav menu attributes.
 *
 * @since  4.0.0
 * @param  array  $attr    Set of attributes.
 * @param  string $context A specific context (e.g., 'primary').
 * @return array
 */
function cherry_attr_menu( $attr, $context ) {
	$attr['class'] = 'menu';
	$attr['role']  = 'navigation';

	if ( ! empty( $context ) ) {
		$attr['id']    = "menu-{$context}";
		$attr['class'] = "menu-{$context} menu";
	}

	return $attr;
}

/**
 * Post <article> element attributes.
 *
 * @since  4.0.0
 * @param  array $attr Set of attributes.
 * @return array
 */
function cherry_attr_post( $attr ) {
	$post         = get_post();
	$meta_classes = array();
	$classes      = array();
	$classes[]    = 'clearfix';

	if ( 'true' == cherry_get_option( 'blog-post-date' ) ) {
		$meta_classes[] = 'cherry-has-entry-date';
	}

	if ( 'true' == cherry_get_option( 'blog-post-author' ) ) {
		$meta_classes[] = 'cherry-has-entry-author';
	}

	if ( 'true' == cherry_get_option( 'blog-post-comments' ) ) {
		$meta_classes[] = 'cherry-has-entry-comments';
	}

	if ( 'true' == cherry_get_option( 'blog-categories' ) ) {
		$meta_classes[] = 'cherry-has-entry-cats';
	}

	if ( 'true' == cherry_get_option( 'blog-tags' ) ) {
		$meta_classes[] = 'cherry-has-entry-tags';
	}

	$meta_classes = array_unique( $meta_classes );

	if ( is_singular() ) {

		// Single post.
		if ( 'post' == get_post_type() ) {
			$classes = wp_parse_args( $classes, $meta_classes );
		}

	} else {
		// Blog, Search page, Archive pages.
		$classes = wp_parse_args( $classes, $meta_classes );
	}

	$attr['class'] = implode( ' ', get_post_class( $classes ) );

	// Make sure we have a real post first.
	if ( ! empty( $post ) ) {
		$attr['id'] = 'post-' . get_the_ID();
	} else {
		$attr['id'] = 'post-0';
	}

	return $attr;
}

/**
 * Post terms (tags, categories, etc.) attributes.
 *
 * @since  4.0.0
 * @param  array  $attr    Set of attributes.
 * @param  string $context A specific context (e.g., 'primary').
 * @return array
 */
function cherry_attr_entry_terms( $attr, $context ) {

	if ( ! empty( $context ) ) {
		$attr['class'] = 'entry-terms ' . sanitize_html_class( $context );
	}

	return $attr;
}
