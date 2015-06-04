<?php
/**
 * Class for the building ui-checkbox elements.
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

if ( ! class_exists( 'UI_Checkbox' ) ) {
	class UI_Checkbox {

		private $settings = array();
		private $defaults_settings = array(
			'id'			=> 'cherry-ui-checkbox-id',
			'name'			=> 'cherry-ui-checkbox-name',
			'value'			=> array( 'checkbox-1', 'checkbox-2', 'checkbox-3'),
			'options'		=> array(
				'checkbox-1'	=> 'checkbox 1',
				'checkbox-2'	=> 'checkbox 2',
				'checkbox-3'	=> 'checkbox 3'
			),
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Checkbox class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-checkbox-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Checkbox.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			$counter = 0;
			if( $this->settings['options'] && !empty( $this->settings['options'] ) && is_array( $this->settings['options'] ) ){
				if ( !is_array( $this->settings['value'] ) ) {
					$this->settings['value'] = array( $this->settings['value'] );
				}
				foreach ( $this->settings['options'] as $option => $option_value) {

					if( '' !== $this->settings['value'] ){
						$option_checked = in_array( $option, $this->settings['value'] ) ? $option : '' ;
						$item_value = in_array( $option, $this->settings['value'] ) ? 'true' : 'false' ;
					}else{
						$option_checked = '';
						$item_value = 'false';
					}

					$checked = ( $option_checked !== '' ) ? 'checked' : '';

					$html .= '<div class="cherry-checkbox-item-wrap">';
						$html .= '<div class="cherry-checkbox-item ' . $checked . '"><span class="marker dashicons dashicons-yes"></span></div>';
						$html .= '<input type="hidden" id="' . $this->settings['id'] . '-' . $counter . '" class="cherry-checkbox-input ' . $this->settings['class'] . '" name="' . $this->settings['name'] . '['. $option .']" value="' . esc_html( $item_value ) . '" >';
						$html .= '<label class="cherry-checkbox-label" for="' . $this->settings['id'] . '-' . $counter . '">' . $option_value . '</label> ';
					$html .= '</div>';

					$counter++;
				}
			}
			return $html;
		}

		/**
		 * Get current file URL
		 *
		 * @since  4.0.0
		 */
		public static function get_current_file_url() {
			$abs_path = str_replace('/', '\\', ABSPATH);
			$assets_url = dirname( __FILE__ );
			$assets_url = str_replace( $abs_path, '', $assets_url );
			$assets_url = site_url().'/'.$assets_url;
			$assets_url = str_replace( '\\', '/', $assets_url );

			return $assets_url;
		}

		/**
		 * Enqueue javascript and stylesheet UI_Checkbox
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-checkbox.min',
				self::get_current_file_url() . '/assets/min/ui-checkbox.min.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_style(
				'ui-checkbox',
				self::get_current_file_url() . '/assets/ui-checkbox.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}