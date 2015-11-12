<?php
/**
 * Post Meta Template Functions.
 *
 * Gets meta for the current post in the loop.
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
 * Display the post date.
 *
 * @since 4.0.0
 * @param array $args Arguments.
 */
function cherry_the_post_date( $args ) {
	echo cherry_get_the_post_date( $args );
}

/**
 * Retrieve the post date.
 *
 * @since  4.0.0
 * @param  array $args Arguments.
 * @return string      Post date.
 */
function cherry_get_the_post_date( $args ) {
	$post_id   = get_the_ID();
	$post_type = get_post_type( $post_id );

	/**
	 * Filter the default arguments used to display a post date.
	 *
	 * @since 4.0.0
	 * @param array  $args      Array of arguments.
	 * @param int    $post_id   The post ID.
	 * @param string $post_type The post type of the current post.
	 */
	$defaults = apply_filters( 'cherry_get_the_post_date_defaults', array(
		'before'     => '',
		'after'      => '',
		'format'     => get_option( 'date_format' ),
		'human_time' => '', // `%s ago`
	), $post_id, $post_type );

	$args = wp_parse_args( $args, $defaults );

	// If $human_time is passed in, allow for '%s ago' where '%s' is the return value of human_time_diff().
	if ( ! empty( $args['human_time'] ) ) {

		$time = sprintf( $args['human_time'], human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
	} else {

		// Else, just grab the time based on the format.
		$time = get_the_time( $args['format'] );
	}

	$output = '<span class="posted-on">' . $args['before'] . '<time class="entry-date published" datetime="' . get_the_time( 'Y-m-d\TH:i:sP' ) . '">' . $time . '</time>' . $args['after'] . '</span>';

	/**
	 * Filter a post date.
	 *
	 * @since 4.0.0
	 * @param string $output Post date.
	 * @param array  $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_date', $output, $args );
}

/**
 * Display an individual post's author with a link to his or her archive.
 *
 * @since 4.0.0
 * @param array $args Arguments.
 */
function cherry_the_post_author( $args ) {
	echo cherry_get_the_post_author( $args );
}

/**
 * Retrieve an individual post's author with a link to his or her archive.
 *
 * @since  4.0.0
 * @param  array  $args Arguments.
 * @return string       Post's author.
 */
function cherry_get_the_post_author( $args ) {
	$post_id   = get_the_ID();
	$post_type = get_post_type( $post_id );

	/**
	 * Filter the default arguments used to display a post author.
	 *
	 * @since 4.0.0
	 * @param array  $args      Array of arguments.
	 * @param int    $post_id   The post ID.
	 * @param string $post_type The post type of the current post.
	 */
	$defaults = apply_filters( 'cherry_get_the_post_author_args', array(
		'text'   => '%s',
		'before' => '',
		'after'  => '',
	), $post_id, $post_type );

	$args = wp_parse_args( $args, $defaults );

	$author = cherry_get_the_post_author_posts_link();

	if ( empty( $author ) ) {
		return;
	}

	$output = $args['before'];
	$output .= sprintf( $args['text'], $author );
	$output .= $args['after'];

	$output = '<span class="author vcard">' . $output . '</span>';

	/**
	 * Filter a post's author.
	 *
	 * @since  4.0.0
	 * @return string $output Post's author.
	 * @param  array  $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_author', $output, $args );
}

/**
 * Display a post's number of comments.
 *
 * @since 4.0.0
 * @param array $args Arguments.
 */
function cherry_the_post_comments( $args ) {
	echo cherry_get_the_post_comments( $args );
}

/**
 * Retrieve a post's number of comments.
 *
 * @since  4.0.0
 * @param  array  $args Arguments.
 * @return string       Number of comments.
 */
function cherry_get_the_post_comments( $args ) {
	$post_id   = get_the_ID();
	$post_type = get_post_type( $post_id );

	if ( ! post_type_supports( $post_type, 'comments' ) ) {
		return;
	}

	/**
	 * Filter the default arguments used to display a post author.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/comments_number
	 *
	 * @since 4.0.0
	 * @param array  $args      Array of arguments.
	 * @param int    $post_id   The post ID.
	 * @param string $post_type The post type of the current post.
	 */
	$defaults = apply_filters( 'cherry_get_the_post_comments_defaults', array(
		'zero'      => false,
		'one'       => false,
		'more'      => false,
		'before'    => '',
		'after'     => '',
	), $post_id, $post_type );

	$args = wp_parse_args( $args, $defaults );

	if ( ! comments_open() ) {
		return;
	}

	if ( ! get_comments_number() && ( false === $args['zero'] ) ) {
		return;
	}

	ob_start();
	comments_number( $args['zero'], $args['one'], $args['more'] );
	$comments = ob_get_clean();
	$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );
	$output   = '<span class="comments-link">' . $args['before'] . $comments . $args['after'] . '</span>';

	/**
	 * Filter a post's number of comments.
	 *
	 * @since  4.0.0
	 * @return string $output Post's number of comments.
	 * @param  array  $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comments', $output, $args );
}

/**
 * Retrieve a post's taxonomy.
 *
 * @since 4.0.0
 * @param array $args Arguments.
 */
function cherry_the_post_taxonomy( $args ) {
	echo cherry_get_the_post_taxonomy( $args );
}

/**
 * Retrieve a post's taxonomy.
 *
 * @since  4.0.0
 * @param  array  $args Arguments.
 * @return string       Taxonomy.
 */
function cherry_get_the_post_taxonomy( $args ) {
	$post_id   = get_the_ID();
	$post_type = get_post_type( $post_id );

	/**
	 * Filter the arguments used to display a post taxonomy.
	 *
	 * @since 4.0.0
	 * @param array  $args      Array of arguments.
	 * @param int    $post_id   The post ID.
	 * @param string $post_type The post type of the current post.
	 */
	$defaults = apply_filters( 'cherry_get_the_post_taxonomy_defaults', array(
		'name'      => 'category',
		'separator' => ', ',
		'before'    => '',
		'after'     => '',
		'text'      => '%s',
		'wrap'      => '<span %s>%s</span>',
	), $post_id, $post_type );

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Returns an HTML string of taxonomy terms associated with a post and given taxonomy.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/get_the_term_list
	 */
	$terms = get_the_term_list( $post_id, $args['name'], '', $args['separator'], '' );

	if ( is_wp_error( $terms ) ) {
		return;
	}

	if ( empty( $terms ) ) {
		return;
	}

	$output = $args['before'];
	$output .= sprintf(
		$args['wrap'],
		cherry_get_attr( 'entry-terms', $args['name'] ),
		sprintf( $args['text'], $terms )
	);
	$output .= $args['after'];

	$output = sprintf( '<span class="entry-terms_wrap %1$s_wrap">%2$s</span>', sanitize_html_class( $args['name'] ), $output );

	/**
	 * Filters a post's taxonomy.
	 *
	 * @since  4.0.0
	 * @return string $output Post's taxonomy.
	 * @param  array  $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_taxonomy', $output, $args );
}

/**
 * Retrieve a single meta data for a author (user).
 *
 * @since 4.0.0
 * @param array $args Arguments.
 */
function cherry_the_post_author_meta( $args ) {
	echo cherry_get_the_post_author_meta( $args );
}

/**
 * Display a single meta data for a author (user).
 *
 * @since  4.0.0
 * @param  array $args Arguments.
 * @return string      Author meta.
 */
function cherry_get_the_post_author_meta( $args ) {
	$post_id   = get_the_ID();
	$post_type = get_post_type( $post_id );

	/**
	 * Filter the arguments used to display a post taxonomy.
	 *
	 * @since 4.0.0
	 * @param array  $args      Array of arguments.
	 * @param int    $post_id   The post ID.
	 * @param string $post_type The post type of the current post.
	 */
	$defaults = apply_filters( 'cherry_get_the_post_author_meta_defaults', array(
		'field'  => '',
		'before' => '',
		'after'  => '',
		'wrap'   => '<div class="%1$s">%2$s</div>',
	), $post_id, $post_type );

	$args = wp_parse_args( $args, $defaults );

	$meta   = $args['before'] . get_the_author_meta( $args['field'] ) . $args['after'];
	$output = sprintf( $args['wrap'], sanitize_html_class( $args['field'] ), $meta );

	/**
	 * Filters a single meta data for a author.
	 *
	 * @since  4.0.0
	 * @return string $output Author meta.
	 * @param  array  $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_author_meta', $output, $args );
}

/**
 * Retrieve a link to all posts by an author.
 *
 * @since 4.0.0
 * @param array $args Arguments.
 */
function cherry_the_author_posts_link() {
	echo cherry_get_the_post_author_posts_link();
}

/**
 * Display a link to all posts by an author.
 *
 * @since  4.0.0
 * @param  array $args Arguments.
 * @return string      An HTML link to the author page.
 */
function cherry_get_the_post_author_posts_link() {
	ob_start();
	the_author_posts_link();
	$author = ob_get_clean();

	return $author;
}
