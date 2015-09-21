<?php
/**
 * Class for the building ui-webfont elements.
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

if ( ! class_exists( 'UI_Webfont' ) ) {
	class UI_Webfont {

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
			'id'			=> 'cherry-ui-typography-id',
			'name'			=> 'cherry-ui-typography-name',
			'value'			=> array(),
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

			$this->defaults_settings['id'] = 'cherry-ui-webfont-' . uniqid();

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

			$google_fonts_array = $this->get_google_font();
			$standart_fonts_array = $this->get_standart_font();
			$all_fonts_array = array();
			$html .= '<div class="cherry-ui-webfont-wrap" data-id="' . $this->settings['id'] . '" data-name="' . $this->settings['name'] . '">';
				$html .= '<div class="add-font-wrap">';
					$html .= '<div class="font-family">';
						$all_fonts_array = array(
							'optgroup-1' => array(
								'label'			=> __( 'Standard Webfonts', 'cherry' ),
								'group_options' => array()
							),
							'optgroup-2' => array(
								'label'			=> __( 'Google Webfonts', 'cherry' ),
								'group_options' => array()
							)
						);

						if( $standart_fonts_array && !empty( $standart_fonts_array ) && is_array( $standart_fonts_array ) ){
							foreach ( $standart_fonts_array as $font_key => $font_value ) {
								$all_fonts_array[ 'optgroup-1' ][ 'group_options' ][ $font_value['family'] ] = esc_html( $font_value['family'] );
							}
						}
						if( $google_fonts_array && !empty( $google_fonts_array ) && is_array( $google_fonts_array ) ){
							foreach ( $google_fonts_array as $font_key => $font_value ) {
								$all_fonts_array[ 'optgroup-2' ][ 'group_options' ][ $font_value['family'] ] = esc_html( $font_value['family'] );
							}
						}

						$ui_font_select = new UI_Select(
							array(
								'id'			=> $this->settings['id'] . '-font-family',
								'name'			=> $this->settings['name'],
								'value'			=> '',
								'options'		=> $all_fonts_array,
								'class'			=> 'new-font-select cherry-filter-select'
							)
						);
						$html .= $ui_font_select->render();
					$html .= '</div>';
					$html .= '<a class="add-button ajax-loader" href="javascript:void(0)"><span class="dashicons dashicons-plus"></span></a>';
					$html .= '<div class="clear"></div>';
				$html .= '</div>';
				$html .= '<div class="font-list">';
				$html .= '</div>';
			$html .= '</div>';

			return $html;
		}

		/**
		 * Get font variants ui_select
		 *
		 * @param  string 		font name
		 * @return string 		html
		 *
		 * @since  4.0.0
		 */
		public function get_font_variants( $id, $name, $value, $font ){
			$variants = array();

			$value = isset( $value ) ? $value : 'regular';

			foreach ( $this->get_standart_font() as $key => $font_settings ) {
				if( stripslashes( $font ) == stripslashes( $font_settings['family'] ) ){
					$variants = $font_settings['variants'];
				}
			}
			foreach ( $this->get_google_font() as $key => $font_settings ) {
				if( $font == $font_settings['family'] ){
					$variants = $font_settings['variants'];
				}
			}

			foreach ($variants as $variant_key => $variant_value) {
				$text_piece_1 = preg_replace ( '/[0-9]/s', '', $variant_value );
				$text_piece_2 = preg_replace ( '/[A-Za-z]/s', ' ', $variant_value );
				$value_text = ucwords( $text_piece_2 . ' ' . $text_piece_1 );
				$variants_array[ $variant_value ] = $value_text;
			}

			if( $variants_array && !empty( $variants_array ) && is_array( $variants_array )){
				$html = '<label for="' . $id . '">' . __( 'Font Style', 'cherry' ) . '</label> ';
				$ui_style_select = new UI_Select(
					array(
						'id'			=> $id . '-style',
						'name'			=> $name . '[style]',
						'value'			=> $value,
						'options'		=> $variants_array,
						'multiple'		=> true,
						'class'			=> 'cherry-font-style cherry-multi-select'
					)
				);
				$html .= $ui_style_select->render();

				return $html;
			}

			return false;
		}

		/**
		 * Get font subsets ui_select
		 *
		 * @param  string 		font name
		 * @return string 		html
		 *
		 * @since  4.0.0
		 */
		public function get_font_subsets( $id, $name, $value, $font ){
			$variants = array();

			$value = isset( $value ) ? $value : array( 'latin' );

			foreach ( $this->get_standart_font() as $key => $font_settings ) {
				if( stripslashes( $font ) == stripslashes( $font_settings['family'] ) ){
					$subsets = $font_settings['subsets'];
				}
			}
			foreach ( $this->get_google_font() as $key => $font_settings ) {
				if( $font == $font_settings['family'] ){
					$subsets = $font_settings['subsets'];
				}
			}

			foreach ( $subsets as $subset_key => $subset_value) {
					$value_text = str_replace( '-ext', ' Extended', $subset_value );
					$value_text = ucwords( $value_text );
					$character_array[ $subset_value ] = $value_text;
			}

			if( $character_array && !empty( $character_array ) && is_array( $character_array )){
				$html = '<label for="' . $id . '-character">' . __( 'Character Sets', 'cherry' ) . '</label> ';
				$ui_character_select = new UI_Select(
					array(
						'id'			=> $id . '-character',
						'name'			=> $name . '[character]',
						'value'			=> $value,
						'options'		=> $character_array,
						'multiple'		=> true,
						'class'			=> 'cherry-font-character cherry-multi-select'
					)
				);
				$html .= $ui_character_select->render();

				return $html;
			}

			return false;
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
				'ui-webfont.min',
				self::get_current_file_url() . '/assets/ui-webfont.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);

			wp_enqueue_style(
				'ui-webfont',
				self::get_current_file_url() . '/assets/ui-webfont.css',
				array(),
				'1.0.0',
				'all'
			);
		}

	}
}


add_action( 'wp_ajax_get_fonts_variants_subsets', 'get_fonts_variants_subsets' );

function get_fonts_variants_subsets() {
	if ( !empty($_POST) && array_key_exists('font', $_POST) && array_key_exists('id', $_POST) && array_key_exists('name', $_POST) ) {
		$font = $_POST['font'];
		$id = $_POST['id'];
		$name = $_POST['name'];

		$ui_webfont = new UI_Webfont;
		$html = '<div class="font-item">';
			$html .= '<div class="inner">';
				$html .= '<div class="font-variants">';
					$html .= $ui_webfont->get_font_variants( $id, $name, 'regular', $font );
				$html .= '</div>';
				$html .= '<div class="font-subsets">';
					$html .= $ui_webfont->get_font_subsets( $id, $name, 'latin', $font );
				$html .= '</div>';
				$html .= '<a class="remove-button" href="javascript:void(0)"><span class="dashicons dashicons-no"></span></a>';
				$html .= '<div class="clear"></div>';
			$html .= '</div>';
		$html .= '</div>';

		echo $html;
		exit;
	}
}
/*
add_action( 'wp_ajax_get_fonts_subsets', 'get_fonts_subsets' );

function get_fonts_subsets() {
	if ( !empty($_POST) && array_key_exists('font', $_POST) && array_key_exists('id', $_POST) && array_key_exists('name', $_POST) ) {
		$font = $_POST['font'];
		$id = $_POST['id'];
		$name = $_POST['name'];

		$ui_webfont = new UI_Webfont;
		$html = $ui_webfont->get_font_subsets( $id, $name, 'latin', $font );

		echo $html;
		exit;
	}
}*/