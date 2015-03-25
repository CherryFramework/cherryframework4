<?php
/**
 * Cherry theme static-areas configuration
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Register a static areas.
add_action( 'init', 'cherry_register_static_areas' );
function cherry_register_static_areas() {

	cherry_register_static_area( array(
		'id'             => 'header-top',
		'name'           => __( 'Header Top', 'cherry' ),
		'before'         => '',
		'after'          => '',
		'before_static'  => '<div class="static clearfix">',
		'after_static'   => '</div>',
		'container_wrap' => true,
		'row_wrap'       => true,
	) );

	cherry_register_static_area( array(
		'id'             => 'header-left',
		'name'           => __( 'Header Left', 'cherry' ),
		'before'         => '<div class="col-md-7">',
		'after'          => '</div>',
		'container_wrap' => false,
	) );

	cherry_register_static_area( array(
		'id'             => 'header-right',
		'name'           => __( 'Header Right', 'cherry' ),
		'before'         => '<div class="col-md-5">',
		'after'          => '</div>',
		'container_wrap' => false,
	) );

	cherry_register_static_area( array(
		'id'             => 'header-bottom',
		'name'           => __( 'Header Bottom', 'cherry' ),
		'container_wrap' => false,
		)
	);

	cherry_register_static_area( array(
		'id'             => 'slider',
		'name'           => __( 'Slider Area', 'cherry' ),
		'container_wrap' => false,
		'row_wrap'       => false,
	) );

	cherry_register_static_area( array(
		'id'   => 'footer-top',
		'name' => __( 'Footer Top', 'cherry' ),
	) );

	cherry_register_static_area( array(
		'id'   => 'footer-bottom',
		'name' => __( 'Footer Bottom', 'cherry' ),
	) );
}