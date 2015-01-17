<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

class Cherry_Layouts {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 4.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

		if ( !class_exists( 'Cherry_Interface_Builder' ) ) {
			return;
		}

		if ( !class_exists( 'Cherry_Options_Framework' ) ) {
			return;
		}

		// Add the layout meta box on the 'add_meta_boxes' hook.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );

		// Saves the post format on the post editing page.
		add_action( 'save_post',      array( $this, 'save_post'      ), 10, 2 );
	}

	/**
	 * Adds the theme layouts meta box if the post type supports 'theme-layouts' and the current user has
	 * permission to edit post meta.
	 *
	 * @since  4.0.0
	 * @param  string $post_type The post type of the current post being edited.
	 * @param  object $post      The current post object.
	 * @return void
	 */
	public function add_meta_boxes( $post_type, $post ) {

		if ( ( post_type_supports( $post_type, 'cherry-layouts' ) ) && ( current_user_can( 'edit_post_meta', $post->ID ) || current_user_can( 'add_post_meta', $post->ID ) || current_user_can( 'delete_post_meta', $post->ID ) ) )
			add_meta_box( 'cherry-layouts-metabox', __( 'Layout', 'cherry' ), array( $this, 'callback_metabox' ), $post_type, 'normal', 'high' );
	}

	/**
	 * Displays a meta box of radio selectors on the post editing screen, which allows theme users to select
	 * the layout they wish to use for the specific post.
	 *
	 * @since  4.0.0
	 * @param  object $post The post object currently being edited.
	 * @param  array  $box  Specific information about the meta box being loaded.
	 * @return void
	 */
	public function callback_metabox( $post, $box ) {

		// Get theme-supported theme layouts.
		$post_layouts = $this->get_layouts();

		// Get the current post's layout.
		$post_layout = $this->get_post_layout( $post->ID );

		$args = array(
			'id'            => 'cherry-layout',
			'type'          => 'radio',
			'value'         => $post_layout,
			'display_input' => false,
			'options'       => $post_layouts,
		);

		wp_nonce_field( basename( __FILE__ ), 'cherry-layouts-nonce' );

		$builder = new Cherry_Interface_Builder( array(
			'name_prefix' => 'cherry',
			'pattern'     => 'inline',
			'class'       => array( 'section' => 'single-section' ),
		) );

		printf( '<div class="post-layout">%s</div>', $builder->add_form_item( $args ) );
	}

	/**
	 * Saves the post layout metadata if on the post editing screen in the admin.
	 *
	 * @since  4.0.0
	 * @param  int      $post_id The ID of the current post being saved.
	 * @param  object   $post    The post object currently being saved.
	 * @return void|int
	 */
	public function save_post( $post_id, $post = '' ) {

		if ( !is_object( $post ) ) {
			$post = get_post();
		}

		// Verify the nonce for the post formats meta box.
		if ( !isset( $_POST['cherry-layouts-nonce'] ) || !wp_verify_nonce( $_POST['cherry-layouts-nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// Get the meta key.
		$meta_key = 'cherry_layout';

		// Get the previous post layout.
		$meta_value = $this->get_post_layout( $post_id );

		// Get the all submitted `cherry` data.
		$cherry_meta = $_POST['cherry'];

		// Get the submitted post layout.
		if ( isset( $cherry_meta['cherry-layout'] ) ) {
			$new_meta_value = $cherry_meta['cherry-layout'];
		} else {
			$new_meta_value = '';
		}

		// If there is no new meta value but an old value exists, delete it.
		if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value ) {
			$this->delete_post_layout( $post_id );
		}

		// If a new meta value was added and there was no previous value, add it.
		elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value ) {
			$this->set_post_layout( $post_id, $new_meta_value );
		}

		// If the old layout doesn't match the new layout, update the post layout meta.
		elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $new_meta_value && $new_meta_value != $meta_value ) {
			$this->set_post_layout( $post_id, $new_meta_value );
		}
	}

	/**
	 * Gets all the available layouts for the theme.
	 *
	 * @since  4.0.0
	 * @return array Either theme-supported layouts or the default layouts.
	 */
	public function get_layouts() {

		// Set up the default layout strings.
		$default = array(
			'default' => array(
				'label'   => __( 'Inherit', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-default.png',
			),
		);

		// Get theme-supported layouts.
		$layouts = cherry_get_options('blog-page-layout');
		$layouts = array_merge( $default, $layouts);

		return apply_filters( 'cherry_layouts_get_layouts', $layouts );
	}

	/**
	 * Get the post layout based on the given post ID.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id The ID of the post to get the layout for.
	 * @return string $layout  The name of the post's layout.
	 */
	public function get_post_layout( $post_id ) {

		// Get the post layout.
		$layout = get_post_meta( $post_id, 'cherry_layout', true );

		// Return the layout if one is found. Otherwise, return 'default'.
		return ( !empty( $layout ) ? $layout : 'default' );
	}

	/**
	 * Update/set the post layout based on the given post ID and layout.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id The ID of the post to set the layout for.
	 * @param  string $layout  The name of the layout to set.
	 * @return bool            True on successful update, false on failure.
	 */
	public function set_post_layout( $post_id, $layout ) {
		return update_post_meta( $post_id, 'cherry_layout', $layout );
	}

	/**
	 * Deletes a post layout.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id The ID of the post to delete the layout for.
	 * @return bool            True on successful delete, false on failure.
	 */
	public function delete_post_layout( $post_id ) {
		return delete_post_meta( $post_id, 'cherry_layout' );
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

Cherry_Layouts::get_instance();