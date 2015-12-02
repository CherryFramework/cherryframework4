<?php
/**
 * Class for the building ui-background elements.
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

if ( ! class_exists( 'UI_Background' ) ) {
	class UI_Background {

		private $settings = array();
		private $defaults_settings = array(
			'id'			=> 'cherry-ui-background-id',
			'name'			=> 'cherry-ui-background-name',
			'multi_upload'	=> true,
			'library_type'	=> 'image',
			'value'				=> array(
				'image'			=> '',
				'color'			=> '#ff0000',
				'repeat'		=> 'repeat',
				'position'		=> 'left',
				'attachment'	=> 'fixed',
				'clip'			=> 'padding-box',
				'size'			=> 'auto',
				'origin'		=> 'padding-box',
			),
			'label'			=> '',
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Background class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-background-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Background.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			$background_options = array(
				'repeat' => array(
						'no-repeat'		=> __( 'No repeat', 'cherry' ),
						'repeat'		=> __( 'Repeat All', 'cherry' ),
						'repeat-x'		=> __( 'Repeat Horizontally', 'cherry' ),
						'repeat-y'		=> __( 'Repeat Vertically', 'cherry' )
				),
				'position' => array(
						'top-left'		=> __( 'Top Left', 'cherry' ),
						'top'			=> __( 'Top Center', 'cherry' ),
						'right-top'		=> __( 'Top Right', 'cherry' ),
						'left'			=> __( 'Middle Left', 'cherry' ),
						'center'		=> __( 'Middle Center', 'cherry' ),
						'right'			=> __( 'Middle Right', 'cherry' ),
						'bottom-left'	=> __( 'Bottom Left', 'cherry' ),
						'bottom'		=> __( 'Bottom Center', 'cherry' ),
						'bottom-right'	=> __( 'Bottom Right', 'cherry' )
				),
				'attachment' => array(
						'notdefined'	=> __( 'Not defined', 'cherry' ),
						'scroll'		=> __( 'Scroll Normally', 'cherry' ),
						'fixed'			=> __( 'Fixed in Place', 'cherry' )
				),
				'clip' => array(
						'notdefined'	=> __( 'Not defined', 'cherry' ),
						'padding-box'	=> __( 'Padding box', 'cherry' ),
						'border-box'	=> __( 'Border box', 'cherry' ),
						'content-box'	=> __( 'Content box', 'cherry' )
				),
				'size' => array(
						'notdefined'	=> __( 'Not defined', 'cherry' ),
						'auto'			=> __( 'Auto', 'cherry' ),
						'cover'			=> __( 'Cover', 'cherry' ),
						'contain'		=> __( 'Contain', 'cherry' )
				),
				'origin' => array(
						'notdefined'	=> __( 'Not defined', 'cherry' ),
						'padding-box'	=> __( 'Padding box', 'cherry' ),
						'border-box'	=> __( 'Border box', 'cherry' ),
						'content-box'	=> __( 'Content box', 'cherry' )
				)
			);

			$ui_media = new UI_Media(
				array(
					'id'			=> $this->settings['id'].'-image',
					'name'			=> $this->settings['name'].'[image]',
					'value'			=> $this->settings['value']['image'],
					'multi_upload'	=> $this->settings['multi_upload'],
					'library_type'	=> $this->settings['library_type'],
				)
			);
			$ui_colorpicker = new UI_Colorpicker(
				array(
					'id'			=> $this->settings['id'].'-color',
					'name'			=> $this->settings['name'].'[color]',
					'value'			=> $this->settings['value']['color'],
				)
			);

			if( '' !== $this->settings['label'] ){
				$html .= '<label class="cherry-label" for="' . $this->settings['id'] . '">' . $this->settings['label'] . '</label> ';
			}
			$html .= '<div class="cherry-ui-background-wrap">';
				$html .= '<div class="cherry-ui-background-media">';
					$html .= $ui_media->render();
				$html .= '</div>';
				$html .= '<div class="cherry-ui-background-settings">';

					$html .= '<label for="' . $this->settings['id'] . '-settings">' . __( 'Background Settings', 'cherry' ) . '</label> ';
					$html .= '<div class="cherry-ui-background-color">';
						$html .= '<label for="' . $this->settings['id'] . '-color">' . __( 'Background Color', 'cherry' ) . '</label> ';
						$html .= $ui_colorpicker->render();
					$html .= '</div>';
					foreach ( $background_options as $options_key => $options_settings) {
						if( isset( $this->settings['value'][$options_key] ) ){
							$html .= '<div class="cherry-background-setting-item">';
								$ui_select = new UI_Select(
									array(
										'id'			=> $this->settings['id'] . '[' . $options_key . ']',
										'name'			=> $this->settings['name'] . '[' . $options_key . ']',
										'value'			=> $this->settings['value'][$options_key],
										'options'		=> $options_settings,
									)
								);
								$label = sprintf( __( 'Background %s', 'cherry' ), $options_key );
								$html .= '<label for="' . $this->settings['id'] . '[$options_key]">' . $label . '</label> ';
								$html .= $ui_select->render();
							$html .= '</div>';
						}
					}
					$html .= '<div class="clear"></div>';
				$html .= '</div>';

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
		 * Enqueue javascript and stylesheet UI_Background
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_style(
				'ui-background-min',
				self::get_current_file_url() . '/assets/min/ui-background.min.css',
				array(),
				'1.0.0',
				'all'
			);
		}
	}
}