<?php
/**
 * The core functions file for the Cherry_Framework. Functions defined here are generally
 * used across the entire framework to make various tasks faster. This file should be loaded
 * prior to any other files because its functions are needed to run the framework.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Allows theme developers to set a definite prefix for their theme. If this isn't set, the framework
 * will assume the prefix is the value of 'get_template()'. This should be called early, such as in
 * the theme setup function.
 *
 * @since  4.0.0
 * @global object $cherry The global Cherry_Framework object.
 * @param  string $prefix
 */
function cherry_set_prefix( $prefix ) {
	global $cherry;

	$cherry->prefix = sanitize_key( apply_filters( 'cherry_prefix', $prefix ) );
}

/**
 * Defines the theme prefix. This allows developers to infinitely change the theme. In theory,
 * one could use the Cherry_Framework core to create their own theme or filter 'cherry_prefix' with a
 * plugin to make it easier to use hooks across multiple themes without having to figure out
 * each theme's hooks (assuming other themes used the same system).
 *
 * @since  4.0.0
 * @global object $cherry         The global Cherry_Framework object.
 * @return string $cherry->prefix The prefix of the theme.
 */
function cherry_get_prefix() {
	global $cherry;

	// If the global prefix isn't set, define it. Plugin/theme authors may also define a custom prefix.
	if ( empty( $cherry->prefix ) ) {
		$cherry->prefix = sanitize_key( apply_filters( 'cherry_prefix', get_template() ) );
	}

	return $cherry->prefix;
}

/**
 * Function for setting the content width of a theme. This does not check if a content width has been set; it
 * simply overwrites whatever the content width is.
 *
 * @since  4.0.0
 * @global int    $content_width The width for the theme's content area.
 * @param  int    $width         Numeric value of the width to set.
 */
function cherry_set_content_width( $width = '' ) {
	global $content_width;

	$content_width = absint( $width );
}

/**
 * Function for getting the theme's content width.
 *
 * @since  4.0.0
 * @global int   $content_width The width for the theme's content area.
 * @return int   $content_width
 */
function cherry_get_content_width() {
	global $content_width;

	return $content_width;
}

function cherry_get_container_class( $location ) {
	global $cherry_layout;

	if ( 'wide' === $cherry_layout ) {
		$class = 'container';
	} elseif ( 'boxed' === $cherry_layout ) {
		$class = 'container-fluid';
	}

	if ( cherry_display_sidebar( 'sidebar-main' ) ) {
		$class = 'container-fluid';
	}

	$class .= ' container-' . sanitize_html_class( $location );

	/**
	 * Filters a class for container.
	 *
	 * @since 4.0.0
	 * @param string $class    HTML-class for container.
	 * @param string $location A container location.
	 */
	$class = apply_filters( 'cherry_get_container_class', $class, $location );

	return esc_attr( trim( $class ) );
}