<?php
/**
 * Sets up custom confguration for the theme. This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 */
add_action( 'after_setup_theme', 'cherry_theme_config', 11 );

/**
 * Load necessary config parts
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
		'static-areas'
	);

	// get from child theme disabled config statements array
	$disabled_statements = apply_filters( 'cherry_disable_config_statements', array() );

	$config_statements = array_diff( $config_statements, $disabled_statements );

	foreach ( $config_statements as $statement ) {
		cherry_require( PARENT_CONFIG_DIR . "$statement.php" );
	}

}

/**
 * add statics autoloader on init
 */
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

// Added class for Footer Sidebar widgets.
add_filter( 'cherry_sidebar_args', 'cherry_footer_sidebar_class' );

// Added wrap for Footer Sidebar widgets.
add_action( 'cherry_sidebar_footer_start', 'cherry_sidebar_footer_wrap_open' );
add_action( 'cherry_sidebar_footer_end', 'cherry_sidebar_footer_wrap_close' );

// Output classes for Secondary column.
// add_filter( 'cherry_attr_sidebar', 'cherry_sidebar_main_class', 10, 2 );

// Added class for Footer Sidebar widgets.
function cherry_footer_sidebar_class( $args ) {
	if ( 'sidebar-footer' === $args['id'] ) {
		$args['before_widget'] = preg_replace( '/class="/', "class=\"col-sm-3 ", $args['before_widget'], 1 );
	}

	return $args;
}

// Added wrap for Footer Sidebar widgets
function cherry_sidebar_footer_wrap_open() {
	echo "<div class='container'><div class='row'>";
}
function cherry_sidebar_footer_wrap_close() {
	echo "</div></div>";
}

/**
 * Output classes for Secondary column.
 *
 * @since 4.0.0
 *
 * @return string Classes name
 */
function cherry_sidebar_main_class( $attr, $context ) {
	if ( 'secondary' === $context ) {
		$attr['class'] .= ' ' . apply_filters( 'cherry_sidebar_main_class', 'col-sm-4' );
	}

	return $attr;
}