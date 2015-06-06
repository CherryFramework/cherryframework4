<?php
/**
 * Class for the building ui-ace-editor elements.
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

if ( ! class_exists( 'UI_Ace_Editor' ) ) {
	class UI_Ace_Editor {

		private $settings = array();
		private $defaults_settings = array(
			'id'				=> 'cherry-ui-ace-editor-id',
			'name'				=> 'cherry-ui-ace-editor-name',
			'value'				=> '',
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Ace_Editor class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-ace-editor-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Ace_Editor.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			$html .= '<div class="ace-editor-wrapper ' . $this->settings['class'] . '">';
				$html .= '<textarea id="' . $this->settings['id'] . '-textarea" class="ace-editor" name="' . $this->settings['name'] . '" data-editor="' . $this->settings['id'] . '-editor" data-editor-mode="css" data-editor-theme="monokai">';
					$html .= $this->settings['value'];
				$html .= '</textarea>';
				$html .= '<pre id="' . $this->settings['id'] . '-editor" class="ace-editor-area">';
					$html .= htmlspecialchars( $this->settings['value'] );
				$html .= '</pre>';
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
		 * Enqueue javascript and stylesheet UI_Ace_Editor
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ace',
				self::get_current_file_url() . '/assets/vendor/ace.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_script(
				'ui-ace-editor.min',
				self::get_current_file_url() . '/assets/min/ui-ace-editor.min.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_style(
				'ui-ace-editor',
				self::get_current_file_url() . '/assets/ui-ace-editor.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}