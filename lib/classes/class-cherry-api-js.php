<?php
/**
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if ( !class_exists( 'Cherry_Api_Js' ) ) {
	class Cherry_Api_Js {
		private static $options = array( 'product_type' => 'framework' );
		private static $assets = array( 'script' => '', 'style' => '' );

		function __construct( $attr = array() ) {
			self::$options = array_merge( self::$options, $attr );

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_cherry_api_scripts' ), 0 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_cherry_api_scripts' ), 0 );

			add_action( 'wp_print_scripts', array( __CLASS__, 'get_include_script' ) );
			add_action( 'wp_print_styles', array( __CLASS__, 'get_include_style' ) );
			add_action( 'admin_print_styles', array( __CLASS__, 'get_include_style' ) );

			add_action( 'wp_print_scripts', array( __CLASS__, 'write' ));
		}

		/**
		 * Register ande Enqueue Cherry Api.
		 *
		 * @since 4.0.0
		 */
		public static function enqueue_cherry_api_scripts() {
			// Cherry Framework JS API
			if( self::$options[ 'product_type' ] === 'framework' ){
				$src = esc_url( trailingslashit( CHERRY_URI ) . 'assets/js/cherry-api.js' ) ;
				$version = CHERRY_VERSION;
			}else{
				$src = plugins_url( 'assets/js/cherry-api.js', CHERRY_SHORTCODES_FILE ) ;
				$version = CHERRY_SHORTCODES_VERSION;
			}
			wp_register_script( 'cherry-api', $src, array( 'jquery' ), $version, true );
			wp_enqueue_script( 'cherry-api' );
		}

		/**
		 * Get Script List
		 *
		 * @since 4.0.0
		 */
		public static function get_include_script() {
			$script = implode( '.js", "', wp_scripts()->queue );
			self::$assets[ 'script' ] = '["' . $script . '.js"]';
		}

		/**
		 * Get Style List
		 *
		 * @since 4.0.0
		 */
		public static function get_include_style() {
			$style = implode('.css", "', wp_styles()->queue);
			self::$assets[ 'style' ] = '["' . $style . '.css"]';
		}
		/**
		 * Write Script
		 *
		 * @since 4.0.0
		 */
		public static function write() {
			echo '<script type="text/javascript">var wp_load_style = ' . self::$assets[ 'style' ] . ', wp_load_script = ' . self::$assets[ 'script' ] . ';</script>';
		}
	}
	$Cherry_Api_Js = new Cherry_Api_Js();
}