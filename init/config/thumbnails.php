<?php
/**
 * Thumbnails configuration.
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

// Registers custom image sizes for the theme.
add_action( 'init', 'cherry_register_image_sizes' );
function cherry_register_image_sizes() {

	if ( ! current_theme_supports( 'post-thumbnails' ) ) {
		return;
	}

	// Registers a new image sizes.
	add_image_size( 'cherry-thumb-s', 200, 150, true );
	add_image_size( 'cherry-thumb-l', 1170, 780, true );
	add_image_size( 'cherry-thumb-xl', 1920, 1080, true );
}