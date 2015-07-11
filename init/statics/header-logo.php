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
class cherry_header_logo_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.1
	 */
	public function callback() {
		printf( '<div class="site-branding">%1$s %2$s</div>',
			cherry_get_site_logo( 'header' ),
			cherry_get_site_description()
		);
	}
}

/**
 * Registration for Header Logo static.
 */
new cherry_header_logo_static(
	array(
		'id'      => 'header_logo',
		'name'    => __( 'Logo', 'cherry' ),
		'options' => array(
			'col-xs'   => 'col-xs-12',
			'col-sm'   => 'col-sm-12',
			'col-md'   => 'col-md-6',
			'col-lg'   => 'col-lg-6',
			'position' => 1,
			'area'     => 'header-top',
		)
	)
);