<?php

class Cherry_Admin {

	/**
	 * Initialize the loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

		// Register admin javascript and stylesheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_styles' ), 1 );

		// Load admin javascript and stylesheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
	}

	/**
	 * Register admin-specific javascript.
	 *
	 * @since 4.0.0
	 */
	public function register_admin_scripts() {
		wp_register_script( 'select2', trailingslashit( CHERRY_URI ) . 'admin/assets/js/select2.js', array( 'jquery' ), CHERRY_VERSION, true );
		wp_register_script( 'statics-areas-editor-plugin', trailingslashit( CHERRY_URI ) . 'admin/assets/js/statics-areas-editor-plugin.js', array( 'jquery' ), CHERRY_VERSION, true );
		wp_register_script( 'icon-editor-plugin', trailingslashit( CHERRY_URI ) . 'admin/assets/js/icon-editor-plugin.js', array( 'jquery' ), CHERRY_VERSION, true );
		wp_register_script( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/js/interface-builder.js', array( 'jquery' ), CHERRY_VERSION, true );
		wp_register_script( 'admin-interface', trailingslashit( CHERRY_URI ) . 'admin/assets/js/admin-interface.js', array( 'jquery' ), CHERRY_VERSION, true );
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
		wp_register_style( 'cherry-ui-elements', trailingslashit( CHERRY_URI ) . 'admin/assets/css/cherry-ui-elements.css', array(), CHERRY_VERSION, 'all' );
	}

	/**
	 * Enqueue admin-specific javascript.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_scripts( $hook_suffix ) {
		// if ( 'toplevel_page_cherry-options' == $hook_suffix ) {
			// jQ select2.js plugin for custom select
			wp_enqueue_script( 'select2' );
			wp_enqueue_script( 'statics-areas-editor-plugin' );
			// wp_enqueue_script( 'icon-editor-plugin' );
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'admin-interface' );
		// }
	}

	/**
	 * Enqueue admin-specific stylesheet.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_styles( $hook_suffix ) {
		// if ( 'toplevel_page_cherry-options' == $hook_suffix ) {
			wp_enqueue_style( 'select2' );
			wp_enqueue_style( 'jquery-ui' );
			wp_enqueue_style( 'interface-builder' );
			wp_enqueue_style( 'admin-interface' );
			wp_enqueue_style( 'cherry-ui-elements' );
		// }
	}
}
new Cherry_Admin();