<?php
/**
 * Class for template hierarchy.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Function return the full path to the main template file.
 *
 * @since  4.0.0
 * @return string
 */
function cherry_template_path() {
	return Cherry_Wrapping::$main_template;
}

/**
 * Function return the base name of the template file.
 *
 * @since  4.0.0
 * @return string
 */
function cherry_template_base() {
	return Cherry_Wrapping::$base;
}

/**
 * Class for template hierarchy.
 * Based on Sage Starter Theme by Roots.
 *
 * @author  Cristi Burcă <mail@scribu.net>
 * @author  Roots
 * @author  Cherry Team <support@cherryframework.com>
 * @link    https://roots.io/sage/
 * @license http://opensource.org/licenses/MIT
 * @since   4.0.0
 */
class Cherry_Wrapping {

	/**
	 * Stores the full path to the main template file.
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	static $main_template;

	/**
	 * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	 *
	 * @since 4.0.0
	 * @var   string
	 */
	static $base;

	/**
	 * Initialize new instance of Cherry_Wrapping class by setting a variable for the $slug (which defaults to base)
	 * and create a new $templates array with the fallback template base.php as the first item.
	 *
	 * @since 4.0.0
	 * @param string $template default base's file name
	 */
	public function __construct( $template = 'base.php' ) {
		$this->slug      = basename( $template, '.php' );
		$this->templates = array( $template );

		/**
		 * Check to see if the $base exists (i.e. confirming we're not starting on index.php)
		 * and shift a more specific template to the front of the $templates array.
		 */
		if ( self::$base ) {
			$str = substr( $template, 0, -4 );
			array_unshift( $this->templates, sprintf( $str . '-%s.php', self::$base ) );
		}

	}

	/**
	 * To apply a filter to final $templates array, before returning the full path to the most specific existing base template
	 * via the inbuilt WordPress function locate_template.
	 *
	 * @since 4.0.0
	 */
	public function __toString() {
		$this->templates = apply_filters( 'cherry_wrap_' . $this->slug, $this->templates );
		return locate_template( $this->templates );
	}

	/**
	 * Function that saves the $main_template path
	 * and $base as static variables in Cherry_Wrapping class.
	 *
	 * @since 4.0.0
	 * @param string $main The path of the template to include
	 */
	static function wrap( $main ) {
		self::$main_template = $main;
		self::$base = basename( self::$main_template, '.php' );

		if ( 'index' == self::$base ) {
			self::$base = false;
		}

		return new Cherry_Wrapping();
	}
}
/**
 * This filter hook is executed immediately
 * before WordPress includes the predetermined template file.
 */
add_filter( 'template_include', array( 'Cherry_Wrapping', 'wrap' ), 99 );