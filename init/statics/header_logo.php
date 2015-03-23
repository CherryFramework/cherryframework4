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
 * Header logo static
 */
class cherry_header_logo_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {
		if ( cherry_get_site_title() || cherry_get_site_description() ) {

			printf( '<div class="site-branding">%1$s %2$s</div>',
				cherry_get_site_title(),
				cherry_get_site_description()
			);

		}
	}
}

/**
 * Call Header logostatic registration
 */
new cherry_header_logo_static(
	array(
		'id'      => 'header_logo',
		'name'    => __( 'Logo', 'cherry4' ),
		'options' => array(
			'col-xs'   => 'col-xs-12',
			'col-sm'   => 'col-sm-12',
			'col-md'   => 'col-md-4',
			'col-lg'   => 'col-lg-4',
			'class'    => 'custom-logo',
			'area'     => 'header-top',
			'priority' => 1,
		)
	)
);