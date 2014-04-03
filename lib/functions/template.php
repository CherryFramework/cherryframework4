<?php
/**
 * Functions for loading template parts. These functions are helper functions or more flexible functions
 * than what core WordPress currently offers with template part loading.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Loads a post content template based on the post type and/or the post format.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_content_template() {

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based on post type and post format.
		$templates[] = "content-{$post_type}-{$post_format}.php";
		$templates[] = "content/{$post_type}-{$post_format}.php";

		// Template based on the post format.
		$templates[] = "content-{$post_format}.php";
		$templates[] = "content/{$post_format}.php";
	}

	// Template based on the post type.
	$templates[] = "content-{$post_type}.php";
	$templates[] = "content/{$post_type}.php";

	// Fallback 'content.php' template.
	$templates[] = 'content.php';
	$templates[] = 'content/content.php';

	// Allow devs to filter the content template hierarchy.
	$templates = apply_filters( 'cherry_content_template_hierarchy', $templates );

	// Apply filters and return the found content template.
	include( apply_filters( 'cherry_content_template', locate_template( $templates, false, false ) ) );
}