<?php
/**
 * Post formats configuration.
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

// Enable support for Post Formats.
add_theme_support( 'post-formats', array(
	'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video',
) );