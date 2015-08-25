<?php
/**
 * Sets up the admin functionality for the framework.
 *
 * @package   Cherry_Framework
 * @version   4.0.0
 * @author    Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2012 - 2015, Cherry Team
 * @link      http://www.cherryframework.com/
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Cherry_Admin {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 4.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Initialize the loading admin scripts & styles. Adding the meta boxes.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Loads post meta boxes on the post editing screen.
		add_action( 'load-post.php',     array( $this, 'load_post_meta_boxes' ) );
		add_action( 'load-post-new.php', array( $this, 'load_post_meta_boxes' ) );

		global $cherry_options_framework, $cherry_page_builder;

		$cherry_page_builder = new Cherry_Page_Builder();

		$cherry_options_framework = new Cherry_Options_Framework;
		$options_framework_admin = new Cherry_Options_Framework_Admin;
		$cherry_statics_page = new Cherry_Statics_Page();
	}

	/**
	 * Loads admin-specific javascript.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_scripts( $hook_suffix ) {

		if ( 'toplevel_page_cherry' == $hook_suffix || 'cherry_page_options' == $hook_suffix ) {

			wp_enqueue_media();
			wp_enqueue_script( 'admin-interface', trailingslashit( CHERRY_URI ) . 'admin/assets/js/admin-interface.js', array( 'jquery' ), CHERRY_VERSION, true );

			$messages = array(
				'no_file'            => __( 'Please, select a file to import', 'cherry' ),
				'invalid_type'       => __( 'Invalid file type', 'cherry' ),
				'success'            => __( 'Cherry Options imported. ', 'cherry' ),
				'section_restore'    => __( 'section restored.', 'cherry' ),
				'options_restore'    => __( 'All options restored', 'cherry' ),
				'section_loaded'     => __( 'options loaded.', 'cherry' ),
				'confirm_button'     => __( 'Yes', 'cherry' ),
				'cancel_button'      => __( 'No', 'cherry' ),
				'partial_empty'      => __( 'Neither option is not selected', 'cherry' ),
				'download_started'   => __( 'File download started...', 'cherry' ),
				'redirect_url'       => menu_page_url( 'options', false ),
			);

			wp_localize_script( 'admin-interface', 'cherry_options_page_data', $messages );
		}

		if ( 'cherry_page_statics' == $hook_suffix ) {
			wp_enqueue_media();
			wp_enqueue_script( 'admin-statics-page', trailingslashit( CHERRY_URI ) . 'admin/assets/js/admin-statics-page.js', array( 'jquery' ), CHERRY_VERSION, true );

			$messages = array(
				'no_file'         => __( 'Please, select import file', 'cherry' ),
				'invalid_type'    => __( 'Invalid file type', 'cherry' ),
				'success'         => __( 'Statics settings imported. ', 'cherry' ),
				'statics_restore' => __( 'Statics restored', 'cherry' ),
				'redirect_url'    => menu_page_url( 'statics', false ),
			);

			wp_localize_script( 'admin-statics-page', 'cherry_statics_page_data', $messages );
		}

		wp_enqueue_style( 'admin-interface', trailingslashit( CHERRY_URI ) . 'admin/assets/css/admin-interface.css', array(), CHERRY_VERSION, 'all' );
		wp_enqueue_style( 'cherry-ui-elements', trailingslashit( CHERRY_URI ) . 'admin/assets/css/cherry-ui-elements.css', array(), CHERRY_VERSION, 'all' );
	}

	/**
	 * Loads custom meta boxes.
	 *
	 * @since 4.0.0
	 */
	public function load_post_meta_boxes() {
		$screen    = get_current_screen();
		$post_type = $screen->post_type;

		if ( !empty( $post_type ) && post_type_supports( $post_type, 'cherry-grid-type' ) ) {
			require_once( trailingslashit( CHERRY_ADMIN ) . 'class-cherry-grid-type.php' );
		}

		if ( !empty( $post_type ) && post_type_supports( $post_type, 'cherry-layouts' ) ) {
			require_once( trailingslashit( CHERRY_ADMIN ) . 'class-cherry-layouts.php' );
		}

		if ( !empty( $post_type ) && post_type_supports( $post_type, 'cherry-post-style' ) ) {
			require_once( trailingslashit( CHERRY_ADMIN ) . 'class-cherry-post-style.php' );
		}
	}

	/**
	 * Returns the instance.
	 *
	 * @since  4.0.0
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

Cherry_Admin::get_instance();


