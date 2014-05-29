<?php
// Header structure.
add_action( 'cherry_header_before', 'cherry_header_wrap', 999 );
add_action( 'cherry_header_after',  'cherry_header_wrap',   0 );
add_action( 'cherry_header',        'cherry_header_logo',   1 );
add_action( 'cherry_header',        'cherry_header_nav',    9 );

// Footer structure.
add_action( 'cherry_footer_before', 'cherry_footer_wrap',    999 );
add_action( 'cherry_footer_after',  'cherry_footer_wrap',      0 );
add_action( 'cherry_footer',        'cherry_footer_sidebar',   9 );
add_action( 'cherry_footer',        'cherry_footer_info',     15 );

// Content structure.
add_action( 'cherry_get_content',    'cherry_content_register_hook' );
add_action( 'cherry_content_before', 'cherry_content_wrap',     999 );
add_action( 'cherry_content_after',  'cherry_content_wrap',       0 );

// Post structure in the loop.
add_action( 'cherry_post_loop', 'cherry_post_structure_loop' );

// Single post structure.
add_action( 'cherry_post_single', 'cherry_post_structure_single' );

add_filter( 'cherry_post_structure_loop',   'cherry_post_loop_structure_setup',   9, 3 );
add_filter( 'cherry_post_structure_single', 'cherry_post_single_structure_setup', 9, 3 );

/**
 * Output Header Wrap.
 *
 * @since 4.0.0
 */
function cherry_header_wrap() {

	if ( !did_action( 'cherry_header' ) ) {

		printf( '<header %s><div class="container">', cherry_get_attr( 'header' ) );

	} else {

		echo '</div></header>';

	}

}

/**
 * Prints HTML with Header Logo.
 *
 * @since 4.0.0
 */
function cherry_header_logo() {

	if ( cherry_get_site_title() || cherry_get_site_description() ) {
		echo '<!-- Branding -->';
		printf( '<div class="site-branding">%1$s %2$s</div>', cherry_get_site_title(), cherry_get_site_description() );
	}

}

/**
 * Prints HTML with Header Menu.
 *
 * @since 4.0.0
 */
function cherry_header_nav() {

	if ( has_nav_menu( 'header' ) ) {

		echo '<!-- Navigation -->';

		// http://codex.wordpress.org/Function_Reference/wp_nav_menu
		$args = array(
					'theme_location' => 'header',
					'container'      => '',
					'menu_class'     => 'sf-menu',
					'items_wrap'     => '<nav ' . cherry_get_attr( 'menu', 'navigation' ) . '><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
				);
		wp_nav_menu( apply_filters( 'cherry_header_nav_args', $args ) );

	}
}

/**
 * Output Footer Wrap.
 *
 * @since 4.0.0
 */
function cherry_footer_wrap() {

	if ( !did_action( 'cherry_footer' ) ) {

		printf( '<footer %s><div class="container">', cherry_get_attr( 'footer' ) );

	} else {

		echo '</div></footer>';
	}
}

/**
 * Register hook for `sidebar-footer`.
 *
 * @since 4.0.0
 */
function cherry_footer_sidebar() {
	do_action( 'cherry_get_footer_sidebar', 'sidebar-footer' );
}

/**
 * Prints HTML with Footer Info.
 *
 * @since 4.0.0
 */
function cherry_footer_info() {
	$output = "<div class='site-info'>";
	$output .= sprintf(
					__( 'Copyright &copy; %1$s %2$s. Powered by %3$s and %4$s.', 'cherry' ),
					date_i18n( 'Y' ), cherry_get_site_link(), cherry_get_wp_link(), cherry_get_theme_link()
				);
	$output .= "</div>";

	echo $output;
}

/**
 * Register Content hooks.
 *
 * @since 4.0.0
 */
function cherry_content_register_hook() {
	do_action( 'cherry_content_before' );
	do_action( 'cherry_content' );
	do_action( 'cherry_content_after' );
}

/**
 * Output Primary Content Wrap.
 *
 * @since 4.0.0
 */
function cherry_content_wrap() {

	if ( !did_action( 'cherry_content' ) ) {

		echo '<!-- Primary column -->';
		printf( '<div id="primary" class="content-area %1$s"><main %2$s>', cherry_content_class(), cherry_get_attr( 'content' ) );

	} else {

		echo '</main></div>';

	}

}

/**
 * Setup default the post stucture in the loop.
 *
 * @since  4.0.0
 *
 * @param  string $template_name The template name for content
 * @return void
 */
function cherry_post_structure_loop( $template_name = '' ) {
	$post_type = get_post_type();

	if ( '' === $template_name ) {

		if ( post_type_supports( $post_type, 'post-formats' ) ) :

			$template_name = ( get_post_format( get_the_ID() ) ) ? get_post_format( get_the_ID() ) : 'standard';

		else :

			$template_name = apply_filters( 'cherry_default_content_template', 'content', $post_type );

		endif;

	}

	$structure_elements = apply_filters( 'cherry_post_structure_loop', array( 'header', 'meta', 'excerpt' ), $template_name, $post_type );

	foreach ( $structure_elements as $element ) {

		call_user_func( apply_filters( 'cherry_post_call_user_func', "cherry_the_post_{$element}", $element ) );

	}
}

/**
 * Setup default the single post stucture.
 *
 * @since  4.0.0
 *
 * @param  string $template_name The template name for content
 * @return void
 */
function cherry_post_structure_single( $template_name = '' ) {
	$post_type = get_post_type();

	if ( '' === $template_name ) {

		if ( post_type_supports( $post_type, 'post-formats' ) ) :

			$template_name = ( get_post_format( get_the_ID() ) ) ? get_post_format( get_the_ID() ) : 'standard';

		else :

			$template_name = apply_filters( 'cherry_default_content_template', 'content', $post_type );

		endif;

	}

	$structure_elements = apply_filters( 'cherry_post_structure_single', array( 'header', 'meta', 'content', 'footer' ), $template_name, $post_type );

	foreach ( $structure_elements as $element ) {

		call_user_func( apply_filters( 'cherry_post_call_user_func', "cherry_the_post_{$element}", $element ) );

	}
}

/**
 * Modifies the post stucture in the loop.
 *
 * @since  4.0.0
 *
 * @param  array  $structure_elements The elements of post structure
 * @param  string $template_name      The template name for content
 * @param  string $post_type          The post type of the current post
 * @return array                      The elements of post structure
 */
function cherry_post_loop_structure_setup( $structure_elements, $template_name, $post_type ) {

	switch ( $template_name ) {

		case 'attachment':
			$structure_elements = array( 'header', 'content', 'footer' );
			break;

		case 'aside':
			$structure_elements = array( 'content' );
			break;

		case 'content':
			$structure_elements = array( 'thumbnail', 'header', 'meta', 'excerpt', 'footer' );
			break;

		case 'image':
			$structure_elements = array( 'thumbnail', 'header', 'meta', 'excerpt' );
			break;

		case 'link':
			$structure_elements = array( 'header', 'meta' );
			break;

		case 'page':
			$structure_elements = array( 'thumbnail', 'header', 'excerpt' );
			break;

		case 'quote':
			$structure_elements = array( 'content', 'footer' );
			break;

		case 'standard':
			$structure_elements = array( 'thumbnail', 'header', 'meta', 'excerpt', 'footer' );
			break;

		case 'status':
			$structure_elements = array( 'header', 'content', 'footer' );
			break;

		default:
			break;
	}

	return $structure_elements;
}

/**
 * Modifies the single post stucture.
 *
 * @since 4.0.0
 *
 * @param  array  $structure_elements The elements of post structure
 * @param  string $template_name      The template name for content
 * @param  string $post_type          The post type of the current post
 * @return array                      The elements of post structure
 */
function cherry_post_single_structure_setup( $structure_elements, $template_name ) {

	switch ( $template_name ) {

		case 'attachment':
			$structure_elements = array( 'header', 'content', 'footer' );
			break;

		case 'chat':
			$structure_elements = array( 'header', 'meta', 'excerpt', 'content', 'footer' );
			break;

		case 'content':
			$structure_elements = array( 'thumbnail', 'header', 'meta', 'content', 'footer' );
			break;

		case 'page':
			$structure_elements = array( 'header', 'content', 'footer' );
			break;

		case 'quote':
			$structure_elements = array( 'content', 'footer' );
			break;

		case 'standard':
			$structure_elements = array( 'thumbnail', 'header', 'meta', 'content', 'footer' );
			break;

		case 'status':
			$structure_elements = array( 'header', 'content', 'footer' );
			break;

		default:
			break;
	}

	return $structure_elements;
}