<?php
/**
 * Functions and filters for handling the output of post formats.
 *
 * This file is only loaded if themes declare support for `post-formats`. If a theme declares support for
 * `post-formats`, the content filters will not run for the individual formats that the theme
 * supports.
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

// Add support for structured post formats.
add_action( 'wp_loaded', 'cherry_structured_post_formats', 1 );

/**
 * Theme compatibility for post formats. This function adds appropriate filters for
 * the various post formats that a theme supports.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 */
function cherry_structured_post_formats() {

	// Add infinity symbol to aside posts.
	if ( current_theme_supports( 'post-formats', 'aside' ) ) {
		add_filter( 'cherry_the_post_content_defaults', 'cherry_aside_infinity', 9, 3 );
	}

	// Filter the titles of link posts.
	if ( current_theme_supports( 'post-formats', 'link' ) ) {
		add_filter( 'the_title', 'cherry_get_the_link_title', 10, 2 );
	}

	// Filter the entry-header of link posts.
	if ( current_theme_supports( 'post-formats', 'link' ) ) {
		add_filter( 'cherry_get_the_post_title_defaults', 'cherry_get_the_link_url', 10, 3 );
	}

	// Wraps <blockquote> around quote posts.
	if ( current_theme_supports( 'post-formats', 'quote' ) ) {
		add_filter( 'the_content', 'cherry_quote_content' );
	}

	// Filter the content of chat posts.
	if ( current_theme_supports( 'post-formats', 'chat' )
		&& apply_filters( 'cherry_post_format_chat_formatting', true ) ) {
		add_filter( 'the_content', 'cherry_format_chat_content' );
	}

	// Auto-add paragraphs to the chat text.
	add_filter( 'cherry_post_format_chat_text', 'wpautop' );

	// Filter the attachment markup to be prepended to the post content.
	add_filter( 'prepend_attachment', 'cherry_attachment_content', 9 );
}

/**
 * Adds an infinity character "&#8734;" to the end of the post content on 'aside' posts.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array  $args      Array of arguments.
 * @param  int    $post_id   The post ID.
 * @param  string $post_type The post type of the current post.
 * @return string $content
 */
function cherry_aside_infinity( $args, $post_id, $post_type ) {
	global $post;

	if ( is_singular( $post_type ) ) {
		return $args;
	}

	if ( ! post_type_supports( $post->post_type, 'post-formats' ) ) {
		return $args;
	}

	if ( post_password_required() ) {
		return $args;
	}

	if ( ! has_post_format( 'aside', $post_id ) ) {
		return $args;
	}

	$infinity = '<a class="entry-permalink" href="' . get_permalink() . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '">&#8734;</a>';
	$args['after'] = ' ' . apply_filters( 'cherry_aside_infinity', $infinity );

	return $args;
}

/**
 * This function filters the post title when viewing a post with the `link` post format.
 *
 * @since  4.0.0
 * @param  string $title   The post title.
 * @param  int    $post_id The post ID.
 * @return string          The post-format `link` title.
 */
function cherry_get_the_link_title( $title, $post_id ) {

	if ( is_admin() ) {
		return $title;
	}

	if ( 'link' !== get_post_format( $post_id ) ) {
		return $title;
	}

	return $title . '<span class="format-link-marker"></span>';
}

/**
 * This function filters the post link when viewing a post with the `link` post format.
 *
 * @since  4.0.0
 * @param  array  $args      The defaults arguments used to display a post title.
 * @param  int    $post_id   The post ID.
 * @param  string $post_type The post type.
 * @return array
 */
function cherry_get_the_link_url( $args, $post_id, $post_type ) {

	if ( ! post_type_supports( $post_type, 'post-formats' ) ) {
		return $args;
	}

	if ( ! has_post_format( 'link' ) ) {
		return $args;
	}

	/**
	 * Filter a URL for post-format `link` title.
	 *
	 * @since 4.0.0
	 * @param string $url URL for post-format `link` title.
	 */
	$args['url'] = apply_filters( 'cherry_link_title_url', cherry_get_post_format_url() );

	return $args;
}

/**
 * Checks if the quote post has a <blockquote> tag within the content.
 * If not, wraps the entire post content with one.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @global object $post
 * @param  string $content The post content.
 * @return string $content
 */
function cherry_quote_content( $content ) {
	global $post;

	if ( ! is_object( $post ) ) {
		return $content;
	}

	if ( ! post_type_supports( $post->post_type, 'post-formats' ) ) {
		return $content;
	}

	if ( post_password_required() ) {
		return $content;
	}

	if ( ! has_post_format( 'quote' ) ) {
		return $content;
	}

	if ( ! preg_match( '/<blockquote.*?>/', $content, $matches ) ) {
		$content = "<blockquote>{$content}</blockquote>";
	}

	return $content;
}

/**
 * This function filters the attachment markup to be prepended to the post content.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  string $p The attachment HTML output.
 */
function cherry_attachment_content( $p ) {

	if ( ! is_attachment() ) {
		return $p;
	}

	$post_id = get_the_ID();

	$attr = array(
		'align'   => 'aligncenter',
		'width'   => '',
		'caption' => '',
	);

	if ( wp_attachment_is_image( $post_id ) ) {

		$src = wp_get_attachment_image_src( $post_id, 'full' );

		if ( is_array( $src ) && ! empty( $src ) ) :

			$attr['width'] = esc_attr( $src[1] );
			$content       = wp_get_attachment_image( $post_id, 'full', false, array( 'class' => 'aligncenter' ) );

		endif;

	} elseif ( cherry_attachment_is_audio( $post_id ) || cherry_attachment_is_video( $post_id ) ) {

		$attr['width'] = cherry_get_content_width();
		$content       = $p;

	} else {
		return $p;
	}

	if ( ! has_excerpt() ) {
		return $content;
	}

	$attr['caption'] = get_the_excerpt();
	$output          = img_caption_shortcode( $attr, $content );

	return $output;
}

/**
 * This function filters the post content when viewing a post with the "chat" post format.  It formats the
 * content with structured HTML markup to make it easy for theme developers to style chat posts.  The
 * advantage of this solution is that it allows for more than two speakers (like most solutions).  You can
 * have 100s of speakers in your chat post, each with their own, unique classes for styling.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @author Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 4.0.2
 * @global array  $cherry_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param  string $content     The content of the post.
 * @return string $chat_output The formatted content of the post.
 */
function cherry_format_chat_content( $content ) {
	global $cherry_post_format_chat_ids, $post;

	if ( ! is_object( $post ) ) {
		return $content;
	}

	if ( ! post_type_supports( $post->post_type, 'post-formats' ) ) {
		return $content;
	}

	if ( post_password_required() ) {
		return $content;
	}

	// If this is not a 'chat' post, return the content.
	if ( ! has_post_format( 'chat' ) ) {
		return $content;
	}

	// Set the global variable of speaker IDs to a new, empty array for this chat.
	$cherry_post_format_chat_ids = array();

	// Allow the separator (separator for speaker/text) to be filtered.
	$separator = apply_filters( 'cherry_post_format_chat_separator', ':' );

	// Open the chat transcript div and give it a unique ID based on the post ID.
	$chat_output = "\n\t\t\t" . '<div id="chat-transcript-' . esc_attr( $post->ID ) . '" class="chat-transcript">';

	// Split the content to get individual chat rows.
	$chat_rows = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", $content );

	// Loop through each row and format the output.
	foreach ( $chat_rows as $chat_row ) {

		// If a speaker is found, create a new chat row with speaker and text.
		if ( strpos( $chat_row, $separator ) ) {

			// Split the chat row into author/text.
			$chat_row_split = explode( $separator, trim( $chat_row ), 2 );

			// Get the chat author and strip tags.
			$chat_author = strip_tags( trim( $chat_row_split[0] ) );

			// Get the chat text.
			$chat_text = trim( $chat_row_split[1] );

			// Get the chat row ID (based on chat author) to give a specific class to each row for styling.
			$speaker_id = cherry_format_chat_row_id( $chat_author );

			// Open the chat row.
			$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

			// Add the chat row author.
			$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-author ' . sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) . ' vcard"><cite class="fn">' . apply_filters( 'cherry_post_format_chat_author', $chat_author, $speaker_id ) . '</cite>' . $separator . '</div>';

			// Add the chat row text.
			$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'cherry_post_format_chat_text', $chat_text, $chat_author, $speaker_id ) ) . '</div>';

			// Close the chat row.
			$chat_output .= "\n\t\t\t\t" . '</div><!-- .chat-row -->';

		} else {

			/**
			 * If no author is found, assume this is a separate paragraph of text that belongs to the
			 * previous speaker and label it as such, but let's still create a new row.
			 */
			if ( ! empty( $chat_row ) ) {

				// Open the chat row.
				$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

				/* Don't add a chat row author.  The label for the previous row should suffice. */

				// Add the chat row text.
				$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'cherry_post_format_chat_text', $chat_row, $chat_author, $speaker_id ) ) . '</div>';

				// Close the chat row.
				$chat_output .= "\n\t\t\t</div><!-- .chat-row -->";
			}
		}
	}

	// Close the chat transcript div.
	$chat_output .= "\n\t\t\t</div><!-- .chat-transcript -->\n";

	// Return the chat content and apply filters for developers.
	return apply_filters( 'cherry_post_format_chat_content', $chat_output );
}

/**
 * This function returns an ID based on the provided chat author name.  It keeps these IDs in a global
 * array and makes sure we have a unique set of IDs.  The purpose of this function is to provide an "ID"
 * that will be used in an HTML class for individual chat rows so they can be styled.  So, speaker "John"
 * will always have the same class each time he speaks.  And, speaker "Mary" will have a different class
 * from "John" but will have the same class each time she speaks.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @author Cherry Team <support@cherryframework.com>
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 4.0.2
 * @global array  $cherry_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param  string $chat_author Author of the current chat row.
 * @return int                 The ID for the chat row based on the author.
 */
function cherry_format_chat_row_id( $chat_author ) {
	global $cherry_post_format_chat_ids;

	// Let's sanitize the chat author to avoid craziness and differences like "John" and "john".
	$chat_author = strtolower( strip_tags( $chat_author ) );

	// Add the chat author to the array.
	$cherry_post_format_chat_ids[] = $chat_author;

	// Make sure the array only holds unique values.
	$cherry_post_format_chat_ids = array_unique( $cherry_post_format_chat_ids );

	// Return the array key for the chat author and add "1" to avoid an ID of "0".
	return absint( array_search( $chat_author, $cherry_post_format_chat_ids ) ) + 1;
}
