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
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_styles', 10 );

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

	// Loop through each style and register it.
	foreach ( $styles as $style ) {
		wp_register_style(
			sanitize_key( $style['handle'] ),
			esc_url( $style['src'] ),
			null,
			preg_replace( '/[^a-z0-9_\-.]/', '', strtolower( $style['version'] ) ),
			'all'
		);
	}
}

/**
 * Tells WordPress to load the styles needed for the framework using the wp_enqueue_style() function.
 *
 * @since  4.0.0
 */
function cherry_enqueue_styles() {
	// Get framework styles.
	$styles = cherry_get_styles();

	// Loop through each of the core framework styles and enqueue them if supported.
	foreach ( $styles as $style ) {
		wp_enqueue_style( $style );
	}
}

/**
 * Returns an array of the core framework's available styles for use in themes.
 *
 * @since  4.0.0
 * @return array $styles All the available framework styles.
 */
function cherry_get_styles() {
	// Get the theme prefix.
	$prefix = cherry_get_prefix();

	// Get the active theme stylesheet version.
	$version = wp_get_theme()->get( 'Version' );

	// Get the theme-supported stylesheets.
	$supports = get_theme_support( 'cherry-styles' );

	// If the theme support for any styles.
	if ( is_array( $supports[0] ) ) :

		// Responsive grid?
		$responsive = cherry_get_option( 'grid-responsive' );

		$grid_responsive = ( 'true' == $responsive ) ?
			array(
				'handle'  => $prefix . 'grid-responsive',
				'src'     => trailingslashit( CHILD_URI ) . 'assets/css/grid-responsive.css',
				'version' => $version,
			) : false;

		// Default styles.
		$defaults = apply_filters( 'cherry_get_styles_defaults', array(
			'main' => array(
				'handle'  => $prefix . 'main',
				'src'     => trailingslashit( CHILD_URI ) . 'assets/css/main.css',
				'version' => $version,
			),
			'grid-base' => array(
				'handle'  => $prefix . 'grid-base',
				'src'     => trailingslashit( CHILD_URI ) . 'assets/css/grid-base.css',
				'version' => $version,
			),
			'grid-responsive' => $grid_responsive,
			'drop-downs' => array(
				'handle'  => get_template() . '-drop-downs',
				'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/drop-downs.css',
				'version' => CHERRY_VERSION,
			),
			'add-ons' => array(
				'handle'  => get_template() . '-add-ons',
				'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/add-ons.css',
				'version' => CHERRY_VERSION,
			),
			'style' => array(
				'handle'  => $prefix . 'style',
				'src'     => get_stylesheet_uri(),
				'version' => $version,
			),
		) );

		$styles = array();
		foreach ( $supports[0] as $s ) {

			if ( empty( $defaults[ $s ] ) ) {
				continue;
			}

			if ( !is_array( $defaults[ $s ] ) ) {
				continue;
			}

			$styles[ $s ] = $defaults[ $s ];
		}

	endif;

	// Add the main stylesheet (this must be included).
	$styles['style'] = array(
		'handle'  => $prefix . 'style',
		'src'     => get_stylesheet_uri(),
		'version' => $version,
	);

	/**
	 * Filters the array of styles.
	 *
	 * @since 4.0.0
	 * @param array $styles
	 */
	return apply_filters( 'cherry_get_styles', $styles );
}

/**
 * Get CSS variables into array
 *
 * @since  4.0.0
 *
 * @return array  dynamic CSS variables
 */
function cherry_get_css_varaibles() {

	$var_list = array(
		'color-primary',
		'color-success',
		'color-info',
		'color-warning',
		'color-danger',
		'color-gray-variations',
		'typography-body-text',
		'typography-link',
		'typography-input-text',
		'typography-h1',
		'typography-h2',
		'typography-h3',
		'typography-h4',
		'typography-h5',
		'typography-h6'
	);

	$var_list = apply_filters( 'cherry_css_var_list', $var_list );

	if ( ! is_array( $var_list ) ) {
		return false;
	}

	$result = array();

	foreach ( $var_list as $var ) {
		$result[$var] = cherry_get_option($var);
	}

	return $result;
}