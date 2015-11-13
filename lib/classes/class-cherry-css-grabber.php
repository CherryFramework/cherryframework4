<?php
/**
 * Garab CSS during page load and print it in footer
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Cherry_CSS_Grabber' ) ) {

	class Cherry_CSS_Grabber {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 4.0.5
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Grabbed CSS holder
		 *
		 * @since 4.0.5
		 * @var string
		 */
		private $css = null;

		/**
		 * Constructor for the class
		 */
		function __construct() {

			add_action( 'wp_footer', array( $this, 'print_css' ) );

		}

		/**
		 * Add CSS code to grabber
		 *
		 * @since  4.0.5
		 * @param  string $style cs to add into data
		 * @return void
		 */
		public function add_css( $style = null ) {

			if ( ! $style ) {
				return;
			}

			$this->css .= $style;

		}

		/**
		 * Print grabbed styles
		 *
		 * @since  4.0.5
		 * @return void
		 */
		public function print_css() {

			if ( empty( $this->css ) ) {
				return;
			}

			printf( '<style type="text/css">%s</style>', $this->css );

		}

		/**
		 * Returns the instance.
		 *
		 * @since  4.0.5
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Create class instance
 */
add_action( 'after_setup_theme', array( 'Cherry_CSS_Grabber', 'get_instance' ) );

/**
 * Add styles to grabber
 *
 * @since  4.0.5
 * @param  string $style CSS-styles to add
 * @return void
 */
function cherry_add_generated_style( $style = null ) {

	if ( ! $style ) {
		return;
	}

	$grabber = Cherry_CSS_Grabber::get_instance();

	$grabber->add_css( $style );

}