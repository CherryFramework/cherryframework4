<?php
/**
 * Class for the building ui swither elements .
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

if ( ! class_exists( 'UI_Switcher' ) ) {
	class UI_Switcher {

		private $settings = array();
		/**
		 * Constructor method for the UI_Switcher class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->settings = $this->get_defaults_settings();

			$this->settings = wp_parse_args( $args, $this->settings );
			add_action( 'admin_enqueue_scripts', array( get_called_class(), 'enqueue_assets' ) );
		}

		/**
		 * Render html UI_Switcher.
		 *
		 * @since  4.0.0
		 */
		protected function get_defaults_settings(){
			return array(
				'id'				=> 'ui-switcher-'.uniqid(),
				'name'				=> 'ui-switch',
				'value'				=> 'true',
				'class'				=> 'interface-builder-item',
				'toggle'			=> array(
					'true_toggle'	=> __( 'On', 'cherry' ),
					'false_toggle'	=> __( 'Off', 'cherry' )
				)
			);
		}

		/**
		 * Render html UI_Switcher.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			$html .= '<div class="cherry-switcher-wrap ' . $this->settings['class'] . '">';
				$html .= '<label class="sw-enable"><span>' . $this->settings['toggle']['true_toggle'] . '</span></label>';
				$html .= '<label class="sw-disable"><span>' . $this->settings['toggle']['false_toggle']  . '</span></label>';
				$html .= '<input id="' . $this->settings['id'] . '" type="hidden" class="cherry-input-switcher" name="' . $this->settings['name'] . '" ' . checked( 'true', $this->settings['value'], false ) . ' value="' . esc_html( $this->settings['value'] ) . '" >';
			$html .= '</div>';

			return $html;
		}

		/**
		 * Enqueue javascript and stylesheet UI_Switcher.
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-switcher-js',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-switcher/assets/min/ui-switcher.min.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);
			wp_enqueue_style(
				'ui-switcher-css',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-switcher/assets/ui-switcher.css',
				array(),
				CHERRY_VERSION,
				'all'
			);
		}
	}
}