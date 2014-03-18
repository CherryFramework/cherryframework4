<?php
/**
 * Functions for outputting common site data in the `<head>` area of a site.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Adds common theme items to <head>.
add_action( 'wp_head', 'cherry_meta_charset',  0 );
add_action( 'wp_head', 'cherry_doctitle',      0 );
add_action( 'wp_head', 'cherry_meta_viewport', 1 );
add_action( 'wp_head', 'cherry_link_pingback', 3 );

// Filters the WordPress title.
add_filter( 'wp_title', 'cherry_wp_title', 10, 2 );

// Removes unnecessary code that WordPress puts to <head>.
// http://wpengineer.com/1438/wordpress-header/
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Removes injected CSS from recent comments widget
add_filter( 'wp_head', 'cherry_remove_recent_comments_style', 1 );

// Removes WordPress version from stylesheets and scripts
add_filter( 'style_loader_src', 'cherry_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'cherry_remove_wp_ver_css_js', 9999 );

/**
 * Adds the meta charset to the header.
 *
 * @since  4.0.0
 */
function cherry_meta_charset() {
	echo "<meta charset=\"" . get_bloginfo( 'charset' ) . "\" />\n";
}

/**
 * Adds the title to the header.
 *
 * @since  4.0.0
 */
function cherry_doctitle() {
	printf( "<title>%s</title>\n", wp_title( '|', false, 'right' ) );
}

/**
 * Adds the meta viewport to the header.
 *
 * @since  4.0.0
 */
function cherry_meta_viewport() {
	echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />\n";
}

/**
 * Adds the pingback meta tag to the head so that other sites can know how to send a pingback to our site.
 *
 * @since  4.0.0
 */
function cherry_link_pingback() {
	if ( 'open' === get_option( 'default_ping_status' ) ) {
		echo "<link rel=\"pingback\" href=\"" . get_bloginfo( 'pingback_url' ) . "\" />\n";
	}
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since  4.0.0
 *
 * @param  string $title Default title text for current view.
 * @param  string $sep   Optional separator.
 * @return string        The filtered title.
 */
function cherry_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'cherry' ), max( $paged, $page ) );
	}

	return $title;
}

/**
 * Remove inline CSS used by Recent Comments widget
 *
 * @since  4.0.0
 */
function cherry_remove_recent_comments_style() {
	global $wp_widget_factory;

	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

/**
 * Remove WordPress version
 *
 * @since  4.0.0
 *
 * @param  string $src URL to the file
 * @return string      URL to the file
 */
function cherry_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}