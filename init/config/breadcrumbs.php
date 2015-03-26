<?php
/**
 * Cherry breadcrumbs configuration
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// add breadcrumbs to template
add_action( 'cherry_before_main_content', 'cherry_get_breadcrumbs' );

/**
 * Add breadcrumbs output to template
 *
 * @since 4.0.0
 */
function cherry_get_breadcrumbs() {
	$breadcrumbs = new cherry_breadcrumbs();
	$breadcrumbs->get_trail();
}