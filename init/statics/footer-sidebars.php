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
 * Footer Sidebars static.
 */
class cherry_footer_sidebars_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 * @since 4.0.0
	 */
	public function callback() {
		cherry_get_sidebar( 'footer-1' );
		cherry_get_sidebar( 'footer-2' );
		cherry_get_sidebar( 'footer-3' );
		cherry_get_sidebar( 'footer-4' );
	}
}

/**
 * Registration for Footer Sidebars static.
 */
new cherry_footer_sidebars_static(
	array(
		'name'    => __( 'Footer Sidebars', 'cherry' ),
		'id'      => 'footer_sidebars',
		'options' => array(
			'position' => 1,
			'area'     => 'footer-top',
		)
	)
);