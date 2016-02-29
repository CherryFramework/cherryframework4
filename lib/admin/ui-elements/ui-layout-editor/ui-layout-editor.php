<?php
/**
 * Class for the building ui-layout-editor elements.
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

if ( ! class_exists( 'UI_Layout_Editor' ) ) {
	class UI_Layout_Editor {

		private $settings = array();
		private $defaults_settings = array(
			'id'				=> 'cherry-ui-layout-editor-id',
			'name'				=> 'cherry-ui-layout-editor-name',
			'value'			=> array(
				'position'	=> array(
					'top'		=> '',
					'right'		=> '',
					'bottom'	=> '',
					'left'		=> '',
				),
				'margin'	=> array(
					'top'		=> '',
					'right'		=> '',
					'bottom'	=> '',
					'left'		=> '',
				),
				'border'	=> array(
					'top'		=> '1px',
					'right'		=> '1px',
					'bottom'	=> '1px',
					'left'		=> '1px',
					'style'		=> 'solid',
					'radius'	=> '0',
					'color'		=> '#ff0000'
				),
				'padding'	=> array(
					'top'		=> '',
					'right'		=> '',
					'bottom'	=> '',
					'left'		=> '',
				),
				'container'	=> array(
					'width'		=> '',
					'height'	=> '',
				),
			),
			'label'			=> '',
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Layout_Editor class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-layout-editor-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Layout_Editor.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			if( '' !== $this->settings['label'] ){
				$html .= '<label class="cherry-label" for="' . $this->settings['id'] . '">' . $this->settings['label'] . '</label> ';
			}
			$html .= '<div id="' . $this->settings['id'] . '" class="cherry-layout-editor-wrap ' . $this->settings['class'] . '">';
				$html .= '<div class="cherry-layout-editor-inner">';
					$html .= '<input class="ui-layout-editor-input input-top" name="' . $this->settings['name'] . '[position][top]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['position']['top'] ) . '">';
					$html .= '<input class="ui-layout-editor-input input-right" name="' . $this->settings['name'] . '[position][right]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['position']['right'] ) . '">';
					$html .= '<input class="ui-layout-editor-input input-bottom" name="' . $this->settings['name'] . '[position][bottom]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['position']['bottom'] ) . '">';
					$html .= '<input class="ui-layout-editor-input input-left" name="' . $this->settings['name'] . '[position][left]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['position']['left'] ) . '">';
					$html .= '<div class="position-inner">';
						$html .= '<span class="hint-label">' . __( 'position', 'cherry' ) .'</span>';
						$html .= '<div class="margin-inner">';
							$html .= '<span class="hint-label">' . __( 'margin', 'cherry' ) .'</span>';
							$html .= '<input class="ui-layout-editor-input input-top" name="' . $this->settings['name'] . '[margin][top]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['margin']['top'] ) . '">';
							$html .= '<input class="ui-layout-editor-input input-right" name="' . $this->settings['name'] . '[margin][right]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['margin']['right'] ) . '">';
							$html .= '<input class="ui-layout-editor-input input-bottom" name="' . $this->settings['name'] . '[margin][bottom]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['margin']['bottom'] ) . '">';
							$html .= '<input class="ui-layout-editor-input input-left" name="' . $this->settings['name'] . '[margin][left]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['margin']['left'] ) . '">';
							$html .= '<div class="border-inner">';
								$html .= '<span class="hint-label">' . __( 'border', 'cherry' ) .'</span>';
								$html .= '<input class="ui-layout-editor-input input-top" name="' . $this->settings['name'] . '[border][top]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['border']['top'] ) . '">';
								$html .= '<input class="ui-layout-editor-input input-right" name="' . $this->settings['name'] . '[border][right]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['border']['right'] ) . '">';
								$html .= '<input class="ui-layout-editor-input input-bottom" name="' . $this->settings['name'] . '[border][bottom]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['border']['bottom'] ) . '">';
								$html .= '<input class="ui-layout-editor-input input-left" name="' . $this->settings['name'] . '[border][left]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['border']['left'] ) . '">';
								$html .= '<div class="padding-inner">';
									$html .= '<span class="hint-label">' . __( 'padding', 'cherry' ) .'</span>';
									$html .= '<input class="ui-layout-editor-input input-top" name="' . $this->settings['name'] . '[padding][top]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['padding']['top'] ) . '">';
									$html .= '<input class="ui-layout-editor-input input-right" name="' . $this->settings['name'] . '[padding][right]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['padding']['right'] ) . '">';
									$html .= '<input class="ui-layout-editor-input input-bottom" name="' . $this->settings['name'] . '[padding][bottom]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['padding']['bottom'] ) . '">';
									$html .= '<input class="ui-layout-editor-input input-left" name="' . $this->settings['name'] . '[padding][left]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['padding']['left'] ) . '">';
									$html .= '<div class="container-inner">';
										$html .= '<span class="hint-label">' . __( 'size', 'cherry' ) .'</span>';
										$html .= '<input class="ui-layout-editor-input input-width" name="' . $this->settings['name'] . '[container][width]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['container']['width'] ) . '">';
										$html .= '<input class="ui-layout-editor-input input-height" name="' . $this->settings['name'] . '[container][height]" type="text" placeholder="-" value="' . esc_html( $this->settings['value']['container']['height'] ) . '">';
									$html .= '</div>';
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
				$html .= '<div class="border-controls">';
					$html .= '<div class="border-control border-control-style">';
						$border_styles = array(
							'solid'		=> __( 'solid', 'cherry' ),
							'dashed'	=> __( 'dashed', 'cherry' ),
							'dotted'	=> __( 'dotted', 'cherry' ),
							'double'	=> __( 'double', 'cherry' ),
							'groove'	=> __( 'groove', 'cherry' ),
							'ridge'		=> __( 'ridge', 'cherry' ),
							'inset'		=> __( 'inset', 'cherry' ),
							'outset'	=> __( 'outset', 'cherry' ),
							'none'		=> __( 'none', 'cherry' ),
						);

						$html .= '<label for="' . $this->settings['id'] . '-border-style">' . __( 'Border style', 'cherry' ) . '</label> ';
						if($border_styles && !empty($border_styles) && is_array($border_styles)){
							$ui_border_style_select = new UI_Select(
								array(
									'id'			=> $this->settings['id'] . '-border-style',
									'name'			=> $this->settings['name'] . '[border][style]',
									'value'			=> $this->settings['value']['border']['style'],
									'options'		=> $border_styles,
									'class'			=> 'cherry-border-style'
								)
							);
							$html .= $ui_border_style_select->render();
						}
					$html .= '</div>';
					$html .= '<div class="border-control border-control-radius">';
						$html .= '<label for="' . $this->settings['id'] . '-border-radius">' . __( 'Border radius', 'cherry' ) . '</label> ';
						$ui_border_radius = new UI_Text(
							array(
								'id'			=> $this->settings['id'] . '-border-radius',
								'name'			=> $this->settings['name'] . '[border][radius]',
								'value'			=> $this->settings['value']['border']['radius'],
								'class'			=> 'cherry-border-radius'
							)
						);
						$html .= $ui_border_radius->render();
					$html .= '</div>';
					$html .= '<div class="border-control border-control-color">';
						$html .= '<label for="' . $this->settings['id'] . '-border-color">' . __( 'Border color', 'cherry' ) . '</label> ';
						$ui_border_colorpicker = new UI_Colorpicker(
							array(
								'id'			=> $this->settings['id'] . '-border-color',
								'name'			=> $this->settings['name'] . '[border][color]',
								'value'			=> $this->settings['value']['border']['color'],
								'class'			=> 'cherry-border-color'
							)
						);
						$html .= $ui_border_colorpicker->render();
					$html .= '</div>';
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
		 * Enqueue javascript and stylesheet UI_Layout_Editor
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){

			wp_enqueue_script(
				'ui-layout-editor-min',
				self::get_current_file_url() . '/assets/min/ui-layout-editor.min.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_style(
				'ui-layout-editor-min',
				self::get_current_file_url() . '/assets/min/ui-layout-editor.min.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}