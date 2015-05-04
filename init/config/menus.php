<?php
/**
 * Cherry theme menus configuration
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

// Register custom menus.
add_action( 'init', 'cherry_register_menus' );
function cherry_register_menus() {
	register_nav_menu( 'primary',   __( 'Primary', 'cherry' ) );
	register_nav_menu( 'secondary', __( 'Secondary', 'cherry' ) );
}