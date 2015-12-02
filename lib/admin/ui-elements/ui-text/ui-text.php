<?php
/**
 * Class for the building ui-text elements.
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

if ( ! class_exists( 'UI_Text' ) ) {
	class UI_Text {

		private $settings = array();
		private $defaults_settings = array(
			'type'			=> 'text',// text, email, password, search
			'id'			=> 'cherry-ui-input-id',
			'name'			=> 'cherry-ui-input-name',
			'value'			=> '',
			'placeholder'	=> '',
			'label'			=> '',
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Text class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-input-text-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Text.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			if( '' !== $this->settings['label'] ){
				$html .= '<label class="cherry-label" for="' . $this->settings['id'] . '">' . $this->settings['label'] . '</label> ';
			}
			$html .= '<input type="' . $this->settings['type'] . '" id="' . $this->settings['id']  . '" class="widefat cherry-ui-text ' . $this->settings['class'] . '"  name="' . $this->settings['name'] . '"  value="' . esc_html( $this->settings['value'] ) . '" placeholder="' . $this->settings['placeholder'] . '">';

			return $html;
		}

		/**
		 * Get current file URL
		 *
		 * @since  4.0.0
		 */
		public static function get_current_file_url() {
			/*$abs_path = str_replace('/', '\\', ABSPATH);
			$assets_url = dirname( __FILE__ );
			$assets_url = str_replace( $abs_path, '', $assets_url );
			$assets_url = site_url().'/'.$assets_url;
			$assets_url = str_replace( '\\', '/', $assets_url );*/


			$assets_url = dirname( __FILE__ );
			$site_url = site_url();
			$assets_url = str_replace( untrailingslashit( ABSPATH ), $site_url, $assets_url );
			$assets_url = str_replace( '\\', '/', $assets_url );

			return $assets_url;
		}

		/**
		 * Enqueue javascript and stylesheet UI_Text
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){

			wp_enqueue_style(
				'ui-text',
				self::get_current_file_url() . '/assets/ui-text.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}