<?php
/**
 * Class for the building ui-typography elements.
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

if ( ! class_exists( 'UI_Typography' ) ) {
	class UI_Typography {

		/**
		 * Define fonts server URL
		 * @var string
		 */
		public $fonts_host = '//fonts.googleapis.com/css';
		private $google_font_url	= null;
		private $standart_font_url	= null;
		private $google_font		= array();
		private $standart_font		= array();

		private $settings = array();
		private $defaults_settings = array(
			'id'				=> 'cherry-ui-typography-id',
			'name'				=> 'cherry-ui-typography-name',
			'max_value '		=> 500,
			'value'				=> array(
				//'fonttype'		=> 'standart',
				'family'		=> 'Arial, Helvetica',
				'character'		=> 'latin',
				'style'			=> 'regular',
				'size'			=> 20,
				'lineheight'	=> 20,
				'letterspacing' => 0,
				'align'			=> 'center',
				'color'			=> '#222222',
			),
			'class'			=> '',
		);

		/**
		 * Constructor method for the UI_Typography class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			$this->fonts_host = apply_filters( 'cherry_google_fonts_cdn', $this->fonts_host );

			$this->google_font_url = self::get_current_file_url() . '/assets/fonts/google-fonts.json';
			$this->standart_font_url = self::get_current_file_url() . '/assets/fonts/standard-fonts.json';

			$this->defaults_settings['id'] = 'cherry-ui-typography-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Typography.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';
			$text_align = array(
				'notdefined'	=> __( 'Not defined', 'cherry' ),
				'inherit'		=> __( 'Inherit', 'cherry' ),
				'left'			=> __( 'Left', 'cherry' ),
				'right'			=> __( 'Right', 'cherry' ),
				'center'		=> __( 'Center', 'cherry' ),
				'justify'		=> __( 'Justify', 'cherry' )
			);

			$google_fonts_array = $this->get_google_font();
			$standart_fonts_array = $this->get_standart_font();

			$character_array = array();
			$style_array = array();
			$fonttype = '';

			$html .= '<div class="cherry-ui-typography-wrap">';
			//Font Family
				$html .= '<div class="cherry-column-section">';
					$html .= '<div class="inner">';
						$html .= '<div class="field-font-family">';
							$html .= '<label for="' . $this->settings['id'] . '-family">' . __( 'Font Family', 'cherry' ) . '</label> ';
							$html .= '<select id="' . $this->settings['id'] . '-family" class="cherry-ui-select cherry-font-family" name="' . $this->settings['name'] . '[family]">';
								if( $standart_fonts_array && !empty( $standart_fonts_array ) && is_array( $standart_fonts_array ) ){
									$html .= '<optgroup label="' . __( 'Standart Webfonts', 'cherry' ) . '" data-font-type="standart">';
										foreach ($standart_fonts_array as $font_key => $font_value) {
											$category = is_array($font_value['category']) ? implode(",", $font_value['category']): $font_value['category'] ;
											$style = is_array($font_value['variants']) ? implode(",", $font_value['variants']): $font_value['variants'] ;
											$character = is_array($font_value['subsets']) ? implode(",", $font_value['subsets']): $font_value['subsets'] ;

											$selected_state = '';
											if( $this->settings['value']['family'] && !empty( $this->settings['value']['family'] ) ){
												if ( !is_array( $this->settings['value']['family'] ) ) {
													$this->settings['value']['family'] = array( $this->settings['value']['family'] );
												}

												foreach ( $this->settings['value']['family'] as $key => $value) {
													$selected_state = selected( $value, $font_value['family'], false );
													if( $selected_state == " selected='selected'" ){
														$fonttype = 'standart';
														break;
													}
												}
											}

											$html .= '<option value="' . $font_value['family'] . '" data-category="' . $category . '" data-style="' . $style . '" data-character="' . $character . '" ' . $selected_state . '>'. esc_html( $font_value['family'] ) .'</option>';
										}
									$html .= '</optgroup>';
								}
								if( $google_fonts_array && !empty( $google_fonts_array ) && is_array( $google_fonts_array ) ){
									$html .= '<optgroup label="' . __( 'Google Webfonts', 'cherry' ) . '" data-font-type="web">';
										foreach ( $google_fonts_array as $font_key => $font_value ) {
											$category = is_array($font_value['category']) ? implode(",", $font_value['category']): $font_value['category'] ;
											$style = is_array($font_value['variants']) ? implode(",", $font_value['variants']): $font_value['variants'] ;
											$character = is_array($font_value['subsets']) ? implode(",", $font_value['subsets']): $font_value['subsets'] ;

											foreach ($font_value['variants'] as $style_key => $style_value) {
												if(!array_key_exists ($style_value, $style_array)){
													$text_piece_1 = preg_replace ('/[0-9]/s', '', $style_value);
													$text_piece_2 = preg_replace ('/[A-Za-z]/s', ' ', $style_value);
													$value_text = ucwords($text_piece_2 . ' ' . $text_piece_1);
													$style_array[$style_value] = $value_text;
												}
											}

											foreach ($font_value['subsets'] as $character_key => $character_value) {
												if(!array_key_exists ($character_value, $character_array)){
													$value_text = str_replace('-ext', ' Extended', $character_value);
													$value_text = ucwords($value_text);
													$character_array[$character_value] = $value_text;
												}
											}
											$selected_state = '';
											if( $this->settings['value']['family'] && !empty( $this->settings['value']['family'] ) ){
												if ( !is_array( $this->settings['value']['family'] ) ) {
													$this->settings['value']['family'] = array( $this->settings['value']['family'] );
												}

												foreach ( $this->settings['value']['family'] as $key => $value) {
													$selected_state = selected( $value, $font_value['family'], false );
													if( $selected_state == " selected='selected'" ){
														$fonttype = 'web';
														break;
													}
												}
											}
											$html .= '<option value="' . $font_value['family'] . '" data-category="' . $category . '" data-style="' . $style . '" data-character="' . $character . '" ' . $selected_state . '>'. esc_html( $font_value['family'] ) .'</option>';
										}
									$html .= '</optgroup>';
								}
							$html .= '</select>';
						$html .= '</div>';
						$html .= '<div class="field-font-style">';
							if( $style_array && !empty( $style_array ) && is_array( $style_array )){
								$html .= '<label for="' . $this->settings['id'] . '-style">' . __( 'Font Style', 'cherry' ) . '</label> ';
								$ui_style_select = new UI_Select(
									array(
										'id'			=> $this->settings['id'] . '-style',
										'name'			=> $this->settings['name'] . '[style]',
										'value'			=> $this->settings['value']['style'],
										'options'		=> $style_array,
										'class'			=> 'cherry-font-style'
									)
								);
								$html .= $ui_style_select->render();
							}
						$html .= '</div>';
						$html .= '<div class="field-font-character">';
							if( $character_array && !empty( $character_array ) && is_array( $character_array )){
								$html .= '<label for="' . $this->settings['id'] . '-character">' . __( 'Character Sets', 'cherry' ) . '</label> ';
								$ui_character_select = new UI_Select(
									array(
										'id'			=> $this->settings['id'] . '-character',
										'name'			=> $this->settings['name'] . '[character]',
										'value'			=> $this->settings['value']['character'],
										'options'		=> $character_array,
										'class'			=> 'cherry-font-character'
									)
								);
								$html .= $ui_character_select->render();
							}
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
				$html .= '<div class="cherry-column-section">';
					$html .= '<div class="inner">';
						$html .= '<div class="field-font-size">';
							$html .= '<label for="' . $this->settings['id'] . '-size">' . __( 'Size', 'cherry' ) . '</label> ';

							$ui_size_stepper = new UI_Stepper(
								array(
									'id'			=> $this->settings['id'] . '-size>',
									'name'			=> $this->settings['name'] . '[size]',
									'value'			=> $this->settings['value']['size'],
									'max_value'		=> 500,
									'min_value'		=> 0,
									'step_value'	=> 1,
									'class'			=> 'font-size'
								)
							);
							$html .= $ui_size_stepper->render();
						$html .= '</div>';

						$html .= '<div class="field-font-lineheight">';
							$html .= '<label for="' . $this->settings['id'] . '-lineheight">' . __( 'Line-height', 'cherry' ) . '</label> ';
							$ui_lineheight_stepper = new UI_Stepper(
								array(
									'id'			=> $this->settings['id'] . '-lineheight>',
									'name'			=> $this->settings['name'] . '[lineheight]',
									'value'			=> $this->settings['value']['lineheight'],
									'max_value'		=> 500,
									'min_value'		=> 0,
									'step_value'	=> 1,
									'class'			=> 'font-lineheight'
								)
							);
							$html .= $ui_lineheight_stepper->render();
						$html .= '</div>';

						$html .= '<div class="field-font-letter-spacing">';
							$html .= '<label for="' . $this->settings['id'] . '-letterspacing">' . __( 'Letter-spacing', 'cherry' ) . '</label> ';
							$ui_letterspacing_stepper = new UI_Stepper(
								array(
									'id'			=> $this->settings['id'] . '-letterspacing>',
									'name'			=> $this->settings['name'] . '[letterspacing]',
									'value'			=> $this->settings['value']['letterspacing'],
									'max_value'		=> 50,
									'min_value'		=> -50,
									'step_value'	=> 1,
									'class'			=> 'font-letterspacing'
								)
							);
							$html .= $ui_letterspacing_stepper->render();
						$html .= '</div>';

						$html .= '<div class="field-font-color">';
							$html .= '<label for="' . $this->settings['id'] . '-color">' . __( 'Font color', 'cherry' ) . '</label> ';
							$ui_colorpicker = new UI_Colorpicker(
								array(
									'id'			=> $this->settings['id'] . '-color',
									'name'			=> $this->settings['name'] . '[color]',
									'value'			=> $this->settings['value']['color'],
									'class'			=> 'cherry-color-picker'
								)
							);
							$html .= $ui_colorpicker->render();
						$html .= '</div>';

						$html .= '<div class="field-font-align">';
							$html .= '<label for="' . $this->settings['id'] . '-align">' . __( 'Text align', 'cherry' ) . '</label> ';
							$ui_align_select = new UI_Select(
								array(
									'id'			=> $this->settings['id'] . '-align',
									'name'			=> $this->settings['name'] . '[align]',
									'value'			=> $this->settings['value']['align'],
									'options'		=> $text_align,
									'class'			=> 'cherry-text-align'
								)
							);
							$html .= $ui_align_select->render();
						$html .= '</div>';

						$html .= '<div class="clear"></div>';
					$html .= '</div>';
				$html .= '</div>';
				$html .= '<div class="clear"></div>';

				$ui_preview_textarea = new UI_Textarea(
					array(
						'id'			=> $this->settings['id'] . '-preview',
						'name'			=> 'none',
						'value'			=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
						'rows'			=> 4,
						'class'			=> 'cherry-font-preview',
					)
				);
				$html .= $ui_preview_textarea->render();

				$html .= '<input class="cherry-font-category" name="' . $this->settings['name'] . '[category]" value=""  type="hidden" />';
				$html .= '<input class="font-type" name="' . $this->settings['name'] . '[fonttype]" type="hidden" value="' . esc_html( $fonttype ) . '">';
			$html .= '</div>';
			return $html;
		}

		/**
		 * Get single font URL by font data
		 *
		 * @since  4.0.0
		 */
		public function get_single_font_url( $font_data ) {

			$font_data = wp_parse_args( $font_data, array(
				'family'    => '',
				'style'     => '',
				'character' => ''
			) );

			if ( ! $this->is_google_font( $font_data ) ) {
				return;
			}

			$font_family = $font_data['family'] . ':' . $font_data['style'];
			$subsets     = $font_data['character'];

			$query_args = array(
				'family' => urlencode( $font_family ),
				'subset' => urlencode( $subsets )
			);

			$fonts_url = add_query_arg( $query_args, $this->fonts_host );

			return $fonts_url;
		}
		/**
		 * Check if selected font is google font
		 *
		 * @since  4.0.0
		 *
		 * @param  array   $data  font data from option
		 * @return boolean
		 */
		public function is_google_font( $data ) {

		if ( ! isset( $data['fonttype'] ) ) {
			return false;
		}

		return ( 'web' == $data['fonttype'] );

		}
		/**
		 * Retrieve a list of available Standart fonts.
		 *
		 * @since  4.0.0
		 * @return array
		 */
		private function get_standart_font() {

			if ( empty( $this->standart_font ) ) {
				// Get cache.

				$fonts = get_transient( 'cherry_standart_fonts' );

				if ( false === $fonts ) {

					if ( !function_exists( 'WP_Filesystem' ) ) {
						include_once( ABSPATH . '/wp-admin/includes/file.php' );
					}

					WP_Filesystem();
					global $wp_filesystem;

					if ( !$wp_filesystem->exists( self::get_font_path(). '/assets/fonts/standard-fonts.json' ) ) { // Check for existence.
						return false;
					}

					// Read the file.
					$json = $wp_filesystem->get_contents( self::get_font_path(). '/assets/fonts/standard-fonts.json' );
					if ( !$json ) {
						return new WP_Error( 'reading_error', 'Error when reading file' ); // Return error object.
					}

					$content = json_decode( $json, true );
					$fonts   = $content['items'];

					// Set cache.
					set_transient( 'cherry_standart_fonts', $fonts, WEEK_IN_SECONDS );
				}
				$this->standart_font = $fonts;
			}

			return $this->standart_font;
		}
		/**
		 * Retrieve a list of available Google web fonts.
		 *
		 * @since  4.0.0
		 * @return array
		 */
		private function get_google_font() {
			if ( empty( $this->google_font ) ) {
				// Get cache.
				$fonts = get_transient( 'cherry_google_fonts' );

				if ( false === $fonts ) {
					if ( !function_exists( 'WP_Filesystem' ) ) {
						include_once( ABSPATH . '/wp-admin/includes/file.php' );
					}

					WP_Filesystem();
					global $wp_filesystem;

					if ( !$wp_filesystem->exists( self::get_font_path(). '/assets/fonts/google-fonts.json' ) ) { // Check for existence.
						return false;
					}

					// Read the file.
					$json = $wp_filesystem->get_contents( self::get_font_path(). '/assets/fonts/google-fonts.json' );

					if ( !$json ) {
						return new WP_Error( 'reading_error', 'Error when reading file' ); // Return error object.
					}

					$content = json_decode( $json, true );
					$fonts   = $content['items'];

					// Set cache.
					set_transient( 'cherry_google_fonts', $fonts, 1 );
				}

				$this->google_font = $fonts;
			}

			return $this->google_font;
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
		 * Get current file URL
		 *
		 * @since  4.0.0
		 */
		public static function get_font_path() {
			$assets_url = dirname( __FILE__ );
			/*$site_url = site_url();
			$assets_url = str_replace( untrailingslashit( ABSPATH ), $site_url, $assets_url );
			$assets_url = str_replace( '\\', '/', $assets_url );*/

			return dirname( __FILE__ );
		}

		/**
		 * Enqueue javascript and stylesheet UI_Typography
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-typography.min',
				self::get_current_file_url() . '/assets/ui-typography.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_style(
				'ui-typography',
				self::get_current_file_url() . '/assets/ui-typography.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}

add_action( 'wp_ajax_get_google_font_link', 'get_google_font_link' );

function get_google_font_link() {
	if ( !empty($_POST) && array_key_exists('font_data', $_POST) ) {
		$font_data = $_POST['font_data'];
		$font_family = (string)$font_data['family'];
		$font_style = (string)$font_data['style'];
		$font_character = (string)$font_data['character'];

		$google_fonts = new UI_Typography;

		$google_font_url = $google_fonts->get_single_font_url( array( 'family' => $font_family, 'style' => $font_style, 'character' => $font_character, 'fonttype' => 'web' ) );
		echo $google_font_url;
		exit;
	}
}