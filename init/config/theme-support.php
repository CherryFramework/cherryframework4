<?php
/**
 * Cherry theme supports configuration
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Enable support for Post Formats.
add_theme_support( 'post-formats', array(
	'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video',
) );

// Loads scripts.
add_theme_support( 'cherry-scripts', array(
	'comment-reply', 'drop-downs',
) );

// Loads styles.
add_theme_support( 'cherry-styles', array(
	'grid-base', 'grid-responsive', 'drop-downs', 'main', 'add-ons',
) );

// Loads shortcodes.
add_theme_support( 'cherry-shortcodes' );

// Handle content width for embeds and images.
cherry_set_content_width( 780 );