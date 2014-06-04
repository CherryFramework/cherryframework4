<?php
/**
 * Media template functions. These functions are meant to handle various features needed in theme templates
 * for media and attachments.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Check if the attachment is an 'audio'.
 *
 * @since  4.0.0
 *
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
 * @since  4.0.0
 *
 * @param  int   $post_id Attachment ID.
 * @return bool
 */
function cherry_attachment_is_video( $post_id = null ) {
	$post_id   = ( null === $post_id ) ? get_the_ID() : $post_id;
	$mime_type = get_post_mime_type( $post_id );

	list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

	return 'video' === $type ? true : false;
}

/**
 * Retrieve formatted audio metadata.
 *
 * @since  4.0.0
 *
 * @param  int   $post_id  Attachment ID.
 * @param  array $metadata The attachment metadata.
 * @return array
 */
function cherry_audio_meta( $post_id, $metadata ) {

	// Get ID3 keys (labels for metadata).
	$id3_keys = wp_get_attachment_id3_keys( $post_id );

	$items = array();

	// Formated length of time the audio file runs.
	if ( !empty( $metadata['length_formatted'] ) )
		$items['length_formatted'] = array( $metadata['length_formatted'], $id3_keys['length_formatted'] );

	// Artist.
	if ( !empty( $metadata['artist'] ) )
		$items['artist'] = array( $metadata['artist'], $id3_keys['artist'] );

	// Album.
	if ( !empty( $metadata['album'] ) )
		$items['album'] = array( $metadata['album'], $id3_keys['album'] );

	// Year.
	if ( !empty( $metadata['year'] ) )
		$items['year'] = array( $metadata['year'], $id3_keys['year'] );

	// Genre.
	if ( !empty( $metadata['genre'] ) )
		$items['genre'] = array( $metadata['genre'], $id3_keys['genre'] );

	// File size.
	if ( !empty( $metadata['filesize'] ) )
		$items['filesize'] = array( size_format( $metadata['filesize'], 2 ), $id3_keys['filesize'] );

	// Mime type.
	if ( !empty( $metadata['mime_type'] ) )
		$items['mime_type'] = array( $metadata['mime_type'], $id3_keys['mime_type'] );

	return apply_filters( 'cherry_audio_meta', $items );
}

/**
 * Retrieve formatted video metadata.
 *
 * @since  4.0.0
 *
 * @param  int   $post_id  Attachment ID.
 * @param  array $metadata The attachment metadata.
 * @return array
 */
function cherry_video_meta( $post_id, $metadata ) {

	// Get ID3 keys (labels for metadata).
	$id3_keys = wp_get_attachment_id3_keys( $post_id );

	$items = array();

	// File size.
	if ( !empty( $metadata['filesize'] ) )
		$items['filesize'] = array( size_format( $metadata['filesize'], 2 ), $id3_keys['filesize'] );

	// Mime type.
	if ( !empty( $metadata['mime_type'] ) )
		$items['mime_type'] = array( $metadata['mime_type'], $id3_keys['mime_type'] );

	// Formated length of time the video file runs.
	if ( !empty( $metadata['length_formatted'] ) )
		$items['length_formatted'] = array( $metadata['length_formatted'], $id3_keys['length_formatted'] );

	// Dimensions (width x height in pixels).
	if ( !empty( $metadata['width'] ) && !empty( $metadata['height'] ) )
		// Translators: Media dimensions - 1 is width and 2 is height.
		$items['dimensions'] = array( sprintf( __( '%1$s &#215; %2$s', 'cherry' ), number_format_i18n( absint( $metadata['width'] ) ), number_format_i18n( absint( $metadata['height'] ) ) ), __( 'Dimensions', 'cherry' ) );

	return apply_filters( 'cherry_video_meta', $items );
}

/**
 * Retrieve formatted image metadata.
 *
 * @since  4.0.0
 *
 * @param  int   $post_id  Attachment ID.
 * @param  array $metadata The attachment metadata.
 * @return array
 */
function cherry_image_meta( $post_id, $metadata ) {
	$items = array();

	// If there's a width and height.
	if ( !empty( $metadata['width'] ) && !empty( $metadata['height'] ) ) {

		$items['dimensions'] = array(
			// Translators: Media dimensions - 1 is width and 2 is height.
			'<a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &times; %2$s', 'cherry' ), number_format_i18n( absint( $metadata['width'] ) ), number_format_i18n( absint( $metadata['height'] ) ) ) . '</a>',
			__( 'Dimensions', 'cherry' )
		);
	}

	// If a timestamp exists, add it to the $items array.
	if ( !empty( $metadata['image_meta']['created_timestamp'] ) )
		$items['created_timestamp'] = array( date_i18n( get_option( 'date_format' ), $metadata['image_meta']['created_timestamp'] ), __( 'Date', 'cherry' ) );

	// If a camera exists, add it to the $items array.
	if ( !empty( $metadata['image_meta']['camera'] ) )
		$items['camera'] = array( $metadata['image_meta']['camera'], __( 'Camera', 'cherry' ) );

	// If an aperture exists, add it to the $items array.
	if ( !empty( $metadata['image_meta']['aperture'] ) )
		$items['aperture'] = array( sprintf( '<sup>f</sup>&frasl;<sub>%s</sub>', $metadata['image_meta']['aperture'] ), __( 'Aperture', 'cherry' ) );

	// If a focal length is set, add it to the $items array.
	if ( !empty( $metadata['image_meta']['focal_length'] ) )
		// Translators: Camera focal length.
		$items['focal_length'] = array( sprintf( __( '%s mm', 'cherry' ), $metadata['image_meta']['focal_length'] ), __( 'Focal Length', 'cherry' ) );

	// If an ISO is set, add it to the $items array.
	if ( !empty( $metadata['image_meta']['iso'] ) ) {
		$items['iso'] = array(
			$metadata['image_meta']['iso'],
			'<abbr title="' . __( 'International Organization for Standardization', 'cherry' ) . '">' . __( 'ISO', 'cherry' ) . '</abbr>'
		);
	}

	return apply_filters( 'cherry_image_meta', $items );
}