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
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register Cherry Framework styles.
add_action( 'wp_enqueue_scripts', 'cherry_register_styles', 2 );

// Load Cherry Framework styles.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_styles', 10 );

// Add post specific inline CSS.
add_action( 'wp_enqueue_scripts', 'cherry_post_inline_styles', 101 );

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
	$defaults = array(
		'handle'  => '',
		'src'     => '',
		'deps'    => null,
		'version' => '1.0',
		'media'   => 'all',
	);

	// Get framework styles.
	$styles = cherry_get_styles();

	// Loop through each style and register it.
	foreach ( $styles as $id => $style ) {

		if ( 'style' == $id && wp_style_is( CHERRY_DYNAMIC_CSS_HANDLE, 'registered' ) ) {
			$defaults['deps'] = array( CHERRY_DYNAMIC_CSS_HANDLE );
		}

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
 * @since 4.0.0
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
 * Get post specific CSS styles and paste it to head.
 *
 * @since 4.0.0
 */
function cherry_post_inline_styles() {
	$post_id   = get_queried_object_id();
	$post_type = get_post_type( $post_id );

	if ( ! $post_type || ! post_type_supports( $post_type, 'cherry-post-style' ) ) {
		return;
	}

	if ( wp_style_is( CHERRY_DYNAMIC_CSS_HANDLE, 'enqueued' ) ) {
		$handle = CHERRY_DYNAMIC_CSS_HANDLE;
	} else {
		$cherry_styles = cherry_get_styles();
		$handle        = isset( $cherry_styles['style'] ) ? $cherry_styles['style']['handle'] : false;
	}

	if ( ! $handle ) {
		return;
	}

	$header_bg = cherry_current_page()->get_property( 'background', 'header' );

	if ( ! $header_bg ) {
		return;
	}

	$custom_bg = cherry_get_background_css( '.site-header', $header_bg );

	/**
	 * Filter a custom background style.
	 *
	 * @since 4.0.0
	 * @param string $custom_bg Background style.
	 * @param int    $post_id   The post ID.
	 */
	$custom_bg = apply_filters( 'cherry_post_inline_styles', $custom_bg, $post_id );

	if ( ! $custom_bg ) {
		return;
	}

	wp_add_inline_style( $handle, sanitize_text_field( $custom_bg ) );
}
