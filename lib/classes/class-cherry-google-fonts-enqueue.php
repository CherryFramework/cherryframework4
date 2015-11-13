<?php
/**
 * Cherry enqueue Google fonts class.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://themehybrid.com/plugins/breadcrumb-trail, http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Cherry enqueue Google fonts class.
 * @since  4.0.0
 */
class cherry_enqueue_fonts {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance = null;

	/**
	 * Array of typography options names
	 * @var array
	 */
	public $typography_options_set = array();

	/**
	 * Array of stored google fonts data
	 * @var array
	 */
	public $fonts_data = array();

	/**
	 * JSON string with google fonts data parsed from font file
	 * @var null
	 */
	public $google_fonts = null;

	/**
	 * Define fonts server URL
	 * @var string
	 */
	public $fonts_host = '//fonts.googleapis.com/css';

	function __construct() {

		$this->fonts_host = apply_filters( 'cherry_google_fonts_cdn', $this->fonts_host );

		add_action( 'cherry-options-updated', array( $this, 'reset_fonts_cache' ) );
		add_action( 'cherry-section-restored', array( $this, 'reset_fonts_cache' ) );
		add_action( 'cherry-options-restored', array( $this, 'reset_fonts_cache' ) );
		add_action( 'cherry_data_manager_install_complete', array( $this, 'reset_fonts_cache' ) );

		if ( is_admin() ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'prepare_fonts' ) );

	}

	/**
	 * Get fonts data and enqueue URL
	 *
	 * @since 4.0.0
	 */
	function prepare_fonts() {

		$font_url = $this->get_fonts_url();
		wp_enqueue_style( 'cherry-google-fonts', $font_url );
	}

	/**
	 * Return theme Google fonts URL to enqueue it
	 *
	 * @since  4.0.5
	 * @return string
	 */
	public function get_fonts_url() {

		$font_url = get_transient( 'cherry_google_fonts_url' );
		$font_url = false;

		if ( ! $font_url ) {

			// Get typography options list
			$this->get_options_set();

			// build Google fonts data array
			foreach ( $this->typography_options_set  as $option ) {
				$this->add_font( $option );
			}

			$font_url = $this->build_fonts_url();

			if ( false == $font_url ) {
				return;
			}

			set_transient( 'cherry_google_fonts_url', $font_url, WEEK_IN_SECONDS );
		}

		return $font_url;

	}

	/**
	 * Build Google fonts stylesheet URL from stored data
	 *
	 * @since  4.0.0
	 */
	function build_fonts_url() {

		$font_families = array();
		$subsets       = array();

		if ( empty( $this->fonts_data ) ) {
			return false;
		}

		foreach ( $this->fonts_data as $family => $data ) {
			$styles = implode( ',', array_unique( $data['style'] ) );
			$font_families[] = $family . ':' . $styles;
			$subsets = array_merge( $subsets, $data['character'] );
		}

		$subsets = array_unique( $subsets );

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( implode( ',', $subsets ) ),
		);

		$fonts_url = add_query_arg( $query_args, $this->fonts_host );

		return $fonts_url;
	}

	/**
	 * Get single typography option value from database and store it in object property
	 *
	 * @since  4.0.0
	 *
	 * @param  string  $option  option name to get from database
	 */
	function add_font( $option ) {

		$option_val = cherry_get_option( $option, false );

		if ( ! $option_val || ! is_array( $option_val ) ) {
			return;
		}

		if( array_key_exists( 'family' , $option_val)){
			$this->push_font( $option_val );
		}else{
			foreach ($option_val as $font_data ) {
				$this->push_font( $font_data );
			}
		}
	}

	/**
	 * Get single typography/webfont option value from database and store it in object property
	 *
	 * @since  4.0.0
	 *
	 * @param  string  $option  option name to get from database
	 */
	function push_font( $font_data ) {

		if ( ! $this->is_google_font( $font_data ) ) {
			return;
		}
		$font = $font_data['family'];

		if( !is_array( $font_data['character'] ) ){
			$font_data['character'] = array( $font_data['character'] );
		}
		if ( ! isset( $this->fonts_data[$font] ) ) {
			$style_set = is_array( $font_data['style'] ) ? $font_data['style'] : array( $font_data['style'] );
			$this->fonts_data[$font] = array(
				'style'     => $style_set,
				'character' => $font_data['character']
			);
		} else {
			$style_set = is_array( $font_data['style'] ) ? $font_data['style'] : array( $font_data['style'] );
			$this->fonts_data[$font] = array(
				'style'     => array_merge( $this->fonts_data[$font]['style'], $style_set ),
				'character' => array_merge( $this->fonts_data[$font]['character'], $font_data['character'] )
			);
		}
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
	 * Get options set from full options array
	 *
	 * @since  4.0.0
	 */
	function get_options_set() {

		if ( ! class_exists( 'Cherry_Options_Framework' ) ) {
			return;
		}

		$default_options_data = Cherry_Options_Framework::load_settings();

		array_walk( $default_options_data, array( $this, 'walk_sections' ) );
	}

	/**
	 * Walk through sections array
	 *
	 * @since  4.0.0
	 *
	 * @param  array  $item section data
	 * @param  string $key  section key
	 */
	function walk_sections( $item, $key ) {

		if ( is_array( $item ) && ! empty( $item['options-list'] ) ) {
			array_walk( $item['options-list'], array( $this, 'catch_option' ) );
		}

	}

	/**
	 * Catcn single typography while walking through options array
	 *
	 * @since  4.0.0
	 */
	function catch_option( $item, $key ) {

		if ( ! is_array( $item ) || ! array_key_exists( 'type', $item ) ) {
			return;
		}

		if ( 'typography' == $item['type'] || 'webfont' == $item['type'] ) {
			$this->typography_options_set[] = $key;
		}

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
	 * Reset fonts cache
	 *
	 * @since 4.0.0
	 */
	function reset_fonts_cache() {
		delete_transient( 'cherry_google_fonts_url' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  4.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

}

add_action( 'after_setup_theme', array( 'cherry_enqueue_fonts', 'get_instance' ), 40 );