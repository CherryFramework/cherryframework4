<?php
/**
 * Load current page object
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Cherry_Current_Page' ) ) {

	/**
	 * Current page object class
	 */
	class Cherry_Current_Page {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 4.0.5
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Current page object
		 * @var object
		 */
		private $current_page;

		/**
		 * Page object structure
		 * @var array
		 */
		public $structure;

		/**
		 * Queried object for current page
		 *
		 * @var int
		 */
		public $page_object;

		/**
		 * Context for current page.
		 *
		 * @since 4.0.6
		 * @access public
		 * @var string
		 */
		public $context;

		/**
		 * Constructor for the class
		 */
		function __construct() {

			$this->page_object = apply_filters( 'cherry_current_object_id', get_queried_object_id() );
			$this->structure   = apply_filters(
				'cherry_curent_page_obj_structure',
				array(
					'grid_header'       => array( $this, 'get_grid_header' ),
					'grid_content'      => array( $this, 'get_grid_content' ),
					'grid_footer'       => array( $this, 'get_grid_footer' ),
					'layout'            => array( $this, 'get_layout' ),
					'background_header' => array( $this, 'get_background_header' ),
				)
			);

		}

		/**
		 * Return whole current page object
		 *
		 * @since  4.0.5
		 * @return object
		 */
		public function get_page() {

			if ( ! empty( $this->current_page ) ) {

				return $this->current_page;
			}

			$this->current_page = new stdClass();

			foreach ( $this->structure as $property => $callback ) {

				if ( ! is_callable( $callback ) ) {
					continue;
				}

				$this->current_page->$property = call_user_func( $callback );
			}

			return $this->current_page;

		}

		/**
		 * Get single propery from current page object
		 *
		 * @since  4.0.5
		 * @param  string $property propery name to get.
		 * @param  string $location optional parameter, pass property location.
		 * @return mixed
		 */
		public function get_property( $property = null, $location = null ) {

			if ( ! $property ) {
				return false;
			}

			if ( null !== $location ) {
				$property .= '_' . $location;
			}

			$this->get_page();

			if ( isset( $this->current_page->$property ) ) {
				return $this->current_page->$property;
			}

			return false;
		}

		/**
		 * Get current page layout type
		 *
		 * @since  4.0.5
		 * @since  4.0.6 Using `$this->get_id()` method instead of `$this->page_object` property.
		 * @return string
		 */
		public function get_layout() {

			if ( isset( $this->current_page->layout ) ) {
				return $this->current_page->layout;
			}

			$layout = apply_filters(
				'cherry_get_page_layout',
				$this->get_meta( 'cherry_layout', true )
			);

			if ( $layout && ( 'default-layout' !== $layout ) ) {
				return $layout;
			}

			if ( is_single() ) {
				$layout = apply_filters(
					'cherry_get_single_post_layout',
					cherry_get_option( 'single-post-layout' ), $this->get_id()
				);
			} else {
				$layout = apply_filters(
					'cherry_get_archive_page_layout',
					cherry_get_option( 'page-layout' ), $this->get_id()
				);
			}

			return $layout;
		}

		/**
		 * Get header grid type
		 *
		 * @since  4.0.5
		 * @return string
		 */
		public function get_grid_header() {
			return $this->get_grid( 'header' );
		}

		/**
		 * Get content grid type
		 *
		 * @since  4.0.5
		 * @return string
		 */
		public function get_grid_content() {
			return $this->get_grid( 'content' );
		}

		/**
		 * Get footer grid type
		 *
		 * @since  4.0.5
		 * @return string
		 */
		public function get_grid_footer() {
			return $this->get_grid( 'footer' );
		}

		/**
		 * Get header background
		 *
		 * @since  4.0.5
		 * @return array
		 */
		public function get_background_header() {

			if ( isset( $this->current_page->background_header ) ) {
				return $this->current_page->background_header;
			}

			$styles = $this->get_meta( 'cherry_style', true );

			if ( ! $styles ) {
				return false;
			}

			$custom_bg = '';

			if ( isset( $styles['header-background'] ) ) {
				return $styles['header-background'];
			}

			return false;

		}

		/**
		 * Get grid type for current location
		 *
		 * @since  4.0.5
		 * @param  string $location site location to get grid data for.
		 * @return string
		 */
		public function get_grid( $location = false ) {

			if ( ! $location ) {
				return false;
			}

			$prop = 'grid_' . $location;

			if ( isset( $this->current_page->$prop ) ) {
				return $this->current_page->$prop;
			}

			// Gets a single value.
			$grid_type = apply_filters(
				'cherry_get_page_grid_type',
				$this->get_meta( 'cherry_grid_type', true )
			);

			if ( ! empty( $grid_type[ $location ] ) && ( 'default-grid-type' !== $grid_type[ $location ] ) ) {
				return $grid_type[ $location ];
			}

			$type = cherry_get_option( $location . '-grid-type' );

			return $type;
		}

		/**
		 * Retrieve meta field for a object.
		 *
		 * @since  4.0.6
		 * @param  string $key    The meta key to retrieve.
		 * @param  bool   $single Whether to return a single value.
		 * @return mixed          Meta field.
		 */
		public function get_meta( $key, $single ) {
			$id       = $this->get_id();
			$context  = $this->get_context();
			$callback = "get_{$context}_meta";

			if ( ! function_exists( $callback ) ) {

				/**
				 * Filter a returned boolean variable when a callback-function not exists.
				 *
				 * @since 4.0.6
				 * @param bool|mixed $meta    Value to return when object meta are empty.
				 * @param string     $context Object context.
				 * @param int        $id      Object ID.
				 * @param string     $key     The meta key to retrieve.
				 */
				return apply_filters( 'cherry_current_object_has_meta', false, $context, $id, $key );
			}

			$meta = call_user_func( $callback, $id, $key, $single );

			/**
			 * Filter a retrieve object meta.
			 *
			 * @since 4.0.6
			 * @param string $meta    Object meta.
			 * @param string $context Object context.
			 * @param int    $id      Object ID.
			 * @param string $key     The meta key to retrieve.
			 */
			return apply_filters( 'cherry_current_object_meta', $meta, $context, $id, $key );
		}

		/**
		 * Retrieve ID of the current queried object.
		 *
		 * @since  4.0.6
		 * @return int Object ID.
		 */
		public function get_id() {
			return $this->page_object;
		}

		/**
		 * Retrieve context of the current queried object.
		 *
		 * @since  4.0.6
		 * @return string
		 */
		public function get_context() {

			if ( isset( $this->context ) ) {
				return $this->context;
			}

			$this->context = 'post';

			if ( is_category() || is_tag() || is_tax() ) {
				$this->context = 'term';
			}

			/**
			 * Filter a current object context.
			 *
			 * @since 4.0.6
			 * @param string $context Object context.
			 * @param int    $id      Object ID.
			 */
			$this->context = apply_filters( 'cherry_current_object_context', $this->context, $this->get_id() );

			return $this->context;
		}

		/**
		 * Returns the instance.
		 *
		 * @since 4.0.5
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

	/**
	 * Get Cherry_Current_Page class instance
	 *
	 * @since  4.0.5
	 * @return object
	 */
	function cherry_current_page() {
		return Cherry_Current_Page::get_instance();
	}

}
