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
 * Register footer menu static
 */
class cherry_footer_menu_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {
		cherry_get_menu_template( 'secondary' );
	}
}

/**
 * Call footer menu static registration
 */
new cherry_footer_menu_static(
	array(
		'id'      => 'footer_menu',
		'name'    => __( 'Footer Menu', 'cherry' ),
		'options' => array(
			'col-lg'   => 'col-lg-8',
			'col-md'   => 'col-md-8',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'priority' => 2,
			'area'     => 'footer-bottom',
		)
	)
);