<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2008 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/hybrid-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'wp_page_menu_args', 'cherry_page_menu_args' );
add_filter( 'body_class', 'cherry_body_classes' );
add_filter( 'wp_footer', 'cherry_cookie_banner' );

add_action( 'wp', 'cherry_setup_author' );

/**
 * Get our `wp_nav_menu()` fallback, `wp_page_menu()`, to show a home link.
 *
 * @author Automattic
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $args Configuration arguments.
 * @return array       An array of page menu arguments.
 */
function cherry_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @author Automattic
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array $classes Classes for the body element.
 * @return array
 */
function cherry_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @author Automattic
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function cherry_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

/**
 * Display the cookie banner.
 *
 * @since  4.0.0
 * @return string HTML-markup for cookie banner.
 */
function cherry_cookie_banner() {

	if ( 'false' == cherry_get_option( 'cookie-banner-visibility' ) ) {
		return;
	}

	if ( '' == cherry_get_option( 'cookie-banner-text' ) ) {
		return;
	}

	if ( isset( $_COOKIE['cherry_cookie_banner'] ) && '1' == $_COOKIE['cherry_cookie_banner'] ) {
		return;
	}

	ob_start(); ?>

	<div id="cherry-cookie-banner" class="cherry-cookie-banner-wrap alert alert-warning alert-dismissible" role="alert">
		<div class="container">
			<button type="button" id="cherry-dismiss-cookie" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<?php echo htmlspecialchars_decode( cherry_get_option( 'cookie-banner-text' ) ); ?>
		</div>
	</div>

	<?php $output = ob_get_contents();
	ob_end_clean();

	/**
	 * Filter a cookie banner.
	 *
	 * @since 4.0.0
	 * @param $output HTML-markup for cookie banner.
	 */
	$output = apply_filters( 'cherry_cookie_banner', $output );

	printf( '%s', $output );
}
