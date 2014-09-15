<?php
/**
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if ( !class_exists( 'Cherry_Options_Framework' ) ) {
	class Cherry_Options_Framework {

		/**
		* Cherry_Options_Framework constructor
		* 
		* @since 1.0.0
		*/

		function __construct() {
			add_action( 'admin_init', array( $this, 'create_themename_option' ) );
		}

		/**
		 * Create themename option
		 *
		 * @since 1.0.0
		 */
		public function create_themename_option() {
			// This gets the theme name from the stylesheet (lowercase and without spaces)
			$themename = get_option( 'stylesheet' );
			$themename = preg_replace("/\W/", "_", strtolower($themename) );
			$cherry_options_settings = get_option('cherry-options');
			$cherry_options_settings['id'] = $themename;
			update_option('cherry-options', $cherry_options_settings);
		}

		/**
		 * 
		 * Save options to DB
		 *
		 * @since 1.0.0
		 */
		public function save_options($options_array) {
			$settings = get_option( 'cherry-options' );
			update_option($settings['id'], $options_array);
		}


		/**
		 * 
		 * Load options from DB
		 *
		 * @since 1.0.0
		 */
		public function load_options() {
			$settings = get_option( 'cherry-options' );
			$result_options = get_option( $settings['id'] );

			return $result_options;
		}

		/**
		 * Get default set of options
		 *
		 * @since 1.0.0
		 */
		public function load_settings() {
			$result_settings = null;

			if ( !$result_settings ) {
		        // Load options from options.php file (if it exists)
		        $location = apply_filters( 'default_set_file_location', array('cherry-options.php') );
		        if ( $optionsfile = locate_template( $location, true ) ) {
		            if ( function_exists( 'cherry_options_sets' ) ) {
						$result_settings = cherry_options_sets();
					}
		        }
			}
			return $result_settings;
		}

		/**
		 * 
		 *
		 * @since 1.0.0
		 */
		public function is_options_exist() {
			$cherry_options_settings = get_option( 'cherry-options' );
			(get_option($cherry_options_settings['id']) == false)? $is_options=false : $is_options = true;
			return $is_options;
		}
		
		/**
		 * 
		 * Create 
		 *
		 * @since 1.0.0
		 */
		public function create_options_array() {
			$default_set = $this->load_settings();

			foreach ( $default_set as $key => $value ) {
				$setname = $key;
				$set = array();
					foreach ( $value['options-list'] as $key => $value ) {
						$set[$key] = $value['value'];
					}	
				$options_parsed_array[$setname] = array('options-list'=>$set);
			}

			return $options_parsed_array;
		}

		/**
		 * 
		 * Create and save updated options
		 *
		 * @since 1.0.0
		 */
		public function create_updated_options_array($post_array) {
			if($this->is_options_exist()){
				$options = $this->load_options();
				//var_dump('options exist');
			}else{
				$options = $this->create_options_array();
				//var_dump('options no exist');
			}
			
			if(isset($options)){				
				foreach ( $options as $section_key => $value ) {
					$section_name = $section_key;
					$option_list = $value['options-list'];
						foreach ($post_array as $key => $value) {
							$options[$section_name]['options-list'][$key] = $post_array[$key];
						}
				}

				$this->save_options($options);
			}
		}

		/**
		 * 
		 * Create and save updated options
		 *
		 * @since 1.0.0
		 */
		public function restore_default_settings_array() {
			$options = $this->create_options_array();
				if(isset($options)){
					$this->save_options($options);
				}
		}

		/**
		 * Merge default set with seved options
		 *
		 * @since 1.0.0
		 */
		public function merged_settings() {
			$result_settings = null;

			$default_settings = $this->load_settings();
			$loaded_settings = $this->load_options();			

			foreach ( $default_settings as $key => $value ) {
				$section_name = $key;
				$option_list = $value['options-list'];
					foreach ($option_list as $optname => $value) {
						$default_settings[$section_name]['options-list'][$optname]['value'] = $loaded_settings[$section_name]['options-list'][$optname];
					}
			}

			$result_settings = $default_settings;
			return $result_settings;
		}

		/**
		 *
		 * @since 1.0.0
		 */
		public function update_option_key_value($sections_name='', $option_name='', $new_value='') {
			$result_array = $this->load_options();
				$result_array[$sections_name]['options-list'][$option_name] = $new_value;
			return $result_array;	
		}
		

		/**
		 * Check for the existence of an option in the database
		 *
		 * @since 1.0.0
		 */
		public function get_settings() {
			$result_settings = array();

			$cherry_options_settings = get_option( 'cherry-options' );

			if($this->is_options_exist()){
				//var_dump('merged_settings');
				$result_settings = $this->merged_settings();
			}else{
				//var_dump('default_settings');
				$result_settings = $this->load_settings();
			}

			return $result_settings;
		}

		/**
		 * Get option value
		 *
		 * @since 1.0.0
		 */
		static function get_option_value( $name, $default = false ) {
			$setting = get_option( 'cherry-options' );
			if ( ! isset( $setting['id'] ) ) {
				return $default;
			}
			$options_array = get_option( $setting['id'] );
			if ( isset( $options_array ) ) {
				foreach ( $options_array as $sections_name => $value ) {
					if(array_key_exists($name, $value['options-list'])){
						return $value['options-list'][$name];
					}
				}
			}
			return $default;
		}
	}
}

?>
