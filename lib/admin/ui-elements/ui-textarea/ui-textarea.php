<?php
/**
 * Class for the building ui-textarea elements.
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

if ( ! class_exists( 'UI_Textarea' ) ) {
	class UI_Textarea {

		private $settings = array();
		private $defaults_settings = array(
			'id'			=> 'cherry-ui-textarea-id',
			'name'			=> 'cherry-ui-textarea-name',
			'value'			=> '',
			'placeholder'	=> '',
			'rows'			=> '10',
			'cols'			=> '20',
			'label'			=> '',
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Textarea class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-textarea-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Textarea.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			if( '' !== $this->settings['label'] ){
				$html .= '<label class="cherry-label" for="' . $this->settings['id'] . '">' . $this->settings['label'] . '</label> ';
			}
			$html .= '<textarea id="' . $this->settings['id']  . '" class="cherry-ui-textarea ' . $this->settings['class'] . '" name="' . $this->settings['name'] . '" rows="' . $this->settings['rows'] . '" cols="' . $this->settings['cols'] . '" placeholder="' . $this->settings['placeholder'] . '">' . esc_html( $this->settings['value'] ) . '</textarea>';
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
		 * Enqueue javascript and stylesheet UI_Textarea
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_style(
				'ui-textarea',
				self::get_current_file_url() . '/assets/ui-textarea.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}