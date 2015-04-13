<?php
/**
 * Cherry theme menus configuration
 *
 * @package    Cherry_Framework
 * @subpackage Config
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Define which templates/pages exclude the sidebar.
 *
 *  @since 4.0.0
 * @param  string $id Sidebar ID.
 * @return bool       Display or not the sidebar?
 */
function cherry_display_sidebar( $id ) {
	global $wp_registered_sidebars;

	if ( array_key_exists( $id, $wp_registered_sidebars ) !== TRUE ) {
		return false;
	}

	$sidebars = apply_filters( 'cherry_display_sidebar_args', array(
		'sidebar-main' => new Cherry_Sidebar(
			/**
			 * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags).
			 * Any of these conditional tags that return true won't show the sidebar.
			 *
			 * If you only wanted to exclude page from displaying the sidebar, you'll need to pass
			 * an additional argument through the array, namely the page id, the slug, or the title.
			 * To do this you need to pass the conditional and argument together as an array.
			 * The following would exclude a page with id of 36, page with slug 'page-slug' and page with title 'Page Title':
			 *
			 *      array(
			 *          array('is_page', array(36, 'page-slug', 'Page Title'))
			 *      ),
			 */
			array(
				'is_404',
				'is_front_page',
			),
			/**
			 * Page template checks (via is_page_template()).
			 * Any of these page templates that return true won't show the sidebar.
			 */
			array(
				// 'templates/my-template-name.php',
			)
		),
		'sidebar-secondary' => new Cherry_Sidebar(
			array(
				'is_404',
				'is_front_page',
			)
		),
		'sidebar-footer-1' => new Cherry_Sidebar(
			array(
				'is_404',
			)
		),
		'sidebar-footer-2' => new Cherry_Sidebar(
			array(
				'is_404',
			)
		),
		'sidebar-footer-3' => new Cherry_Sidebar(
			array(
				'is_404',
			)
		),
		'sidebar-footer-4' => new Cherry_Sidebar(
			array(
				'is_404',
			)
		),
	) );

	if ( !isset( $sidebars[ $id ] ) ) {
		return true;
	}

	return apply_filters( 'cherry_display_sidebar', $sidebars[ $id ]->display, $id );
}