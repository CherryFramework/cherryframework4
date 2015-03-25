<?php
/**
 * Utils Functions
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Load Cherry Framework scripts.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_utility_scripts' );

function cherry_enqueue_utility_scripts() {
	global $is_chrome;

	$smooth_scroll = cherry_get_option('general-smoothscroll');

	if( $smooth_scroll == "false"){
		return false;
	}

	wp_register_script( 'jquery-mousewheel', esc_url( trailingslashit( CHERRY_URI ) . 'assets/js/jquery.mousewheel.min.js' ), array( 'jquery' ), '3.0.6', true );
	wp_register_script( 'jquery-smoothscroll', esc_url( trailingslashit( CHERRY_URI ) . 'assets/js/jquery.simplr.smoothscroll.min.js' ), array( 'jquery', 'jquery-mousewheel' ), '3.0.6', true );

	if( !wp_is_mobile() && $is_chrome ){
		wp_enqueue_script( 'jquery-smoothscroll' );
	}
}

?>