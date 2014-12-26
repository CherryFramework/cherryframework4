<?php
/**
 * Functions for handling stylesheets in the framework. Themes can add support for the
 * 'cherry-styles' feature to allow the framework to handle loading the stylesheets into the
 * theme header at an appropriate point.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Register Cherry Framework styles.
add_action( 'wp_enqueue_scripts', 'cherry_register_styles', 0 );

// Load Cherry Framework styles.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_styles', 5 );

// Load theme style.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_theme_style', 11 );

/**
 * Registers stylesheets for the framework. This function merely registers styles with WordPress using
 * the wp_register_style() function. It does not load any stylesheets on the site. If a theme wants to
 * register its own custom styles, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @since  4.0.0
 */
function cherry_register_styles() {

	// Get framework styles.
	$styles = cherry_get_styles();

	// Get the active theme stylesheet version.
	$version = wp_get_theme()->get( 'Version' );
	// $prefix  = cherry_get_prefix( true );
	$prefix  = cherry_get_prefix();

	// Loop through each style and register it.
	foreach ( $styles as $style => $args ) {

		$defaults = array(
			'handle'  => $prefix . $style,
			'src'     => trailingslashit( CHILD_URI ) . "assets/css/{$style}.css",
			'deps'    => null,
			'version' => $version,
			'media'   => 'all'
		);

		$args = wp_parse_args( $args, $defaults );

		wp_register_style(
			sanitize_key( $args['handle'] ),
			esc_url( $args['src'] ),
			is_array( $args['deps'] ) ? $args['deps'] : null,
			preg_replace( '/[^a-z0-9_\-.]/', '', strtolower( $args['version'] ) ),
			esc_attr( $args['media'] )
		);
	}
}

/**
 * Tells WordPress to load the styles needed for the framework using the wp_enqueue_style() function.
 *
 * @since  4.0.0
 */
function cherry_enqueue_styles() {

	// Get the theme-supported stylesheets.
	$supports = get_theme_support( 'cherry-styles' );

	// If the theme doesn't add support for any styles, return.
	if ( !is_array( $supports[0] ) )
		return;

	// Get framework styles.
	$styles = cherry_get_styles();

	// Get prefix.
	// $prefix = cherry_get_prefix( true );
	$prefix = cherry_get_prefix();

	// Loop through each of the core framework styles and enqueue them if supported.
	foreach ( $supports[0] as $style ) {

		if ( isset( $styles[ $style ]['handle'] ) ) {
			wp_enqueue_style( $styles[ $style ]['handle'] );
		} else {
			wp_enqueue_style( $prefix . $style );
		}
	}
}

function cherry_enqueue_theme_style() {
	// wp_enqueue_style( cherry_get_prefix( true ) . 'style' );
	wp_enqueue_style( cherry_get_prefix() . 'style' );
}

/**
 * Returns an array of the core framework's available styles for use in themes.
 *
 * @since  4.0.0
 * @return array $styles All the available framework styles.
 */
function cherry_get_styles() {
	// Responsive grid?
	$responsive      = cherry_get_option('grid-responsive');
	$grid_responsive = ( 'true' == $responsive  ) ? array( 'src' => trailingslashit( CHILD_URI ) . 'assets/css/grid-responsive.css' ) : array( 'src' => false );

	// Default styles available.
	$styles = array(
		'main'            => array( 'src' => trailingslashit( CHILD_URI ) . 'assets/css/main.css' ),
		'grid-base'       => array( 'src' => trailingslashit( CHILD_URI ) . 'assets/css/grid-base.css' ),
		'grid-responsive' => $grid_responsive,
		'drop-downs'      => array(
			'handle'  => get_template() . '-drop-downs',
			'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/drop-downs.css',
			'version' => CHERRY_VERSION,
		),
		'add-ons' => array(
			'handle'  => get_template() . '-add-ons',
			'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/add-ons.css',
			'version' => CHERRY_VERSION,
		),
		'style'   => array( 'src' => get_stylesheet_uri() ),
	);

	/**
	 * Filters the array of styles.
	 *
	 * @since 4.0.0
	 * @param array $styles
	 */
	return apply_filters( 'cherry_get_styles', $styles );
}