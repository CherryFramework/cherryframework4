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

if ( !class_exists( 'Cherry_Options_Framework_Admin' ) ) {
	class Cherry_Options_Framework_Admin {

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

			// attach import/export options handlers
			add_action( 'wp_ajax_cherry_export_options', array( $this, 'export_options' ) );
			add_action( 'wp_ajax_cherry_import_options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_cherry_save_options', array( $this, 'cherry_save_options' ) );
			add_action( 'wp_ajax_cherry_restore_section', array( $this, 'cherry_restore_section' ) );
			add_action( 'wp_ajax_cherry_restore_options', array( $this, 'cherry_restore_options' ) );
			add_action( 'wp_ajax_get_options_section', array( $this, 'get_options_section' ) );
			add_action( 'wp_ajax_default_options_backup', array( $this, 'default_options_backup' ) );

			// add options to allowed MIME types
			add_filter( 'upload_mimes', array( $this, 'add_options_mime' ) );

			$this->init();

			$url = add_query_arg(
				array( 'action' => 'cherry_export_options' ),
				admin_url( 'admin-ajax.php' )
			);

			self::$options_export_url = wp_nonce_url( $url, 'cherry_export' );
		}

		private function init(){
			global $cherry_options_framework, $submenu, $cherry_page_builder;

			$this->option_inteface_builder = new Cherry_Interface_Builder(
				array(
					'pattern'		=> 'grid',
					'hidden_items'	=> apply_filters( 'cherry-hidden-options', array() )
				)
			);

			$cherry_page_builder -> add_parent_menu_item (array(
				'page_title' => __( 'Theme Cherry Framework', 'cherry' ),
				'menu_title' => __( 'Cherry', 'cherry' ),
				'capability' => 'edit_theme_options',
				'menu_slug' => 'cherry',
				'function' => array( __CLASS__, 'cherry_options_page_build'),
				'icon_url' => PARENT_URI . '/lib/admin/assets/images/svg/cherry-icon.svg',
				'position' => 62,
				'before_content' => '
					<div class="cherry-info-box">
						<div class="documentation-link">' . __( 'Feel free to view detailed ', 'cherry' ) . '
							<a href="http://cherryframework.com/documentation/cf4/" title="' . __( 'Documentation', 'cherry' ) . '" target="_blank">' . __( 'Cherry Framework 4 documentation', 'cherry' ) . '</a>
						</div>
					</div>'
			));

			$cherry_page_builder -> add_child_menu_item (array(
				'parent_slug'	=> 'cherry',
				'page_title'	=> __( 'Theme Cherry Framework', 'cherry' ),
				'menu_title'	=> __( 'Options', 'cherry' ),
				'capability'	=> 'edit_theme_options',
				'menu_slug'		=> 'options',
				'function'		=> array( __CLASS__, 'cherry_options_page_build'),
				'before_content' => '
					<div class="cherry-info-box">
						<div class="documentation-link">' . __( 'Feel free to view detailed ', 'cherry' ) . '
							<a href="http://cherryframework.com/documentation/cf4/" title="' . __( 'Documentation', 'cherry' ) . '" target="_blank">' . __( 'Cherry Framework 4 documentation', 'cherry' ) . '</a>
						</div>
					</div>'
			));

			// Settings need to be registered after admin_init
			add_action( 'admin_init', array( $this, 'settings_init' ) );

			add_action( 'admin_head', array( $this, 'admin_head' ) );

			//************* Sanitize Utility Filters  ************************************//
			// Utility sanitize text
			add_filter( 'utility_sanitize_text',        array( $this, 'utility_sanitize_text' ) );
			// Utility sanitize textarea
			add_filter( 'utility_sanitize_textarea',    array( $this, 'utility_sanitize_textarea' ) );
			// Utility sanitize checkbox
			add_filter( 'utility_sanitize_checkbox',    array( $this, 'utility_sanitize_checkbox' ) );
			// Utility sanitize lider
			add_filter( 'utility_sanitize_slider',      array( $this, 'utility_sanitize_slider' ) );
			// Utility sanitize editor
			add_filter( 'utility_sanitize_editor',      array( $this, 'utility_sanitize_editor' ) );
			// Utility sanitize editor
			add_filter( 'utility_sanitize_image',       array( $this, 'utility_sanitize_image' ) );
			// Utility sanitize color picker
			add_filter( 'utility_sanitize_colorpicker', array( $this, 'utility_sanitize_colorpicker' ) );
		}

		/**
		 * Add options to allowed MIME types
		 *
		 * @since  4.0.0
		 */
		function add_options_mime( $mime_types ){
			$mime_types['options'] = 'cherry/options';
			return $mime_types;
		}

		/**
		 * Process options export
		 *
		 * @since 4.0.0
		 */
		public function export_options() {

			if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'cherry_export' ) ) {
				wp_die( __( 'Invalid request', 'cherry' ), __( 'Error. Invalid request', 'cherry' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Invalid request', 'cherry' ), __( 'Error. Invalid request', 'cherry' ) );
			}

			$settings = get_option( 'cherry-options' );
			$options  = get_option( $settings['id'] );

			$options = json_encode( $options );

			$filename = 'options-export-' . gmdate( "d-m-Y-His" ) . '.options';
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
		 * Ajax import options
		 *
		 * @since 4.0.0
		 */
		function import_options() {

			$validate = check_ajax_referer( 'cherry_import_options', 'nonce', false );
			if ( ! $validate ) {
				wp_send_json( array( 'type' => 'error' ) );
			}

			if ( ! isset( $_REQUEST['file'] ) || ! isset( $_REQUEST['type'] ) ) {
				wp_send_json( array( 'type' => 'error' ) );
			}

			if ( 'cherry/options' != $_REQUEST['type'] ) {
				wp_send_json( array( 'type' => 'error' ) );
			}

			// init WP filesystem
			global $wp_filesystem;

			$url = admin_url();

			// First attempt to get credentials.
			if ( false === ( $creds = request_filesystem_credentials( $url, '', true, false, null ) ) ) {
				/**
				 * If we comes here - we don't have credentials
				 * so the request for them is displaying
				 * no need for further processing.
				 **/
				wp_send_json( array( 'type' => 'error' ) );
			}

			// Now we got some credentials - try to use them.
			if ( ! WP_Filesystem( $creds ) ) {

				// Incorrect connection data - ask for credentials again, now with error message.
				request_filesystem_credentials( $url, '', true, false );

				wp_send_json( array( 'type' => 'error' ) );
			}

			// get export file content
			$import_file = get_attached_file( $_REQUEST['file'] );

			if ( ! $import_file ) {
				wp_send_json( array( 'type' => 'error' ) );
			}

			$import_file = str_replace( ABSPATH, $wp_filesystem->abspath(), $import_file );
			$import_data = $wp_filesystem->get_contents( $import_file );

			$import_options = json_decode( $import_data, true );
			$this->options_import_array = $import_options;

			if ( ! is_array( $import_options ) || empty( $import_options ) ) {
				wp_send_json( array( 'type' => 'error' ) );
			}

			// get current options array
			$settings        = get_option( 'cherry-options' );
			$current_options = get_option( $settings['id'] );

			$result = array();

			foreach ( $current_options as $section => $data ) {
				foreach ( $data['options-list'] as $opt => $val ) {

					if ( isset( $import_options[$section]['options-list'][$opt] ) ) {
						$result[$section]['options-list'][$opt] = $import_options[$section]['options-list'][$opt];
					} else {
						$result[$section]['options-list'][$opt] = $current_options[$section]['options-list'][$opt];
					}

				}
			}

			update_option( $settings['id'], $result );

			wp_send_json( array( 'type' => 'success' ) );
		}

		/**
		 * Ajax get current options section
		 *
		 * @since 4.0.0
		 */
		function get_options_section() {
			if ( !empty($_POST) && array_key_exists('active_section', $_POST) ) {
				global $cherry_options_framework;
				$html = '';
				$active_section = $_POST['active_section'];

				$cherry_options = $cherry_options_framework->get_current_settings();
				$current_section_options = $cherry_options[$active_section];

				$html .= $this->option_inteface_builder->multi_output_items($current_section_options['options-list']);
				printf( '<div class="options-group %1$s">%2$s</div>', $active_section, $html );
				exit;
			}
		}

		/**
		 * Ajax save options
		 *
		 * @since 4.0.0
		 */
		function cherry_save_options(){
			if ( !empty($_POST) && array_key_exists('post_array', $_POST) ) {
				global $cherry_options_framework;
				$post_array = $_POST['post_array'];

				$options = $cherry_options_framework->create_updated_options( $post_array );

				$cherry_options_framework->save_options( $options );
				$response = array(
					'message' => __( 'Options have been saved', 'cherry' ),
					'type' => 'success-notice'
				);

				do_action( 'cherry-options-updated' );

				wp_send_json( $response );
			}
		}

		/**
		 * Ajax restore section
		 *
		 * @since 4.0.0
		 */
		function cherry_restore_section(){
			if ( !empty($_POST) && array_key_exists('current_section', $_POST) ) {
				global $cherry_options_framework;
				$current_section = $_POST['current_section'];
				$cherry_options_framework -> restore_section_settings_array( $current_section );

				do_action( 'cherry-section-restored' );

				exit;
			}
		}

		/**
		 * Ajax restore options
		 *
		 * @since 4.0.0
		 */
		function cherry_restore_options(){
			global $cherry_options_framework;
			$cherry_options_framework -> restore_default_settings_array();

			do_action( 'cherry-options-restored' );
		}

		/**
		 * Ajax set default options
		 *
		 * @since 4.0.0
		 */
		function default_options_backup(){
			if ( !empty($_POST) && array_key_exists('post_array', $_POST) ) {
				global $cherry_options_framework;
				$post_array = $_POST['post_array'];

				$default_backup_options = get_option( $cherry_options_framework->themename . '_defaults' );
				if( false == $default_backup_options ){
					$response = array(
						'message' => __( 'Default options backup has been created', 'cherry' ),
						'type' => 'success-notice'
					);
				}else{
					$response = array(
						'message' => __( 'Default options backup has been overwrited', 'cherry' ),
						'type' => 'info-notice'
					);
				}

				$options = $cherry_options_framework->create_updated_options( $post_array );

				$default_options_name = $cherry_options_framework->themename .'_defaults';

				update_option( $default_options_name, $options);

				wp_send_json( $response );
			}
		}

		/**
		 * Registers the settings
		 *
		 * @since 4.0.0
		 */
		function settings_init() {
			// Load Options Framework Settings
			$cherry_options_settings = get_option( 'cherry-options' );

			register_setting( 'cherry-options', $cherry_options_settings['id'], array( $this, 'validate_options' ) );
		}

		/**
		 * Delete sub menu item
		 *
		 * @since 4.0.0
		 */
		function admin_head(){
			global $submenu;
			unset($submenu['cherry'][0]);
		}

		/**
		 * Registers the settings
		 *
		 * @since 4.0.0
		 */
		function new_section_name($result) {
			global $cherry_options_framework;
			$currentSectionName = $cherry_options_framework->get_section_name_by_id($_POST['active_section']);
			$result = '<i>' . $currentSectionName . '</i>';
			return $result;
		}

		/**
		 * Validate Options.
		 *
		 *
		 * @since 4.0.0
		 */
		function validate_options( $option_value ) {
			global $cherry_options_framework;

			foreach ($option_value as $sectionName => $sectionOptionsList) {
				foreach ($sectionOptionsList['options-list'] as $optionId => $optionValue) {
					$optionType = $cherry_options_framework->get_type_by_id($optionId);
					// For a value to be submitted to database it must pass through a sanitization filter
					if ( has_filter( 'utility_sanitize_' . $optionType ) ) {
						$validated_value = apply_filters( 'utility_sanitize_' . $optionType, $optionValue );
						$option_value[$sectionName]['options-list'][$optionId] = $validated_value;
					}
				}
			}
			return $option_value;
		}

		/**
		 * Priority sorting
		 *
		 * @since 4.0.0
		 */
		private static function priority_sorting($base_array) {
			uasort($base_array, array( __CLASS__, 'compare' ));
			return $base_array;
		}
		/**
		 * Custom compare function.
		 *
		 * @since  4.0.0
		 * @param  int $a
		 * @param  int $b
		 */
		private static function compare( $a, $b ) {
			return ($a['priority'] - $b['priority']);
		}
		/**
		 * Child priority sorting
		 *
		 * @since 4.0.0
		 */
		private static function child_priority_sorting($base_array) {
			foreach ($base_array as $sectionName => $sectionSettings) {
				$parent = !empty( $sectionSettings['parent'] ) ? $sectionSettings['parent'] : '';
				if($parent !== ''){
					$tmpPriority = $base_array[$parent]['priority']+1;
					$base_array[$sectionName]['priority'] = $tmpPriority;

				}
			}
			return $base_array;
		}

		/**
		 *
		 * @since 4.0.0
		 */
		public static function cherry_options_page_build() {
			global $cherry_options_framework;

				$section_index = 0;

				$cherry_options = $cherry_options_framework->get_current_settings();

				$cherry_options = self::child_priority_sorting($cherry_options);

				$cherry_options = self::priority_sorting($cherry_options);

				?>
			<?php settings_errors( 'cherry-options' ); ?>
				<form id="cherry-options" class="cherry-ui-core" method="post">
					<?php settings_fields( 'cherry-options' ); ?>
					<input class="active-section-field" type="hidden" name="active_section" value="">
					<div class="cherry-sections-wrapper">
						<ul class="cherry-option-section-tab vertical-tabs_ vertical-tabs_width_mid_">
							<?php
							foreach ($cherry_options as $section_key => $section_value) {
								$parent = !empty( $section_value['parent'] ) ? $section_value['parent'] : '';
								( $parent !== '') ? $subClass = 'subitem' : $subClass = '';
								$priority_value = $section_value['priority']; ?>
								<li class="tabitem-<?php echo $section_index; ?> <?php echo $subClass; ?> <?php echo $parent ?>" data-section-name="<?php echo $section_key; ?>"><a href="javascript:void(0)"><i class="<?php echo $section_value["icon"]; ?>"></i><span><?php echo $section_value["name"]; ?></span></a></li>
							<?php $section_index++; } ?>
						</ul>
						<div class="cherry-option-group-list"></div>
						<div class="clear"></div>
					</div>
					<div class="cherry-submit-wrapper">
						<div class="cherry-options-export-import">
							<div class="wrap-cherry-export-options">
								<a href="<?php echo esc_url( self::$options_export_url ) ?>" id="cherry-export-options" class="button button-default_">
									<?php _e( 'Export', 'cherry' ); ?>
								</a>
							</div>
							<div class="wrap-cherry-import-options">
								<a href="#" id="cherry-import-options" class="button button-default_">
									<?php _e( 'Import', 'cherry' ); ?>
								</a>
							</div>
							<div class="wrap-cherry-default-options-backup">
								<a href="#" id="cherry-default-options-backup" class="button button-default_">
									<?php _e( 'Default options', 'cherry' ); ?>
									<div class="cherry-spinner-wordpress spinner-wordpress-type-3"><span class="cherry-inner-circle"></span></div>
								</a>
							</div>
						</div>
						<div id="wrap-cherry-save-options">
							<a href="#" id="cherry-save-options" class="button button-primary_">
								<?php echo __( 'Save options', 'cherry' ); ?>
								<div class="cherry-spinner-wordpress spinner-wordpress-type-2"><span class="cherry-inner-circle"></span></div>
							</a>
						</div>
						<div id="wrap-cherry-restore-section">
							<a href="#" id="cherry-restore-section" class="button button-default_">
								<?php echo __( 'Restore section', 'cherry' ); ?>
							</a>
						</div>
						<div id="wrap-cherry-restore-options">
							<a href="#" id="cherry-restore-options" class="button button-default_">
								<?php echo __( 'Restore options', 'cherry' ); ?>
							</a>
						</div>
					</div>
				</form>
				<div class="cherry-ui-core">
					<div class="cherry-options-import">
						<div class="cherry-import-file-name"></div>
						<?php wp_nonce_field( 'cherry_import_options', 'import-options-nonce', false ); ?>
						<input type="hidden" autocomplete="off" id="cherry-import-options-file-id" value="">
						<input type="hidden" autocomplete="off" id="cherry-import-options-file-type" value="">
						<a href="#" id="cherry-import-options-file" class="button button-default_">
							<?php _e( 'Select file', 'cherry' ); ?>
						</a>
						<a href="#" id="cherry-import-options-start" class="button button-primary_">
							<?php _e( 'Start import', 'cherry' ); ?>
						</a>

						<span class="spinner"></span>
					</div>
				</div>
				<?php
		}


		/**
		 * Is a given string a color formatted in hexidecimal notation?
		 *
		 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
		 * @return   bool
		 *
		 */
		private function validate_hex( $hex ) {
			$hex = trim( $hex );
			/* Strip recognized prefixes. */
			if ( 0 === strpos( $hex, '#' ) ) {
				$hex = substr( $hex, 1 );
			}
			elseif ( 0 === strpos( $hex, '%23' ) ) {
				$hex = substr( $hex, 3 );
			}
			/* Regex match. */
			if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
				return false;
			}
			else {
				return true;
			}
		}

		/************************ Sanitize functions *****************************************/
		/* Text type */
		function utility_sanitize_text( $input ) {
			global $allowedtags;

			return wp_unslash( wp_kses( $input, $allowedtags ) );
		}

		/* Textarea type */
		function utility_sanitize_textarea( $input ) {
			global $allowedposttags;

			return wp_unslash( wp_kses( $input, $allowedposttags ) );
		}

		/* Checkbox type*/
		function utility_sanitize_checkbox( $input ) {
			return $input;
		}

		/* Slider type */
		function utility_sanitize_slider( $input ) {
			return (int) $input;
		}

		/* Editor type */
		function utility_sanitize_editor( $input ) {

			if ( current_user_can( 'unfiltered_html' ) ) {
				$output = wpautop( $input );

			} else {
				global $allowedtags;

				$output = wpautop( wp_kses( $input, $allowedtags ) );
			}

			return wp_unslash( $output );
		}

		/* Image type */
		function utility_sanitize_image( $input ) {
			$output = '';
			$filetype = wp_check_filetype( $input );

			if ( $filetype["ext"] ) {
				$output = esc_url( $input );
			}

			return $output;
		}

		/* Color Picker */
		function utility_sanitize_colorpicker( $input, $default = '' ) {

			if ( $this->validate_hex( $input ) ) {
				return $input;
			}

			return $default;
		}


	}//end  Cherry_Options_Framework_Admin class
}//endif class exist
?>