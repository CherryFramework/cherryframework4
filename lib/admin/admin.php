<?php
/**
 * Theme administration functions used with other components of the framework admin.
 * This file is for setting up any basic features and holding additional admin helper functions.
 *
 * @package    Cherry_Framework
 * @subpackage Admin
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
	require_once( trailingslashit( CHERRY_CLASSES ) . 'class-cherry-admin.php' );

	// Include theme options page.
	require_once( 'views/cherry-framework-options-page.php' );

	// Added menu items in admin panel.
	function cherry_add_admin_menu() {

	}
	// add_action( 'admin_menu', 'cherry_add_admin_menu');

?>