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
 * Banner static
 */
class cherry_banner_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {
		echo '<img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder" alt="placeholder">';
	}
}

/**
 * Call banner static registration
 */
new cherry_banner_static(
	array(
		'id'       => 'banner',
		'name'     => __( 'Banner', 'cherry' ),
		'options'  => array(
			'col-lg'   => 'col-lg-6',
			'col-md'   => 'col-md-6',
			'col-sm'   => 'col-sm-6',
			'col-xs'   => 'col-xs-6',
			'class'    => 'custom-banner',
			'priority' => 1,
			'area'     => 'header-left',
		)
	)
);