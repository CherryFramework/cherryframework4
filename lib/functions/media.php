<?php
/**
 * Functions for handling media (i.e., attachments) within themes.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Add all image sizes to the image editor to insert into post.
add_filter( 'image_size_names_choose', 'cherry_image_size_names_choose' );

// Adds ID3 tags for media display.
add_filter( 'wp_get_attachment_id3_keys', 'cherry_attachment_id3_keys', 5, 3 );

// Filters the [audio] shortcode.
//add_filter( 'wp_audio_shortcode', 'cherry_audio_shortcode', 10, 4 );

// Filter the [video] shortcode attributes.
add_filter( 'shortcode_atts_video', 'cherry_video_atts' );

/**
 * Adds theme "post-thumbnail" size plus an internationalized version of the image size name to the
 * "add media" modal.  This allows users to insert the image within their post content editor.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array  $sizes Selectable image sizes.
 * @return array
 */
function cherry_image_size_names_choose( $sizes ) {

	// If the theme as set a custom post thumbnail size, give it a nice name.
	if ( has_image_size( 'post-thumbnail' ) ) {
		$sizes['cherry-thumb-s'] = __( 'Post Thumbnail', 'cherry' );
	}

	return $sizes;
}

/**
 * Creates custom labels for ID3 tags that are used on the front end of the site when displaying
 * media within the theme, typically on attachment pages.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  array   $fields
 * @param  object  $attachment
 * @param  string  $context
 * @return array
 */
function cherry_attachment_id3_keys( $fields, $attachment, $context ) {

	if ( 'display' === $context ) {

		$fields['filesize']         = __( 'File Size', 'cherry' );
		$fields['mime_type']        = __( 'Mime Type', 'cherry' );
		$fields['length_formatted'] = __( 'Run Time',  'cherry' );
	}

	if ( is_object( $attachment ) && cherry_attachment_is_audio( $attachment->ID ) ) {

		$fields['genre'] = __( 'Genre', 'cherry' );
		$fields['year']  = __( 'Year',  'cherry' );
	}

	return $fields;
}

/**
 * Adds a featured image (if one exists) next to the audio player.
 *
 * @since  4.0.0
 * @param  string  $html
 * @param  array   $atts
 * @param  object  $audio
 * @param  object  $post_id
 * @return string
 */
function cherry_audio_shortcode( $html, $atts, $audio, $post_id ) {

	// Don't show in the admin.
	if ( is_admin() ) {
		return $html;
	}

	// Check if post has an image attached.
	if ( !cherry_has_post_thumbnail() ) {
		return $html;
	}

	$image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'aligncenter' ) );

	if ( !empty( $image ) ) {

		$html = $image . $html;

	}

	return $html;
}

/**
 * Featured image for self-hosted videos. If an image is found,
 * it's used as the "poster" attribute in the [video] shortcode.
 *
 * @since  4.0.0
 * @param  array  $atts
 * @return array
 */
function cherry_video_atts( $atts ) {

	// Don't show in the admin.
	if ( is_admin() ) {
		return $atts;
	}

	// Check if post has an image attached.
	if ( !cherry_has_post_thumbnail() ) {
		return $atts;
	}

	// Only run if the user didn't set a 'poster' image.
	if ( empty( $atts['poster'] ) ) :

		$thumbnail_id = get_post_thumbnail_id();

		if ( !empty( $thumbnail_id ) ) :

			$src = wp_get_attachment_image_src( $thumbnail_id, 'full', false );

			if ( is_array( $src ) && !empty( $src ) ) {

				$atts['poster'] = $src[0];

			}

		endif;

	endif;

	return $atts;
}

/**
 * Check if the attachment is an 'audio'.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  int   $post_id Attachment ID.
 * @return bool
 */
function cherry_attachment_is_audio( $post_id = null ) {
	$post_id   = ( null === $post_id ) ? get_the_ID() : $post_id;
	$mime_type = get_post_mime_type( $post_id );

	list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

	return 'audio' === $type ? true : false;
}

/**
 * Check if the attachment is a 'video'.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  int   $post_id Attachment ID.
 * @return bool
 */
function cherry_attachment_is_video( $post_id = null ) {
	$post_id   = ( null === $post_id ) ? get_the_ID() : $post_id;
	$mime_type = get_post_mime_type( $post_id );

	list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

	return 'video' === $type ? true : false;
}