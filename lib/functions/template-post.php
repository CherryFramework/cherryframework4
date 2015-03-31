<?php
/**
 * Post Template Functions.
 *
 * Gets content for the current post in the loop.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Check if post has an image attached.
 *
 * @since  4.0.0
 * @param  int  $post_id Optional. Post ID.
 * @return bool          Whether post has an image attached.
 */
function cherry_has_post_thumbnail( $post_id = null ) {
	$post_id   = ( null === $post_id ) ? get_the_ID() : $post_id;
	$post_type = get_post_type( $post_id );

	if ( !current_theme_supports( 'post-thumbnails' ) ) {
		return false;
	}

	$thumbnail_support = post_type_supports( $post_type, 'thumbnail' );

	if ( 'attachment' === $post_type ) {

		$mime_type = get_post_mime_type();

		if ( !$thumbnail_support && $mime_type ) {

			if ( 0 === strpos( $mime_type, 'audio/' ) ) {

				$thumbnail_support = post_type_supports( 'attachment:audio', 'thumbnail' ) || current_theme_supports( 'post-thumbnails', 'attachment:audio' );

			} elseif ( 0 === strpos( $mime_type, 'video/' ) ) {

				$thumbnail_support = post_type_supports( 'attachment:video', 'thumbnail' ) || current_theme_supports( 'post-thumbnails', 'attachment:video' );

			}

		}

	}

	if ( $thumbnail_support && has_post_thumbnail( $post_id ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Display the post thumbnail.
 *
 * @since 4.0.0
 */
function cherry_the_post_thumbnail() {
	/**
	 * Filter the displayed post thumbnail.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_thumbnail', cherry_get_the_post_thumbnail() );
}

/**
 * Retrieve the post thumbnail.
 *
 * @since  4.0.0
 * @param  int    $post_id        The post ID.
 * @return string $post_thumbnail The post thumbnail HTML
 */
function cherry_get_the_post_thumbnail( $post_id = null ) {

	if ( in_array( get_post_format(), array( 'image', 'gallery' ) ) ) {
		return;
	}

	$post_id   = ( null === $post_id ) ? get_the_ID() : $post_id;
	$post_type = get_post_type( $post_id );

	if ( !cherry_has_post_thumbnail( $post_id ) ) {
		return;
	}

	$defaults = array(
		'container'       => 'figure',
		'container_class' => 'post-thumbnail',
		'size'            => is_singular( $post_type ) ? 'full' : 'post-thumbnail',
		'class'           => is_singular( $post_type ) ? 'aligncenter' : 'alignleft',
		'before'          => '',
		'after'           => '',
		'wrap'            => is_singular( $post_type ) ? '<%1$s class="%2$s">%3$s</%1$s>' : '<%1$s class="%2$s"><a href="%3$s" title="%4$s">%5$s</a></%1$s>',
	);
	/**
	 * Filter the arguments used to display a post thumbnail.
	 *
	 * @since 4.0.0
	 * @param array $args Array of arguments.
	 */
	$args = apply_filters( 'cherry_get_the_post_thumbnail_args', $defaults );
	$args = wp_parse_args( $args, $defaults );

	// OPTIONAL: Declare each item in $args as its own variable.
	extract( $args, EXTR_SKIP );

	// Get the intermediate image sizes and add the full size to the array.
	$sizes = get_intermediate_image_sizes();
	$sizes[] = 'full';

	// Checks if a value exists in an arrays
	$size = ( in_array( $size, $sizes ) ) ? $size : 'post-thumbnail';

	// Gets the Featured Image.
	$thumbnail = get_the_post_thumbnail( $post_id, $size, array( 'class' => $class ) );
	$thumbnail = $before . $thumbnail . $after;

	if ( is_singular( $post_type ) ) {

		$post_thumbnail = sprintf( $wrap, tag_escape( $container ), esc_attr( $container_class ), $thumbnail );

	} else {

		$post_thumbnail = sprintf( $wrap, tag_escape( $container ), esc_attr( $container_class ), esc_url( get_permalink( $post_id ) ), esc_attr( the_title_attribute( 'echo=0' ) ), $thumbnail );

	}

	return $post_thumbnail;
}

/**
 * Display the post header.
 *
 * @since 4.0.0
 */
function cherry_the_post_header() {
	/**
	 * Filter the displayed post header.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_header', cherry_get_the_post_header() );
}

/**
 * Retrieve the post header.
 *
 * @since 4.0.0
 */
function cherry_get_the_post_header() {
	$post_id   = get_the_ID();
	$post_type = get_post_type();

	/**
	 * Filter the arguments used to display a post header.
	 *
	 * @since 4.0.0
	 * @param array  $args      Array of arguments.
	 * @param int    $post_id   The post ID.
	 * @param string $post_type The post type of the current post.
	 */
	$args = apply_filters( 'cherry_get_the_post_header_args', array(
		'tag'    => is_singular( $post_type ) ? 'h1' : 'h2',
		'class'  => '',
		'url'    => 'permalink',
		'before' => '',
		'after'  => '',
		'wrap'   => is_singular( $post_type ) ? '<header class="entry-header"><%1$s class="%2$s">%4$s</%1$s></header>' : '<header class="entry-header"><%1$s class="%2$s"><a href="%3$s" rel="bookmark">%4$s</a></%1$s></header>',
	), $post_id, $post_type );

	// OPTIONAL: Declare each item in $args as its own variable.
	extract( $args, EXTR_SKIP );

	$class .= ' entry-title';

	if ( is_singular( $post_type ) ) :

		$post_title = single_post_title( '', false );

	else :

		$post_title = the_title( '', '', false );

	endif;

	if ( empty( $post_title ) ) {
		return;
	}

	$title = $before . $post_title . $after;
	$url  = ( $url ) ? $url : 'permalink';

	if ( 'permalink' === $url ) {
		$url = get_permalink( $post_id );
	}

	$post_header = sprintf( $wrap, tag_escape( $tag ), esc_attr( trim( $class ) ), esc_url( $url ), $title );

	return $post_header;
}

/**
 * Display the post meta.
 *
 * @since 4.0.0
 */
function cherry_the_post_meta() {
	/**
	 * Filter the displayed post meta.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_meta', cherry_get_the_post_meta() );
}

/**
 * Retrieve the post meta.
 *
 * @since 4.0.0
 */
function cherry_get_the_post_meta() {
	/**
	 * Filter the retrieved the post meta.
	 *
	 * @since 4.0.0
	 */
	$post_meta = apply_filters( 'cherry_get_the_post_meta',
		__( 'Posted on', 'cherry' ) . ' [entry-published] ' . __( 'by', 'cherry' ) . ' [entry-author] [entry-comments-link] [entry-edit-link]',
		get_the_ID()
	);

	if ( empty( $post_meta ) ) {
		return;
	}

	return sprintf( '<div class="entry-meta">%s</div>', $post_meta );
}

/**
 * Display the post content.
 *
 * @since 4.0.0
 */
function cherry_the_post_content() {
	global $post;

	if ( !$post->post_content ) {
		return;
	}

	echo '<div class="entry-content">';
		the_content();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'cherry' ),
			'after'  => '</div>',
		) );
	echo '</div>';
}

/**
 * Display the post excerpt.
 *
 * @since 4.0.0
 */
function cherry_the_post_excerpt() {
	echo '<div class="entry-summary">';
		the_excerpt();
	echo '</div>';
}

/**
 * Display the post footer.
 *
 * @since 4.0.0
 */
function cherry_the_post_footer() {
	/**
	 * Filter the displayed post footer.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_footer', cherry_get_the_post_footer() );
}

/**
 * Retrieve the post footer.
 *
 * @since 4.0.0
 */
function cherry_get_the_post_footer() {
	/**
	 * Filter the retrieved the post footer.
	 *
	 * @since 4.0.0
	 */
	$post_info = apply_filters( 'cherry_get_the_post_footer',
		__( 'Posted in', 'cherry' ) . ' [entry-terms]',
		get_the_ID()
	);

	if ( empty( $post_info ) ) {
		return;
	}

	return sprintf( '<footer class="entry-footer">%s</footer>', $post_info );
}

/**
 * Gets the first URL from the content, even if it's not wrapped in an <a> tag.
 *
 * @since  4.0.0
 *
 * @param  string $content
 * @return string
 */
function cherry_get_content_url( $content ) {

	// Catch links that are not wrapped in an '<a>' tag.
	preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', make_clickable( $content ), $matches );

	return !empty( $matches[1] ) ? esc_url_raw( $matches[1] ) : '';
}

/**
 * If did not find a URL, check the post content for one. If nothing is found, return the post permalink.
 *
 * @since  4.0.0
 *
 * @param  object $post
 * @return string
 */
function cherry_get_post_format_url( $post = null ) {
	$post        = is_null( $post ) ? get_post() : $post;
	$content_url = cherry_get_content_url( $post->post_content );
	$url         = !empty( $content_url ) ? $content_url : get_permalink( $post->ID );

	return esc_url( $url );
}

/**
 * Get featured image for post format image.
 * If has post thumbnail - will get post thumbnail, else - get first image from content
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_the_post_format_image() {

	if ( 'image' != get_post_format() ) {
		return;
	}

	// show nothing on single page if image not from featured
	if ( is_single() && ! cherry_has_post_thumbnail() ) {
		return;
	}

	/**
	 * Filter post format image output to rewrite image from child theme or plugins
	 * @since  4.0.0
	 */
	$result = apply_filters( 'cherry_pre_get_post_image', false );

	if ( false !== $result ) {
		return $result;
	}

	$defaults = array(
		'container'       => 'figure',
		'container_class' => 'post-thumbnail',
		'size'            => 'slider-post-thumbnail',
		'before'          => '',
		'after'           => '',
		'wrap'            => '<%1$s class="%2$s"><a href="%4$s" class="%2$s_link popup-img" data-init=\'%5$s\'>%3$s</a></%1$s>'
	);

	/**
	 * Filter the arguments used to display a post image.
	 *
	 * @since 4.0.0
	 * @param array $args Array of arguments.
	 */
	$args = apply_filters( 'cherry_get_the_post_image_args', $defaults );
	$args = wp_parse_args( $args, $defaults );

	$default_init = array(
		'type' => 'image'
	);

	/**
	 * Filter the arguments used to init image zoom popup.
	 *
	 * @since 4.0.0
	 * @param array $args Array of arguments.
	 */
	$init = apply_filters( 'cherry_get_the_post_image_zoom_init', $default_init );
	$init = wp_parse_args( $init, $default_init );

	$init = json_encode( $init );

	if ( cherry_has_post_thumbnail() ) {

		$post_id   = get_the_id();
		$thumb     = get_the_post_thumbnail( $post_id, $args['size'], array( 'class' => $args['container_class'] . '_img' ) );
		$thumb     = $args['before'] . $thumb . $args['after'];
		$url       = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );

	} else {

		$img = cherry_get_post_images();

		if ( ! $img || empty( $img ) || empty( $img[0] ) ) {
			return false;
		} elseif ( is_int( $img[0] ) ) {

			$thumb = wp_get_attachment_image( $img[0], $args['size'], '', array( 'class' => $args['container_class'] . '_img' ) );
			$thumb = $args['before'] . $thumb . $args['after'];
			$url   = wp_get_attachment_url( $img[0] );

		} else {

			global $_wp_additional_image_sizes;

			if ( ! isset( $_wp_additional_image_sizes[$args['size']] ) ) {
				return false;
			}

			$thumb = '<img src="' . esc_url( $img[0] ) . '" class="' . $args['container_class'] . '_img" width="' . $_wp_additional_image_sizes[$args['size']]['width'] . '">';
			$thumb = $args['before'] . $thumb . $args['after'];
			$url   = $img[0];

		}
	}

	$result = sprintf(
		$args['wrap'],
		$args['container'], $args['container_class'], $thumb, $url, $init
	);

	return $result;

}

/**
 * Display featured image for post format image.
 *
 * @since 4.0.0
 */
function cherry_the_post_format_image() {
	/**
	 * Filter featured image for post format image.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_format_image', cherry_get_the_post_format_image() );
}

/**
 * Get featured gallery for post format gallery.
 * If has post thumbnail - will get post thumbnail, else - get first image from content
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_the_post_format_gallery() {

	if ( 'gallery' != get_post_format() ) {
		return;
	}

	if ( is_single() ) {
		return;
	}

	/**
	 * Filter post format gallery output to rewrite gallery from child theme or plugins
	 * @since  4.0.0
	 */
	$result = apply_filters( 'cherry_pre_get_post_gallery', false );

	if ( false !== $result ) {
		return $result;
	}

	$post_id = get_the_id();

	// first - try to get images from galleries in post
	$shortcode_replaced = cherry_get_option( 'blog-gallery-shortcode', 'true' );
	$is_html = ( 'true' == $shortcode_replaced ) ? true : false;
	$post_gallery = get_post_gallery( $post_id, $is_html );

	// if stanadrd gallery shortcode replaced with cherry - return HTML
	if ( is_string( $post_gallery ) && ! empty( $post_gallery ) ) {
		return $post_gallery;
	}

	if ( ! empty( $post_gallery['ids'] ) ) {
		$post_gallery = explode( ',', $post_gallery['ids'] );
	} elseif ( ! empty( $post_gallery['src'] ) ) {
		$post_gallery = $post_gallery['src'];
	} else {
		$post_gallery = false;
	}


	// if can't try to catch images inserted into post
	if ( ! $post_gallery ) {
		$post_gallery = cherry_get_post_images( $post_id, 15 );
	}

	// and if not find any images - try to get images attached to post
	if ( ! $post_gallery || empty( $post_gallery ) ) {

		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 3,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );

		if ( $attachments && is_array($attachments) ) {
			$post_gallery = array_keys($attachments);
		}
	}

	if ( ! $post_gallery || empty( $post_gallery ) ) {
		return false;
	}

	$result = cherry_get_gallery_html( $post_gallery );

	return $result;
}

/**
 * Display featured gallery for post format gallery.
 *
 * @since 4.0.0
 */
function cherry_the_post_format_gallery() {
	/**
	 * Filter featured image for post format image.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_format_gallery', cherry_get_the_post_format_gallery() );
}

/**
 * Custom output for gallery shortcode
 * @param  array  $atts shortcode atts
 * @return string       gallery HTML
 */
function cherry_gallery_shortcode( $result, $attr, $instance ) {

	$replace_allowed = cherry_get_option( 'blog-gallery-shortcode', 'true' );

	if ( 'true' != $replace_allowed ) {
		return '';
	}

	/**
	 * Filter gallery output
	 * @since  4.0.0
	 */
	$result = apply_filters( 'cherry_pre_get_gallery_shortcode', false, $attr, $instance );


	$post = get_post();

	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	if ( false !== $result ) {
		return $result;
	}

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {

		$attachments = explode( ',', str_replace( ' ', '', $atts['include'] ) );

	} elseif ( ! empty( $atts['exclude'] ) ) {

		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'exclude'        => $atts['exclude'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby']
			)
		);
		$attachments = array_keys( $attachments );

	} else {

		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby']
			)
		);

		$attachments = array_keys( $attachments );
	}

	if ( empty( $attachments ) || ! is_array( $attachments ) ) {
		return;
	}

	$result = cherry_get_gallery_html( $attachments );

	return $result;

}

/**
 * Build default gallery HTML from images array
 *
 * @since  4.0.0
 *
 * @param  array  $images images array can contain image IDs or URLs
 * @return string         gallery HTML markup
 */
function cherry_get_gallery_html( $images ) {

	$defaults = array(
		'container_class'  => 'post-gallery',
		'size'             => 'slider-post-thumbnail',
		'container_format' => '<div class="%2$s popup-gallery" data-init=\'%3$s\' data-popup-init=\'%4$s\'>%1$s</div>',
		'item_format'      => '<figure class="%3$s"><a href="%2$s" class="%3$s_link popup-gallery-item" >%1$s</a></figure>'
	);

	/**
	 * Filter default gallery arguments
	 */
	$args = apply_filters( 'cherry_get_the_post_gallery_args', $defaults );
	$args = wp_parse_args( $args, $defaults );

	$default_slider_init = array(
		'infinite' => true,
		'speed'    => 300,
		'fade'     => true,
		'cssEase'  => 'linear'
	);

	/**
	 * Filter default gallery slider inits
	 */
	$init = apply_filters( 'cherry_get_the_post_gallery_args', $default_slider_init );
	$init = wp_parse_args( $init, $default_slider_init );
	$init = json_encode( $init );

	$default_gall_init = array(
		'delegate' => '.popup-gallery-item',
		'type'     => 'image',
		'gallery'  => array(
			'enabled' => true
		)
	);

	/**
	 * Filter default gallery popup inits
	 */
	$gall_init = apply_filters( 'cherry_get_the_post_gallery_popup_args', $default_gall_init );
	$gall_init = wp_parse_args( $gall_init, $default_gall_init );
	$gall_init = json_encode( $gall_init );

	$items = array();

	foreach ( $images as $img ) {

		if ( 0 < intval( $img ) ) {
			$image = wp_get_attachment_image( $img, $args['size'], '', array( 'class' => $args['container_class'] . '_item_img' ) );
			$url   = wp_get_attachment_url( $img );

			$attachment = get_post( $img );

			if ( ! empty( $attachment->post_excerpt ) ) {
				$image .= '<figcaption>' . wptexturize( $attachment->post_excerpt ) . '</figcaption>';
			}

		} else {

			global $_wp_additional_image_sizes;

			if ( ! isset( $_wp_additional_image_sizes[$args['size']] ) ) {
				$width = 'auto';
			} else {
				$width = $_wp_additional_image_sizes[$args['size']]['width'];
			}

			$image = '<img src="' . esc_url( $img ) . '" class="' . $args['container_class'] . '_item_img" width="' . $width . '">';
			$url   = $img;
		}

		$items[] = sprintf(
			$args['item_format'],
			$image, $url, $args['container_class'] . '_item'
		);
	}

	$items = implode( "\r\n", $items );

	$result = sprintf(
		$args['container_format'],
		$items, $args['container_class'], $init, $gall_init
	);

	return $result;
}

/**
 * Get images from post content.
 * Returns image ID's if can find this image in database,
 * returns image URL or bollen false in other case
 *
 * @since  4.0.0
 *
 * @param  int $post_id post ID to search image in
 * @param  int $limit   max images count to search
 * @return bool|string|int
 */
function cherry_get_post_images( $post_id = null, $limit = 1 ) {

	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$content = get_the_content();

	// get first image from content
	preg_match_all( '/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches );

	if ( !isset( $matches[1] ) ) {
		return false;
	}

	$result = array();

	global $wpdb;

	for ( $i = 0; $i < $limit; $i++ ) {

		if ( empty( $matches[1][$i] ) ) {
			continue;
		}

		$image_src = esc_url( $matches[1][$i] );
		$image_src = preg_replace( '/^(.+)(-\d+x\d+)(\..+)$/', '$1$3', $image_src );

		// try to get current iamge ID
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id = $wpdb->get_var( $query );

		if ( ! $id ) {
			$result[] = $image_src;
		} else {
			$result[] = (int)$id;
		}

	}

	return $result;

}

/**
 * Get featured video for video post format from post content.
 * Returns first finded video, iframe, object or embed tag in content
 *
 * @since 4.0.0
 */
function cherry_get_the_post_video() {

	if ( 'video' !== get_post_format() ) {
		return;
	}

	if ( is_single() ) {
		return;
	}

	/**
	 * Filter post format video output to rewrite video from child theme or plugins
	 * @since  4.0.0
	 */
	$result = apply_filters( 'cherry_pre_get_post_video', false );

	if ( false !== $result ) {
		return $result;
	}

	$content = get_the_content();

	$embeds = get_media_embedded_in_content(
		apply_filters( 'the_content', $content ),
		array( 'video', 'object', 'embed', 'iframe' )
	);

	if ( empty( $embeds ) ) {
		return;
	}

	global $_wp_additional_image_sizes;

	// get vdeo dimensions by equal image size
	$embed_size = apply_filters( 'cherry_post_video_size', 'slider-post-thumbnail' );

	if ( ! empty( $_wp_additional_image_sizes[$embed_size] ) ) {
		$width  = $_wp_additional_image_sizes[$embed_size]['width'];
		$height = $_wp_additional_image_sizes[$embed_size]['height'];
	} elseif ( ! empty( $_wp_additional_image_sizes[$embed_size] ) ) {
		$width  = $_wp_additional_image_sizes['slider-post-thumbnail']['width'];
		$height = $_wp_additional_image_sizes['slider-post-thumbnail']['height'];
	} else {
		$width  = 1025;
		$height = 500;
	}

	$embed_html = $embeds[0];

	$reg = '';
	$patterns = array(
		'/width=[\'|"]\d+[\'|"]/i',
		'/height=[\'|"]\d+[\'|"]/i'
	);

	$replacements = array(
		'width="' . $width . '"',
		'height="' . $height . '"'
	);

	$result = preg_replace( $patterns, $replacements, $embed_html );

	return $result;

}

/**
 * Show featured video for video post format
 *
 * @since 4.0.0
 */
function cherry_the_post_video() {
	/**
	 * Filter featured video for post format video.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_video', cherry_get_the_post_video() );
}

/**
 * Get featured audio for audio post format from post content.
 * Returns first finded audio tag in page content
 *
 * @since 4.0.0
 */
function cherry_get_the_post_audio() {

	if ( 'audio' !== get_post_format() ) {
		return;
	}

	if ( is_single() ) {
		return;
	}

	/**
	 * Filter post format audio output to rewrite audio from child theme or plugins
	 * @since  4.0.0
	 */
	$result = apply_filters( 'cherry_pre_get_post_audio', false );

	if ( false !== $result ) {
		return $result;
	}

	$content = get_the_content();

	$embeds = get_media_embedded_in_content( apply_filters( 'the_content', $content ), array( 'audio' ) );

	if ( ! empty( $embeds ) ) {
		return $embeds[0];
	}

}

/**
 * Show featured audio for audio post format
 *
 * @since 4.0.0
 */
function cherry_the_post_audio() {
	/**
	 * Filter featured audio for post format audio.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_the_post_audio', cherry_get_the_post_audio() );
}