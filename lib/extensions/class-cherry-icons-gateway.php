<?php
/**
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

if ( ! class_exists( 'Cherry_Icons_Gateway' ) ) {

	/**
	 * Gteway to connect custom theme icons with Shortcodes Ultimate icon picker
	 */
	class Cherry_Icons_Gateway {

		/**
		 * Custom font icons array
		 * @var array
		 */
		public $font_icons = array();

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		function __construct() {

			/**
			 * Grab custom font icons from theme and 3rd party plugins
			 * Icons must be passed in format $handle => $path_to_css_file
			 *
			 * @since  4.0.0
			 */
			$this->font_icons = apply_filters( 'cherry_custom_font_icons', array() );

			if ( empty( $this->font_icons ) ) {
				return;
			}

			// Register custom fonts
			add_action( 'wp_enqueue_scripts', array( $this, 'register_fonts' ), 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_fonts' ), 1 );
			// Add icons to picker
			add_filter( 'cherry_shortcodes/data/icons', array( $this, 'prepare_icon_picker' ) );
			// Enqueue styles on backend
			add_filter( 'cherry_shortcodes_admin_styles', array( $this, 'enqueue_admin' ) );
			// Enqueue styles on frontend
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public' ) );

		}

		/**
		 * Register custom fonts CSS files
		 *
		 * @since  4.0.0
		 */
		function register_fonts() {

			if ( ! is_array( $this->font_icons ) ) {
				return;
			}

			foreach ( $this->font_icons as $handle => $src ) {
				wp_register_style( $handle, $src );
			}

		}

		/**
		 * Replace URL with path in src
		 *
		 * @since  4.0.0
		 *
		 * @param  string $url
		 * @return string $path
		 */
		public function prepare_path( $url ) {

			$url = remove_query_arg( array( 'rev', 'ver', 'v' ), $url );

			return str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $url );
		}

		/**
		 * Enqueue custom font icons in admin (to show its in icon picker)
		 *
		 * @since  4.0.0
		 *
		 * @param  array  $styles SU admin styles
		 */
		public function enqueue_admin( $styles ) {

			$handles = array_keys( $this->font_icons );

			return array_merge( $styles, $handles );

		}

		/**
		 * Enqueue custom font icons in admin (to show its in icon picker)
		 *
		 * @since  4.0.0
		 */
		public function enqueue_public() {

			foreach ( $this->font_icons as $handle => $src ) {
				wp_enqueue_style( $handle );
			}

		}

		/**
		 * Prepare icons for icon picker
		 *
		 * @since  4.0.0
		 *
		 * @param  array  $icons existing icons
		 */
		public function prepare_icon_picker( $icons ) {

			ob_start();

			foreach ( $this->font_icons as $handle => $src ) {
				$path = $this->prepare_path( $src );
				include $path;
			}

			$result = ob_get_clean();

			preg_match_all( '/\.([-a-zA-Z0-9]+):before[, {]/', $result, $matches );

			if ( is_array( $matches ) && ! empty( $matches[1] ) ) {
				return array_merge( $matches[1], $icons );
			} else {
				return $icons;
			}

		}

		/**
		 * Returns the instance.
		 *
		 * @since  4.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance )
				self::$instance = new self;

			return self::$instance;
		}

	}

	// Create new instance of Icons gateway
	add_action( 'after_setup_theme', array( 'Cherry_Icons_Gateway', 'get_instance' ) );

}