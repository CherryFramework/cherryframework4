<?php
/**
 * Theme Layouts - A WordPress script for creating dynamic layouts.
 *
 * Theme Layouts was created to allow theme developers to easily style themes with dynamic layout
 * structures.  It gives users the ability to control how each post (or any post type) is displayed on the
 * front end of the site.  The layout can also be filtered for any page of a WordPress site.
 *
 * The script will filter the WordPress body_class to provide a layout class for the given page.  Themes
 * must support this hook or its accompanying body_class() function for the Theme Layouts script to work.
 * Themes must also handle the CSS based on the layout class.  This script merely provides the logic.  The
 * design should be handled on a theme-by-theme basis.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   ThemeLayouts
 * @version   0.6.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2010 - 2014, Justin Tadlock
 * @link      http://justintadlock.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register metadata with WordPress. */
// add_action( 'init', 'theme_layouts_register_meta' );

// Add post type support for theme layouts.
add_action( 'init', 'theme_layouts_add_post_type_support', 5 );

// Set up the custom post layouts.
add_action( 'admin_init', 'theme_layouts_admin_setup' );

/* Filters the theme layout mod. */
add_filter( 'theme_mod_theme_layout', 'theme_layouts_filter_layout', 5 );

// Filters the body_class hook to add a custom class.
add_filter( 'body_class', 'theme_layouts_body_class' );

/**
 * Registers the theme layouts meta key ('Layout') for specific object types and provides a function to
 * sanitize the metadata on update.
 *
 * @since  0.4.0
 * @access public
 * @return void
 */
function theme_layouts_register_meta() {
	register_meta( 'post', theme_layouts_get_meta_key(), 'theme_layouts_sanitize_meta' );
	register_meta( 'user', theme_layouts_get_meta_key(), 'theme_layouts_sanitize_meta' );
}

/**
 * Callback function for sanitizing meta when add_metadata() or update_metadata() is called by WordPress.
 * If a developer wants to set up a custom method for sanitizing the data, they should use the
 * "sanitize_{$meta_type}_meta_{$meta_key}" filter hook to do so.
 *
 * @since  4.0.0
 * @param  mixed  $meta_value The value of the data to sanitize.
 * @param  string $meta_key   The meta key name.
 * @param  string $meta_type  The type of metadata (post, comment, user, etc.)
 * @return mixed  $meta_value
 */
function theme_layouts_sanitize_meta( $meta_value, $meta_key, $meta_type ) {
	return sanitize_html_class( $meta_value );
}

/**
 * Adds post type support to `post` and `page`.
 *
 * @since  4.0.0
 * @return void
 */
function theme_layouts_add_post_type_support() {

	// Sets available public post types.
	$post_types = apply_filters( 'cherry_layouts_add_post_type_support', array( 'post', 'page' ) );

	// For each available post type, create a meta box on its edit page if it supports '$prefix-post-settings'.
	foreach ( $post_types as $type ) {
		add_post_type_support( $type, 'theme-layouts' );
	}
}

/**
 * Gets all the available layouts for the theme.
 *
 * @since  4.0.0
 * @return array Either theme-supported layouts or the default layouts.
 */
function theme_layouts_get_layouts() {

	// Set up the default layout strings.
	$default = array(
		'default' => array(
			'label'   => __( 'Default', 'cherry' ),
			'img_src' => CHERRY_URI . '/admin/assets/images/layout-both-sidebar.png',
		),
	);

	// Get theme-supported layouts.
	$layouts = cherry_get_options('blog-page-layout');
	$layouts = array_merge( $default , $layouts);

	return apply_filters( 'theme_layouts_get_layouts', $layouts );
}

/**
 * Returns an array of arguments for setting up the theme layouts script.  The defaults are merged
 * with the theme-supported arguments.
 *
 * @since  0.5.0
 * @access public
 * @return array  Arguments for the theme layouts script.
 */
function theme_layouts_get_args() {
	$defaults = array(
		'customize' => true,
		'post_meta' => true,
		'default'   => 'default'
	);

	$layouts = get_theme_support( 'theme-layouts' );

	$args = isset( $layouts[1] ) ? $layouts[1] : array();

	return apply_filters( 'theme_layouts_args', wp_parse_args( $args, $defaults ) );
}

/**
 * Filters the 'theme_mods_theme_layout' hook to alter the layout based on post and user metadata.
 * Theme authors should also use this hook to filter the layout if need be.
 *
 * @since  0.5.0
 * @access public
 * @param  string  $theme_layout
 * @return string
 */
function theme_layouts_filter_layout( $theme_layout ) {

	/* If viewing a singular post, get the post layout. */
	if ( is_singular() )
		$layout = get_post_layout( get_queried_object_id() );

	/* If viewing an author archive, get the user layout. */
	elseif ( is_author() )
		$layout = get_user_layout( get_queried_object_id() );

	/* If a layout was found, set it. */
	if ( !empty( $layout ) && 'default' !== $layout ) {
		$theme_layout = $layout;
	}

	/* Else, if no layout option has yet been saved, return the theme default. */
	elseif ( empty( $theme_layout ) ) {
		$args = theme_layouts_get_args();
		$theme_layout = $args['default'];
	}

	return $theme_layout;
}

/**
 * Gets the layout for the current post based off the 'Layout' custom field key if viewing a singular post
 * entry.  All other pages are given a default layout of 'layout-default'.
 *
 * @since  0.2.0
 * @access public
 * @return string The layout for the given page.
 */
function theme_layouts_get_layout() {

	/* Get the available theme layouts. */
	$layouts = theme_layouts_get_layouts();

	/* Get the theme layout arguments. */
	$args = theme_layouts_get_args();

	/* Set the layout to an empty string. */
	$layout = get_theme_mod( 'theme_layout', $args['default'] );

	/* Make sure the given layout is in the array of available post layouts for the theme. */
	if ( empty( $layout ) || !in_array( $layout, $layouts ) || 'default' == $layout )
		$layout = $args['default'];

	/* @deprecated 0.2.0. Use the 'get_theme_layout' hook. */
	$layout = apply_filters( 'get_post_layout', "layout-{$layout}" );

	/* @deprecated 0.5.0.  Use the 'theme_mods_theme_layout' hook. */
	return esc_attr( apply_filters( 'get_theme_layout', $layout ) );
}

/**
 * Get the post layout based on the given post ID.
 *
 * @since  4.0.0
 * @param  int    $post_id The ID of the post to get the layout for.
 * @return string $layout  The name of the post's layout.
 */
function get_post_layout( $post_id ) {

	// Get the post layout.
	$layout = get_post_meta( $post_id, theme_layouts_get_meta_key(), true );

	// Return the layout if one is found. Otherwise, return 'default'.
	return ( !empty( $layout ) ? $layout : 'default' );
}

/**
 * Update/set the post layout based on the given post ID and layout.
 *
 * @since  4.0.0
 * @param  int    $post_id The ID of the post to set the layout for.
 * @param  string $layout  The name of the layout to set.
 * @return bool            True on successful update, false on failure.
 */
function set_post_layout( $post_id, $layout ) {
	error_log('set_post_layout');
	return update_post_meta( $post_id, theme_layouts_get_meta_key(), $layout );
}

/**
 * Deletes a post layout.
 *
 * @since  4.0.0
 * @param  int    $post_id The ID of the post to delete the layout for.
 * @return bool            True on successful delete, false on failure.
 */
function delete_post_layout( $post_id ) {
	error_log('delete_post_layout');
	return delete_post_meta( $post_id, theme_layouts_get_meta_key() );
}

/**
 * Checks if a specific post's layout matches that of the given layout.
 *
 * @since  4.0.0
 * @param  string $layout  The name of the layout to check if the post has.
 * @param  int    $post_id The ID of the post to check the layout for.
 * @return bool            Whether the given layout matches the post's layout.
 */
function has_post_layout( $layout, $post_id = '' ) {

	// If no post ID is given, use WP's get_the_ID() to get it and assume we're in the post loop.
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	// Return true/false based on whether the layout matches.
	return ( $layout == get_post_layout( $post_id ) ? true : false );
}

/**
 * Get the layout for a user/author archive page based on a specific user ID.
 *
 * @since  0.3.0
 * @access public
 * @param  int    $user_id The ID of the user to get the layout for.
 * @return string          The layout if one exists, 'default' if one doesn't.
 */
// function get_user_layout( $user_id ) {

// 	/* Get the user layout. */
// 	$layout = get_user_meta( $user_id, theme_layouts_get_meta_key(), true );

// 	/* Return the layout if one is found.  Otherwise, return 'default'. */
// 	return ( !empty( $layout ) ? $layout : 'default' );
// }

/**
 * Update/set the layout for a user/author archive paged based on the user ID.
 *
 * @since  0.3.0
 * @access public
 * @param  int    $user_id The ID of the user to set the layout for.
 * @param  string $layout  The name of the layout to set.
 * @return bool            True on successful update, false on failure.
 */
// function set_user_layout( $user_id, $layout ) {
// 	return update_user_meta( $user_id, theme_layouts_get_meta_key(), $layout );
// }

/**
 * Deletes a user layout.
 *
 * @since  0.4.0
 * @access public
 * @param  int    $user_id The ID of the user to delete the layout for.
 * @return bool            True on successful delete, false on failure.
 */
// function delete_user_layout( $user_id ) {
// 	return delete_user_meta( $user_id, theme_layouts_get_meta_key() );
// }

/**
 * Checks if a specific user's layout matches that of the given layout.
 *
 * @since  0.3.0
 * @access public
 * @param  string $layout  The name of the layout to check if the user has.
 * @param  int    $user_id The ID of the user to check the layout for.
 * @return bool            Whether the given layout matches the user's layout.
 */
// function has_user_layout( $layout, $user_id = '' ) {

// 	/* If no user ID is given, assume we're viewing an author archive page and get the user ID. */
// 	if ( empty( $user_id ) )
// 		$user_id = get_query_var( 'author' );

// 	/* Return true/false based on whether the layout matches. */
// 	return ( $layout == get_user_layout( $user_id ) ? true : false );
// }

/**
 * Adds the post layout class to the WordPress body class in the form of "layout-$layout". This allows
 * theme developers to design their theme layouts based on the layout class. If designing a theme with
 * this extension, the theme should make sure to handle all possible layout classes.
 *
 * @since  4.0.0
 * @param  array $classes
 * @return array $classes
 */
function theme_layouts_body_class( $classes ) {

	// Adds the layout to array of body classes.
	$classes[] = sanitize_html_class( theme_layouts_get_layout() );

	// Return the $classes array.
	return $classes;
}

/**
 * Creates default text strings based on the default post layouts.
 *
 * @since  4.0.0
 * @return array $strings
 */
function theme_layouts_strings() {

	// Set up the default layout strings.
	$strings = array(
		'default' => array(
			'label'   => __( 'Default', 'cherry' ),
			'img_src' => CHERRY_URI . '/admin/assets/images/layout-both-sidebar.png',
		),
	);

	// Get theme-supported layouts.
	$layouts = cherry_get_options('blog-page-layout');

	if ( !empty( $layouts ) ) {
		$strings = array_merge( $layouts, $strings );
	}

	return apply_filters( 'theme_layouts_strings', $strings );
}

/**
 * Get a specific layout's text string.
 *
 * @since  4.0.0
 * @param  string $layout
 * @return string
 */
function theme_layouts_get_string( $layout ) {

	// Get an array of post layout strings.
	$strings = theme_layouts_strings();

	// Return the layout's string if it exists. Else, return the layout slug.
	return ( ( isset( $strings[ $layout ] ) ) ? $strings[ $layout ] : $layout );
}

/**
 * Post layouts admin setup. Registers the post layouts meta box for the post editing screen. Adds the
 * metadata save function to the 'save_post' hook.
 *
 * @since  4.0.0
 * @return void
 */
function theme_layouts_admin_setup() {
	/* Get the extension arguments. */
	// $args = theme_layouts_get_args();

	/* Return if the theme doesn't support the post meta box. */
	// if ( false === $args['post_meta'] )
	// 	return;

	// Load the post meta boxes on the new post and edit post screens.
	add_action( 'load-post.php',     'theme_layouts_load_meta_boxes' );
	add_action( 'load-post-new.php', 'theme_layouts_load_meta_boxes' );
}

/**
 * Hooks into the 'add_meta_boxes' hook to add the theme layouts meta box and the 'save_post' hook
 * to save the metadata.
 *
 * @since  4.0.0
 * @return void
 */
function theme_layouts_load_meta_boxes() {

	// Add the layout meta box on the 'add_meta_boxes' hook.
	add_action( 'add_meta_boxes', 'theme_layouts_add_meta_boxes', 10, 2 );

	// Saves the post format on the post editing page.
	add_action( 'save_post',      'theme_layouts_save_post', 10, 2 );
}

/**
 * Adds the theme layouts meta box if the post type supports 'theme-layouts' and the current user has
 * permission to edit post meta.
 *
 * @since  4.0.0
 * @param  string $post_type The post type of the current post being edited.
 * @param  object $post      The current post object.
 * @return void
 */
function theme_layouts_add_meta_boxes( $post_type, $post ) {

	if ( ( post_type_supports( $post_type, 'theme-layouts' ) ) && ( current_user_can( 'edit_post_meta', $post->ID ) || current_user_can( 'add_post_meta', $post->ID ) || current_user_can( 'delete_post_meta', $post->ID ) ) )
		add_meta_box( 'theme-layouts-post-meta-box', __( 'Layout', 'cherry' ), 'theme_layouts_post_meta_box', $post_type, 'normal', 'high' );
}

/**
 * Displays a meta box of radio selectors on the post editing screen, which allows theme users to select
 * the layout they wish to use for the specific post.
 *
 * @since  4.0.0
 * @param  object $post The post object currently being edited.
 * @param  array  $box  Specific information about the meta box being loaded.
 * @return void
 */
function theme_layouts_post_meta_box( $post, $box ) {

	// Get theme-supported theme layouts.
	$post_layouts = theme_layouts_get_layouts();

	// Get the current post's layout.
	$post_layout = get_post_layout( $post->ID );

	$args = array(
		'id'            => 'theme-layout',
		'type'          => 'radio',
		'value'         => $post_layout,
		'display_input' => false,
		'options'       => $post_layouts,
	);

	wp_nonce_field( basename( __FILE__ ), 'theme-layouts-nonce' );

	$builder = new Cherry_Interface_Builder( array(
		'name_prefix' => 'cherry',
		'pattern'     => 'inline',
		'class'       => array( 'section' => 'single-section' ),
	) );

	printf( '<div class="post-layout">%s</div>', $builder->add_form_item( $args ) );
}

/**
 * Saves the post layout metadata if on the post editing screen in the admin.
 *
 * @since  0.2.0
 * @access public
 * @param  int      $post_id The ID of the current post being saved.
 * @param  object   $post    The post object currently being saved.
 * @return void|int
 */
function theme_layouts_save_post( $post_id, $post = '' ) {

	if ( !is_object( $post ) ) {
		$post = get_post();
	}

	// Verify the nonce for the post formats meta box.
	if ( !isset( $_POST['theme-layouts-nonce'] ) || !wp_verify_nonce( $_POST['theme-layouts-nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// Get the meta key.
	$meta_key = theme_layouts_get_meta_key();

	// Get the previous post layout.
	$meta_value = get_post_layout( $post_id );

	// Get the all submitted `cherry` data.
	$cherry_meta = $_POST['cherry'];

	// Get the submitted post layout.
	if ( isset( $cherry_meta['theme-layout'] ) ) {
		$new_meta_value = $cherry_meta['theme-layout'];
	} else {
		$new_meta_value = '';
	}

	// If there is no new meta value but an old value exists, delete it.
	if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value ) {
		delete_post_layout( $post_id );
	}

	// If a new meta value was added and there was no previous value, add it.
	elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value ) {
		set_post_layout( $post_id, $new_meta_value );
	}

	// If the old layout doesn't match the new layout, update the post layout meta.
	elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $meta_value !== $new_meta_value ) {
		set_post_layout( $post_id, $new_meta_value );
	}

	error_log($meta_key);
}

/**
 * Wrapper function for returning the metadata key used for objects that can use layouts.
 *
 * @since  4.0.0
 * @return string The meta key used for theme layouts.
 */
function theme_layouts_get_meta_key() {
	return apply_filters( 'theme_layouts_meta_key', '_cherry_theme_layout' );
}

/**
 * @since      0.1.0
 * @deprecated 0.2.0 Use theme_layouts_get_layout().
 */
function post_layouts_get_layout() {
	return theme_layouts_get_layout();
}
