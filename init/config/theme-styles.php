<?php
/**
 * Styles configuration.
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

// Loads styles.
add_theme_support( 'cherry-styles', array(
	'grid-base', 'grid-responsive', 'slick', 'magnific-popup', 'drop-downs', 'main', 'main-responsive', 'add-ons'
) );