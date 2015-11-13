<?php
/**
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

if ( !class_exists( 'Cherry_Statics_Page' ) ) {
	class Cherry_Statics_Page {

		/**
		 * Holds the instances of this class.
		 *
		 * @since 4.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * @since 4.0.0
		 * @var   string
		 */
		private $option_inteface_builder = null;

		/**
		 * URL to get exported options file download
		 * @since 4.0.0
		 * @var   string
		 */
		public static $options_export_url = null;

		/**
		* Cherry_Options_Framework_Admin constructor
		*
		* @since 4.0.0
		*/

		function __construct() {
			require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-static-area-editor/ui-static-area-editor.php' );

			add_action( 'admin_init', array( $this, 'statics_option_field' ) );

			add_action( 'wp_ajax_cherry_save_statics', array( $this, 'cherry_save_statics' ) );
			add_action( 'wp_ajax_cherry_restore_statics', array( $this, 'cherry_restore_statics' ) );
			add_action( 'wp_ajax_default_statics_backup', array( $this, 'default_statics_backup' ) );
			add_action( 'wp_ajax_export_statics', array( $this, 'export_statics' ) );

			add_action( 'wp_ajax_get_minor_select', array( $this, 'get_minor_select' ) );

			//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_builder_scripts' ) );

			$this->init();

			$url = add_query_arg(
				array( 'action' => 'export_statics' ),
				admin_url( 'admin-ajax.php' )
			);

			self::$options_export_url = wp_nonce_url( $url, 'cherry_export' );
		}

		/**
		 * Create statics option field
		 *
		 * @since 4.0.0
		 */
		public function statics_option_field() {

			$cherry_options_settings = get_option('cherry-options');

			if( false == get_option( $cherry_options_settings['id'] . '_statics') ){
				$defaults_statics = $this->get_default_statics();
				update_option( $cherry_options_settings['id'] . '_statics', $defaults_statics );
			}

		}

		private function init() {
			// Add the options page and menu item.
			global $cherry_page_builder;

			$document_link = cherry_get_documentation_link();

			$cherry_page_builder->add_child_menu_item( array(
				'parent_slug'    => 'cherry',
				'page_title'     => __( 'Static Area Builder', 'cherry' ),
				'menu_title'     => __( 'Static Area Builder', 'cherry' ),
				'capability'     => 'edit_theme_options',
				'menu_slug'      => 'statics',
				'function'       => array( __CLASS__, 'cherry_statics_page_build' ),
				'before_content' => '
					<div class="cherry-info-box">
						<div class="documentation-link">' . __( 'Feel free to view detailed ', 'cherry' ) . $document_link .
						'</div>
					</div>
					<div class="cherry-info-box">' . __( "Use static area builder to arrange static blocks. You can drag-n-drop static blocks to arrange them or add new ones.", 'cherry' ) . '</div>'
			) );


			// Settings need to be registered after admin_init
			//add_action( 'admin_init', array( $this, 'settings_init' ) );
		}

		/**
		 * Ajax save statics
		 *
		 * @since 4.0.0
		 */
		function cherry_save_statics(){
			if ( !empty($_POST) && array_key_exists('static_array', $_POST) ) {
				global $cherry_registered_statics;

				$static_array = $_POST['static_array'];

				$updated_statics_array = array();
				foreach ( $static_array as $static => $settings ) {
					$tmp_options = $settings[ 'options' ];
					$tmp_conditions = $settings[ 'conditions' ];
					if( isset( $cherry_registered_statics[ $static ] ) ){
						$updated_statics_array[ $static ] = $cherry_registered_statics[ $static ];
							foreach ( $updated_statics_array[ $static ][ 'options' ] as $option_key => $option_value ) {
								if( isset( $static_array[ $static ][ 'options' ][ $option_key ] ) ){
									$updated_statics_array[ $static ][ 'options' ][ $option_key ] = $static_array[ $static ][ 'options' ][ $option_key ];
								}
							}
							$updated_statics_array[ $static ][ 'conditions' ] = $tmp_conditions;
					}
				}

				$settings = get_option( 'cherry-options' );
				update_option($settings['id'] . '_statics', $updated_statics_array);

				$response = array(
					'message' => __( 'Statics have been saved', 'cherry' ),
					'type' => 'success-notice'
				);

				do_action( 'cherry-options-updated' );

				//exit;
				wp_send_json( $response );
			}
		}

		/**
		 * Ajax restore statics
		 *
		 * @since 4.0.0
		 */
		function cherry_restore_statics(){
			global $cherry_registered_statics;

			$settings = get_option( 'cherry-options' );
			$defaults_statics = $this->get_default_statics();

			update_option( $settings['id'] . '_statics', $defaults_statics );

			do_action( 'cherry-options-restored' );

			exit;
		}

		/**
		 * Ajax set default statics
		 *
		 * @since 4.0.0
		 */
		function default_statics_backup(){
			if ( !empty($_POST) && array_key_exists('static_array', $_POST) ) {
				global $cherry_registered_statics;
				$theme_options = get_option( 'cherry-options' );

				$static_array = $_POST['static_array'];

				$default_backup_statics = get_option( $theme_options['id'] . '_statics_defaults' );
				if( false == $default_backup_statics ){
					$response = array(
						'message' => __( 'Default statics backup has been created', 'cherry' ),
						'type' => 'success-notice'
					);
				}else{
					$response = array(
						'message' => __( 'Default statics backup has been overwritten', 'cherry' ),
						'type' => 'info-notice'
					);
				}

				$updated_statics_array = array();
				foreach ( $static_array as $static => $settings ) {
					if( array_key_exists( $static, $cherry_registered_statics ) && isset( $static ) ){
						foreach ( $cherry_registered_statics[ $static ] as $key => $value ) {
							if ( !array_key_exists( $key, $settings ) ) {
								$settings[ $key ] = $cherry_registered_statics[ $static ][ $key ];
							}
						}
						foreach ( $cherry_registered_statics[ $static ][ 'options' ] as $option_key => $option_value ) {
							if( !array_key_exists( $option_key, $settings[ 'options' ] ) ){
								$settings[ 'options' ][ $option_key ] = $option_value;
							}
						}
						$updated_statics_array[ $static ] = $settings;
					}
				}

				update_option( $theme_options['id'] . '_statics_defaults', $updated_statics_array );

				wp_send_json( $response );
				exit;
			}
		}

		/**
		 * Ajax get minor select
		 *
		 * @since 4.0.0
		 */
		function get_minor_select(){
			if ( !empty($_POST) && array_key_exists('major_type', $_POST) ) {
				$major = $_POST['major_type'];

				$html = '';
				switch ( $major ) {
					case 'category':
						$html .= '<option value="">' . __( 'All category pages', 'cherry' ) . '</option>';

						$categories = get_categories( array( 'number' => 1000, 'orderby' => 'count', 'order' => 'DESC' ) );
						usort( $categories, array( __CLASS__, 'strcasecmp_name' ) );

						foreach ( $categories as $category ) {
							$html .= '<option value="' . $category->slug . '">' . esc_html( $category->name ) . '</option>';
						}
						break;
					case 'loggedin':
						$html .= '<option value="loggedin">' . __( 'Logged in', 'cherry' ) . '</option>';
						$html .= '<option value="loggedout">' . __( 'Logged out', 'cherry' ) . '</option>';
						break;
					case 'author':
						$html .= '<option value="">' . __( 'All author pages', 'cherry' ) . '</option>';
						foreach ( get_users( array( 'orderby' => 'name', 'exclude_admin' => true ) ) as $author ) {
							$html .= '<option value="' . esc_attr( $author->user_login ) . '">' . esc_html( $author->display_name ) . '</option>';
						}
						break;
					case 'role':
						global $wp_roles;
						foreach ( $wp_roles->roles as $role_key => $role ) {
							$html .= '<option value="' . esc_attr( $role_key ) . '">' . esc_html( $role['name'] ) . '</option>';
						}
						break;
					case 'tag':
						$html .= '<option value="">' . __( 'All tag pages', 'cherry' ) . '</option>';

						$tags = get_tags( array( 'number' => 1000, 'orderby' => 'count', 'order' => 'DESC' ) );
						usort( $tags, array( __CLASS__, 'strcasecmp_name' ) );

						foreach ( $tags as $tag ) {
							$html .= '<option value="' . esc_attr( $tag->slug ) . '">' . esc_html( $tag->name ) . '</option>';
						}
						break;
					case 'date':
						$html .= '<option value="">' . __( 'All date archives', 'cherry' ) . '</option>';
						$html .= '<option value="day">' . __( 'Daily archives', 'cherry' ) . '</option>';
						$html .= '<option value="month">' . __( 'Monthly archives', 'cherry' ) . '</option>';
						$html .= '<option value="year">' . __( 'Yearly archives', 'cherry' ) . '</option>';
					break;
					case 'page':

						$html .= '<option value="front">' . __( 'Front page', 'cherry' ) . '</option>';
						$html .= '<option value="posts">' . __( 'Posts page', 'cherry' ) . '</option>';
						$html .= '<option value="archive">' . __( 'Archive page', 'cherry' ) . '</option>';
						$html .= '<option value="404">' . __( '404 error page', 'cherry' ) . '</option>';
						$html .= '<option value="search">' . __( 'Search results', 'cherry' ) . '</option>';

						$html .= '<optgroup label="' . __( 'Post type:', 'cherry' ) . '">';
							$post_types = get_post_types( array( 'public' => true ), 'objects' );
							foreach ( $post_types as $post_type ) {
								$html .= '<option value="' . esc_attr( 'post_type-' . $post_type->name ) . '">' . esc_html( $post_type->labels->singular_name ) . '</option>';
							}
						$html .= '</optgroup>';
						$pages = get_pages();
						$html .= '<optgroup label="' . __( 'Static page:', 'cherry' ) . '">';
							foreach ( $pages as $page => $page_settings) {
								$html .= '<option value="' . $page_settings->post_name . '">' . $page_settings->post_title . '</option>';
							}
						$html .= '</optgroup>';

						break;
					case 'taxonomy':
							$html .= '<option value="">' . __( 'All taxonomy pages', 'cherry' ) . '</option>';
							$taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
							usort( $taxonomies, array( __CLASS__, 'strcasecmp_name' ) );

							foreach ( $taxonomies as $taxonomy ) {
								$html .= '<optgroup label="' .  sprintf( __( '%s:', 'cherry' ), $taxonomy->labels->name ) . '">';
									$html .= '<option value="' . esc_attr( $taxonomy->name ) . '">' . 'All ' . esc_html( $taxonomy->name ) . ' pages' . '</option>';
									$terms = get_terms( array( $taxonomy->name ), array( 'number' => 250, 'hide_empty' => false ) );
									foreach ( $terms as $term ) {
										$html .= '<option value="' . esc_attr( $taxonomy->name . '_tax_' . $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
									}
								$html .= '</optgroup>';
							}
						break;
				}

				echo $html;
				exit;
			}
		}

		public static function strcasecmp_name( $a, $b ) {
			return strcasecmp( $a->name, $b->name );
		}

		/**
		 * Process options export
		 *
		 * @since 4.0.0
		 */
		public function export_statics() {

			if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'cherry_export' ) ) {
				wp_die( __( 'Invalid request', 'cherry' ), __( 'Error. Invalid request', 'cherry' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Invalid request', 'cherry' ), __( 'Error. Invalid request', 'cherry' ) );
			}

			$settings = get_option( 'cherry-options' );
			$options  = get_option( $settings['id'] . '_statics');

			$options = json_encode( $options );

			$filename = 'statics-export-' . gmdate( "d-m-Y-His" ) . '.options';
			$now      = gmdate( "D, d M Y H:i:s" );
			// disable caching
			header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
			header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
			header("Last-Modified: {$now} GMT");

			// force download
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");

			// disposition / encoding on response body
			header("Content-Disposition: attachment;filename={$filename}");
			header("Content-Transfer-Encoding: binary");

			echo $options;

			exit();
		}

		/**
		 * Get defaults settings
		 *
		 * @since 4.0.0
		 */
		public function get_default_statics() {
			global $wp_filesystem, $cherry_registered_statics;

			$theme_settings = get_option( 'cherry-options' );
			$default_backup_statics = get_option( $theme_settings['id'] . '_statics_defaults' );

			if( $default_backup_statics ){
				return $default_backup_statics;
			}

			if ( ! $this->filesystem_init() ) {
				return $cherry_registered_statics;
			}else{
				$path = get_stylesheet_directory() . '/default-options/statics_default.options';
				$path = str_replace( ABSPATH, $wp_filesystem->abspath(), $path );

				if ( ! $wp_filesystem->exists( $path ) ) {
					return $cherry_registered_statics;
				}
				$export_options = json_decode( $wp_filesystem->get_contents( $path ), true );

				return $export_options;
			}
			return $cherry_registered_statics;
		}

		/**
		 * Check for the existence of an statics option in the database
		 *
		 * @since 1.0.0
		 */
		public static function get_current_statics() {
			global $cherry_registered_statics;
			$result_settings = array();
			$cherry_options_settings = get_option('cherry-options');

			if( false == get_option($cherry_options_settings['id'] . '_statics') ){
				$result_settings = $cherry_registered_statics;
			}else{
				$settings = get_option( 'cherry-options' );
				$saved_settings = get_option( $settings['id'] . '_statics' );
				$result_settings = $saved_settings;

				foreach ( $result_settings as $saved_static_key => $saved_static_settings) {
					if( !array_key_exists( $saved_static_key, $cherry_registered_statics ) ){
						unset( $result_settings[ $saved_static_key ] );
					}
				}

				foreach ( $cherry_registered_statics as $registered_static_key => $registered_static_settings ) {
					if( !array_key_exists( $registered_static_key, $saved_settings ) ){
						$result_settings[ $registered_static_key ] = $registered_static_settings;
					}

				}

			}

			return $result_settings;
		}

		/**
		 * Initialize Filesystem object.
		 *
		 * @since  4.0.0
		 * @return bool|str false on failure, stored text on success
		 */
		public function filesystem_init() {

			global $wp_filesystem;

			$url = admin_url();

			// First attempt to get credentials.
			if ( false === ( $creds = request_filesystem_credentials( $url, '', true, false, null ) ) ) {
				/**
				 * If we comes here - we don't have credentials
				 * so the request for them is displaying
				 * no need for further processing.
				 **/
				return false;
			}

			// Now we got some credentials - try to use them.
			if ( ! WP_Filesystem( $creds ) ) {

				// Incorrect connection data - ask for credentials again, now with error message.
				request_filesystem_credentials( $url, '', true, false );

				return false;
			}

			return true; // Filesystem object successfully initiated.
		}

		/**
		 * Validate Options.
		 *
		 *
		 * @since 4.0.0
		 */
		function validate_options( $option_value ) {
			return $option_value;
		}


		public static function cherry_statics_page_build() {
			global $cherry_registered_statics;
			$statics = self::get_current_statics();

			?>
			<div class="statics-wrapper">
				<form id="cherry-statics" method="post">
				<?php
					$ui_statics = new UI_Static_Area_Editor(
						array(
							'id'			=> 'statics',
							'name'			=> 'statics',
							'value'			=> $statics,
							'options'		=> $cherry_registered_statics
						)
					);

					echo $ui_statics->render();
				?>
					<div class="submit-wrapper">
						<div class="wrap-cherry-save-statics">
							<a href="#" id="cherry-save-statics" class="button button-primary_">
								<?php echo __( 'Save statics', 'cherry' ); ?>
								<div class="cherry-spinner-wordpress spinner-wordpress-type-2"><span class="cherry-inner-circle"></span></div>
							</a>
						</div>
						<div class="wrap-cherry-restore-statics">
							<a href="#" id="cherry-restore-statics" class="button button-default_">
								<?php echo __( 'Restore statics', 'cherry' ); ?>
							</a>
						</div>
						<div class="wrap-cherry-export-statics">
							<a href="<?php echo esc_url( self::$options_export_url ) ?>" id="cherry-export-statics" class="button button-default_">
								<?php _e( 'Export statics', 'cherry' ); ?>
							</a>
						</div>
						<div class="wrap-cherry-default-statics-backup">
							<a href="#" id="cherry-default-statics-backup" class="button button-default_">
								<?php _e( 'Default statics', 'cherry' ); ?>
								<div class="cherry-spinner-wordpress spinner-wordpress-type-3"><span class="cherry-inner-circle"></span></div>
							</a>
						</div>
					</div>
				</form>

			</div>
			<?php
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
	}//end  Cherry_Statics_Page class
}//endif class exist

//Cherry_Statics_Page::get_instance();
?>