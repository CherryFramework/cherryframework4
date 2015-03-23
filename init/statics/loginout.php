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
 * Login/out block static
 */
class cherry_loginout_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {
		wp_loginout();
	}
}

/**
 * Call Login/out static registration
 */
new cherry_loginout_static(
	array(
		'id'       => 'loginout',
		'name'     => __( 'Log In/Out', 'cherry' ),
		'options'  => array(
			'col-lg'   => 'col-lg-6',
			'col-md'   => 'col-md-6',
			'col-sm'   => 'col-sm-6',
			'col-xs'   => 'col-xs-6',
			'class'    => 'custom-loginout',
			'priority' => 2,
			'area'     => 'header-left',
		)
	)
);