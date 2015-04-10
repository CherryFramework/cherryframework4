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
 * Example static.
 */
class cherry_example_static extends cherry_register_static {

	/**
	 * Callback method for registered static.
	 * @since 4.0.0
	 */
	public function callback() {}
}

/**
 * Registration for Example static.
 */
new cherry_example_static(
	array(
		'id'       => 'example', // Static ID
		'name'     => __( 'Example', 'cherry' ), // Static name
		'options'  => array(
			'col-lg'   => 'col-lg-6',  // Large devices Desktops (≥1200px)
			'col-md'   => 'col-md-6',  // Medium devices Desktops (≥992px)
			'col-sm'   => 'col-sm-12', // Small devices Tablets (≥768px)
			'col-xs'   => 'col-xs-12', // Extra small devices Phones (<768px)
			'class'    => 'example-css-class', // Extra CSS class
			'priority' => 1,
			'area'     => 'static-area-id', // ID for static area
		)
	)
);