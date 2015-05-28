<?php
/**
 * Sidebars configuration.
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Register sidebars.
add_action( 'widgets_init', 'cherry_register_sidebars' );
function cherry_register_sidebars() {

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-main',
			'name'        => __( 'Main Sidebar', 'cherry' ),
			'description' => __( 'This is the main sidebar if you are using a two or three column site layout option.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-secondary',
			'name'        => __( 'Secondary Sidebar', 'cherry' ),
			'description' => __( 'This is the secondary sidebar if you are using a three column site layout option.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-header',
			'name'        => __( 'Header Sidebar', 'cherry' ),
			'description' => __( 'A sidebar located in the header of the site.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-footer-1',
			'name'        => __( 'Footer Sidebar 1', 'cherry' ),
			'description' => __( 'A sidebar located in the footer of the site.', 'cherry' ),
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-footer-2',
			'name'        => __( 'Footer Sidebar 2', 'cherry' ),
			'description' => __( 'A sidebar located in the footer of the site.', 'cherry' ),
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-footer-3',
			'name'        => __( 'Footer Sidebar 3', 'cherry' ),
			'description' => __( 'A sidebar located in the footer of the site.', 'cherry' ),
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-footer-4',
			'name'        => __( 'Footer Sidebar 4', 'cherry' ),
			'description' => __( 'A sidebar located in the footer of the site.', 'cherry' ),
		)
	);
}