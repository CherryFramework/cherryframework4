<?php
/**
 * Class for the building ui-repeater elements.
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

if ( ! class_exists( 'UI_Repeater' ) ) {
	class UI_Repeater {

		private $name              = '';
		private $settings          = array();
		private $defaults_settings = array(
			'id'		=> 'cherry-ui-repeater-id',
			'name'		=> 'cherry-ui-repeater-name',
			'value'		=> array(
					array(
						'external-link'	=> 'http://google.com',
						'font-class'	=> 'dashicons-admin-site',
						'link-label'	=> 'custom text',
					),
					array(
						'external-link'	=> 'https://www.youtube.com/',
						'font-class'	=> 'dashicons-admin-generic',
						'link-label'	=> 'custom text',
					),
					array(
						'external-link'	=> 'https://vimeo.com/',
						'font-class'	=> 'dashicons-admin-media',
						'link-label'	=> 'custom text',
					),
				),
			'class'		=> '',
		);

		/**
		 * Constructor method for the UI_Repeater class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-repeater-'.uniqid();
			$this->settings                = wp_parse_args( $args, $this->defaults_settings );
			$this->name                    = $this->get_option_name();

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Repeater.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			$html .= '<div class="cherry-repeater-wrap" data-name="' . $this->settings['name'] . '">';
				$html .= '<div class="cherry-repeater-item-list">';
					$html .= '<div class="cherry-repeater-dublicate-item">';
						$html .= '<div class="col">';
							$html .= '<input class="' . $this->settings['class'] . 'external-link" name="' . $this->settings['name'] . '" type="text" placeholder="' . __( 'External link', 'cherry' ) . '" value="">';
						$html .= '</div>';
						$html .= '<div class="col">';
							$html .= '<input class="' . $this->settings['class'] . 'font-class" name="' . $this->settings['name'] . '" type="text" placeholder="' . __( 'Font class', 'cherry' ) . '" value="">';
						$html .= '</div>';
						$html .= '<div class="col">';
							$html .= '<input class="' . $this->settings['class'] . 'link-label" name="' . $this->settings['name'] . '" type="text" placeholder="' . __( 'Link label', 'cherry' ) . '" value="">';
						$html .= '</div>';
						$html .= '<input class="' . $this->settings['class'] . 'network-id" name="' . $this->settings['name'] . '" type="hidden" value="">';

						$html .= '<div class="repeater-delete-button-holder"><a class="repeater-delete-button" href="javascript:void(0);"><i class="dashicons dashicons-trash"></i></a></div>';
					$html .= '</div>';

					if( is_array( $this->settings['value'] ) ){
						$count = 0;
						foreach ( $this->settings['value']  as $handle => $handleArray ) {
							$html .= '<div class="cherry-repeater-item">';
								$html .= '<div class="col">';
									$html .= '<input class="' . $this->settings['class'] . 'external-link" name="' . $this->settings['name'] . '[' . $handle. '][external-link]" type="text" placeholder="' . __( 'External link', 'cherry' ) . '" value="' . esc_html( $handleArray['external-link'] ) . '">';
								$html .= '</div>';
								$html .= '<div class="col">';
									$html .= '<input class="' . $this->settings['class'] . 'font-class" name="' . $this->settings['name'] . '[' . $handle. '][font-class]" type="text" placeholder="' . __( 'Font class', 'cherry' ) . '" value="' . esc_html( $handleArray['font-class'] ) . '">';
								$html .= '</div>';
								$html .= '<div class="col">';
									$html .= '<input class="' . $this->settings['class'] . 'link-label" name="' . $this->settings['name'] . '[' . $handle. '][link-label]" type="text" placeholder="' . __( 'Link label', 'cherry' ) . '" value="' . esc_html( $handleArray['link-label'] ) . '">';
								$html .= '</div>';

								$value = ! empty( $handleArray['network-id'] ) ? $handleArray['network-id'] : 'network-' . $count;
								$html .= '<input class="network-id" name="' . $this->settings['name'] . '[' . $count . '][network-id]" type="hidden" value="' . $value . '">';

								$html .= '<div class="repeater-delete-button-holder"><a class="repeater-delete-button" href="javascript:void(0);"><i class="dashicons dashicons-trash"></i></a></div>';
							$html .= '</div>';
							$count++;
						}
					}
				$html .= '</div>';
				$html .= '<div class="repeater-add-button-holder">';
					$html .= '<a class="repeater-add-button" href="javascript:void(0);"><i class="dashicons dashicons-plus"></i></a>';
				$html .= '</div>';
			$html .= '</div>';

			return $html;
		}

		public function get_option_name() {

			if ( empty( $this->settings['name'] ) ) {
				return;
			}

			$option_name = explode( '[', $this->settings['name'] );
			$option_name = empty( $option_name[1] ) ? trim( $option_name[0], ']' ) : trim( $option_name[1], ']' );

			return $option_name;
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
		 * Enqueue javascript and stylesheet UI_Repeater
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'cherry-repeater-plugin-min',
				self::get_current_file_url() . '/assets/min/cherry-repeater-plugin.min.js',
				array( 'jquery', 'jquery-ui-sortable' ),
				'1.0.0',
				true
			);

			wp_enqueue_script(
				'ui-repeater-min',
				self::get_current_file_url() . '/assets/min/ui-repeater.min.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);

			wp_enqueue_style(
				'ui-repeater-min',
				self::get_current_file_url() . '/assets/min/ui-repeater.min.css',
				array(),
				'1.0.0',
				'all'
			);
		}
	}
}