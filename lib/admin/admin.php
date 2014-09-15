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
	require_once( 'pages/cherry-framework-options-page.php' );

	//Added menu items in admin panel
	function cherry_add_admin_menu() {

	}
	add_action( 'admin_menu', 'cherry_add_admin_menu');

?>