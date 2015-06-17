<?php
/**
 * Class for the building ui-static-area-editor elements.
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

if ( ! class_exists( 'UI_Static_Area_Editor' ) ) {
	class UI_Static_Area_Editor {

		private $settings = array();
		private $defaults_settings = array(
			'id'		=> 'cherry-ui-static-area-editor-id',
			'name'		=> 'cherry-ui-static-area-editor-name',
			'value'		=> array(
				'static_1' => array(
					'options' => array(
						'col-xs' => 'col-xs-1',
						'col-sm' => 'col-sm-1',
						'col-md' => 'col-md-1',
						'col-lg' => 'col-lg-1',
						'class' => '',
						'area' => 'header-top',
						'position' => 1,
					),
					'name' => 'Static 1',
				),
				'static_2' => array(
					'options' => array(
						'col-xs' => 'col-xs-1',
						'col-sm' => 'col-sm-1',
						'col-md' => 'col-md-1',
						'col-lg' => 'col-lg-1',
						'class' => '',
						'area' => 'header-top',
						'position' => 2,
					),
					'name' => 'Static 2',
				),
				'static_3' => array(
					'options' => array(
						'col-xs' => 'col-xs-1',
						'col-sm' => 'col-sm-1',
						'col-md' => 'col-md-1',
						'col-lg' => 'col-lg-1',
						'class' => '',
						'area' => 'footer-top',
						'position' => 3,
					),
					'name' => 'Static 3',
				),
			),
			'options'=> array(
				'static_1' => array(
					'options' => array(
						'col-xs' => 'col-xs-1',
						'col-sm' => 'col-sm-1',
						'col-md' => 'col-md-1',
						'col-lg' => 'col-lg-1',
						'class' => '',
						'area' => 'header-top',
						'position' => 1,
					),
					'name' => 'Static 1',
				),
				'static_2' => array(
					'options' => array(
						'col-xs' => 'col-xs-1',
						'col-sm' => 'col-sm-1',
						'col-md' => 'col-md-1',
						'col-lg' => 'col-lg-1',
						'class' => '',
						'area' => 'header-top',
						'position' => 2,
					),
					'name' => 'Static 2',
				),
				'static_3' => array(
					'options' => array(
						'col-xs' => 'col-xs-1',
						'col-sm' => 'col-sm-1',
						'col-md' => 'col-md-1',
						'col-lg' => 'col-lg-1',
						'class' => '',
						'area' => 'footer-top',
						'position' => 3,
					),
					'name' => 'Static 3',
				),
			),
			'class'		=> '',
		);

		/**
		 * Constructor method for the UI_Static_Area_Editor class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->defaults_settings['id'] = 'cherry-ui-static-area-editor-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Static_Area_Editor.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			global $cherry_registered_static_areas;
			$col_xs_array = array(
				'none'		=> __( 'none', 'cherry' ),
				'col-xs-1'	=> __( 'col-xs-1', 'cherry' ),
				'col-xs-2'	=> __( 'col-xs-2', 'cherry' ),
				'col-xs-3'	=> __( 'col-xs-3', 'cherry' ),
				'col-xs-4'	=> __( 'col-xs-4', 'cherry' ),
				'col-xs-5'	=> __( 'col-xs-5', 'cherry' ),
				'col-xs-6'	=> __( 'col-xs-6', 'cherry' ),
				'col-xs-7'	=> __( 'col-xs-7', 'cherry' ),
				'col-xs-8'	=> __( 'col-xs-8', 'cherry' ),
				'col-xs-9'	=> __( 'col-xs-9', 'cherry' ),
				'col-xs-10'	=> __( 'col-xs-10', 'cherry' ),
				'col-xs-11'	=> __( 'col-xs-11', 'cherry' ),
				'col-xs-12'	=> __( 'col-xs-12', 'cherry' ),
			);
			$col_sm_array = array(
				'none'		=> __( 'none', 'cherry' ),
				'col-sm-1'	=> __( 'col-sm-1', 'cherry' ),
				'col-sm-2'	=> __( 'col-sm-2', 'cherry' ),
				'col-sm-3'	=> __( 'col-sm-3', 'cherry' ),
				'col-sm-4'	=> __( 'col-sm-4', 'cherry' ),
				'col-sm-5'	=> __( 'col-sm-5', 'cherry' ),
				'col-sm-6'	=> __( 'col-sm-6', 'cherry' ),
				'col-sm-7'	=> __( 'col-sm-7', 'cherry' ),
				'col-sm-8'	=> __( 'col-sm-8', 'cherry' ),
				'col-sm-9'	=> __( 'col-sm-9', 'cherry' ),
				'col-sm-10'	=> __( 'col-sm-10', 'cherry' ),
				'col-sm-11'	=> __( 'col-sm-11', 'cherry' ),
				'col-sm-12'	=> __( 'col-sm-12', 'cherry' ),
			);
			$col_md_array = array(
				'none'		=> __( 'none', 'cherry' ),
				'col-md-1'	=> __( 'col-md-1', 'cherry' ),
				'col-md-2'	=> __( 'col-md-2', 'cherry' ),
				'col-md-3'	=> __( 'col-md-3', 'cherry' ),
				'col-md-4'	=> __( 'col-md-4', 'cherry' ),
				'col-md-5'	=> __( 'col-md-5', 'cherry' ),
				'col-md-6'	=> __( 'col-md-6', 'cherry' ),
				'col-md-7'	=> __( 'col-md-7', 'cherry' ),
				'col-md-8'	=> __( 'col-md-8', 'cherry' ),
				'col-md-9'	=> __( 'col-md-9', 'cherry' ),
				'col-md-10'	=> __( 'col-md-10', 'cherry' ),
				'col-md-11'	=> __( 'col-md-11', 'cherry' ),
				'col-md-12'	=> __( 'col-md-12', 'cherry' ),
			);
			$col_lg_array = array(
				'none'		=> __( 'none', 'cherry' ),
				'col-lg-1'	=> __( 'col-lg-1', 'cherry' ),
				'col-lg-2'	=> __( 'col-lg-2', 'cherry' ),
				'col-lg-3'	=> __( 'col-lg-3', 'cherry' ),
				'col-lg-4'	=> __( 'col-lg-4', 'cherry' ),
				'col-lg-5'	=> __( 'col-lg-5', 'cherry' ),
				'col-lg-6'	=> __( 'col-lg-6', 'cherry' ),
				'col-lg-7'	=> __( 'col-lg-7', 'cherry' ),
				'col-lg-8'	=> __( 'col-lg-8', 'cherry' ),
				'col-lg-9'	=> __( 'col-lg-9', 'cherry' ),
				'col-lg-10'	=> __( 'col-lg-10', 'cherry' ),
				'col-lg-11'	=> __( 'col-lg-11', 'cherry' ),
				'col-lg-12'	=> __( 'col-lg-12', 'cherry' ),
			);
				$html .= '<div id="' . $this->settings['id'] . '" class="cherry-static-area-editor-wrap" data-name="' .$this->settings['name'] . '">';
					$html .= '<div class="area-units">';
						foreach ( $cherry_registered_static_areas as $area => $area_settings ) {
							$html .= '<div class="area-unit" data-area="' . $area . '">';
								$html .= '<h3 class="title-primary_ title-mid_ text_center_">' . $area_settings['name'] . '</h3>';
								$html .= '<div class="accordion-unit">';
									foreach ( $this->settings['value'] as $handle => $handleArray ) {
										if ( $area == $handleArray['options']['area'] && 'available-statics' !== $handleArray['options']['area'] ) {
											$html .= '<div class="group" data-static-id="' . $handle . '">';
											$html .= '<h3><span class="label">' . $handleArray['name'] . '</span><div class="delete-group dashicons dashicons-trash"></div></h3>';
											$html .= '<div>';
												$html .= '<div class="field-col-xs">';
													$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-xs">' . __( '.col-xs-*', 'cherry' ) . '</label> ';
													$ui_xs_select = new UI_Select(
														array(
															'id'			=> $this->settings['id'] . '-' . $handle . '-col-xs',
															'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-xs]',
															'value'			=> $handleArray['options']['col-xs'],
															'options'		=> $col_xs_array,
															'class'			=> 'key-col-xs'
														)
													);
													$html .= $ui_xs_select->render();
												$html .= '</div>';
												$html .= '<div class="field-col-sm">';
													$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-sm">' . __( '.col-sm-*', 'cherry' ) . '</label> ';
													$ui_sm_select = new UI_Select(
														array(
															'id'			=> $this->settings['id'] . '-' . $handle . '-col-sm',
															'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-sm]',
															'value'			=> $handleArray['options']['col-sm'],
															'options'		=> $col_sm_array,
															'class'			=> 'key-col-sm'
														)
													);
													$html .= $ui_sm_select->render();
												$html .= '</div>';
												$html .= '<div class="field-col-md">';
													$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-md">' . __( '.col-md-*', 'cherry' ) . '</label> ';
													$ui_md_select = new UI_Select(
														array(
															'id'			=> $this->settings['id'] . '-' . $handle . '-col-md',
															'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-md]',
															'value'			=> $handleArray['options']['col-md'],
															'options'		=> $col_md_array,
															'class'			=> 'key-col-md'
														)
													);
													$html .= $ui_md_select->render();
												$html .= '</div>';
												$html .= '<div class="field-col-lg">';
													$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-lg">' . __( '.col-lg-*', 'cherry' ) . '</label> ';
													$ui_lg_select = new UI_Select(
														array(
															'id'			=> $this->settings['id'] . '-' . $handle . '-col-lg',
															'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-lg]',
															'value'			=> $handleArray['options']['col-lg'],
															'options'		=> $col_lg_array,
															'class'			=> 'key-col-lg'
														)
													);
													$html .= $ui_lg_select->render();
												$html .= '</div>';
												$html .= '<div class="field-class">';
													$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-class">' . __( 'Custom class', 'cherry' ) . '</label> ';
													$ui_class_text = new UI_Text(
														array(
															'id'			=> $this->settings['id'] . '-' . $handle . '-class',
															'name'			=> $this->settings['name'] . '[' . $handle . '][options][class]',
															'value'			=> esc_html( $handleArray['options']['class'] ),
															'class'			=> 'key-custom-class',
														)
													);
													$html .= $ui_class_text->render();
												$html .= '</div>';
												$html .= '<input type="hidden" class="key-item-name" name="' . $this->settings['name'] . '[' . $handle . '][name]" value="' . $handleArray['name'] . '">';
												$html .= '<input type="hidden" class="key-area" name="' . $this->settings['name'] . '[' . $handle . '][options][area]" value="' . $handleArray['options']['area'] . '">';
												$html .= '<input type="hidden" class="key-position" name="' . $this->settings['name'] . '[' . $handle . '][options][position]" value="' . $handleArray['options']['position'] . '">';
											$html .= '</div>';
										$html .= '</div>';
										}
									}
								$html .= '</div>';//end accordion-unit
							$html .= '</div>';//end area-unit
						}// end foreach $available_areas
					$html .= '</div>';//end area-units

					$html .= '<div class="available-statics area-unit" data-area="available-statics">';
						$html .= '<h3 class="title-primary_ title-mid_ text_center_">' . __('Available statics', 'cherry') . '</h3>';
						$html .= '<div class="accordion-unit">';
							foreach ( $this->settings['value'] as $handle => $handleArray ) {
								if ( 'available-statics' == $handleArray['options']['area'] ) {
									$html .= '<div class="group" data-static-id="' . $handle . '">';
									$html .= '<h3><span class="label">' . $handleArray['name'] . '</span><div class="delete-group dashicons dashicons-trash"></div></h3>';
									$html .= '<div>';
										$html .= '<div class="field-col-xs">';
											$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-xs">' . __( '.col-xs-*', 'cherry' ) . '</label> ';
											$ui_xs_select = new UI_Select(
												array(
													'id'			=> $this->settings['id'] . '-' . $handle . '-col-xs',
													'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-xs]',
													'value'			=> $handleArray['options']['col-xs'],
													'options'		=> $col_xs_array,
													'class'			=> 'key-col-xs'
												)
											);
											$html .= $ui_xs_select->render();
										$html .= '</div>';
										$html .= '<div class="field-col-sm">';
											$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-sm">' . __( '.col-sm-*', 'cherry' ) . '</label> ';
											$ui_sm_select = new UI_Select(
												array(
													'id'			=> $this->settings['id'] . '-' . $handle . '-col-sm',
													'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-sm]',
													'value'			=> $handleArray['options']['col-sm'],
													'options'		=> $col_sm_array,
													'class'			=> 'key-col-sm'
												)
											);
											$html .= $ui_sm_select->render();
										$html .= '</div>';
										$html .= '<div class="field-col-md">';
											$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-md">' . __( '.col-md-*', 'cherry' ) . '</label> ';
											$ui_md_select = new UI_Select(
												array(
													'id'			=> $this->settings['id'] . '-' . $handle . '-col-md',
													'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-md]',
													'value'			=> $handleArray['options']['col-md'],
													'options'		=> $col_md_array,
													'class'			=> 'key-col-md'
												)
											);
											$html .= $ui_md_select->render();
										$html .= '</div>';
										$html .= '<div class="field-col-lg">';
											$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-col-lg">' . __( '.col-lg-*', 'cherry' ) . '</label> ';
											$ui_lg_select = new UI_Select(
												array(
													'id'			=> $this->settings['id'] . '-' . $handle . '-col-lg',
													'name'			=> $this->settings['name'] . '[' . $handle . '][options][col-lg]',
													'value'			=> $handleArray['options']['col-lg'],
													'options'		=> $col_lg_array,
													'class'			=> 'key-col-lg'
												)
											);
											$html .= $ui_lg_select->render();
										$html .= '</div>';
										$html .= '<div class="field-class">';
											$html .= '<label for="' . $this->settings['id'] . '-' . $handle . '-class">' . __( 'Custom class', 'cherry' ) . '</label> ';
											$ui_class_text = new UI_Text(
												array(
													'id'			=> $this->settings['id'] . '-' . $handle . '-class',
													'name'			=> $this->settings['name'] . '[' . $handle . '][options][class]',
													'value'			=> esc_html( $handleArray['options']['class'] ),
													'class'			=> 'key-custom-class',
												)
											);
											$html .= $ui_class_text->render();
										$html .= '</div>';
										$html .= '<input type="hidden" class="key-item-name" name="' . $this->settings['name'] . '[' . $handle . '][name]" value="' . $handleArray['name'] . '">';
										$html .= '<input type="hidden" class="key-area" name="' . $this->settings['name'] . '[' . $handle . '][options][area]" value="' . $handleArray['options']['area'] . '">';
										$html .= '<input type="hidden" class="key-position" name="' . $this->settings['name'] . '[' . $handle . '][options][position]" value="' . $handleArray['options']['position'] . '">';
									$html .= '</div>';
								$html .= '</div>';
								}
							}
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
		 * Enqueue javascript and stylesheet UI_Static_Area_Editor
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'statics-areas-editor-plugin',
				self::get_current_file_url() . '/assets/statics-areas-editor-plugin.js',
				array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-sortable' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_script(
				'ui-static-area-editor.min',
				self::get_current_file_url() . '/assets/min/ui-static-area-editor.min.js',
				array( 'jquery' ),
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
				'ui-static-area-editor',
				self::get_current_file_url() . '/assets/ui-static-area-editor.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}