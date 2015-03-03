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

if ( ! class_exists( 'cherry_css_compiler' ) ) {

	/**
	 * Compiler main class
	 *
	 * @since  4.0.0
	 */
	class cherry_css_compiler {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * CSS to optiomize
		 * @var array
		 */
		public $compiler_data = array();

		/**
		 * CSS handles to optimize
		 * @var array
		 */
		public $compile_handles = array();

		/**
		 * Dynamic CSS URL
		 */
		public $css_file_url = '';

		/**
		 * Dynamic CSS path
		 */
		public $css_file_path = '';

		/**
		 * CSS already compiled
		 */
		public $already_compiled = false;

		/**
		 * Service varibale to process url replacements
		 */
		private $current_dir_url = false;

		/**
		 * Construct function
		 */
		function __construct() {

			if ( defined( 'CHERRY_DEVELOPER_MODE' ) && CHERRY_DEVELOPER_MODE ) {
				return;
			}

			$prefix = cherry_get_prefix();

			$this->compile_handles = apply_filters(
				'cherry_compiler_static_css',
				array( $prefix . 'main', $prefix . 'grid-base', $prefix . 'grid-responsive' )
			);

			$upload_dir = wp_upload_dir();

			$this->css_file_url = apply_filters(
				'cherry_dynamic_css_url',
				$upload_dir['baseurl'] . '/cherry-css/style.css'
			);

			$css_dir_path = $upload_dir['basedir'] . '/cherry-css/';

			$this->css_file_path = apply_filters(
				'cherry_dynamic_css_path',
				$css_dir_path . 'style.css'
			);

			// create directory for stylesheet
			if ( ! file_exists( $css_dir_path ) && ! is_dir( $css_dir_path ) ) {
				wp_mkdir_p( $css_dir_path );
			}

			$this->already_compiled = get_transient( 'cherry_compiled_css' );

			add_filter( 'style_loader_tag', array( $this, 'disable_handles' ), 1, 2 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylesheet' ), 999 );
		}

		/**
		 * Don't print concatenated CSS
		 *
		 * @since  4.0.0
		 *
		 * @param  string $src    stylesheet src
		 * @param  string $handle stylesheet handle
		 */
		function disable_handles( $src, $handle ) {

			if ( in_array( $handle, $this->compile_handles ) ) {
				return;
			}

			return $src;
		}

		/**
		 * Get dynamic CSS data to compile in the end of main CSS file
		 *
		 * @since 4.0.0
		 */
		function get_dynamic_css() {

			$variables = array(
				'color-primary' => cherry_get_option( 'color-primary' ),
				'color-success' => cherry_get_option( 'color-success' )
			);

			/**
			 * Filter CSS varaibles list
			 */
			$variables = apply_filters( 'cherry_css_varaibles', $variables );

			$data = array(
				'a' => array(
					'color' => $variables['color-primary']
				),
				'a:hover' => array(
					'color' => $variables['color-success']
				),
				'#bla-bla > .ho-ho-ho' => array(
					'background-color' => $variables['color-primary'],
					'color'            => $variables['color-success'],
				)
			);

			/**
			 * Filter dynamic styles list
			 */
			$data = apply_filters( 'cherry_compiler_dynamic_css', $data );

			return $data;
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
			$home_url  = '/' . preg_quote( home_url('/'), '/' ) . '/';
			$home_path = '/' . preg_quote( ABSPATH, '/' ) . '/';
			$url = remove_query_arg( array( 'rev', 'ver', 'v' ), $url );

			return preg_replace( $home_url, ABSPATH, $url );
		}

		/**
		 * Replace path with URL in src
		 *
		 * @since  4.0.0
		 *
		 * @param  string $path
		 * @return string $url
		 */
		public function prepare_url( $path ) {
			$home_url  = '/' . preg_quote( home_url('/'), '/' ) . '/';
			$home_path = '/' . preg_quote( ABSPATH, '/' ) . '/';

			return preg_replace( $home_path, home_url('/'), $path );
		}

		/**
		 * Prepare static CSS
		 *
		 * @param string $src
		 * @param string $handle
		 */
		public function prepare_static_css() {

			if ( ! $this->compile_handles || ! is_array( $this->compile_handles ) ) {
				return;
			}

			global $wp_styles;

			foreach ( $this->compile_handles as $handle ) {
				if ( empty( $wp_styles->registered[$handle] ) ) {
					continue;
				}
				$this->compiler_data[$handle] = $this->prepare_path( $wp_styles->registered[$handle]->src );
			}
		}

		/**
		 * Run stylesheet compilation and enqueue or just enqueue if compiled
		 *
		 * @since  4.0.0
		 */
		public function enqueue_stylesheet() {

			if ( ! $this->already_compiled ) {
				$this->prepare_static_css();
				$this->compile_stylesheet();
			}

			wp_enqueue_style(
				'cherry-dynamic-style',
				$this->css_file_url, array(), filemtime( $this->css_file_path )
			);
		}

		/**
		 * Compile stylesheet
		 *
		 * @since 4.0.0
		 */
		function compile_stylesheet() {

			$compiled_style = '';

			// Concatenate Cherry CSS file into single CSS
			if ( ! empty( $this->compiler_data ) ) {
				$compiled_style .= $this->concatenate_static_css();
			}
			// Compile dynamic styles
			$compiled_style .= $this->prepare_dynamic_css();

			// Minify CSS
			require_once( CHERRY_EXTENSIONS . '/class-cssmin.php' );
			$compiled_style = CssMin::minify( $compiled_style );

			file_put_contents( $this->css_file_path, $compiled_style );

			set_transient( 'cherry_compiled_css', true, 2*DAY_IN_SECONDS );
		}

		/**
		 * Concatenate static CSS files
		 *
		 * @since 4.0.0
		 */
		function concatenate_static_css() {

			$result = '';

			foreach ( $this->compiler_data as $handle => $path ) {

				if ( ! file_exists( $path ) ) {
					continue;
				}

				$style = file_get_contents( $path );

				$pathinfo              = pathinfo($path);
				$url_to_paste          = $this->prepare_url( $pathinfo['dirname'] );
				$this->current_dir_url = $url_to_paste;

				$patterns = array(
					"/url\([',\"](.[^\)]*)[',\"]\)/",
					"/url\((.[^\'\)\"]*)\)/"
				);

				$result .= preg_replace_callback( $patterns, array( $this, 'replace_relative_url' ), $style );
			}

			return $result;
		}

		/**
		 * Compile dynamic CSS
		 *
		 * @since 4.0.0
		 */
		function prepare_dynamic_css() {

			$dynamic_styles = $this->get_dynamic_css();

			if ( ! $dynamic_styles || ! is_array( $dynamic_styles ) ) {
				return;
			}

			$css = '';

			foreach ( $dynamic_styles as $selector => $style ) {
				$css_str = '';
				foreach ( $style as $property => $value ) {
					$css_str .= $property . ':' . $value . ';';
				}
				$css .= $selector . ' {' . $css_str . '}';
			}

			return $css;
		}

		/**
		 * Replace relative path in URL with absolute
		 *
		 * @since 4.0.0
		 *
		 * @param  array  $matches  matches array
		 * @return string           replcaed string
		 */
		function replace_relative_url( $matches ) {

			if ( ! $this->current_dir_url ) {
				return $matches[1];
			}

			$depth = preg_match_all('/(\.\.\/)/', $matches[1], $result);
			if ( 0 === $depth ) {
				return 'url("' . $this->current_dir_url . '/' . $matches[1] . '")';
			}

			for ( $i = 1; $i <= $depth ; $i++) {
				$url  = preg_replace( '/\/([^\/]*)$/', '', $this->current_dir_url, 1 );
				$path = preg_replace( '/(\.\.\/)/', '', $matches[1] );
			}

			return 'url("' . $url . '/' . $path . '")';
		}

		/**
		 * Delete compiler status transient to recompile CSS
		 *
		 * @since 4.0.0
		 */
		function reset_compiled_css() {
			delete_transient( 'cherry_compiled_css' );
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance )
				self::$instance = new self;

			return self::$instance;
		}

	}

	cherry_css_compiler::get_instance();

}

/**
 * Delete compiler status transient to recompile CSS
 *
 * @since  4.0.0
 */
function cherry_reset_compiled_css() {

	if ( ! class_exists( 'cherry_css_compiler' ) ) {
		return false;
	}

	cherry_css_compiler::reset_compiled_css();
}