<?php
/**
 * Sets up custom confguration for the theme. This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Load necessary config parts.
 *
 * @since 4.0.0
 */
function cherry_theme_config() {

	$config_statements = array(
		'theme-scripts',
		'theme-styles',
		'content-width',
		'post-formats',
		'thumbnails',
		'post-type-support',
		'menus',
		'sidebars',
		'display-sidebars',
		'static-areas',
		'title-tag'
	);

	// Get from child theme disabled config statements array.
	$disabled_statements = apply_filters( 'cherry_disable_config_statements', array() );

	$config_statements = array_diff( $config_statements, $disabled_statements );

	foreach ( $config_statements as $statement ) {
		cherry_require( PARENT_CONFIG_DIR . "$statement.php" );
	}

}

/**
 * Add statics autoloader on init.
 */
add_action( 'init', 'cherry_static_autoload', 11 );

/**
 * Autoload existing statics.
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
			$parent_statics[$file] = PARENT_STATICS_DIR . $file;
		}
	}

	// prepare child static files
	if ( is_array( $child ) ) {
		foreach ( $child as $file ) {
			$child_statics[$file] = $child_dir . $file;
		}
	}
	// combine parent and child statics into single array
	$statics = array_merge( (array)$parent_statics, $child_statics );

	if ( ! $statics || ! is_array( $statics ) ) {
		return false;
	}

	foreach ( $statics as $static_file => $static_path ) {
		cherry_require( $static_path );
	}

}