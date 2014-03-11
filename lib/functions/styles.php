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

/**
 * Registers stylesheets for the framework. This function merely registers styles with WordPress using
 * the wp_register_style() function. It does not load any stylesheets on the site. If a theme wants to
 * register its own custom styles, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @since 4.0.0
 * @access private
 * @return void
 */
function cherry_register_styles() {

	// Get framework styles.
	$styles = cherry_get_styles();

	// Loop through each style and register it.
	foreach ( $styles as $style => $args ) {

		$defaults = array(
			'handle'  => $style,
			'src'     => trailingslashit( CHERRY_URI ) . "css/{$style}.css",
			'deps'    => null,
			'version' => false,
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
 * @since 4.0.0
 * @access private
 * @return void
 */
function cherry_enqueue_styles() {

	// Get the theme-supported stylesheets.
	$supports = get_theme_support( 'cherry-styles' );

	// If the theme doesn't add support for any styles, return.
	if ( !is_array( $supports[0] ) )
		return;

	// Loop through each of the core framework styles and enqueue them if supported.
	foreach ( $supports[0] as $style ) {
		wp_enqueue_style( $style );
	}
}

/**
 * Returns an array of the core framework's available styles for use in themes.
 *
 * @since 4.0.0
 * @access private
 * @return array $styles All the available framework styles.
 */
function cherry_get_styles() {

	// Default styles available.
	$styles = array(
		'drop-downs' => array( 'version' => '1.7.4' ),
	);

	// If a child theme is active, add the parent theme's style.
	if ( is_child_theme() ) {
		$parent = wp_get_theme( get_template() );

		// Get the parent theme stylesheet.
		$src = trailingslashit( PARENT_URI ) . "style.css";

		$styles['parent'] = array( 'src' => $src, 'version' => $parent->get( 'Version' ) );
	}

	// Add the active theme style.
	$styles['style'] = array( 'src' => get_stylesheet_uri(), 'version' => wp_get_theme()->get( 'Version' ) );

	// Return the array of styles.
	return apply_filters( 'cherry_styles', $styles );
}