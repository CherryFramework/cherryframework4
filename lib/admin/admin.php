<?php
/**
 * Theme administration functions used with other components of the framework admin. This file is for
 * setting up any basic features and holding additional admin helper functions.
 */
	//Include admin scripts
	require_once( 'scripts.php' );
	//Include admin style
	require_once( 'style.php' );

	//Include theme options page
	require_once( 'pages/theme-options-page.php' );

	//Added menu items in admin panel
	function cherry_add_admin_menu() {
		$cherry_menu = 'cherry-framework';
		//add main menu item
		//Cherry interface
		add_menu_page( __( 'Cherry options page', 'cherry' ), __( 'Cherry options', 'cherry' ), 'edit_theme_options', $cherry_menu, 'cherry_options', 'dashicons-admin-settings', 61 );
	}
	add_action( 'admin_menu', 'cherry_add_admin_menu');

?>