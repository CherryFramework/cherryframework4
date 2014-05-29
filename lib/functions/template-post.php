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
 * @since 4.0.0
 */
function cherry_get_the_post_thumbnail() {
	$post_type = get_post_type();

	if ( !current_theme_supports( 'post-thumbnails', $post_type ) ) {
		return;
	}

	if ( !has_post_thumbnail() ) {
		return;
	}

	$post_id  = get_the_ID();
	$defaults = array(
		'container'       => 'figure',
		'container_class' => 'post-thumbnail',
		'size'            => is_singular( $post_type ) ? 'large' : 'post-thumbnail',
		'class'           => is_singular( $post_type ) ? 'alignnone' : 'alignleft',
		'before'          => '',
		'after'           => '',
		'wrap'            => is_singular( $post_type ) ? '<%1$s class="%2$s">%3$s</%1$s>' : '<%1$s class="%2$s"><a href="%3$s" title="%4$s">%5$s</a></%1$s>',
	);
	/**
	 * Filter the arguments used to display a post thumbnail.
	 *
	 * @since 4.0.0
	 *
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

	$defaults = array(
		'tag'    => is_singular( $post_type ) ? 'h1' : 'h2',
		'class'  => '',
		'url'    => 'permalink',
		'before' => '',
		'after'  => '',
		'wrap'   => is_singular( $post_type ) ? '<header class="entry-header"><%1$s class="%2$s">%4$s</%1$s></header>' : '<header class="entry-header"><%1$s class="%2$s"><a href="%3$s" rel="bookmark">%4$s</a></%1$s></header>',
	);
	/**
	 * Filter the arguments used to display a post header.
	 *
	 * @since 4.0.0
	 *
	 * @param array $args Array of arguments.
	 */
	$args = apply_filters( 'cherry_get_the_post_header_args', $defaults );
	$args = wp_parse_args( $args, $defaults );

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
	$post_meta = apply_filters( 'cherry_get_the_post_meta', __( 'Posted on', 'cherry' ) . ' [entry-published] ' . __( 'by', 'cherry' ) . ' [entry-author] [entry-comments-link] [entry-edit-link]', get_the_ID() );

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
	$post_info = apply_filters( 'cherry_get_the_post_footer', __( 'Posted in', 'cherry' ) . ' [entry-terms]', get_the_ID() );

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