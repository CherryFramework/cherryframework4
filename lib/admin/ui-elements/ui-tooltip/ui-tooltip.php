<?php
/**
 * Class for the building ui-tooltip elements.
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

if ( ! class_exists( 'UI_Tooltip' ) ) {
	class UI_Tooltip {

		private $settings = array();
		private $defaults_settings = array(
			'id'			=> 'cherry-ui-tooltip-id',
			'hint'			=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum',
			),
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Tooltip class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-tooltip-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Tooltip.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			$type_hint = $this->settings['hint']['type'];
			switch ($type_hint) {
				case 'image':
					$html = '<div id="' . $this->settings['id'] . '" class="hint-image" data-hint-image="' . $this->settings['hint']['content'] .'"></div>';
					break;
				case 'video':
					$embed_code = wp_oembed_get($this->settings['hint']['content'], array('width' => 400));
					$html = '<div id="' . $this->settings['id'] . '" class="hint-video"  data-hint-video="">'. $embed_code .'</div>';
					break;
				default:
					$html = '<div id="' . $this->settings['id'] . '" class="hint-text" title="' . esc_html( $this->settings['hint']['content'] ) .'"><span class="dashicons dashicons-editor-help"></span></div>';
					break;
			}

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
		 * Enqueue javascript and stylesheet UI_Tooltip
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-tooltip-min',
				self::get_current_file_url() . '/assets/min/ui-tooltip.min.js',
				array( 'jquery', 'jquery-ui-tooltip' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_style(
				'ui-tooltip-min',
				self::get_current_file_url() . '/assets/min/ui-tooltip.min.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}