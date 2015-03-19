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
 * Info block static
 */
class cherry_info_block_static extends cherry_register_static {

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public static function callback() {
		echo "Static 7";
	}
}

/**
 * Call info block static registration
 */
cherry_info_block_static::register(
	array(
		'id'       => 'info2',
		'options'  => array(
			'priority' => 2,
			'area'     => 'header-bottom',
		)
	)
);