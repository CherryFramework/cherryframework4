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
		 * Correctly get container classes for shop page
		 *
		 * @since  4.0.0
		 * @param  array $classes current container classes
		 */
		function fix_shop_page_object( $object_id ) {

			if ( ! function_exists( 'is_shop' ) || ! function_exists( 'wc_get_page_id' ) ) {
				return $object_id;
			}

			if ( ! is_shop() ) {
				return $object_id;
			}

			$page_id = wc_get_page_id( 'shop' );

			return $page_id;

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

/**
 * Custom WooCommerce breadcrumbs for Cherry
 * (extends default Cherry breadcrumbs)
 *
 * @since 4.0.0
 */
class Cherry_Woo_Breadcrumbs extends cherry_breadcrumbs {

	/**
	 * Build breadcrumbs trail items array
	 *
	 * @since 4.0.0
	 */
	public function build_trail() {

		if ( is_front_page() ) {

			// if we on front page
			$this->add_front_page();

		} else {

			// do this for all other pages
			$this->add_network_home_link();
			$this->add_site_home_link();
			$this->add_shop_page();

			if ( is_singular( 'product' ) ) {
				$this->add_single_product();
			} elseif ( is_tax( array( 'product_cat', 'product_tag' ) ) ) {
				$this->add_product_tax();
			}

		}

		/* Add paged items if they exist. */
		$this->add_paged_items();

		/**
		 * Filter final item array
		 * @since  4.0.0
		 * @var    array
		 */
		$this->items = apply_filters( 'cherry_breadcrumbs_items', $this->items, $this->args );
	}

	/**
	 * Add single product trailings
	 *
	 * @since  4.0.0
	 */
	private function add_single_product() {

		$terms = false;

		if ( function_exists( 'wc_get_product_terms' ) ) {
			global $post;
			$terms = wc_get_product_terms(
				$post->ID,
				'product_cat',
				array( 'orderby' => 'parent', 'order' => 'DESC' )
			);
		}

		if ( $terms ) {
			$main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
			$this->term_ancestors( $main_term->term_id, 'product_cat' );
			$this->_add_item( 'link_format', $main_term->name, get_term_link( $main_term ) );
		}

		$this->_add_item( 'target_format', get_the_title( $post->ID ) );
		$this->page_title = false;

	}

	/**
	 * Add parent erms items for a term
	 *
	 * @since 4.0.0
	 * @param string $taxonomy
	 */
	private function term_ancestors( $term_id, $taxonomy ) {

		$ancestors = get_ancestors( $term_id, $taxonomy );
		$ancestors = array_reverse( $ancestors );

		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, $taxonomy );
			if ( ! is_wp_error( $ancestor ) && $ancestor ) {
				$this->_add_item( 'link_format', $ancestor->name, get_term_link( $ancestor ) );
			}
		}
	}

	/**
	 * Get product category page trilink
	 *
	 * @since 4.0.0
	 */
	private function add_product_tax() {
		$current_term = $GLOBALS['wp_query']->get_queried_object();
		if ( is_tax( 'product_cat' ) ) {
			$this->term_ancestors( $current_term->term_id, 'product_cat' );
		}
		$this->_add_item( 'target_format', $current_term->name );
	}

	/**
	 * Add WooCommerce shop page
	 *
	 * @since  4.0.0
	 */
	private function add_shop_page() {

		$shop_page_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : false;

		if ( ! $shop_page_id ) {
			return;
		}

		$label = get_the_title( $shop_page_id );
		$url   = get_permalink( $shop_page_id );

		if ( ! is_page( $shop_page_id ) && ! is_post_type_archive( 'product' ) ) {
			$this->_add_item( 'link_format', $label, $url );
		} elseif ( $label && true === $this->args['show_title'] ) {
			$this->page_title = $label;
			$this->_add_item( 'target_format', $label );
		}

	}

}