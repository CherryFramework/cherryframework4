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
 * Searchform static
 */
class cherry_searchform_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {
		get_search_form( true );
	}
}

/**
 * Call searchform static registration
 */
new cherry_searchform_static(
	array(
		'id'      => 'searchform',
		'name'    => __( 'Search Form', 'cherry' ),
		'options' => array(
			'col-lg'   => 'col-lg-12',
			'col-md'   => 'col-md-12',
			'col-sm'   => 'col-sm-12',
			'col-xs'   => 'col-xs-12',
			'class'    => 'custom-searchform',
			'priority' => 1,
			'area'     => 'header-right',
		)
	)
);