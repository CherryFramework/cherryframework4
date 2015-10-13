<?php
/**
 * Class for the building ui range slider elements .
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

if ( ! class_exists( 'UI_Range_Slider' ) ) {
	class UI_Range_Slider {

		private $settings = array();
		private $defaults_settings = array(
			'id'			=> 'cherry-ui-range-slider-id',
			'name'			=> 'cherry-ui-range-slider-name',
			'max_value'		=> 100,
			'min_value'		=> 0,
			'value'			=> array(
				'left_value'	=> 30,
				'right_value'	=> 50,
			),
			'step_value'	=> 1,
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Range_Slider class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-range-slider-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Range_Slider.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			$ui_left_stepper = new UI_Stepper(
				array(
					'id'			=> $this->settings['id'] . '-left-stepper',
					'name'			=> $this->settings['name'].'[left_value]',
					'max_value'		=> $this->settings['max_value'],
					'min_value'		=> $this->settings['min_value'],
					'value'			=> $this->settings['value']['left_value'],
					'step_value'	=> $this->settings['step_value'],
					'class'			=> 'range-slider-left-stepper'
				)
			);
			$ui_right_stepper = new UI_Stepper(
				array(
					'id'			=> $this->settings['id'] . '-right-stepper',
					'name'			=> $this->settings['name'].'[right_value]',
					'max_value'		=> $this->settings['max_value'],
					'min_value'		=> $this->settings['min_value'],
					'value'			=> $this->settings['value']['right_value'],
					'step_value'	=> $this->settings['step_value'],
					'class'			=> 'range-slider-right-stepper'
				)
			);

			$html .= '<div class="cherry-range-slider-wrap">';
				$html .= '<div class="cherry-range-slider-left-input">';
					$html .= $ui_left_stepper->render();
				$html .= '</div>';
				$html .= '<div class="cherry-range-slider-holder">';
					$html .= '<div class="cherry-range-slider-unit" data-left-limit="' . $this->settings['min_value'] . '" data-right-limit="' . $this->settings['max_value'] . '" data-left-value="' . $this->settings['value']['left_value'] . '" data-right-value="' . $this->settings['value']['right_value'] . '"></div>';
				$html .= '</div>';
				$html .= '<div class="cherry-range-slider-right-input">';
					$html .= $ui_right_stepper->render();
				$html .= '</div>';
				$html .= '<div class="clear"></div>';
			$html .= '</div>';

			return $html;
		}

		/**
		 * Get current file URL
		 *
		 * @since  4.0.0
		 */
		public static function get_current_file_url() {
			$assets_url = dirname( __FILE__ );
			$site_url = site_url();
			$assets_url = str_replace( untrailingslashit( ABSPATH ), $site_url, $assets_url );
			$assets_url = str_replace( '\\', '/', $assets_url );

			return $assets_url;
		}

		/**
		 * Enqueue javascript and stylesheet UI_Range_Slider.
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-range-slider-min',
				self::get_current_file_url() . '/assets/min/ui-range-slider.min.js',
				array( 'jquery', 'jquery-ui-slider' ),
				CHERRY_VERSION,
				true
			);
			wp_enqueue_style(
				'jquery-ui',
				self::get_current_file_url() . '/assets/jquery-ui.css',
				array(),
				CHERRY_VERSION,
				'all'
			);
			wp_enqueue_style(
				'ui-range-slider-min',
				self::get_current_file_url() . '/assets/min/ui-range-slider.min.css',
				array(),
				CHERRY_VERSION,
				'all'
			);
		}

	}
}