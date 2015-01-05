<?php

// Header structure.
add_action( 'cherry_header_before', 'cherry_header_wrap', 999 );
add_action( 'cherry_header_after',  'cherry_header_wrap',   0 );
add_action( 'cherry_header',        'cherry_header_load_template' );

// Footer structure.
add_action( 'cherry_footer_before', 'cherry_footer_wrap',    999 );
add_action( 'cherry_footer_after',  'cherry_footer_wrap',      0 );
add_action( 'cherry_footer',        'cherry_footer_sidebar',   9 );
// add_action( 'cherry_footer',        'cherry_footer_menu',     15 );
// add_action( 'cherry_footer',        'cherry_footer_info',     25 );
add_action( 'cherry_footer',        'cherry_footer_load_template' );

// Content structure.
// add_action( 'cherry_get_content',    'cherry_content_register_hook' );
add_action( 'cherry_content_before', 'cherry_content_wrap',     999 );
add_action( 'cherry_content_after',  'cherry_content_wrap',       0 );

// Post structure in the loop.
add_action( 'cherry_post_loop', 'cherry_post_structure_loop' );

// Single post structure.
add_action( 'cherry_post_single', 'cherry_post_structure_single' );

// Attachment metadata.
add_action( 'cherry_post_after', 'cherry_get_attachment_metadata' );

add_filter( 'cherry_post_structure_loop',   'cherry_post_loop_structure_setup',   9, 3 );
add_filter( 'cherry_post_structure_single', 'cherry_post_single_structure_setup', 9, 3 );

/**
 * Output Header Wrap.
 *
 * @since 4.0.0
 */
function cherry_header_wrap() {

	if ( !did_action( 'cherry_header' ) ) {

		printf( '<header %s>', cherry_get_attr( 'header' ) );

	} else {

		echo '</header>';

	}

}

/**
 * Output Footer Wrap.
 *
 * @since 4.0.0
 */
function cherry_footer_wrap() {

	if ( !did_action( 'cherry_footer' ) ) {

		printf( '<footer %s>', cherry_get_attr( 'footer' ) );

	} else {

		echo '</footer>';
	}
}

function cherry_header_load_template() {
	get_template_part( 'templates/wrapper-header' );
}

function cherry_footer_load_template() {
	get_template_part( 'templates/wrapper-footer' );
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
 * Prints HTML with Secondary Menu.
 *
 * @since 4.0.0
 */
function cherry_footer_menu() {
	cherry_get_menu_template( 'secondary' );
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
		printf( '<div id="primary" class="content-area"><main %s>', cherry_get_attr( 'content' ) );

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
			$structure_elements = array( 'thumbnail', 'header', 'content' );
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
			$structure_elements = array( 'header', 'excerpt' );
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
			$structure_elements = array( 'header', 'meta', 'content' );
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

/**
 * Display or retrieve the attachment meta.
 *
 * @since 4.0.0
 *
 * @param  int           $post_id Attachment ID.
 * @param  bool          $echo    Display the attachment meta?
 * @return void | array
 */
function cherry_get_attachment_metadata( $post_id = 0, $echo = true ) {

	$post_id = ( $post_id ) ? $post_id : get_the_ID();

	if ( wp_attachment_is_image( $post_id ) ) {

		$type = 'image';

	} elseif ( cherry_attachment_is_audio( $post_id ) ) {

		$type = 'audio';

	} elseif ( cherry_attachment_is_video( $post_id ) ) {

		$type = 'video';

	}

	// Get the attachment metadata.
	$metadata = wp_get_attachment_metadata( $post_id );

	if ( !$metadata ) {
		return;
	}

	if ( is_array( $metadata ) ) :

		if ( function_exists("cherry_{$type}_meta") ) :

			$items = call_user_func( "cherry_{$type}_meta", $post_id, $metadata );

			if ( true !== $echo ) {
				return $items;
			}

		endif;

	endif;

	if ( isset( $items ) && !empty( $items ) ) {

		$display = '';

		foreach ( $items as $item ) {

			$display .= sprintf( '<li><span class="prep">%1$s</span> <span class="data">%2$s</span></li>', $item[1], $item[0] );

		}

		$display = '<ul class="media-meta">' . $display . '</ul>';

	}

	if ( isset( $display ) ) {

		$title = sprintf( __( '%s Info', 'cherry' ), $type );

		printf( '<div class="attachment-meta"><div class="media-info"><h3 class="media-title">%1$s</h3>%2$s</div></div>', $title, $display );

	}

}