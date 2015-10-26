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
 * Header Logo static.
 */
class cherry_footer_logo_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.1
	 */
	public function callback() {
		echo cherry_get_site_logo( 'footer' );
	}
}

/**
 * Registration for Header Logo static.
 */
new cherry_footer_logo_static(
	array(
		'id'      => 'footer_logo',
		'name'    => __( 'Footer Logo', 'cherry' ),
		'options' => array(
			'col-xs' => 'col-xs-12',
			'col-sm' => 'col-sm-12',
			'col-md' => 'col-md-6',
			'col-lg' => 'col-lg-6',
			'area'   => 'available-statics',
		)
	)
);