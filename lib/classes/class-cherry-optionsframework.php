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

//add_action( 'after_setup_theme', array( 'Cherry_Options_Framework', 'get_instance' ) );

if ( !class_exists( 'Cherry_Options_Framework' ) ) {
	class Cherry_Options_Framework {

		public $current_section_name = '';
		public static $loaded_settings;
		public $themename = '';
		public static $is_db_options_exist = null;
		private static $instance = null;

		/**
		* Cherry_Options_Framework constructor
		*
		* @since 4.0.0
		*/
		function __construct() {

			add_action( 'admin_init', array( $this, 'create_themename_option' ) );

		}

		public static function get_instance() {


			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance )
				self::$instance = new self;

			return self::$instance;
		}

		/**
		 * Create themename option
		 *
		 * @since 4.0.0
		 */
		public function create_themename_option() {
			// This gets the theme name from the stylesheet (lowercase and without spaces)
			$themename                     = get_option( 'stylesheet' );
			$this->themename               = preg_replace("/\W/", "_", strtolower($themename) );
			$cherry_options_settings       = get_option('cherry-options');
			$cherry_options_settings['id'] = $this->themename;

			update_option('cherry-options', $cherry_options_settings);

			//$this->loaded_settings = $this->load_settings();

			if( !self::is_db_options_exist() ){
				//$this->loaded_settings = $this->load_settings();
				$options = $this->get_default_options( $this->load_settings() );
				$this->save_options( $options );
			}
		}

		/**
		 *
		 * Save options to DB
		 *
		 * @since 4.0.0
		 */
		public function save_options( $options_array ) {
			$settings = get_option( 'cherry-options' );
			update_option($settings['id'], $options_array);
		}

		/**
		 *
		 * Load options from DB
		 *
		 * @since 4.0.0
		 */
		public function load_options() {
			$settings = get_option( 'cherry-options' );
			$result_options = get_option( $settings['id'] );

			return $result_options;
		}

		/**
		 *
		 *
		 * @since 4.0.0
		 */
		public static function is_db_options_exist() {

			if ( null !== self::$is_db_options_exist ) {
				return self::$is_db_options_exist;
			}

			$cherry_options_settings = get_option( 'cherry-options' );
			( false == get_option($cherry_options_settings['id']) ) ? $is_options = false : $is_options = true;

			self::$is_db_options_exist = $is_options;

			return $is_options;
		}

		/**
		 *
		 *
		 * @since 4.0.0
		 */
		public function get_section_name_by_id($section_id) {
			$default_settings = $this->load_settings();
			$result = $default_settings[$section_id]['name'];
			return $result;
		}

		/**
		 *
		 *
		 * @since 4.0.0
		 */
		public function get_type_by_id($option_id) {
			$result = '';

			$default_settings = $this->load_settings();
			foreach ($default_settings as $sectionName => $sectionSettings) {
				foreach ($sectionSettings['options-list'] as $optionId => $optionSettings) {
					if($option_id == $optionId){
						$result = $optionSettings['type'];

						if( isset( $optionSettings['multiple'] ) && true == $optionSettings['multiple'] ){
							$result = 'multiple-select';
						}
					}
				}
			}
			return $result;
		}

		/**
		 *
		 * Create
		 *
		 * @since 4.0.0
		 */
		public function create_options_array() {
			$default_set = $this->load_settings();

			foreach ( $default_set as $key => $value ) {
				$setname = $key;
				$set = array();
					foreach ( $value['options-list'] as $key => $value ) {
						if( isset( $value['value'] ) ){
							$set[$key] = $value['value'];
						}
					}
				$options_parsed_array[ $setname ] = array('options-list'=>$set);
			}

			return $options_parsed_array;
		}

		/**
		 *
		 * Create and save updated options
		 *
		 * @since 4.0.0
		 */
		public function create_updated_options( $post_array ) {
			$options = $this->create_options_array();
			$saved_options = $this->load_options();

			foreach ( $options as $section_key => $value) {
				$option_list = $value['options-list'];
				foreach ($option_list as $option_key => $value) {
					if( isset( $saved_options[$section_key]['options-list'][$option_key] ) ){
						$options[$section_key]['options-list'][$option_key] = $saved_options[$section_key]['options-list'][$option_key];
					}
				}
			}

			if(isset($options)){
				foreach ( $options as $section_key => $value ) {
					$section_name = $section_key;
					$option_list = $value['options-list'];
						foreach ($option_list as $key => $value) {
							$type = $this->get_type_by_id($key);
							switch ($type) {
								case 'multiple-select':
									if (isset($post_array[$key])) {
										$options[$section_name]['options-list'][$key] = array_filter( $post_array[$key] );
									}
									break;
								case 'webfont':
									if (isset($post_array[$key])) {
										$checked_fonts = array();
										if( !empty( $post_array[ $key ] ) && is_array( $post_array[ $key ] ) ){
											foreach ( $post_array[ $key ] as $font_key => $font ) {
												$font['style'] = array_filter( $font['style'] );
												$font['style'] = !empty( $font['style'] ) ? $font['style'] : array( 'regular' );
												$font['character'] = array_filter( $font['character'] );
												$font['character'] = !empty( $font['character'] ) ? $font['character'] : array( 'latin' );
												$checked_fonts[$font_key] = $font;
											}
										}
										$options[$section_name]['options-list'][$key] = $checked_fonts;
									}
									break;
								case 'checkbox':
									if (isset($post_array[$key])) {
										$check_value = array();
										foreach ( $post_array[$key] as $checkbox => $checkbox_value ) {
											if( 'true' == $checkbox_value ){
												$check_value[] = $checkbox;
											}
										}
										$options[$section_name]['options-list'][$key] = $check_value;
									}
									break;
								default:
									if (isset($post_array[$key])) {
										$options[$section_name]['options-list'][$key] = $post_array[$key];
									}
									break;
							}
						}
				}
				return $options;
			}
			return false;
		}
		/**
		 *
		 * Restore section and save options
		 *
		 * @since 4.0.0
		 */
		public function restore_section_settings_array( $activeSection ) {
			$activeSectionName = $activeSection;

			$loaded_settings = $this->load_options();

			$default_settings = $this->get_default_options();

			if(isset($loaded_settings)){
				foreach ( $loaded_settings as $section_key => $value ) {
					$section_name = $section_key;
					$option_list = $value['options-list'];
					if( $section_name == $activeSectionName ){
						foreach ($option_list as $key => $value) {
							if( isset( $default_settings[$section_name]['options-list'][$key] ) ){
								$loaded_settings[$section_name]['options-list'][$key] = $default_settings[$section_name]['options-list'][$key];
							}
						}
					}
				}
				$this->save_options($loaded_settings);
			}
		}

		/**
		 *
		 * Restore and save options
		 *
		 * @since 4.0.0
		 */
		public function restore_default_settings_array() {

			$default_settings = $this->get_default_options();

			if( isset( $default_settings ) ){
				$this->save_options( $default_settings );
			}
		}

		/**
		 *
		 * Restore and save options
		 *
		 * @since 4.0.0
		 */
		public function get_default_options() {
			global $wp_filesystem;
			$default_backup_options = get_option( $this->themename . '_defaults' );

			if( $default_backup_options ){
				return $default_backup_options;
			}

			if ( ! $this->filesystem_init() ) {
				return $this->create_options_array();
			}else{
				$path = get_stylesheet_directory().'/default-options/default.options';
				$path = str_replace( ABSPATH, $wp_filesystem->abspath(), $path );

				if ( ! $wp_filesystem->exists( $path ) ) {
					return $this->create_options_array();
				}
				$export_options = json_decode( $wp_filesystem->get_contents( $path ), true );
				return $export_options;
			}
			return $this->create_options_array();
		}

		/**
		 * Get default set of options
		 *
		 * @since 4.0.0
		 */
		static function load_settings() {
			$result_settings = null;
				if( !empty( self::$loaded_settings ) ){
					return  self::$loaded_settings;
				}
				// Load options from options.php file (if it exists)
				$location = apply_filters( 'default_set_file_location', array('cherry-options.php') );
				if ( $optionsfile = locate_template( $location, true ) ) {
					if ( function_exists( 'cherry_defaults_settings' ) ) {
						$result_settings = cherry_defaults_settings();
					}
				}
				self::$loaded_settings = $result_settings;
			return $result_settings;
		}
		/**
		 * Merge default set with seved options
		 *
		 * @since 4.0.0
		 */
		public function merged_settings() {
			$result_settings = null;

			$default_settings = $this->load_settings();
			$loaded_settings = $this->load_options();

			foreach ( $default_settings as $key => $value ) {
				$section_name = $key;
				$option_list = $value['options-list'];
					foreach ($option_list as $optname => $value) {
						if( array_key_exists($section_name, $loaded_settings) && isset( $loaded_settings[$section_name]['options-list'][$optname] ) ){
							$default_settings[$section_name]['options-list'][$optname]['value'] = $loaded_settings[$section_name]['options-list'][$optname];
						}
					}
			}
			$result_settings = $default_settings;
			return $result_settings;
		}

		/**
		 * Check for the existence of an option in the database
		 *
		 * @since 4.0.0
		 */
		public function get_current_settings() {
			$result_settings = array();

			if( self::$is_db_options_exist ){
				$result_settings = $this->merged_settings();
			}else{
				$result_settings = $this->load_settings();
			}

			return $result_settings;
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
		 * Get option value
		 *
		 * @since 4.0.0
		 */
		public function get_option_value( $name, $default = false ) {

			$cached = wp_cache_get( $name, 'cherry-options' );

			if ( $cached ) {
				return $cached;
			}

			$setting = get_option( 'cherry-options' );
			if(self::is_db_options_exist()){
				$options_array = apply_filters('cherry_option_value_source_array', get_option( $setting['id'] ) );
				if ( $options_array ) {
					foreach ( $options_array as $sections_name => $section_value ) {
						if( !empty( $section_value[ 'options-list' ] ) ){
							if(array_key_exists($name, $section_value['options-list'])){
								wp_cache_set( $name, $section_value['options-list'][$name], 'cherry-options' );
								return $section_value['options-list'][$name];
							}
						}
					}
				}
			}else{
				$settings_array = self::load_settings();
				if ( $settings_array ) {
					foreach ( $settings_array as $sections_name => $section_value ) {
						if(array_key_exists($name, $section_value['options-list'])){
							wp_cache_set( $name, $section_value['options-list'][$name]['value'], 'cherry-options' );
							return $section_value['options-list'][$name]['value'];
						}
					}
				}
			}
			wp_cache_set( $name, $default, 'cherry-options' );
			return $default;
		}

		public function get_option_values( $name ) {
			$settings_array = self::load_settings();

			if ( !$settings_array ) {
				return false;
			}

			foreach ( $settings_array as $sections_name => $section_value ) :

				if ( isset( $section_value['options-list'][ $name ]['options'] ) ) {
					return $section_value['options-list'][ $name ]['options'];
				}

			endforeach;

			return false;
		}
	}
}

/**
 * Retrieve option value based on name of option.
 *
 * @since  4.0.0
 * @since  4.0.5 Added the `cherry_option_` filter.
 * @param  string $name    Name of option to retrieve.
 * @param  mixed  $default Default value to return if the option does not exist.
 * @return mixed           Value set for the option.
 */
function cherry_get_option( $name, $default = false ) {
	$options_framework = Cherry_Options_Framework::get_instance();
	$value             = $options_framework->get_option_value( $name, $default );

	/**
	 * Filter the value of an existing option.
	 *
	 * @since 4.0.5
	 * @param mixed $value Value of the option.
	 */
	return apply_filters( 'cherry_option_' . $name, $value );
}

function cherry_get_options( $name ) {
	$options_framework = Cherry_Options_Framework::get_instance();
	return $options_framework->get_option_values( $name );
}

?>