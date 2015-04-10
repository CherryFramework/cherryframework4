<?php
/**
 * The core functions file for the Cherry_Framework. Functions defined here are generally
 * used across the entire framework to make various tasks faster. This file should be loaded
 * prior to any other files because its functions are needed to run the framework.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
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
 * Defines the theme prefix.
 *
 * @since  4.0.0
 * @global object $cherry         The global Cherry_Framework object.
 * @return string $cherry->prefix The prefix of the theme.
 */
function cherry_get_prefix() {
	global $cherry;

	// If the global prefix isn't set, define it. Plugin/theme authors may also define a custom prefix.
	if ( empty( $cherry->prefix ) ) {

		$prefix = ( is_child_theme() ) ? get_stylesheet() : get_template();
		$prefix = preg_replace( '/\W/', '_', strtolower( $prefix ) );
		$prefix .= '-';

		$cherry->prefix = sanitize_key( apply_filters( 'cherry_prefix', $prefix ) );
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

/**
 * Safely get value from arry by key
 *
 * @since  4.0.0
 * @param  array   $array    array to search value in
 * @param  string  $key      key
 * @param  mixed   $default  default value to return if key not found in array
 * @return mixed             value from array ar default if nothing found
 */
function cherry_esc_value( $array, $key, $default = false ) {

	if ( ! $array || ! is_array( $array ) ) {
		return $default;
	}

	if ( isset( $array[$key] ) ) {

		return $array[$key];
	}

	return $default;
}

/**
 * Load and evaluates the specified file.
 * Previously search file with in child theme, then in framework,
 * so you can easly overload needed file in your child theme
 *
 * @since  4.0.0
 *
 * @param  string  $path  file path, relative to theme directory
 */
function cherry_require( $path ) {

	if ( defined( 'CHILD_DIR' ) ) {
		$child_dir = CHILD_DIR;
	} else {
		$child_dir = get_stylesheet_directory();
	}

	$abspath = preg_replace( '#/+#', '/', trailingslashit( $child_dir ) . $path );

	// if file found in child theme - include it and break function
	if ( file_exists( $abspath ) ) {
		require_once $abspath;
		return;
	}

	// if file was not found in child theme - search it in parent
	if ( defined( 'PARENT_DIR' ) ) {
		$parent_dir = PARENT_DIR;
	} else {
		$parent_dir = get_template_directory();
	}

	$abspath = preg_replace( '#/+#', '/', trailingslashit( $parent_dir ) . $path );

	if ( file_exists( $abspath ) ) {
		require_once $abspath;
		return;
	}

	// if file was not found at all - die with message
	$message = sprintf( __( 'File %s doesn\'t exist', 'cherry' ), $abspath );
	$title   = __( 'Doing it wrong', 'cherry' );
	wp_die( $message, $title );
}

/**
 * Compare child theme Cherry version and current Cherry version.
 * Returns 0, if child theme version equal framework version
 * Returns -1, if child theme version greater than frammework
 * Returns 1, if framework version greater than child theme
 *
 * @since  4.0.0
 *
 * @return int
 */
function cherry_version_compare() {

	$child_data = get_file_data(
		trailingslashit( CHILD_DIR ) . 'style.css',
		array( 'CherryVersion' => 'Cherry Version' )
	);

	$cherry_child_version = ( ! empty( $child_data['CherryVersion'] ) ) ? $child_data['CherryVersion'] : 0;

	return version_compare( CHERRY_VERSION, $cherry_child_version );
}