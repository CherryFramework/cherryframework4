<?php
/**
 * Class for the building ui-radio elements.
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

if ( ! class_exists( 'UI_Radio' ) ) {
	class UI_Radio {

		private $settings = array();
		private $defaults_settings = array(
			'id'				=> 'cherry-ui-radio-id',
			'name'				=> 'cherry-ui-radio-name',
			'value'				=> 'radio-2',
			'options'			=> array(
				'radio-1' => array(
					'label' => 'Radio 1',
				),
				'radio-2' => array(
					'label' => 'Radio 2',
				),
				'radio-3' => array(
					'label' => 'Radio 3',
				),
			),
			'class'				=> '',
		);

		/**
		 * Constructor method for the UI_Radio class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {

			$this->defaults_settings['id'] = 'cherry-ui-radio-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Radio.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			if ( $this->settings['options'] && !empty( $this->settings['options'] ) && is_array( $this->settings['options']) ) {
				$html .= '<div class="cherry-radio-group">';
					foreach ( $this->settings['options'] as $option => $option_value ) {
						$checked = $option == $this->settings['value'] ? ' checked' : '';
						$radio_id = $this->settings['id'] . '-' . $option;
						$img = isset( $option_value['img_src'] ) && !empty( $option_value['img_src'] ) ? '<img src="' . esc_url( $option_value['img_src'] ) . '" alt="' . esc_html( $option_value['label'] ) . '"><span class="check"><i class="dashicons dashicons-yes"></i></span>' : '<span class="cherry-radio-item"><i></i></span>';
						$class_box = isset( $option_value['img_src'] ) && !empty( $option_value['img_src'] ) ? ' cherry-radio-img' . $checked : ' cherry-radio-item' . $checked;

						$html .= '<div class="' . $class_box . '">';
						$html .= '<input type="radio" class="cherry-radio-input ' . sanitize_html_class( $this->settings['class'] ) . '" id="' . esc_attr( $radio_id ) . '" name="' . esc_attr( $this->settings['name'] ) . '" ' . checked( $option, $this->settings['value'], false ) . ' value="' . esc_attr( $option ) . '">';

							$label_content = $img . $option_value['label'];
						$html .= '<label for="' . $radio_id . '">' . $label_content . '</label> ';
						$html .= '</div>';
					}
					$html .= '<div class="clear"></div>';
				$html .= '</div>';
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
		 * Enqueue javascript and stylesheet UI_Radio
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-radio.min',
				self::get_current_file_url() . '/assets/min/ui-radio.min.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);

			wp_enqueue_style(
				'ui-radio',
				self::get_current_file_url() . '/assets/ui-radio.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}