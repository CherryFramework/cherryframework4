<?php
/**
 * Functions for handling stylesheets in the framework. Themes can add support for the
 * 'cherry-styles' feature to allow the framework to handle loading the stylesheets into the
 * theme header at an appropriate point.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Register Cherry Framework styles.
add_action( 'wp_enqueue_scripts', 'cherry_register_styles', 2 );

// Load Cherry Framework styles.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_styles', 10 );

/**
 * Registers stylesheets for the framework. This function merely registers styles with WordPress using
 * the wp_register_style() function. It does not load any stylesheets on the site. If a theme wants to
 * register its own custom styles, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 */
function cherry_register_styles() {

	// Get framework styles.
	$styles = cherry_get_styles();

	// Loop through each style and register it.
	foreach ( $styles as $id => $style ) {

		if ( 'style' == $id && wp_style_is( CHERRY_DYNAMIC_CSS_HANDLE, 'registered' ) ) {
			$deps = array( CHERRY_DYNAMIC_CSS_HANDLE );
		} else {
			$deps = null;
		}

		$defaults = array(
			'handle'  => '',
			'src'     => '',
			'deps'    => $deps,
			'version' => '1.0',
			'media'   => 'all'
		);

		$style = wp_parse_args( $style, $defaults );

		wp_register_style(
			sanitize_key( $style['handle'] ),
			esc_url( $style['src'] ),
			$style['deps'],
			preg_replace( '/[^a-z0-9_\-.]/', '', strtolower( $style['version'] ) ),
			$style['media']
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
		wp_enqueue_style( $style['handle'] );
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

		$drop_downs = array(
			'handle'  => get_template() . '-drop-downs',
			'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/drop-downs.css',
			'deps'    => array( 'dashicons' ),
			'version' => CHERRY_VERSION,
		);

		// Disable dropdown CSS if Mega Menu enabled
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		if ( in_array( 'cherry-mega-menu/cherry-mega-menu.php', $active_plugins ) ) {
			$drop_downs = false;
		}

		// Responsive grid?
		$responsive = cherry_get_option( 'grid-responsive' );

		$grid_responsive = ( 'true' == $responsive ) ?
			array(
				'handle'  => $prefix . 'grid-responsive',
				'src'     => cherry_file_uri( 'assets/css/grid-responsive.css' ),
				'version' => $version,
			) : false;

		// Default styles.
		$defaults = apply_filters( 'cherry_get_styles_defaults', array(
			'main' => array(
				'handle'  => $prefix . 'main',
				'src'     => cherry_file_uri( 'assets/css/main.css' ),
				'version' => $version,
			),
			'grid-base' => array(
				'handle'  => $prefix . 'grid-base',
				'src'     => cherry_file_uri( 'assets/css/grid-base.css' ),
				'version' => $version,
			),
			'grid-responsive' => $grid_responsive,
			'drop-downs'      => $drop_downs,
			'magnific-popup'  => array(
				'handle'  => get_template() . '-magnific-popup',
				'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/magnific-popup.css',
				'version' => CHERRY_VERSION,
			),
			'slick' => array(
				'handle'  => get_template() . '-slick',
				'src'     => trailingslashit( CHERRY_URI ) . 'assets/css/slick.css',
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

// add post specific inline CSS
add_action( 'wp_enqueue_scripts', 'cherry_post_inline_styles', 101 );

/**
 * Get post specific CSS styles and paste it to head
 *
 * @since 4.0.0
 */
function cherry_post_inline_styles() {

	$cherry_styles = cherry_get_styles();
	$post_id       = get_the_id();
	$post_type     = get_post_type( $post_id );

	if ( ! $post_type || ! post_type_supports( $post_type, 'cherry-post-style' ) ) {
		return;
	}

	if ( wp_style_is( CHERRY_DYNAMIC_CSS_HANDLE, 'enqueued' ) ) {
		$handle = CHERRY_DYNAMIC_CSS_HANDLE;
	} else {
		$handle = isset( $cherry_styles['style'] ) ? $cherry_styles['style']['handle'] : false;
	}

	if ( ! $handle ) {
		return;
	}

	$object_id = apply_filters( 'cherry_current_object_id', $post_id );
	$styles    = get_post_meta( $object_id, 'cherry_style', true );

	if ( ! $styles ) {
		return;
	}

	$custom_bg = '';

	if ( isset( $styles['header-background'] ) ) {
		$custom_bg .= cherry_get_background_css( '.site-header', $styles['header-background'] );
	}

	$custom_bg = apply_filters( 'cherry_post_inline_styles', $custom_bg, $post_id );

	if ( ! $custom_bg ) {
		return;
	}

	wp_add_inline_style( $handle, sanitize_text_field( $custom_bg ) );

}