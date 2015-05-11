<?php
/**
 * Theme administration functions used with other components of the framework admin.
 * This file is for setting up any basic features and holding additional admin helper functions.
 *
 * @package    Cherry_Framework
 * @subpackage Admin
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

require_once( trailingslashit( CHERRY_ADMIN ) . 'class-cherry-admin.php' );

// Include theme options page.
global $cherry_options_framework;

$cherry_options_framework = new Cherry_Options_Framework;
$options_framework_admin = new Cherry_Options_Framework_Admin;
?>