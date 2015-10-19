<?php
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
		} elseif ( $label ) {
			$this->page_title = $label;
			$this->_add_item( 'target_format', $label );
		}

	}

}