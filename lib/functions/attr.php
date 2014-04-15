<?php
/**
 * HTML attribute functions and filters. The purposes of this is to provide a way for theme/plugin devs
 * to hook into the attributes for specific HTML elements and create new or modify existing attributes.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

add_filter( 'cherry_attr_header',  'cherry_attr_header',  9 );
add_filter( 'cherry_attr_footer',  'cherry_attr_footer',  9 );
add_filter( 'cherry_attr_content', 'cherry_attr_content', 9 );
add_filter( 'cherry_attr_sidebar', 'cherry_attr_sidebar', 9, 2 );
add_filter( 'cherry_attr_menu',    'cherry_attr_menu',    9, 2 );

/**
 * Outputs an HTML element's attributes.
 *
 * @since  4.0.0
 * @param  string $slug       The slug/ID of the element (e.g., 'sidebar').
 * @param  string $context    A specific context (e.g., 'primary').
 * @param  array  $attributes Custom attributes to pass in.
 * @return void
 */
function cherry_attr( $slug, $context = '', $attributes = array() ) {
	echo cherry_get_attr( $slug, $context, $attributes );
}

/**
 * Gets an HTML element's attributes. The purpose is to allow folks to modify, remove, or add any attributes they
 * want without having to edit every template file in the theme.
 *
 * @since  4.0.0
 * @param  string $slug       The slug/ID of the element (e.g., 'sidebar').
 * @param  string $context    A specific context (e.g., 'primary').
 * @param  array  $attributes Custom attributes to pass in.
 * @return string
 */
function cherry_get_attr( $slug, $context = '', $attributes = array() ) {
	$output = '';
	$attr   = apply_filters( "cherry_attr_{$slug}", $attributes, $context );

	if ( empty( $attr ) ) {
		$attr['class'] = $slug;
	}

	foreach ( $attr as $name => $value ) {
		$output .= !empty( $value ) ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
	}

	return trim( $output );
}

/* === Structural === */

/**
 * Page <header> element attributes.
 *
 * @since  4.0.0
 * @param  array $attr
 * @return array
 */
function cherry_attr_header( $attr ) {
	$attr['id']    = 'header';
	$attr['class'] = 'site-header';
	$attr['role']  = 'banner';

	return $attr;
}

/**
 * Page <footer> element attributes.
 *
 * @since  4.0.0
 * @param  array $attr
 * @return array
 */
function cherry_attr_footer( $attr ) {
	$attr['id']    = 'footer';
	$attr['class'] = 'site-footer';
	$attr['role']  = 'contentinfo';

	return $attr;
}

/**
 * Main content container of the page attributes.
 *
 * @since  4.0.0
 * @param  array $attr
 * @return array
 */
function cherry_attr_content( $attr ) {
	$attr['id']    = 'main';
	$attr['class'] = 'site-main';
	$attr['role']  = 'main';

	return $attr;
}

/**
 * Sidebar attributes.
 *
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
 * @since  4.0.0
 * @param  array  $attr
 * @param  string $context
 * @return array
 */
function cherry_attr_menu( $attr, $context ) {

	if ( !empty( $context ) )
		$attr['id'] = "{$context}";

	$attr['class']     = 'main-navigation';
	$attr['role']      = 'navigation';

	return $attr;
}