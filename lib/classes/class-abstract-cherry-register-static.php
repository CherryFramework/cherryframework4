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
 * Abstract cherry static register
 *
 * @since  4.0.0
 */
abstract class cherry_register_static {

	/**
	 * Register static function
	 *
	 * @since 4.0.0
	 */
	public static function register( $options ) {

		$options = wp_parse_args(
			$options,
			array(
				'callback' => array( get_called_class(), 'callback' )
			)
		);

		cherry_register_static( $options );
	}

	/**
	 * Callbck method for registered static
	 *
	 * @since 4.0.0
	 */
	public static function callback() {}

}