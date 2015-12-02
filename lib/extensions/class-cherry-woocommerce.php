<?php
/**
 * Add basic Woocommerce compatibility
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

if ( ! class_exists( 'Cherry_Woocommerce' ) ) {

	class Cherry_Woocommerce {

		function __construct() {

			if ( ! $this->has_woocommerce() ) {
				return;
			}

			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			add_filter( 'woocommerce_show_page_title', array( $this, 'remove_archive_title' ) );

			add_filter( 'cherry_layouts_add_post_type_support', array( $this, 'add_cherry_meta_boxes' ) );
			add_filter( 'cherry_grid_type_add_post_type_support', array( $this, 'add_cherry_meta_boxes' ) );
			add_filter( 'cherry_post_style_add_post_type_support', array( $this, 'add_cherry_meta_boxes' ) );

			add_filter( 'cherry_layouts_metabox_params', array( $this, 'change_cherry_metabox_priority' ) );
			add_filter( 'cherry_grid_type_metabox_params', array( $this, 'change_cherry_metabox_priority' ) );
			add_filter( 'cherry_post_style_metabox_params', array( $this, 'change_cherry_metabox_priority' ) );

			add_filter( 'cherry_breadcrumbs_custom_trail', array( $this, 'get_woo_breadcrumbs' ), 10, 2 );

			add_filter( 'cherry_current_object_id', array( $this, 'fix_shop_page_object' ) );
			add_filter( 'cherry_current_object_context', array( $this, 'fix_shop_page_context' ) );

			add_action( 'after_setup_theme', array( $this, 'define_support' ) );
		}

		/**
		 * Declare theme support
		 *
		 * @since  4.0.0
		 */
		public function define_support() {
			add_theme_support( 'woocommerce' );
		}

		/**
		 * Get custom WooCommerce breadcrumbs trail
		 *
		 * @since  4.0.0
		 * @param  bool  $is_custom_breadcrumbs  default custom breadcrums trigger
		 */
		public function get_woo_breadcrumbs( $is_custom_breadcrumbs, $args ) {

			if ( ! $this->is_woo_page() ) {
				return $is_custom_breadcrumbs;
			}

			if ( ! class_exists( 'Cherry_Woo_Breadcrumbs' ) ) {
				require_once( trailingslashit( CHERRY_EXTENSIONS ) . 'class-cherry-woo-breadcrumbs.php' );
			}

			$woo_breadcrums = new Cherry_Woo_Breadcrumbs( $args );
			return array( 'items' => $woo_breadcrums->items, 'page_title' => $woo_breadcrums->page_title );
		}

		/**
		 * Add supports for cherry meta boxes on product page
		 *
		 * @since  4.0.0
		 */
		public function add_cherry_meta_boxes( $defaults ) {
			$defaults[] = 'product';
			return $defaults;
		}

		/**
		 * Change Cherry metabox priority for products, to move them below products box
		 *
		 * @since  4.0.0
		 * @param  array $defaults default meta box params
		 */
		public function change_cherry_metabox_priority( $defaults ) {
			$post_type = get_post_type();
			if ( 'product' !== $post_type ) {
				return $defaults;
			}
			$defaults['priority'] = 'default';
			return $defaults;
		}

		/**
		 * Remove default woocommerce page title from archive pages
		 *
		 * @since  4.0.0
		 * @param  bool $show_title
		 */
		public function remove_archive_title( $show_title ) {
			return false;
		}

		/**
		 * Change default object ID for shop page and shop categories.
		 *
		 * @since  4.0.5
		 * @param  string $object_id current page object ID.
		 * @return string
		 */
		public function fix_shop_page_object( $object_id ) {

			if ( ! function_exists( 'is_shop' ) || ! function_exists( 'wc_get_page_id' ) ) {
				return $object_id;
			}

			if ( ! is_shop() && ! is_tax( 'product_cat' ) && ! is_tax( 'product_tag' ) ) {
				return $object_id;
			}

			$page_id = wc_get_page_id( 'shop' );

			return $page_id;

		}

		/**
		 * set default context for shop page and category tp 'post'
		 *
		 * @since  4.0.6
		 * @param  string $context current context.
		 * @return string
		 */
		public function fix_shop_page_context( $context ) {

			if ( ! function_exists( 'is_shop' ) || ! function_exists( 'wc_get_page_id' ) ) {
				return $context;
			}

			if ( ! is_shop() && ! is_tax( 'product_cat' ) && ! is_tax( 'product_tag' ) ) {
				return $context;
			}

			return 'post';

		}

		/**
		 * Check if we viewing Woo-related page
		 *
		 * @since  4.0.0
		 */
		public function is_woo_page() {

			if ( ! $this->has_woocommerce() ) {
				return false;
			}

			if ( ! function_exists( 'is_woocommerce' ) ) {
				return false;
			}

			return is_woocommerce();
		}

		/**
		 * Check if WooCommerce is active
		 *
		 * @since  4.0.0
		 */
		public function has_woocommerce() {

			return  in_array(
				'woocommerce/woocommerce.php',
				apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
			);

		}

	}

	new Cherry_Woocommerce();

}