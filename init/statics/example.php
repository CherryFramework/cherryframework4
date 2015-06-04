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
	 * Callback-method for registered static.
	 *
	 * @since 4.0.0
	 */
	public function callback() {}
}

/**
 * Registration for Example static.
 */
$args = array(
	'id'      => 'example', // Static ID
	'name'    => __( 'Example', 'cherry' ), // Static name
	'options' => array(
		'col-lg'   => 'col-lg-6',  // (optional) Column class for a large devices (≥1200px)
		'col-md'   => 'col-md-6',  // (optional) Column class for a medium devices (≥992px)
		'col-sm'   => 'col-sm-12', // (optional) Column class for a tablets (≥768px)
		'col-xs'   => 'col-xs-12', // (optional) Column class for a phones (<768px)
		'class'    => 'example-css-class', // (optional) Extra CSS class
		'position' => 1, // (optional) Position in static area (1 - first static, 2 - second static, etc.)
		'area'     => 'static-area-id', // (required) ID for static area
		'collapse' => false, // (required) Collapse column paddings?
	)
);
// new cherry_example_static( $args );