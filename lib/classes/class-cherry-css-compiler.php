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
		 * Check if we can write dynamic CSS to uploads
		 */
		private $is_writable = false;

		/**
		 * Compiler settings
		 */
		public $settings = array(
			'concatenate_css' => 'true',
			'dynamic_css'     => 'file'
		);

		/**
		 * Construct function
		 */
		function __construct() {

			define( 'CHERRY_DYNAMIC_CSS_HANDLE', 'cherry-dynamic-style' );

			if ( defined( 'CHERRY_DEVELOPER_MODE' ) && CHERRY_DEVELOPER_MODE ) {
				return;
			}

			if ( is_admin() ) {
				$this->_admin();
			} else {
				$this->_public();
			}

		}

		/**
		 * Run admin actions
		 *
		 * @since 4.0.0
		 */
		function _admin() {
			add_action( 'cherry-options-updated', array( &$this, 'reset_compiled_css' ) );
			add_action( 'cherry-section-restored', array( &$this, 'reset_compiled_css' ) );
			add_action( 'cherry-options-restored', array( &$this, 'reset_compiled_css' ) );
			add_action( 'cherry_plugin_activate', array( &$this, 'reset_compiled_css' ) );
			add_action( 'cherry_plugin_deactivate', array( &$this, 'reset_compiled_css' ) );
		}

		/**
		 * Run public actions
		 *
		 * @since 4.0.0
		 */
		function _public() {

			$this->settings = array(
				'concatenate_css' => cherry_get_option( 'concatenate-css', 'true' ),
				'dynamic_css'     => cherry_get_option( 'dynamic-css', 'file' )
			);

			// chaeck if upload dir is writable
			$upload_dir        = wp_upload_dir();
			$this->is_writable = is_writable( $upload_dir['basedir'] );

			// Do this only if we have something to print into static file
			if ( 'file' == $this->settings['dynamic_css'] || 'true' == $this->settings['concatenate_css'] ) {

				// get handles list
				$this->compile_handles = $this->get_static_css_handles();
				// set static file URL
				$this->css_file_url = apply_filters(
					'cherry_dynamic_css_url',
					$upload_dir['baseurl'] . '/cherry-css/style.css'
				);

				$css_dir_path = $upload_dir['basedir'] . '/cherry-css/';
				// set static file path
				$this->css_file_path = apply_filters(
					'cherry_dynamic_css_path',
					$css_dir_path . 'style.css'
				);

				// create directory for stylesheet
				if ( ! file_exists( $css_dir_path ) && ! is_dir( $css_dir_path ) ) {
					wp_mkdir_p( $css_dir_path );
				}
				// check if CSS already compiled
				$this->already_compiled = file_exists( $this->css_file_path );

				add_filter( 'style_loader_tag', array( &$this, 'disable_handles' ), 1, 2 );
				add_action( 'wp_enqueue_scripts', array( &$this, 'register_stylesheet' ), 1 );
				add_action( 'wp_enqueue_scripts', array( &$this, 'process_stylesheet' ), 99 );
			}

			// print dynamic CSS directly into head tag if uploads dir not writable
			if ( ! $this->is_writable || 'tag' == $this->settings['dynamic_css'] ) {
				add_action( 'wp_enqueue_scripts', array( &$this, 'print_dynamic_css_inline' ), 999 );
			}
		}

		/**
		 * Get static CSS hanles array to concatenate
		 *
		 * @since 4.0.0
		 */
		function get_static_css_handles() {

			if ( 'false' == $this->settings['concatenate_css'] ) {
				return false;
			}

			$cherry_styles = cherry_get_styles();
			$handles       = array();

			foreach ( $cherry_styles as $id => $style_data ) {

				if ( ! $style_data || 'style' == $id ) {
					continue;
				}

				$handles[] = $style_data['handle'];
			}

			/**
			 * Filter static CSS handles to compile
			 */
			return apply_filters( 'cherry_compiler_static_css', $handles );
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

			if ( ! $this->is_writable ) {
				return $src;
			}

			if ( is_array( $this->compile_handles ) && in_array( $handle, $this->compile_handles ) ) {
				return;
			}

			return $src;
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
		 * Register compiled stylesheet
		 *
		 * @since  4.0.0
		 */
		public function register_stylesheet() {

			// do nothing if uploads dir not writable
			if ( ! $this->is_writable ) {
				return;
			}

			$ver = file_exists( $this->css_file_path ) ? filemtime( $this->css_file_path ) : '0';
			wp_register_style( CHERRY_DYNAMIC_CSS_HANDLE, $this->css_file_url, array(), $ver );
		}

		/**
		 * Process stylesheet compilation
		 *
		 * @since  4.0.0
		 */
		function process_stylesheet() {

			// compile stylesheet if it was reseted or not compiled before
			if ( false !== $this->already_compiled ) {
				return;
			}

			$this->prepare_static_css();
			$this->compile_stylesheet();
		}

		/**
		 * Print dynamic CSS inline
		 *
		 * @since 4.0.0
		 */
		function print_dynamic_css_inline() {

			$data          = $this->prepare_dynamic_css();
			$cherry_styles = cherry_get_styles();

			if ( wp_style_is( CHERRY_DYNAMIC_CSS_HANDLE, 'enqueued' ) ) {
				$handle = CHERRY_DYNAMIC_CSS_HANDLE;
			} else {
				$handle = isset( $cherry_styles['style'] ) ? $cherry_styles['style']['handle'] : false;
			}

			if ( ! $handle ) {
				return;
			}

			wp_add_inline_style( $handle, sanitize_text_field( $data ) );
		}

		/**
		 * Compile stylesheet
		 *
		 * @since 4.0.0
		 */
		function compile_stylesheet() {

			$compiled_style = '';

			// Concatenate Cherry CSS file into single CSS
			if ( ! empty( $this->compiler_data ) && 'true' == $this->settings['concatenate_css'] ) {
				$compiled_style .= $this->concatenate_static_css();
			}
			// Compile dynamic styles
			if ( 'file' == $this->settings['dynamic_css'] ) {
				$compiled_style .= $this->prepare_dynamic_css();
			}

			if ( empty( $compiled_style ) ) {
				return false;
			}

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

			// First of all grab dynamic CSS from plugins
			$data = apply_filters( 'cherry_compiler_dynamic_css', '' );

			// Then get theme CSS (child theme if exist, or from framework)
			ob_start();
			get_template_part( 'init/css/dynamic-style' );
			$data .= ob_get_clean();

			return $data;
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

			$url  = $this->current_dir_url;
			$path = $matches[1];

			for ( $i = 1; $i <= $depth ; $i++) {
				$url  = preg_replace( '/\/([^\/]*)$/', '', $url, 1 );
				$path = preg_replace( '/(\.\.\/)/', '', $path, 1 );
			}
			return 'url("' . $url . '/' . $path . '")';
		}

		/**
		 * Delete compiler status transient to recompile CSS
		 *
		 * @since 4.0.0
		 */
		function reset_compiled_css() {
			unlink( $this->css_file_path );
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

}

add_action( 'after_setup_theme', array( 'cherry_css_compiler', 'get_instance' ), 40 );

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