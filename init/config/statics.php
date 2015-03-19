<?php
/**
 * Cherry theme statics autoload configuration
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// add statics autoloader on init
add_action( 'init', 'cherry_static_autoload' );

/**
 * Autoload existing statics
 *
 * @since 4.0.0
 */
function cherry_static_autoload() {

	$child_dir = defined( 'CHILD_STATICS_DIR' ) ? CHILD_STATICS_DIR : PARENT_STATICS_DIR;

	$parent = array();
	$child  = array();

	if ( file_exists( PARENT_DIR . PARENT_STATICS_DIR ) && is_dir( PARENT_DIR . PARENT_STATICS_DIR ) ) {
		$parent = scandir( PARENT_DIR . PARENT_STATICS_DIR );
	}

	if ( file_exists( CHILD_DIR . $child_dir ) && is_dir( CHILD_DIR . $child_dir ) ) {
		$child = scandir( CHILD_DIR . $child_dir );
	}

	$parent = array_diff( $parent, array( '.', '..', 'index.php' ) );
	$child  = array_diff( $child, array( '.', '..', 'index.php' ) );

	$parent_statics = array();
	$child_statics  = array();

	// prepare parent static files
	if ( is_array( $parent ) ) {
		foreach ( $parent as $file ) {
			$parent_staics[$file] = PARENT_STATICS_DIR . $file;
		}
	}

	// prepare child static files
	if ( is_array( $child ) ) {
		foreach ( $child as $file ) {
			$child_statics[$file] = $child_dir . $file;
		}
	}
	// combine parent and child statics into single array
	$statics = array_merge( $parent_staics, $child_statics );

	if ( ! $statics || ! is_array( $statics ) ) {
		return false;
	}

	foreach ( $statics as $static_file => $static_path ) {
		cherry_require( $static_path );
	}
}