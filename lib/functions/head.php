<?php
/**
 * Functions for outputting common site data in the `<head>` area of a site.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Adds common theme items to <head>.
add_action( 'wp_head', 'cherry_meta_charset',  0 );
add_action( 'wp_head', 'cherry_doctitle',      0 );
add_action( 'wp_head', 'cherry_meta_viewport', 1 );
add_action( 'wp_head', 'cherry_link_pingback', 3 );

/**
 * Adds the meta charset to the header.
 *
 * @since  4.0.0
 */
function cherry_meta_charset() {
	echo "<meta charset=\"" . get_bloginfo( 'charset' ) . "\" />\n";
}

/**
 * Adds the title to the header.
 *
 * @since  4.0.0
 */
function cherry_doctitle() {
	printf( "<title> %s </title>\n", wp_title( ' : ', false ) );
}

/**
 * Adds the meta viewport to the header.
 *
 * @since  4.0.0
 */
function cherry_meta_viewport() {
	echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />\n";
}

/**
 * Adds the pingback link to the header.
 *
 * @since  4.0.0
 */
function cherry_link_pingback() {
	if ( 'open' === get_option( 'default_ping_status' ) )
		echo "<link rel=\"pingback\" href=\"" . get_bloginfo( 'pingback_url' ) . "\" />\n";
}