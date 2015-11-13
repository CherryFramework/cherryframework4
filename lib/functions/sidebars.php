<?php
/**
 * Helper functions for working with the WordPress sidebar system. Currently, the framework creates a
 * simple function for registering HTML5-ready sidebars instead of the default WordPress unordered lists.
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

/**
 * Wrapper function for WordPress' register_sidebar() function. This function exists so that theme authors
 * can more quickly register sidebars with an HTML5 structure instead of having to write the same code
 * over and over. Theme authors are also expected to pass in the ID, name, and description of the sidebar.
 * This function can handle the rest at that point.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array  $args Array of arguments for building a sidebar.
 * @return string       Sidebar ID.
 */
function cherry_register_sidebar( $args ) {

	// Set up some default sidebar arguments.
	$defaults = array(
		'id'            => '',
		'name'          => '',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	/**
	 * Filter the default sidebar arguments
	 *
	 * @since 4.0.0
	 * @param array $defaults Array of default arguments.
	 */
	$defaults = apply_filters( 'cherry_sidebar_defaults', $defaults );

	// Parse the arguments.
	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filter the sidebar arguments.
	 *
	 * @since 4.0.0
	 * @param array $args Array of arguments for building a sidebar.
	 */
	$args = apply_filters( 'cherry_sidebar_args', $args );

	/**
	 * Fires before execute WordPress `register_sidebar` function.
	 *
	 * @since 4.0.0
	 * @param array $args Array of arguments for building a sidebar.
	 */
	do_action( 'cherry_register_sidebar', $args );

	/**
	 * Register the sidebar.
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	return register_sidebar( $args );
}
