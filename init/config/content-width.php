<?php
/**
 * Content width configuration.
 *
 * Set the maximum allowed width for any content in the theme,
 * like oEmbeds and images added to posts.
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

// Handle content width for embeds and images.
cherry_set_content_width( 1170 );