<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Header structure.
add_action( 'cherry_header_before', 'cherry_header_wrap', 999 );
add_action( 'cherry_header_after',  'cherry_header_wrap',   0 );
add_action( 'cherry_header',        'cherry_header_load_template' );

// Footer structure.
add_action( 'cherry_footer_before', 'cherry_footer_wrap',    999 );
add_action( 'cherry_footer_after',  'cherry_footer_wrap',      0 );
add_action( 'cherry_footer',        'cherry_footer_load_template' );

// Content structure.
add_action( 'cherry_content_before', 'cherry_content_wrap',     999 );
add_action( 'cherry_content_after',  'cherry_content_wrap',       0 );
add_action( 'cherry_sidebar_after',  'cherry_content_sidebar_wrap_close', 0 );

// Entry structure.
add_action( 'cherry_entry_before', 'cherry_entry_wrap_open',  999 );
add_action( 'cherry_entry_after',  'cherry_entry_wrap_close',   0 );

// Replace gallery shortcode
add_filter( 'post_gallery', 'cherry_gallery_shortcode', 10, 3 );

// Attachment metadata.
add_action( 'cherry_entry_after', 'cherry_get_attachment_metadata', 9 );

/**
 * Display a site header wrapper.
 *
 * @since  4.0.0
 * @return string HTML-markup for `<header>`.
 */
function cherry_header_wrap() {

	if ( ! did_action( 'cherry_header' ) ) {
		printf( '<header %s>', cherry_get_attr( 'header' ) );
	} else {
		echo '</header>';
	}
}

/**
 * Display a site footer wrapper.
 *
 * @since  4.0.0
 * @return string HTML-markup for `<footer>`.
 */
function cherry_footer_wrap() {

	if ( ! did_action( 'cherry_footer' ) ) {
		printf( '<footer %s>', cherry_get_attr( 'footer' ) );
	} else {
		echo '</footer>';
	}
}

/**
 * Load a `wrapper-header` template.
 *
 * @since 4.0.0
 */
function cherry_header_load_template() {
	get_template_part( 'templates/wrapper-header', cherry_template_base() );
}

/**
 * Load a `wrapper-footer` template.
 *
 * @since 4.0.0
 */
function cherry_footer_load_template() {
	get_template_part( 'templates/wrapper-footer', cherry_template_base() );
}

/**
 * Display a site content wrapper.
 *
 * @since  4.0.0
 * @return string HTML-markup for content.
 */
function cherry_content_wrap() {

	if ( ! did_action( 'cherry_content' ) ) {

		$wrapper = '';

		if ( false !== cherry_display_sidebar( apply_filters( 'cherry_get_main_sidebar', 'sidebar-main' ) ) ) {

			$layout = cherry_current_page()->get_property( 'layout' );
			$class  = sanitize_html_class( $layout . '-wrapper' );

			/**
			 * Filter a CSS-class for site content wrapper.
			 *
			 * @since 4.0.0
			 * @param $class CSS-class for content wrapper.
			 */
			$wrapper_class = apply_filters( 'cherry_content_sidebar_wrapper_class', $class );
			$wrapper       = sprintf( '<div class="%s">', $wrapper_class );
		}

		printf( '%1$s<div id="primary" class="content-area"><main %2$s>', $wrapper, cherry_get_attr( 'main' ) );

	} else {
		echo '</main></div>';
	}
}

/**
 * Closed a content `.*-wrapper`.
 *
 * @since  4.0.0
 * @param  string $sidebar Sidebar ID.
 * @return string          HTML tag.
 */
function cherry_content_sidebar_wrap_close( $sidebar ) {

	if ( apply_filters( 'cherry_get_main_sidebar', 'sidebar-main' ) !== $sidebar ) {
		return;
	}

	if ( did_action( 'cherry_footer' ) ) {
		return;
	}

	echo '</div>';
}

/**
 * Open a post (entry) wrapper.
 *
 * @since  4.0.0
 * @return string `<article>`.
 */
function cherry_entry_wrap_open() {
	printf( '<article %s>', cherry_get_attr( 'post' ) );
}

/**
 * Close a post (entry) wrapper.
 *
 * @since  4.0.0
 * @return string `</article>`.
 */
function cherry_entry_wrap_close() {
	echo '</article>';
}

/**
 * Display or retrieve the attachment meta.
 *
 * @since  4.0.0
 * @param  int  $post_id Attachment ID.
 * @param  bool $echo    Display the attachment meta?
 * @return void|array
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

	if ( ! $metadata ) {
		return;
	}

	if ( ! function_exists( "cherry_{$type}_meta" ) ) {
		return;
	}

	$items = call_user_func( "cherry_{$type}_meta", $post_id, $metadata );

	if ( empty( $items ) ) {
		return;
	}

	if ( true !== $echo ) {
		return $items;
	}

	$display = '';

	foreach ( (array) $items as $item ) {

		$display .= sprintf( '<li><strong class="prep">%1$s</strong>:&nbsp;<span class="data">%2$s</span></li>',
			esc_html( $item[1] ),
			$item[0]
		);
	}

	$display = '<ul class="media-meta">' . $display . '</ul>';
	$title   = sprintf( __( '%s Info', 'cherry' ), $type );

	printf( '<div class="attachment-meta"><div class="media-info"><h3 class="media-title">%1$s</h3>%2$s</div></div>',
		$title,
		$display
	);
}
