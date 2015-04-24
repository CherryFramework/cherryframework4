<?php
/**
 * Class for the building ui stepper elements.
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

if ( ! class_exists( 'UI_Stepper' ) ) {
	class UI_Stepper {

		private $settings = array();
		/**
		 * Constructor method for the UI_Stepper class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->settings = $this->get_defaults_settings();

			$this->settings = wp_parse_args( $args, $this->settings );
			add_action( 'admin_enqueue_scripts', array( get_called_class(), 'enqueue_assets' ) );
		}

		/**
		 * Render html UI_Stepper.
		 *
		 * @since  4.0.0
		 */
		protected function get_defaults_settings(){
			return array(
				'id'			=> 'ui-switcher-'.uniqid(),
				'name'			=> 'ui-stepper',
				'value'			=> '0',
				'max_value'		=> '100',
				'min_value'		=> '0',
				'step_value'	=> '1',
				'class'			=> '',
			);
		}

		/**
		 * Render html UI_Switcher.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			$html .= '<div class="ui-stepper ' . $this->settings['class'] . ' ">';
				$html .= '<input id="' . $this->settings['id'] . '" name="' . $this->settings['name'] . '" class="cherry-stepper-input" type="text" placeholder="inherit" value="' . esc_html( $this->settings['value'] ) . '" data-max-value="' . esc_html( $this->settings['max_value'] ) . '" data-min-value="' . esc_html( $this->settings['min_value'] ) . '" data-step-value="' . esc_html( $this->settings['step_value'] ) . '">';
				$html .= '<span class="cherry-stepper-controls"><em class="step-up" title="' . __( 'Step Up', 'cherry' ) . '">+</em><em class="step-down" title="' . __( 'Step Down', 'cherry' ) . '">-</em></span>';
			$html .= '</div>';
			return $html;
		}

		/**
		 * Enqueue javascript and stylesheet UI_Stepper.
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-stepper-js',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-stepper/assets/min/ui-stepper.min.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);
			wp_enqueue_style(
				'ui-stepper-css',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-stepper/assets/ui-stepper.css',
				array(),
				CHERRY_VERSION,
				'all'
			);
		}
	}
}