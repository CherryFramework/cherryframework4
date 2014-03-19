<?php
/**
 * Functions for handling JavaScript in the framework. Themes can add support for the
 * 'cherry-scripts' feature to allow the framework to handle loading the scripts into
 * the theme header or footer at an appropriate time.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Register Cherry Framework scripts.
add_action( 'wp_enqueue_scripts', 'cherry_register_scripts', 0 );

// Load Cherry Framework scripts.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_scripts', 5 );

/**
 * Registers JavaScript files for the framework.  This function merely registers scripts with WordPress using
 * the wp_register_script() function.  It does not load any script files on the site.  If a theme wants to register
 * its own custom scripts, it should do so on the 'wp_enqueue_scripts' hook.
 *
 * @since  4.0.0
 * @access private
 * @return void
 */
function cherry_register_scripts() {

	// Supported JavaScript.
	$supports = get_theme_support( 'cherry-scripts' );

	// Register the 'drop-downs' script if the current theme supports 'drop-downs'.
	if ( isset( $supports[0] ) && in_array( 'drop-downs', $supports[0] ) ) {
		wp_register_script( 'drop-downs', esc_url( trailingslashit( CHERRY_URI ) . 'js/superfish.js' ), array( 'jquery' ), CHERRY_VERSION, true );
	}
}

/**
 * Tells WordPress to load the scripts needed for the framework using the wp_enqueue_script() function.
 *
 * @since 4.0.0
 * @access private
 * @return void
 */
function cherry_enqueue_scripts() {

	// Supported JavaScript.
	$supports = get_theme_support( 'cherry-scripts' );

	// Load the comment reply script on singular posts with open comments if threaded comments are supported.
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load the 'drop-downs' script if the current theme supports 'drop-downs'.
	if ( isset( $supports[0] ) && in_array( 'drop-downs', $supports[0] ) ) {
		wp_enqueue_script( 'drop-downs' );
	}
}