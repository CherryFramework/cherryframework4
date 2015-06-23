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
 * Search Form static.
 */
class cherry_search_form_static extends cherry_register_static {

	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.0
	 */
	public function callback() {
		get_search_form( true );
	}
}

/**
 * Registration for Search Form static.
 */
new cherry_search_form_static(
	array(
		'id'      => 'search-form',
		'name'    => __( 'Search Form', 'cherry' ),
		'options' => array(
			'col-lg' => 'col-lg-6',
			'col-md' => 'col-md-6',
			'col-sm' => 'col-sm-12',
			'col-xs' => 'col-xs-12',
			'area'   => 'available-statics',
		)
	)
);