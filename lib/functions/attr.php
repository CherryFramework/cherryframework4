<?php
/**
 * HTML attribute functions and filters. The purposes of this is to provide a way for theme/plugin devs
 * to hook into the attributes for specific HTML elements and create new or modify existing attributes.
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  string $slug    The slug/ID of the element (e.g., 'sidebar').
 * @param  string $context A specific context (e.g., 'primary').
 */
function cherry_attr( $slug, $context = '' ) {
	echo cherry_get_attr( $slug, $context );
}

/**
 * Gets an HTML element's attributes. The purpose is to allow folks to modify, remove, or add any attributes they
 * want without having to edit every template file in the theme.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $attr
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $attr
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $attr
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $attr
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
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $attr
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array  $attr
 * @param  string $context
 * @return array
 */
function cherry_attr_sidebar( $attr, $context ) {

	if ( !empty( $context ) ) {
		$attr['id'] = "$context";
	}

	$attr['class'] = 'widget-area';
	$attr['role']  = 'complementary';

	return $attr;
}

/**
 * Nav menu attributes.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array  $attr
 * @param  string $context
 * @return array
 */
function cherry_attr_menu( $attr, $context ) {

	if ( !empty( $context ) ) {
		$attr['id']    = "menu-{$context}";
		$attr['class'] = "menu-{$context} menu";
	} else {
		$attr['class'] = 'menu';
	}

	$attr['role']  = 'navigation';

	return $attr;
}

/**
 * Post <article> element attributes.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $attr
 * @return array
 */
function cherry_attr_post( $attr ) {

	$post = get_post();

	// Make sure we have a real post first.
	if ( !empty( $post ) ) {

		$attr['id']    = 'post-' . get_the_ID();
		$attr['class'] = implode( ' ', get_post_class( 'clearfix' ) );

	} else {

		$attr['id']    = 'post-0';
		$attr['class'] = implode( ' ', get_post_class( 'clearfix' ) );
	}

	return $attr;
}

/**
 * Post terms (tags, categories, etc.) attributes.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array  $attr
 * @param  string $context
 * @return array
 */
function cherry_attr_entry_terms( $attr, $context ) {

	if ( !empty( $context ) ) {
		$attr['class'] = 'entry-terms ' . sanitize_html_class( $context );
	}

	return $attr;
}