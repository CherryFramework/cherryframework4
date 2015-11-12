<?php
/**
 * Media template functions. These functions are meant to handle various features needed in theme templates
 * for media and attachments.
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

/**
 * Retrieve formatted audio metadata.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  int   $post_id  Attachment ID.
 * @param  array $metadata The attachment metadata.
 * @return array           Audio metadata.
 */
function cherry_audio_meta( $post_id, $metadata ) {

	// Get ID3 keys (labels for metadata).
	$id3_keys = wp_get_attachment_id3_keys( $post_id );

	$items = array();

	// Formated length of time the audio file runs.
	if ( ! empty( $metadata['length_formatted'] ) ) {
		$items['length_formatted'] = array( esc_html( $metadata['length_formatted'] ), $id3_keys['length_formatted'] );
	}

	// Artist.
	if ( ! empty( $metadata['artist'] ) ) {
		$items['artist'] = array( esc_html( $metadata['artist'] ), $id3_keys['artist'] );
	}

	// Album.
	if ( ! empty( $metadata['album'] ) ) {
		$items['album'] = array( esc_html( $metadata['album'] ), $id3_keys['album'] );
	}

	// Year.
	if ( ! empty( $metadata['year'] ) ) {
		$items['year'] = array( absint( $metadata['year'] ), $id3_keys['year'] );
	}

	// Genre.
	if ( ! empty( $metadata['genre'] ) ) {
		$items['genre'] = array( esc_html( $metadata['genre'] ), $id3_keys['genre'] );
	}

	// File size.
	if ( ! empty( $metadata['filesize'] ) ) {
		$items['filesize'] = array( size_format( strip_tags( $metadata['filesize'] ), 2 ), $id3_keys['filesize'] );
	}

	// Mime type.
	if ( ! empty( $metadata['mime_type'] ) ) {
		$items['mime_type'] = array( esc_html( $metadata['mime_type'] ), $id3_keys['mime_type'] );
	}

	/**
	 * Filter audio metadata.
	 *
	 * @since 4.0.0
	 * @param array $items Metadata.
	 */
	return apply_filters( 'cherry_audio_meta', $items );
}

/**
 * Retrieve formatted video metadata.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  int   $post_id  Attachment ID.
 * @param  array $metadata The attachment metadata.
 * @return array           Video metadata.
 */
function cherry_video_meta( $post_id, $metadata ) {

	// Get ID3 keys (labels for metadata).
	$id3_keys = wp_get_attachment_id3_keys( $post_id );

	$items = array();

	// File size.
	if ( ! empty( $metadata['filesize'] ) ) {
		$items['filesize'] = array( size_format( strip_tags( $metadata['filesize'] ), 2 ), $id3_keys['filesize'] );
	}

	// Mime type.
	if ( ! empty( $metadata['mime_type'] ) ) {
		$items['mime_type'] = array( esc_html( $metadata['mime_type'] ), $id3_keys['mime_type'] );
	}

	// Formated length of time the video file runs.
	if ( ! empty( $metadata['length_formatted'] ) ) {
		$items['length_formatted'] = array( esc_html( $metadata['length_formatted'] ), $id3_keys['length_formatted'] );
	}

	// Dimensions (width x height in pixels).
	if ( ! empty( $metadata['width'] ) && ! empty( $metadata['height'] ) ) {

		// Translators: Media dimensions - 1 is width and 2 is height.
		$items['dimensions'] = array( sprintf( __( '%1$s &#215; %2$s', 'cherry' ), number_format_i18n( absint( $metadata['width'] ) ), number_format_i18n( absint( $metadata['height'] ) ) ), __( 'Dimensions', 'cherry' ) );
	}

	/**
	 * Filter video metadata.
	 *
	 * @since 4.0.0
	 * @param array $items Metadata.
	 */
	return apply_filters( 'cherry_video_meta', $items );
}

/**
 * Retrieve formatted image metadata.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  int   $post_id  Attachment ID.
 * @param  array $metadata The attachment metadata.
 * @return array           Image metadata.
 */
function cherry_image_meta( $post_id, $metadata ) {
	$items = array();

	// If there's a width and height.
	if ( ! empty( $metadata['width'] ) && ! empty( $metadata['height'] ) ) {

		$items['dimensions'] = array(
			// Translators: Media dimensions - 1 is width and 2 is height.
			'<a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &times; %2$s', 'cherry' ), number_format_i18n( absint( $metadata['width'] ) ), number_format_i18n( absint( $metadata['height'] ) ) ) . '</a>',
			__( 'Dimensions', 'cherry' ),
		);
	}

	// If a timestamp exists, add it to the $items array.
	if ( ! empty( $metadata['image_meta']['created_timestamp'] ) ) {
		$items['created_timestamp'] = array( date_i18n( get_option( 'date_format' ), strip_tags( $metadata['image_meta']['created_timestamp'] ) ), __( 'Date', 'cherry' ) );
	}

	// If a camera exists, add it to the $items array.
	if ( ! empty( $metadata['image_meta']['camera'] ) ) {
		$items['camera'] = array( esc_html( $metadata['image_meta']['camera'] ), __( 'Camera', 'cherry' ) );
	}

	// If an aperture exists, add it to the $items array.
	if ( ! empty( $metadata['image_meta']['aperture'] ) ) {
		$items['aperture'] = array( sprintf( '<sup>f</sup>&frasl;<sub>%s</sub>', absint( $metadata['image_meta']['aperture'] ) ), __( 'Aperture', 'cherry' ) );
	}

	// If a focal length is set, add it to the $items array.
	if ( ! empty( $metadata['image_meta']['focal_length'] ) ) {

		// Translators: Camera focal length.
		$items['focal_length'] = array( sprintf( __( '%s mm', 'cherry' ), absint( $metadata['image_meta']['focal_length'] ) ), __( 'Focal Length', 'cherry' ) );
	}

	// If an ISO is set, add it to the $items array.
	if ( ! empty( $metadata['image_meta']['iso'] ) ) {
		$items['iso'] = array(
			absint( $metadata['image_meta']['iso'] ),
			'<abbr title="' . __( 'International Organization for Standardization', 'cherry' ) . '">' . __( 'ISO', 'cherry' ) . '</abbr>',
		);
	}

	/**
	 * Filter image metadata.
	 *
	 * @since 4.0.0
	 * @param array $items Metadata.
	 */
	return apply_filters( 'cherry_image_meta', $items );
}
