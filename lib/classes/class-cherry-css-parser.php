<?php
/**
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

if ( ! class_exists( 'cherry_css_parser' ) ) {

	/**
	 * Cherry CSS compiler class
	 * Prepare dynamic CSS
	 *
	 * @since  4.0.0
	 */
	class cherry_css_parser {

		/**
		 * Avaliable variables list
		 *
		 * @var array
		 */
		public $variables;

		/**
		 * Avaliable functions list
		 *
		 * @var array
		 */
		public $functions;

		/**
		 * Variable pattern
		 *
		 * @var array
		 */
		public $var_pattern = '/\$(([-_a-zA-Z0-9]+)(\[[\'\"]*([-_a-zA-Z0-9]+)[\'\"]*\])?({([a-z%]+)})?)/';

		/**
		 * Function pattern
		 *
		 * @var array
		 */
		public $func_pattern = '/@(([a-zA-Z_]+)\(([^@\)]*)?\))/';

		function __construct() {

			$this->variables = $this->get_css_varaibles();
			$this->functions = $this->get_css_functions();

		}

		/**
		 * Get CSS variables into array
		 *
		 * @since  4.0.0
		 *
		 * @return array  dynamic CSS variables
		 */
		public function get_css_varaibles() {

			$var_list = array(
				'color-link',
				'color-link-hover',
				'color-primary',
				'color-secondary',
				'color-success',
				'color-info',
				'color-warning',
				'color-danger',
				'color-gray-variations',

				'typography-body',
				'typography-header-logo',
				'typography-footer-logo',
				'typography-header-menu',
				'typography-footer-menu',
				'typography-h1',
				'typography-h2',
				'typography-h3',
				'typography-h4',
				'typography-h5',
				'typography-h6',
				'typography-input-text',
				'typography-breadcrumbs',
				'typography-footer',

				'body-background',
				'header-background',
				'content-background',
				'footer-background',

				'grid-container-width',
				'header-boxed-width',
				'content-boxed-width',
				'footer-boxed-width',

				'header-grid-type',
				'content-grid-type',
				'footer-grid-type',

				'grid-responsive',
			);

			$var_list = apply_filters( 'cherry_css_var_list', $var_list );

			if ( ! is_array( $var_list ) ) {
				return array();
			}

			$result = array();

			foreach ( $var_list as $var ) {
				$result[$var] = cherry_get_option( $var );
			}

			return $result;
		}

		/**
		 * Get avaliable functions into array
		 *
		 * @since  4.0.0
		 *
		 * @return array  dynamic CSS variables
		 */
		public function get_css_functions() {

			$func_list = array(
				'darken'               => 'cherry_colors_darken',
				'lighten'              => 'cherry_colors_lighten',
				'contrast'             => 'cherry_contrast_color',
				'background'           => 'cherry_get_background_css',
				'typography'           => 'cherry_get_typography_css',
				'box'                  => 'cherry_get_box_model_css',
				'emph'                 => 'cherry_element_emphasis',
				'font_size'            => 'cherry_typography_size',
				'container_compare'    => 'cherry_container_width_compare',
				'non_responsive'       => 'cherry_non_responsive_style',
				'media_open'           => 'cherry_media_queries_open',
				'media_close'          => 'cherry_media_queries_close',
				'sum'                  => 'cherry_simple_sum',
				'diff'                 => 'cherry_simple_diff',
				'menu_toogle_endpoint' => 'cherry_menu_toogle_endpoint'
			);

			$func_list = apply_filters( 'cherry_css_func_list', $func_list );

			return $func_list;
		}

		/**
		 * Parse CSS string and replasce varaibles and functions
		 *
		 * @since 4.0.0
		 *
		 * @param string  $css  CSS to parse
		 */
		public function parse( $css ) {

			$replce_vars  = preg_replace_callback( $this->var_pattern, array( $this, 'replace_vars' ), $css );
			$replace_func = preg_replace_callback( $this->func_pattern, array( $this, 'replace_func' ), $replce_vars );

			$result = preg_replace( '/\t|\r|\n|\s{2,}/', '', $replace_func );
			$result = htmlspecialchars_decode( $result );

			return $result;

		}

		/**
		 * Callback function to replace CSS vars
		 *
		 * @since 4.0.0
		 *
		 * @param string  $matches  founded vars
		 */
		function replace_vars( $matches ) {

			$not_found = sprintf( '/* %s */', __( 'Variable not found', 'cherry' ) );

			// check if variable name found
			if ( empty( $matches[2] ) ) {
				return $not_found;
			}

			// check if var exists
			if ( ! array_key_exists( $matches[2], $this->variables ) ) {
				return $not_found;
			}

			$val = $this->variables[$matches[2]];

			$maybe_units = '';

			// check if we need to add units after value
			if ( ! empty( $matches[6] ) ) {
				$maybe_units = $matches[6];
			}

			// check if we search for array val
			if ( ! empty( $matches[4] ) && is_array( $val ) && isset( $val[$matches[4]] ) ) {
				return $val[$matches[4]] . $maybe_units;
			}

			if ( ! is_array( $val ) ) {
				return $val . $maybe_units;
			} else {
				return $matches[0];
			}

		}

		/**
		 * Callback function to replace CSS functions
		 *
		 * @since 4.0.0
		 *
		 * @param string  $matches  founded dunction
		 */
		function replace_func( $matches ) {

			$not_found = sprintf( '/* %s */', __( 'Function does not exist', 'cherry' ) );

			// check if functions name found
			if ( empty( $matches[2] ) ) {
				return $not_found;
			}

			// check if function exists and is not CSS @media query
			if ( ! array_key_exists( $matches[2], $this->functions ) && 'media' !== $matches[2] ) {
				return $not_found;
			} elseif ( 'media' == $matches[2] ) {
				return $matches[0];
			}

			$function = $this->functions[$matches[2]];
			$args     = isset( $matches[3] ) ? $matches[3] : array();

			if ( empty( $args ) ) {
				$result = call_user_func( $function );
				return $result;
			}

			$args = str_replace( ' ', '', $args );
			$args = explode( ',', $args );

			if ( ! function_exists( $function ) ) {
				return $not_found;
			}

			if ( ! empty( $args ) ) {
				$args = array_map( array( $this, 'prepare_args' ), $args );
			}

			$result = call_user_func_array( $function, $args );

			return $result;

		}

		/**
		 * Filter user function arguments
		 *
		 * @since 4.0.0
		 *
		 */
		function prepare_args( $item ) {

			$name = str_replace( '$', '', $item );

			if ( ! array_key_exists( $name, $this->variables ) ) {

				return $item;
			}

			return $this->variables[$name];

		}


	}

}