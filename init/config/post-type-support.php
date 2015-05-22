<?php
/**
 * Cherry theme post types support configuration.
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Add extra support for post types.
add_action( 'init', 'cherry_add_post_type_support' );

function cherry_add_post_type_support() {

	// Enable support for excerpts.
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * Filters the array with post types that supported `cherry-layouts`.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	$post_types = apply_filters( 'cherry_layouts_add_post_type_support', array( 'post', 'page' ) );

	// For each available post type, create a meta box on its edit page.
	foreach ( $post_types as $type ) {
		add_post_type_support( $type, 'cherry-layouts' );
	}

	/**
	 * Filters the array with post types that supported `cherry-grid-type`.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	$post_types = apply_filters( 'cherry_grid_type_add_post_type_support', array( 'post', 'page' ) );

	// For each available post type, create a meta box on its edit page.
	foreach ( $post_types as $type ) {
		add_post_type_support( $type, 'cherry-grid-type' );
	}

	/**
	 * Filters the array with post types that supported `cherry-post-style`.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	$post_types = apply_filters( 'cherry_post_style_add_post_type_support', array( 'post', 'page' ) );

	// For each available post type, create a meta box on its edit page.
	foreach ( $post_types as $type ) {
		add_post_type_support( $type, 'cherry-post-style' );
	}
}