<?php
/**
 * Adds the grid type meta box to the edit post screen.
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
 * Class for creating `Grid Type` metabox.
 *
 * @since 4.0.0
 */
class Cherry_Grid_Type {

	/**
	 * Holds the instances of this class.
	 *
	 * @since 4.0.0
	 * @access private
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Options.
	 *
	 * @since 4.0.0
	 * @access private
	 * @var array
	 */
	private $options = array();

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

		$this->options = array(
			'header'  => array(
				'id'   => 'header',
				'name' => __( 'Header', 'cherry' ),
			),
			'content' => array(
				'id'   => 'content',
				'name' => __( 'Content', 'cherry' ),
			),
			'footer'  => array(
				'id'   => 'footer',
				'name' => __( 'Footer', 'cherry' ),
			),
		);

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
		add_action( 'save_post',      array( $this, 'save_post'      ), 10, 2 );
		add_action( 'admin_head',     array( $this, 'print_styles' ) );
	}

	/**
	 * Adds the meta box if the post type supports 'cherry-grid-type' and the current user has
	 * permission to edit post meta.
	 *
	 * @since  4.0.0
	 * @param  string $post_type The post type of the current post being edited.
	 * @param  object $post      The current post object.
	 * @return void
	 */
	public function add_meta_boxes( $post_type, $post ) {

		if ( ( post_type_supports( $post_type, 'cherry-grid-type' ) )
			&& ( current_user_can( 'edit_post_meta', $post->ID )
				|| current_user_can( 'add_post_meta', $post->ID )
				|| current_user_can( 'delete_post_meta', $post->ID ) )
			) {

			$grid_types = array_map( array( $this, 'get_grid_types' ), $this->options );

			/**
			 * Filter the array of 'add_meta_box' parametrs.
			 *
			 * @since 4.0.0
			 * @param array $metabox Parameters for creating new metabox.
			 */
			$metabox = apply_filters( 'cherry_grid_type_metabox_params', array(
				'id'            => 'cherry-grid-type-metabox',
				'title'         => __( 'Grid Type', 'cherry' ),
				'page'          => $post_type,
				'context'       => 'normal',
				'priority'      => 'high',
				'callback_args' => $grid_types,
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
	 * the grid type they wish to use for the specific post.
	 *
	 * @since  4.0.0
	 * @param  object $post    The post object currently being edited.
	 * @param  array  $metabox Specific information about the meta box being loaded.
	 * @return void
	 */
	public function callback_metabox( $post, $metabox ) {

		// Get the current post's grid type.
		$post_grid_type = $this->get_post_grid_type( $post->ID );

		wp_nonce_field( basename( __FILE__ ), 'cherry-grid-type-nonce' );

		$builder = new Cherry_Interface_Builder( array(
			'name_prefix' => 'grid-type',
			'pattern'     => 'inline',
			'class'       => array( 'section' => 'single-section' ),
		) );

		$builder->enqueue_builder_scripts();
		$builder->enqueue_builder_styles();

		$output = '';

		foreach ( $this->options as $id => $item ) {

			$args = array(
				'id'            => $id,
				'type'          => 'radio',
				'value'         => $post_grid_type[ $id ],
				'display_input' => false,
				'options'       => $metabox['args'][ $id ],
			);

			$output .= sprintf( '<div class="post-grid-type_col"><div class="post-grid-type_col__inner"><h4 class="cherry-title">%1$s</h4>%2$s</div></div>', $item['name'], $builder->add_form_item( $args ) );
		}

		printf( '<div class="post-grid-type_container"><div class="post-grid-type_row">%s</div><div class="clear"></div></div>', $output );

		/**
		 * Fires after `Grid Type` fields of metabox.
		 *
		 * @since 4.0.0
		 * @param object $post    The post object
		 * @param array  $metabox Metabox information.
		 */
		do_action( 'cherry_grid_type_metabox_after', $post, $metabox );
	}

	/**
	 * Saves the post grid type metadata if on the post editing screen in the admin.
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
		if ( ! isset( $_POST['cherry-grid-type-nonce'] )
			|| ! wp_verify_nonce( $_POST['cherry-grid-type-nonce'], basename( __FILE__ ) )
			) {
			return $post_id;
		}

		// Get the meta key.
		$meta_key = 'cherry_grid_type';

		// Get the previous post grid type.
		$meta_value = $this->get_post_grid_type( $post_id );

		// Get the all submitted `grid-type` data.
		$cherry_meta = array_map( 'sanitize_text_field' , $_POST['grid-type'] );

		// Get the submitted post grid type.
		if ( ! empty( $cherry_meta ) ) {
			$new_meta_value = $cherry_meta;
		} else {
			$new_meta_value = '';
		}

		// If there is no new meta value but an old value exists, delete it.
		if ( current_user_can( 'delete_post_meta', $post_id, $meta_key )
			&& ( '' == $new_meta_value && $meta_value )
			) {
			$this->delete_post_grid_type( $post_id );
		}

		// If a new meta value was added and there was no previous value, add it.
		elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key )
			&& ( $new_meta_value && '' == $meta_value )
			) {
			$this->set_post_grid_type( $post_id, $new_meta_value );
		}

		// If the old grid type doesn't match the new grid type, update the post grid type meta.
		elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key )
			&& $new_meta_value
			&& ( $new_meta_value != $meta_value )
			) {
			$this->set_post_grid_type( $post_id, $new_meta_value );
		}
	}

	/**
	 * Gets all the available grid types for the theme.
	 *
	 * @since  4.0.0
	 * @param  array $item Specific array with options.
	 * @return array       Either theme-supported grid types or the default grid types.
	 */
	public function get_grid_types( $item ) {

		// Set up the default grid types strings.
		$default = array(
			'default-grid-type' => array(
				'label'   => __( 'Inherit', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/svg/inherit.svg',
			),
		);

		$grid_types = cherry_get_options( "{$item['id']}-grid-type" );

		if ( ! is_array( $grid_types ) ) {
			$grid_types = array();
		}

		$grid_types = array_merge( $default, $grid_types );

		/**
		 * Filter the available grid types.
		 *
		 * @since 4.0.0
		 * @param array  $grid_types Grid type options.
		 * @param string $id         Option ID.
		 */
		return apply_filters( 'cherry_grid_type_get_types', $grid_types, $item['id'] );
	}

	/**
	 * Get the post grid type based on the given post ID.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id    The ID of the post to get the grid types for.
	 * @return string $grid_types The name of the post's grid types.
	 */
	public function get_post_grid_type( $post_id ) {
		$defaults   = array_fill_keys( array_keys( $this->options ) , 'default-grid-type' );
		$grid_types = get_post_meta( $post_id, 'cherry_grid_type', true );
		$grid_types = wp_parse_args( $grid_types, $defaults );

		return $grid_types;
	}

	/**
	 * Update/set the post grid type based on the given post ID and grid type.
	 *
	 * @since  4.0.0
	 * @param  int    $post_id   The ID of the post to set the grid type for.
	 * @param  string $grid_type The name of the grid type to set.
	 * @return bool              True on successful update, false on failure.
	 */
	public function set_post_grid_type( $post_id, $grid_type ) {
		return update_post_meta( $post_id, 'cherry_grid_type', $grid_type );
	}

	/**
	 * Deletes a post grid type.
	 *
	 * @since  4.0.0
	 * @param  int   $post_id The ID of the post to delete the grid type for.
	 * @return bool           True on successful delete, false on failure.
	 */
	public function delete_post_grid_type( $post_id ) {
		return delete_post_meta( $post_id, 'cherry_grid_type' );
	}

	/**
	 * Output styles for `Grid Type` metabox.
	 *
	 * @since 4.0.0
	 */
	function print_styles() { ?>

		<style type="text/css">
			.post-grid-type_container {
				padding-right: 5px;
				padding-left: 5px;
			}
			.post-grid-type_row {
				margin-right: -5px;
				margin-left: -5px;
			}
			.post-grid-type_col {
				float: left;
				width: 33.33333%;
				padding: 5px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.post-grid-type_col__inner {
				padding-right: 10px;
				padding-left: 10px;
				border: 1px solid #eee;
				border-radius: 2px;
			}
			.post-grid-type_container .cherry-title {
				text-align: center;
			}
		</style>

	<?php }

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

Cherry_Grid_Type::get_instance();
