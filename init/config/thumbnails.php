<?php
/**
 * Cherry theme thumbnails configuration
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Registers custom image sizes for the theme.
add_action( 'init', 'cherry_register_image_sizes' );
function cherry_register_image_sizes() {

	if ( ! current_theme_supports( 'post-thumbnails' ) ) {
		return;
	}
	// Sets the 'post-thumbnail' size.
	set_post_thumbnail_size( 200, 150, true );

	// Adds the 'slider-post-thumbnail' image size.
	add_image_size( 'slider-post-thumbnail', 1025, 500, true );
}