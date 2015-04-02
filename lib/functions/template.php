<?php
/**
 * Functions for loading template parts. These functions are helper functions or more flexible functions
 * than what core WordPress currently offers with template part loading.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

add_action( 'cherry_post',             'cherry_get_content_template' );
add_action( 'cherry_page',             'cherry_get_content_template' );
add_action( 'cherry_content_template', 'cherry_content_template' );

// add_action( 'cherry_get_sidebar',        'cherry_get_sidebar_template' );
// add_action( 'cherry_get_footer_sidebar', 'cherry_get_sidebar_template' );

add_action( 'cherry_get_comments',       'cherry_get_comments_template' );

add_action( 'cherry_loop_empty',         'cherry_noposts' );

/**
 * This is a replacement function for the WordPress `get_header()` function.
 *
 * @since 4.0.0
 * @param string $name The name of the specialised header.
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
 * @since  4.0.0
 * @param  string $name
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
	do_action( 'cherry_content_before' );
	include cherry_template_path();
	do_action( 'cherry_content' );
	do_action( 'cherry_content_after' );
}

/**
 * Loads a post content template based on the post type and/or the post format.
 *
 * @since  4.0.0
 * @return string
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

	do_action( 'cherry_content_template', $templates );
}

function cherry_content_template( $templates ) {
	ob_start();

	include( locate_template( $templates, false, false ) );

	$template = ob_get_contents();
	ob_end_clean();

	printf( '<article %s>', cherry_get_attr( 'post' ) );

		// Perform a regular expression.
		$content = preg_replace_callback( "/%%.+?%%/", 'cherry_do_content', $template );

		echo $content;

	echo '</article>';
}

function cherry_do_content( $matches ) {
	if ( !is_array( $matches ) ) {
		return '';
	}

	if ( empty( $matches ) ) {
		return '';
	}

	$item   = strtolower( trim( $matches[0], '%%' ) );
	$arr    = explode( ' ', $item, 2 );
	$macros = $arr[0];
	$attr   = isset( $arr[1] ) ? shortcode_parse_atts( $arr[1] ) : array();

	$function_name = "cherry_get_the_post_{$macros}";

	/**
	 * Filter callback function's name for outputing post element.
	 * @since 4.0.0
	 */
	$pre = apply_filters( "cherry_pre_get_the_post_{$macros}", false );

	if ( false !== $pre ) {
		return $pre;
	}

	if ( !function_exists( $function_name ) ) {
		return '';
	}

	if ( !isset( $attr['where'] ) ) {
		return call_user_func( $function_name, $attr );
	}

	if ( ( ( 'loop' === $attr['where'] ) && is_singular() )
		|| ( ( 'single' === $attr['where'] ) && !is_singular() )
		) {
		return '';
	}

	return call_user_func( $function_name, $attr );
}

/**
 * Loads template for sidebar by $name.
 *
 * @since  4.0.0
 * @param  string $name
 */
function cherry_get_sidebar( $name = null ) {

	do_action( 'get_sidebar', $name ); // Core WordPress hook.

	$name = (string) $name;

	if ( false === cherry_display_sidebar( 'sidebar-' . $name ) ) {
		return;
	}

	$_name = $name . '-' . cherry_template_base();

	$templates   = array();
	$templates[] = "sidebar-{$_name}.php";
	$templates[] = "sidebar/{$_name}.php";
	$templates[] = "sidebar-{$name}.php";
	$templates[] = "sidebar/{$name}.php";
	$templates[] = 'sidebar.php';
	$templates[] = 'sidebar/sidebar.php';

	$template_path = locate_template( $templates );

	if ( '' !== $template_path ) {
		load_template( $template_path );
		return;
	}

	// Backward compat (when template not found).
	do_action( 'cherry_sidebar_before', $name );

	printf( '<div %s>', cherry_get_attr( 'sidebar', $name ) );

	do_action( 'cherry_sidebar_start', $name );

	if ( is_active_sidebar( "sidebar-{$name}" ) ) {
		dynamic_sidebar( "sidebar-{$name}" );
	} else {
		do_action( 'cherry_sidebar_empty', $name );
	}

	do_action( 'cherry_sidebar_end', $name );

	echo '</div>';

	do_action( 'cherry_sidebar_after', $name );
}

/**
 * Loads template for menu.
 *
 * @since  4.0.0
 * @param  string  $name
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
 * @since  4.0.0
 */
function cherry_get_comments_template() {

	if ( !post_type_supports( get_post_type(), 'comments' ) ) {
		return;
	}

	// If viewing a single post/page/CPT.
	if ( is_singular() ) :

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :

			// Loads the comments.php template.
			comments_template( '/templates/comments.php', true );

		endif;

	endif;
}

/**
 * Loads template if no posts were found.
 *
 * @since  4.0.0
 */
function cherry_noposts() {
	get_template_part( 'content/none' );
}