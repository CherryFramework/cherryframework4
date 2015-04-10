<?php
/**
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Header sidebar static
 */
class cherry_header_sidebar_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {
		cherry_get_sidebar( 'header' );
	}
}

/**
 * Call Header sidebar static registration
 */
new cherry_header_sidebar_static(
	array(
		'id'      => 'header_sidebar',
		'name'    => __( 'Header Sidebar', 'cherry' ),
		'options' => array(
			'priority' => 3,
			'area'     => 'header-bottom',
			// 'col-lg'   => 'col-lg-6',
			'col-md'   => 'col-md-12',
			// 'col-sm'   => 'col-sm-6',
			// 'col-xs'   => 'col-xs-6',
		)
	)
);