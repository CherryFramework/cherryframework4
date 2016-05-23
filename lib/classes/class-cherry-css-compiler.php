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
		 * Dynamic CSS URL
		 */
		public $css_file_url = '';

		/**
		 * Dynamic CSS directory path
		 */
		public $css_dir_path = '';

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

			// check if upload dir is writable
			$upload_dir        = wp_upload_dir();
			$this->is_writable = is_writable( $upload_dir['basedir'] );

			// set static file URL
			$this->css_file_url = $upload_dir['baseurl'] . '/cherry-css/style.css';
			// set static file directory path
			$this->css_dir_path = $upload_dir['basedir'] . '/cherry-css/';
			// set static file path
			$this->css_file_path = $this->css_dir_path . 'style.css';

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
			add_action( 'switch_theme', array( &$this, 'clear_dir' ) );
		}

		/**
		 * Run public actions
		 *
		 * @since 4.0.0
		 */
		public function _public() {

			$this->get_compiler_settings();

			// Do this only if we have something to print into static file
			if ( 'file' == $this->settings['dynamic_css'] || 'true' == $this->settings['concatenate_css'] ) {

				// check if CSS already compiled
				$this->already_compiled = file_exists( $this->css_file_path );

				// Prepare static CSS handles to disable it on frontend
				$this->get_static_css_handles();

				add_filter( 'style_loader_tag', array( &$this, 'disable_handles' ), 1, 2 );
				add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_dynamic_style' ), 99 );
			}

			// print dynamic CSS directly into head tag if uploads dir not writable
			if ( ! $this->is_writable || ! $this->already_compiled || 'tag' == $this->settings['dynamic_css'] ) {
				add_action( 'wp_enqueue_scripts', array( &$this, 'print_dynamic_css_inline' ), 100 );
			}
		}

		/**
		 * Get CSS compiler settings from options
		 *
		 * @since 4.0.0
		 */
		public function get_compiler_settings() {
			$this->settings = array(
				'concatenate_css' => cherry_get_option( 'concatenate-css', 'true' ),
				'dynamic_css'     => cherry_get_option( 'dynamic-css', 'file' )
			);
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
			$skip_styles   = apply_filters( 'cherry_skip_static_css_handles', array( 'magnific-popup', 'slick', 'style' ) );

			foreach ( $cherry_styles as $id => $style_data ) {

				if ( ! $style_data || in_array( $id, $skip_styles ) ) {
					continue;
				}

				$handle = $style_data['handle'];
				$src    = $style_data['src'];

				$this->compiler_data[$handle] = $src;
			}

			$this->compiler_data = apply_filters( 'cherry_compiler_static_css', $this->compiler_data );

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

			if ( ! $this->already_compiled ) {
				return $src;
			}

			global $wp_styles;

			if ( is_array( $this->compiler_data )
				&& array_key_exists( $handle, $this->compiler_data )
				&& $wp_styles->registered[$handle]->src == $this->compiler_data[$handle]
			) {
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
			$path      = str_replace('\\', '/', $path);
			$abspath   = str_replace('\\', '/', ABSPATH);
			$home_path = '/' . preg_quote( $abspath, '/' ) . '/';

			return preg_replace( $home_path, home_url('/'), $path );
		}

		/**
		 * Register compiled stylesheet
		 *
		 * @since  4.0.0
		 */
		public function wp_enqueue_dynamic_style() {

			// do nothing if uploads dir not writable or file not compiled
			if ( ! $this->is_writable || ! $this->already_compiled ) {
				return;
			}

			$ver = file_exists( $this->css_file_path ) ? filemtime( $this->css_file_path ) : '0';
			wp_enqueue_style( CHERRY_DYNAMIC_CSS_HANDLE, $this->css_file_url, array(), $ver );
		}

		/**
		 * Process stylesheet compilation
		 *
		 * @since  4.0.0
		 */
		function process_stylesheet() {

			if ( 'file' != $this->settings['dynamic_css'] && 'true' != $this->settings['concatenate_css'] ) {
				return;
			}

			// create directory for stylesheet if needed
			$this->create_dir();

			if ( 'true' == $this->settings['concatenate_css'] ) {
				$this->get_static_css_handles();
			}

			$this->compile_stylesheet();

		}

		/**
		 * Create Cherry CSS directory in uploads if needed
		 *
		 * @since 4.0.0
		 */
		public function create_dir() {

			if ( ! file_exists( $this->css_dir_path ) && ! is_dir( $this->css_dir_path ) ) {
				wp_mkdir_p( $this->css_dir_path );
			}
		}

		/**
		 * Remove Cherry CSS directory and dynamic CSS file
		 *
		 * @since 4.0.0
		 */
		public function clear_dir() {

			if ( file_exists( $this->css_file_path ) ) {
				unlink( $this->css_file_path );
			}

			if ( file_exists( $this->css_dir_path ) && is_dir( $this->css_dir_path ) ) {
				rmdir( $this->css_dir_path );
			}

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

			global $wp_filesystem;

			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}

			if ( ! $this->filesystem_init() ) {
				return false;
			}

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
			if ( ! class_exists( 'CssMin' ) ) {
				require_once( CHERRY_EXTENSIONS . '/class-cssmin.php' );
				$compiled_style = CssMin::minify( $compiled_style );
			}

			$this->css_file_path = str_replace( ABSPATH, $wp_filesystem->abspath(), $this->css_file_path );

			// Write into file.
			if ( !$wp_filesystem->put_contents( $this->css_file_path, $compiled_style, FS_CHMOD_FILE ) ) {
				return new WP_Error( 'writing_error', 'Error when writing file' ); // Return error object.
			}

		}

		/**
		 * Concatenate static CSS files
		 *
		 * @since 4.0.0
		 */
		function concatenate_static_css() {

			$result = '';

			global $wp_filesystem;

			foreach ( $this->compiler_data as $handle => $url ) {

				$path = $this->prepare_path( $url );

				$path = str_replace( ABSPATH, $wp_filesystem->abspath(), $path );

				if ( ! $wp_filesystem->exists( $path ) ) {
					continue;
				}

				$style = $wp_filesystem->get_contents( $path );

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

			ob_start();

			/**
			 * Allow 3rd party plugins and child themes pass own CSS to parser with lower priority to default CSS
			 *
			 * @since  4.0.4
			 */
			do_action( 'cherry_dynamic_styles_before' );

			$parent_css = PARENT_DIR . '/init/css/dynamic-style.css';
			$child_css  = CHILD_DIR . '/init/css/dynamic-style.css';

			// Include framework dynamic CSS file
			if ( file_exists( $parent_css ) ) {
				include $parent_css;
			}

			// Include child theme Dynamic CSS file (if fwe use child theme, not framework)
			if ( file_exists( $child_css ) && $parent_css !== $child_css ) {
				include $child_css;
			}

			/**
			 * Allow 3rd party plugins and child themes pass own CSS to parser
			 *
			 * @since  4.0.0
			 */
			do_action( 'cherry_dynamic_styles' );

			$data = ob_get_clean();

			$user_css = apply_filters( 'cherry_dynamic_user_css', html_entity_decode( wp_unslash( (string) cherry_get_option( 'general-user-css' ) ) ) );

			if ( $user_css ) {
				$data .= $user_css;
			}

			require_once( CHERRY_CLASSES . '/class-cherry-css-parser.php' );
			$css_parser = new cherry_css_parser();
			$data = $css_parser->parse($data);

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
		 * Initialize Filesystem object.
		 *
		 * @since  4.0.0
		 * @return bool|str false on failure, stored text on success
		 */
		public function filesystem_init() {

			global $wp_filesystem;

			$url = admin_url();

			// First attempt to get credentials.
			if ( false === ( $creds = request_filesystem_credentials( $url, '', true, false, null ) ) ) {
				/**
				 * If we comes here - we don't have credentials
				 * so the request for them is displaying
				 * no need for further processing.
				 **/
				return false;
			}

			// Now we got some credentials - try to use them.
			if ( ! WP_Filesystem( $creds ) ) {

				// Incorrect connection data - ask for credentials again, now with error message.
				request_filesystem_credentials( $url, '', true, false );

				return false;
			}

			return true; // Filesystem object successfully initiated.
		}

		/**
		 * Delete compiled file to recompile CSS
		 *
		 * @since 4.0.0
		 */
		function reset_compiled_css() {

			if ( file_exists( $this->css_file_path ) ) {
				unlink( $this->css_file_path );
			}

			$this->get_compiler_settings();

			$this->process_stylesheet();

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

	$compiler = cherry_css_compiler::get_instance();
	$compiler->reset_compiled_css();
}

/**
 * Delete compiled file when the bulk upgrader process is complete.
 *
 * @since 4.0.2
 */
add_action( 'upgrader_process_complete', 'cherry_reset_css_after_upgrader', 10, 2 );
function cherry_reset_css_after_upgrader( $instance, $data ) {

	if ( ! empty( $data['type'] ) && 'theme' === $data['type'] ) {
		cherry_reset_compiled_css();
	}
}