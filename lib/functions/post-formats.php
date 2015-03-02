<?php
/**
 * Functions and filters for handling the output of post formats.
 *
 * This file is only loaded if themes declare support for 'post-formats'. If a theme declares support for
 * 'post-formats', the content filters will not run for the individual formats that the theme
 * supports.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Add support for structured post formats.
add_action( 'wp_loaded', 'cherry_structured_post_formats', 1 );

/**
 * Theme compatibility for post formats. This function adds appropriate filters for
 * the various post formats that a theme supports.
 *
 * @since  4.0.0
 */
function cherry_structured_post_formats() {
	// Add infinity symbol to aside posts.
	if ( current_theme_supports( 'post-formats', 'aside' ) ) {
		add_filter( 'the_content', 'cherry_aside_infinity', 9 );
	}

	// Filter the excerpt of audio posts.
	if ( current_theme_supports( 'post-formats', 'audio' ) ) {
		add_filter( 'the_excerpt', 'cherry_post_audio_excerpt', 9 );
	}

	// Filter the excerpt of chat posts.
	if ( current_theme_supports( 'post-formats', 'chat' ) ) {
		add_filter( 'the_excerpt', 'cherry_post_chat_excerpt', 9 );
	}

	// Filter the entry-header of link posts.
	if ( current_theme_supports( 'post-formats', 'link' ) ) {
		add_filter( 'cherry_get_the_post_header_args', 'cherry_link_header', 9 );
	}

	// Filter the entry-meta of link posts.
	if ( current_theme_supports( 'post-formats', 'link' ) ) {
		add_filter( 'cherry_get_the_post_meta', 'cherry_post_link_meta' );
	}

	// Wraps <blockquote> around quote posts.
	if ( current_theme_supports( 'post-formats', 'quote' ) ) {
		add_filter( 'the_content', 'cherry_quote_content' );
	}

	// Filter the entry-footer of quote posts.
	if ( current_theme_supports( 'post-formats', 'quote' ) ) {
		add_filter( 'cherry_get_the_post_footer', 'cherry_post_quote_footer', 9 );
	}

	// Filter the entry-header of status posts.
	if ( current_theme_supports( 'post-formats', 'status' ) ) {
		add_filter( 'cherry_get_the_post_header_args', 'cherry_status_header', 9 );
	}

	// Filter the entry-footer of status posts.
	if ( current_theme_supports( 'post-formats', 'status' ) ) {
		add_filter( 'cherry_get_the_post_footer', 'cherry_post_status_footer', 9 );
	}

	// Filter the excerpt of video posts.
	if ( current_theme_supports( 'post-formats', 'video' ) ) {
		add_filter( 'the_excerpt', 'cherry_post_video_excerpt', 9 );
	}

	// Filter the entry-footer of page.
	add_filter( 'cherry_get_the_post_footer', 'cherry_page_footer', 9 );

	// Filter the attachment markup to be prepended to the post content.
	add_filter( 'prepend_attachment', 'cherry_attachment_content', 9 );
}

/**
 * Adds an infinity character "&#8734;" to the end of the post content on 'aside' posts.
 *
 * @since  4.0.0
 *
 * @param  string $content The post content.
 * @return string $content
 */
function cherry_aside_infinity( $content ) {

	if ( has_post_format( 'aside' ) && !is_singular() && !post_password_required() ) {
		$infinity = '<a class="entry-permalink" href="' . get_permalink() . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '">&#8734;</a>';
		$content .= ' ' . apply_filters( 'cherry_aside_infinity', $infinity );
	}

	return $content;
}

/**
 * This function filters the post excerpt when viewing a post with the "audio" post format.
 *
 * @since  4.0.0
 *
 * @param  string $excerpt The post excerpt.
 * @return string          If the post has an excerpt, it returns the excerpt. Else, the post content.
 */
function cherry_post_audio_excerpt( $excerpt ) {

	if ( has_post_format( 'audio' ) && !post_password_required() ) :

		if ( has_excerpt() ) {
			return $excerpt;
		} else {
			$excerpt = '';
			the_content();
		}

	endif;

	return $excerpt;
}

/**
 * This function filters the post excerpt when viewing a post with the "chat" post format.
 *
 * @since  4.0.0
 *
 * @param  string $excerpt The post excerpt.
 * @return string          If the post has an excerpt, it returns the excerpt.
 */
function cherry_post_chat_excerpt( $excerpt ) {

	if ( has_post_format( 'chat' ) && !post_password_required() ) :

		if ( has_excerpt() ) {

			return $excerpt;

		} else {

			$excerpt = '';

		}

	endif;

	return $excerpt;
}

/**
 * This function filters the post header when viewing a post with the "link" post format.
 *
 * @since  4.0.0
 *
 * @param  array $args The defaults arguments used to display a post header.
 * @return array
 */
function cherry_link_header( $args ) {

	if ( has_post_format( 'link' ) ) :

		$post_type = get_post_type();

		$args['url']   = apply_filters( 'cherry_link_header_url', cherry_get_post_format_url() );

		$args['after'] = apply_filters( 'cherry_link_header_after',
			is_singular( $post_type ) ?
			'' :
			'<span class="format-link-marker">&rarr;</span>' );

		$args['wrap']  = apply_filters( 'cherry_link_header_wrap',
			is_singular( $post_type ) ?
			'<header class="entry-header"><%1$s class="%2$s">%4$s</%1$s></header>' :
			'<header class="entry-header"><%1$s class="%2$s"><a href="%3$s" rel="bookmark" target="_blank">%4$s</a></%1$s></header>'
		);

	endif;

	return $args;
}

/**
 * This function filters the entry-meta when viewing a post with the "link" post format.
 *
 * @since  4.0.0
 *
 * @param  string $post_meta The post entry-meta.
 * @param  int    $post_id   The post ID.
 * @return string
 */
function cherry_post_link_meta( $post_meta ) {

	if ( has_post_format( 'link' ) ) :

		if ( !is_singular( get_post_type() ) ) :

			$post_meta = apply_filters( 'cherry_post_link_meta', __( 'Posted on', 'cherry' ) . ' [entry-published] ' . __( 'by', 'cherry' ) . ' [entry-author] [entry-comments-link] [entry-permalink] [entry-edit-link]', get_the_ID() );

		endif;

	endif;

	return $post_meta;
}

/**
 * Checks if the quote post has a <blockquote> tag within the content.
 * If not, wraps the entire post content with one.
 *
 * @since  4.0.0
 *
 * @param  string $content The post content.
 * @return string $content
 */
function cherry_quote_content( $content ) {

	if ( has_post_format( 'quote' ) && !post_password_required() ) {
		preg_match( '/<blockquote.*?>/', $content, $matches );

		if ( empty( $matches ) ) {
			$content = "<blockquote>{$content}</blockquote>";
		}
	}

	return $content;
}

/**
 * This function filters the entry-footer when viewing a post with the "quote" post format.
 *
 * @since  4.0.0
 *
 * @param  string $post_info The post entry-footer.
 * @param  int    $post_id   The post ID.
 * @return string
 */
function cherry_post_quote_footer( $post_info ) {

	if ( has_post_format( 'quote' ) ) :

		if ( is_singular( get_post_type() ) ) {

			$post_info = apply_filters( 'cherry_post_quote_footer_single', __( 'Posted on', 'cherry' ) . ' [entry-published] ' . __( 'by', 'cherry' ) . ' [entry-author] [entry-terms] [entry-edit-link]' );

		} else {

			$post_info = apply_filters( 'cherry_post_quote_footer_loop', __( 'Posted on', 'cherry' ) . ' [entry-published] ' . __( 'by', 'cherry' ) . ' [entry-author] [entry-comments-link] [entry-permalink] [entry-edit-link]' );

		}

	endif;

	return $post_info;
}

/**
 * This function filters the post header when viewing a post with the "status" post format.
 *
 * @since  4.0.0
 *
 * @param  array $args The defaults arguments used to display a post header.
 * @return array
 */
function cherry_status_header( $args ) {

	if ( has_post_format( 'status' ) ) :

		if ( !get_option( 'show_avatars' ) ) { // If avatars are enabled.
			return false;
		} else {

			$avatar     = get_avatar( get_the_author_meta( 'email' ) );
			$title_attr = esc_attr( the_title_attribute( 'echo=0' ) );

			$args['wrap'] = apply_filters( 'cherry_status_header_wrap',
				is_singular( get_post_type() ) ?
				'<header class="entry-header">' . $avatar . '</header>' :
				'<header class="entry-header"><a href="%3$s" title="' . $title_attr . '">' . $avatar . '</a></header>'
			);

		}

	endif;

	return $args;
}

/**
 * This function filters the entry-footer when viewing a post with the "status" post format.
 *
 * @since  4.0.0
 *
 * @param  string $post_info The post entry-footer.
 * @return string
 */
function cherry_post_status_footer( $post_info ) {

	if ( has_post_format( 'status' ) ) :

		if ( get_option( 'show_avatars' ) ) : // If avatars are enabled.

			$post_info = '';

		else :

			$post_info = apply_filters( 'cherry_post_status_footer', __( 'Posted on', 'cherry' ) . ' [entry-published] ' . __( 'by', 'cherry' ) . ' [entry-author] [entry-comments-link] [entry-edit-link]', get_the_ID() );

		endif;

	endif;

	return $post_info;
}

/**
 * This function filters the post excerpt when viewing a post with the "video" post format.
 *
 * @since  4.0.0
 *
 * @param  string $excerpt The post excerpt.
 * @return string          If the post has an excerpt, it returns the excerpt. Else, the post content.
 */
function cherry_post_video_excerpt( $excerpt ) {

	if ( has_post_format( 'video' ) && !post_password_required() ) :

		if ( has_excerpt() ) {
			return $excerpt;
		} else {
			$excerpt = '';
			the_content();
		}

	endif;

	return $excerpt;
}

/**
 * This function filters the entry-footer when viewing a page.
 *
 * @since  4.0.0
 *
 * @param  string $post_info The page entry-footer.
 * @return string
 */
function cherry_page_footer( $post_info ) {

	if ( is_page() ) :

		$post_info = apply_filters( 'cherry_page_footer', '[entry-edit-link]', get_the_ID() );

	endif;

	return $post_info;
}

/**
 * This function filters the attachment markup to be prepended to the post content.
 *
 * @since 4.0.0
 *
 * @param string $p The attachment HTML output.
 */
function cherry_attachment_content( $p ) {

	if ( is_attachment() ) :

		$attr    = array( 'align' => 'aligncenter', 'width' => '', 'caption' => '' );
		$post_id = get_the_ID();

		if ( wp_attachment_is_image( $post_id ) ) {

			$src = wp_get_attachment_image_src( get_the_ID(), 'full' );

			if ( is_array( $src ) && !empty( $src ) ) :

				$attr['width'] = esc_attr( $src[1] );
				$content       = wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) );

			endif;

		} elseif ( cherry_attachment_is_audio( $post_id  ) || cherry_attachment_is_video( $post_id  ) ) {

			$attr['width'] = cherry_get_content_width();
			$content       = $p;

		} else {
			return $p;
		}

		if ( !has_excerpt() ) {
			return $content;
		}

		$attr['caption'] = get_the_excerpt();
		$output          = img_caption_shortcode( $attr, $content );

		return $output;

	endif;

	return $p;
}