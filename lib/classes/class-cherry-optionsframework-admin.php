<?php
/**
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
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
	     * @type string
	     */
	    protected $options_screen = null;
	    private $option_inteface_builder;

		/**
		* Cherry_Options_Framework_Admin constructor
		* 
		* @since 4.0.0
		*/

		function __construct() {
			$this->init();
		}

		private function init(){
			global $cherry_options_framework;
			
			$this->option_inteface_builder = new Cherry_Interface_Bilder(array('pattern' => 'grid'));

			// Gets options to load
	    	//$cherry_options = $cherry_options_framework->get_settings();

	    	// Checks if options are available
	    	//if ( $cherry_options ) {

				// Add the options page and menu item.
				add_action( 'admin_menu', array( $this, 'cherry_admin_menu_add_item' ) );

				// Settings need to be registered after admin_init
				add_action( 'admin_init', array( $this, 'settings_init' ) );

				// Displays notice after options save
				add_action('cherry-options-updated', array( $this, 'save_options_notice' ) );

				// Displays notice after options restored
				add_action('cherry-options-restored', array( $this, 'restore_options_notice' ) );

			//} else {
				// Display a notice if options aren't present in the theme
			//}

		}

		/**
	     * Registers the settings
	     *
	     * @since 4.0.0
	     */
	    function settings_init() {
	    	// Load Options Framework Settings
        	//$cherry_options_settings = get_option( 'cherry-options' );
			//register_setting( 'cherry-options-group', $cherry_options_settings['id'],  array ( $this, 'validate_options' ) );
	    }

	    /**
		 * Display message when options have been saved
		 */

		function save_options_notice() {
			add_settings_error( 'cherry-options-group', 'save-options', __( 'Options saved.', 'cherry-options' ), 'updated' );
		}

		/**
		 * Display message when options have been restored
		 */

		function restore_options_notice() {
			add_settings_error( 'cherry-options-group', 'restore-options', __( 'Options restored.', 'cherry-options' ), 'updated fade' );
		}


		/**
	     *
	     * @since 4.0.0
	     */
		function cherry_admin_menu_add_item() {
			$cherry_options_menu_item = 'cherry-options';
			add_menu_page( __( 'Cherry page', 'cherry' ), __( 'Cherry Options', 'cherry' ), 'edit_theme_options', $cherry_options_menu_item, array( $this, 'cherry_options_page_build' ), 'dashicons-clipboard', 62 );
		}

		/**
		 * Validate Options.
		 *
		 *
		 * @uses $_POST['reset'] to restore default options
		 */
		function validate_options( $option_value ) {
			/*if(isset($_POST['cherry']['save-options'])){
				do_action('cherry-options-updated');
			}
			if(isset($_POST['cherry']['restore-options'])){
				do_action('cherry-options-restored');
			}
			
			return $option_value;*/
		}
		
		/**
	     * Priority sorting
	     *
	     * @since 4.0.0
	     */
		private function priority_sorting($base_array) {
			usort($base_array, function($a, $b){
			    return ($a['priority'] - $b['priority']);
			});
			return $base_array;
		}

		/**
	     *
	     * @since 4.0.0
	     */
		function cherry_options_page_build() {
			global $cherry_options_framework;

			//save options
			if(isset($_POST['cherry']['save-options'])){
				$cherry_options_framework->create_updated_options_array($_POST['cherry']);	
				do_action('cherry-options-updated');
			}
			//restore options
			if(isset($_POST['cherry']['restore-options'])){
				$cherry_options_framework->restore_default_settings_array();
				do_action('cherry-options-restored');
			}

			$cherry_options = $cherry_options_framework->get_settings();

			$cherry_options = $this->priority_sorting($cherry_options);

			?>
			<div class="fixedControlHolder"><span class="saveButton dashicons dashicons-yes"></span><span class="restoreButton dashicons dashicons-no-alt"></span></div>
				<div class="options-page-wrapper">
					<div class="current_theme">
						<span><?php echo "Theme ".get_option( 'current_theme' ); ?></span>
					</div>
					<?php settings_errors( 'cherry-options-group' ); ?>
						<form id="cherry_options" action="" method="post">
							<?php settings_fields( 'cherry-options-group' ); ?>
							<div class="cherry-sections-wrapper">
								<ul class="cherry-tab-menu">
									<?php
									foreach ($cherry_options as $section_key => $section_value) {
										($section_value["parent"] != '')? $subClass = 'subitem' : $subClass = '';
										$priority_value = $section_value['priority'];
										?>
										<li class="tabitem-<?php echo $section_key; echo $subClass; echo $section_value["parent"];?>"><a href="javascript:void(0)"><i class="<?php echo $section_value["icon"]; ?>"></i><span><?php echo $section_value["name"]; ?></span></a></li>
									<?php } ?>
								</ul>
								<div class="cherry-option-group-list">
									<?php
									foreach ($cherry_options as $section_key => $section_value) { ?>
										<div class="options_group"><?php echo $this->option_inteface_builder->multi_output_items($section_value['options-list']); ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="clear"></div>
							<div class="cherry-submit-wrapper">
								<?php
									$submitSection = array();
									$submitSection['save-options'] = array(
												'type'			=> 'submit',
												'value'			=> 'Save Options'
									);
									$submitSection['restore-options'] = array(
												'type'			=> 'submit',
												'value'			=> 'Restore Options'
									);
								?>
								<?php echo $this->option_inteface_builder->multi_output_items($submitSection); ?>
							</div>
						</form>
				</div>
			<?php

		}	
	}
}

?>