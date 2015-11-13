<?php
/**
 * Adds the style box to the edit post screen.
 *
 * @package    Cherry_Framework
 * @subpackage Admin
 * @version    4.0.0
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Class for creating `Style` metabox.
 *
 * @since 4.0.0
 */
class Cherry_Post_Style {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 4.0.0
	 * @access private
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {

		if ( ! class_exists( 'Cherry_Interface_Builder' ) ) {
			return;
		}

		if ( ! class_exists( 'Cherry_Options_Framework' ) ) {
			return;
		}

		// Add the `Layout` meta box on the 'add_meta_boxes' hook.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );

		// Saves the post format on the post editing page.
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
	}

	/**
	 * Adds the meta box if the post type supports 'cherry-post-style' and the current user has
	 * permission to edit post meta.
	 *
	 * @since  4.0.0
	 * @param  string $post_type The post type of the current post being edited.
	 * @param  object $post      The current post object.
	 * @return void
	 */
	public function add_meta_boxes( $post_type, $post ) {

		if ( ( post_type_supports( $post_type, 'cherry-post-style' ) )
			&& ( current_user_can( 'edit_post_meta', $post->ID )
				|| current_user_can( 'add_post_meta', $post->ID )
				|| current_user_can( 'delete_post_meta', $post->ID ) )
			) {

			/**
			 * Filter the array of 'add_meta_box' parametrs.
			 *
			 * @since 4.0.0
			 * @param array $metabox Parameters for creating new metabox.
			 */
			$metabox = apply_filters( 'cherry_post_style_metabox_params', array(
				'id'            => 'cherry-post-style-metabox',
				'title'         => __( 'Style', 'cherry' ),
				'page'          => $post_type,
				'context'       => 'normal',
				'priority'      => 'high',
				'callback_args' => false,
			) );

			/**
			 * Add meta box to the administrative interface.
			 *
			 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
			 */
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				array( $this, 'callback_metabox' ),
				$metabox['page'],
				$metabox['context'],
				$metabox['priority'],
				$metabox['callback_args']
			);
		}
	}

	/**
	 * Displays a meta box of radio selectors on the post editing screen, which allows theme users to select
	 * the layout they wish to use for the specific post.
	 *
	 * @since  4.0.0
	 * @param  object $post    The post object currently being edited.
	 * @param  array  $metabox Specific information about the meta box being loaded.
	 * @return void
	 */
	public function callback_metabox( $post, $metabox ) {
		$bg_defaults = array(
			'image'      => '',
			'color'      => '',
			'repeat'     => '',
			'position'   => '',
			'attachment' => '',
		);

		// Get the current post header bg.
		$header_bg = $this->get_post_style( $post->ID, 'header-background', $bg_defaults );

		$fields = array(
			array(
				'id'    => 'header-background',
				'title' => __( 'Header background', 'cherry' ),
				'type'  => 'background',
				'value' => $header_bg,
			),
		);

		/**
		 * Filter a metabox fields.
		 *
		 * @since 4.0.0
		 * @param array $fields Metabox fields.
		 */
		$fields = apply_filters( 'cherry_post_style_metabox_fields', $fields );

		wp_nonce_field( basename( __FILE__ ), 'cherry-style-nonce' );

		$builder = new Cherry_Interface_Builder( array(
			'name_prefix' => 'cherry-style',
			'pattern'     => 'inline',
			'class'       => array( 'section' => 'single-section' ),
		) );

		$builder->enqueue_builder_scripts();
		$builder->enqueue_builder_styles();

		$content = '';

		foreach ( $fields as $field ) {
			$content .= $builder->add_form_item( $field );
		}

		printf( '<div class="cherry-ui-core post-style">%s</div>', $content );

		/**
		 * Fires after `Style` fields of metabox.
		 *
		 * @since 4.0.0
		 * @param object $post    The post object
		 * @param array  $metabox Metabox information.
		 */
		do_action( 'cherry_style_metabox_after', $post, $metabox );
	}

	/**
	 * Saves the post style metadata if on the post editing screen in the admin.
	 *
	 * @since  4.0.0
	 * @param  int      $post_id The ID of the current post being saved.
	 * @param  object   $post    The post object currently being saved.
	 * @return void|int
	 */
	public function save_post( $post_id, $post = '' ) {

		if ( ! is_object( $post ) ) {
			$post = get_post();
		}

		// Verify the nonce for the post formats meta box.
		if ( ! isset( $_POST['cherry-style-nonce'] )
			|| ! wp_verify_nonce( $_POST['cherry-style-nonce'], basename( __FILE__ ) )
			) {
			return $post_id;
		}

		// Get the meta key.
		$meta_key = 'cherry_style';

		// Get the all submitted `cherry-style` data.
		$cherry_meta = $_POST['cherry-style'];

		$this->set_post_style( $post_id, $cherry_meta );
	}

	/**
	 * Get the specific post style based on the given post ID.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id The ID of the post to get the styles for.
	 * @param  string $param   Style param to get from options.
	 * @param  mixed  $default Default value.
	 * @return string          Style from database.
	 */
	public function get_post_style( $post_id, $param = false, $default = false ) {

		// Get the post layout.
		$style = get_post_meta( $post_id, 'cherry_style', true );

		if ( ! $param ) {
			return $style;
		}

		if ( ! empty( $style[$param] ) ) {
			return $style[ $param ];
		} else {
			return $default;
		}
	}

	/**
	 * Update/set the post layout based on the given post ID and layout.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id The ID of the post to set the layout for.
	 * @param  string $layout  The name of the layout to set.
	 * @return bool            True on successful update, false on failure.
	 */
	public function set_post_style( $post_id, $style ) {
		array_walk_recursive( $style, array( $this, 'sanitize_meta' ) );

		return update_post_meta( $post_id, 'cherry_style', $style );
	}

	/**
	 * Sanitize meta item value
	 *
	 * @todo  personally sanitize item values by their keys
	 *
	 * @since 4.0.0
	 * @param mixed  &$item Item value to sanitize.
	 * @param string $key   Sanitized item key.
	 */
	public function sanitize_meta( &$item, $key ) {
		$item = esc_attr( $item );
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

Cherry_Post_Style::get_instance();
