<?php
/**
 * Functions for loading template parts. These functions are helper functions or more flexible functions
 * than what core WordPress currently offers with template part loading.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Loads a post content template based.
add_action( 'cherry_entry', 'cherry_get_content_template' );

// Loads template for comments.
add_action( 'cherry_entry_after', 'cherry_get_comments_template', 25 );

// Loads template if no posts were found.
add_action( 'cherry_loop_empty', 'cherry_noposts' );

/**
 * This is a replacement function for the WordPress `get_header()` function.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  string $name The name of the specialised header.
 */
function cherry_get_header( $name = null ) {
	do_action( 'get_header', $name ); // Core WordPress hook.

	$templates = array();
	$name      = (string) $name;

	if ( '' === $name ) {
		$name = cherry_template_base();
	}

	$templates[] = "header-{$name}.php";
	$templates[] = "header/{$name}.php";
	$templates[] = 'header.php';
	$templates[] = 'header/header.php';

	locate_template( $templates, true );
}

/**
 * This is a replacement function for the WordPress `get_footer()` function.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  string $name The name of the specialised footer.
 */
function cherry_get_footer( $name = null ) {
	do_action( 'get_footer', $name ); // Core WordPress hook.

	$templates = array();
	$name      = (string) $name;

	if ( '' !== $name ) {
		$name = cherry_template_base();
	}

	$templates[] = "footer-{$name}.php";
	$templates[] = "footer/{$name}.php";
	$templates[] = 'footer.php';
	$templates[] = 'footer/footer.php';

	locate_template( $templates, true );
}

/**
 * Loads appropriate page template file.
 *
 * @since 4.0.0
 */
function cherry_get_content() {
	/**
	 * Fires before content `.*-wrapper` are opened.
	 *
	 * @since 4.0.0
	 */
	do_action( 'cherry_content_before' );

	/**
	 * Main template file.
	 *
	 * @see lib/class/class-cherry-wrapping.php
	 * @since 4.0.0
	 */
	include apply_filters( 'cherry_get_content', cherry_template_path() );

	/**
	 * Fires when entry `<article>` are closed.
	 *
	 * @since 4.0.0
	 */
	do_action( 'cherry_content' );

	/**
	 * Fires when primary `.content-area` are closed.
	 *
	 * @since 4.0.0
	 */
	do_action( 'cherry_content_after' );
}

/**
 * Loads a post content template based on the post type and/or the post format.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return string Post/page content.
 */
function cherry_get_content_template() {

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based on post type and post format.
		$templates[] = "content/{$post_type}-{$post_format}.tmpl";

		// Template based on the post format.
		$templates[] = "content/{$post_format}.tmpl";
	}

	// Template based on the post type.
	$templates[] = "content/{$post_type}.tmpl";

	// Fallback 'content.tmpl' template.
	$templates[] = 'content/content.tmpl';

	// Allow devs to filter the content template hierarchy.
	$templates = apply_filters( 'cherry_content_template_hierarchy', $templates );

	printf( '%s', cherry_parse_tmpl( $templates ) );
}

/**
 * Parse *.tmpl file - replace macros on the real content.
 *
 * @since  4.0.0
 * @param  array  $template_names Set of templates.
 * @return string                 The post/page content.
 */
function cherry_parse_tmpl( $template_names ) {
	ob_start();

	include( locate_template( $template_names, false, false ) );

	$template = ob_get_contents();
	ob_end_clean();

	// Perform a regular expression.
	$output = preg_replace_callback( "/%%.+?%%/", 'cherry_do_content', $template );

	/**
	 * Filter a post/page content.
	 *
	 * @since 4.0.0
	 * @param string $output         The post/page content.
	 * @param string $template       Not passed template content (content with macroses).
	 * @param array  $template_names Set of templates.
	 */
	return apply_filters( 'cherry_parse_tmpl', $output, $template, $template_names );
}

/**
 * Callback-function for regular expression.
 *
 * @since  4.0.0
 * @param  array  $matches Array of matched elements.
 * @return string
 */
function cherry_do_content( $matches ) {

	if ( ! is_array( $matches ) ) {
		return '';
	}

	if ( empty( $matches ) ) {
		return '';
	}

	$item   = trim( $matches[0], '%%' );
	$arr    = explode( ' ', $item, 2 );
	$macros = strtolower( $arr[0] );
	$attr   = isset( $arr[1] ) ? shortcode_parse_atts( $arr[1] ) : array();

	if ( isset( $attr['location'] )
		&& ( 'core' == $attr['location'] )
		&& function_exists( $macros )
		&& is_callable( $macros )
		) {

		// Call a WordPress function.
		return call_user_func( $macros, $attr );
	}

	$function_name = "cherry_get_the_post_{$macros}";

	/**
	 * Filter callback function's name for outputing post element.
	 *
	 * @since 4.0.0
	 * @param bool|mixed $pre  Value to return instead of the callback-function.
	 *                         Default false to skip it.
	 * @param array      $attr Set of macros attributes.
	 */
	$pre = apply_filters( "cherry_pre_get_the_post_{$macros}", false, $attr );

	if ( false !== $pre ) {
		return $pre;
	}

	if ( ! function_exists( $function_name ) || ! is_callable( $function_name ) ) {
		return '';
	}

	if ( ! isset( $attr['where'] ) ) {
		return call_user_func( $function_name, $attr );
	}

	if ( ( ( 'loop' === $attr['where'] ) && is_singular() )
		|| ( ( 'single' === $attr['where'] ) && ! is_singular() )
		) {
		return '';
	}

	return call_user_func( $function_name, $attr );
}

/**
 * Loads template for sidebar by $name.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since 4.0.0
 * @param string $name The name of the specialised sidebar.
 */
function cherry_get_sidebar( $name = null ) {
	do_action( 'get_sidebar', $name ); // Core WordPress hook.

	$name = (string) $name;

	if ( false === cherry_display_sidebar( $name ) ) {
		return;
	}

	$templates   = array();

	if ( $name ) {
		$_name       = $name . '-' . cherry_template_base();
		$templates[] = "{$_name}.php";
		$templates[] = "sidebar/{$_name}.php";
		$templates[] = "{$name}.php";
		$templates[] = "sidebar/{$name}.php";
	}

	$templates[] = 'sidebar/sidebar.php';
	$templates[] = 'sidebar.php';

	$template_path = locate_template( $templates, false, false );

	if ( '' !== $template_path ) {
		require( $template_path );
		return;
	}

	/**
	 * Fires before sidebar wrapper are opened.
	 *
	 * @since 4.0.0
	 * @param string $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_before', $name );

	printf( '<div %s>', cherry_get_attr( 'sidebar', $name ) );

	if ( is_active_sidebar( "{$name}" ) ) {
		dynamic_sidebar( "{$name}" );
	} else {

		/**
		 * Fires if sidebar are empty.
		 *
		 * @since 4.0.0
		 * @param string $name The name of the specialised sidebar.
		 */
		do_action( 'cherry_sidebar_empty', $name );
	}

	echo '</div>';

	/**
	 * Fires after sidebar wrapper are closed.
	 *
	 * @since 4.0.0
	 * @param string $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_after', $name );
}

/**
 * Loads template for menu.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since 4.0.0
 * @param string $name The name of the specialised menu.
 */
function cherry_get_menu_template( $name = '' ) {
	$templates = array();

	if ( '' !== $name ) {
		$templates[] = "menu-{$name}.php";
		$templates[] = "menu/{$name}.php";
	}

	$templates[] = 'menu.php';
	$templates[] = 'menu/menu.php';

	locate_template( $templates, true );
}

/**
 * Loads template for comments.
 *
 * @since 4.0.0
 */
function cherry_get_comments_template() {
	$post_type = get_post_type();

	if ( ! post_type_supports( $post_type, 'comments' ) ) {
		return;
	}

	if ( ! is_singular( $post_type ) ) {
		return;
	}

	if ( ( 'post' == $post_type )
		&& ( 'false' == cherry_get_option( 'blog-comment-status' ) )
		) {
		return;
	}

	if ( ( 'page' == $post_type )
		&& ( 'false' == cherry_get_option( 'page-comments-status' ) )
		) {
		return;
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {

		// Loads the comments.php template.
		comments_template( '/templates/comments.php', true );
	}
}

/**
 * Loads template if no posts were found.
 *
 * @since 4.0.0
 */
function cherry_noposts() {
	get_template_part( 'templates/none' );
}
