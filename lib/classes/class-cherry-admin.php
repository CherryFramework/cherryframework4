<?php

class Cherry_Admin {

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

		// Load admin stylesheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		// Load admin javascript.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Register admin-specific stylesheet.
	 *
	 * @since 4.0.0
	 */
	public function register_admin_styles() {
		wp_register_style( 'select2', trailingslashit( CHERRY_URI ) . 'admin/assets/css/select2.css', array(), CHERRY_VERSION, 'all' );
		wp_register_style( 'jquery-ui', trailingslashit( CHERRY_URI ) . 'admin/assets/css/jquery-ui.css', array(), CHERRY_VERSION, 'all' );
		wp_register_style( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/css/interface-builder.css', array(), CHERRY_VERSION, 'all' );
		wp_register_style( 'admin-interface', trailingslashit( CHERRY_URI ) . 'admin/assets/css/admin-interface.css', array(), CHERRY_VERSION, 'all' );
	}

	/**
	 * Enqueue admin-specific stylesheet.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_styles( $hook_suffix ) {
		if ( 'toplevel_page_cherry-options' == $hook_suffix ) {
			wp_enqueue_style( 'select2' );
			wp_enqueue_style( 'jquery-ui' );
			//wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_style( 'interface-builder' );
			wp_enqueue_style( 'admin-interface' );
		}
	}

	/**
	 * Register admin-specific javascript.
	 *
	 * @since 4.0.0
	 */
	public function register_admin_scripts() {
		wp_register_script( 'select2', trailingslashit( CHERRY_URI ) . 'admin/assets/js/select2.js', array( 'jquery' ), CHERRY_VERSION, true );
		wp_register_script( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/js/interface-builder.js', array( 'jquery' ), CHERRY_VERSION, true );
		wp_register_script( 'admin-interface', trailingslashit( CHERRY_URI ) . 'admin/assets/js/admin-interface.js', array( 'jquery' ), CHERRY_VERSION, true );
	}

	/**
	 * Enqueue admin-specific javascript.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_scripts( $hook_suffix ) {
		if ( 'toplevel_page_cherry-options' == $hook_suffix ) {
			// jQ select2.js plugin for custom select
			wp_enqueue_script( 'select2' );
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( 'admin-interface' );
			
		}
	}
}
new Cherry_Admin();