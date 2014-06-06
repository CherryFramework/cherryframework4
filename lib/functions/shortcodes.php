<?php
/**
 * Shortcodes bundled for use with themes.
 * To use the shortcodes, a theme must register support for 'cherry-shortcodes'.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Register shortcodes.
add_action( 'init', 'cherry_add_shortcodes' );

/**
 * Creates new shortcodes for use in any shortcode-ready area. This function uses the add_shortcode()
 * function to register new shortcodes with WordPress.
 *
 * @since  4.0.0
 * @link   http://codex.wordpress.org/Shortcode_API
 * @return void
 */
function cherry_add_shortcodes() {

	// Add entry-specific shortcodes.
	add_shortcode( 'entry-author',        'cherry_entry_author_shortcode' );
	add_shortcode( 'entry-published',     'cherry_entry_published_shortcode' );
	add_shortcode( 'entry-terms',         'cherry_entry_terms_shortcode' );
	add_shortcode( 'entry-comments-link', 'cherry_entry_comments_link_shortcode' );
	add_shortcode( 'entry-edit-link',     'cherry_entry_edit_link_shortcode' );
	add_shortcode( 'entry-permalink',     'cherry_entry_permalink_shortcode' );
}

/**
 * Displays an individual post's author with a link to his or her archive.
 *
 * @since  4.0.0
 * @param  array  $attr
 * @return string
 */
function cherry_entry_author_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'before' => '',
			'after'  => '',
		),
		$attr,
		'entry-author'
	);

	$author = sprintf( '<a class="url fn n" rel="author" href="%1$s" title="%2$s">%3$s</a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( get_the_author_meta( 'display_name' ) ),
		get_the_author_meta( 'display_name' )
	);

	$output = '<span class="author vcard">' . $attr['before'] . $author . $attr['after'] . '</span>';

	return apply_filters( 'cherry_entry_author_shortcode', $output, $attr );
}

/**
 * Displays the published date of an individual post.
 *
 * @since  4.0.0
 * @param  array  $attr
 * @return string
 */
function cherry_entry_published_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'before'     => '',
			'after'      => '',
			'format'     => get_option( 'date_format' ),
			'human_time' => '',
		),
		$attr,
		'entry-published'
	);

	if ( !empty( $attr['human_time'] ) ) : // If $human_time is passed in, allow for '%s ago' where '%s' is the return value of human_time_diff().

		$time = sprintf( $attr['human_time'], human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );

	else : // Else, just grab the time based on the format.

		$time = get_the_time( $attr['format'] );

	endif;

	$output = '<span class="posted-on">' . $attr['before'] . '<time class="entry-date published" datetime="' . get_the_time( 'Y-m-d\TH:i:sP' ) . '">' . $time . '</time>' . $attr['after'] . '</span>';

	return apply_filters( 'cherry_entry_published_shortcode', $output, $attr );
}

/**
 * Displays a list of terms for a specific taxonomy.
 *
 * @since  4.0.0
 * @param  array  $attr
 * @return string
 */
function cherry_entry_terms_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'is_category' => true,
			'separator'   => ', ',
			'before'      => '',
			'after'       => '',
		),
		$attr,
		'entry-terms'
	);

	// get post by post id
	$post = get_post( get_the_ID() );

	// get post type by post
	$post_type = $post->post_type;

	if ( 'page' === $post_type ) {
		return;
	}

	// get post type taxonomies
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	foreach ( $taxonomies as $tax_name => $tax_obj ) :

		if ( 'post_format' === $tax_name ) {
			continue;
		}

		if ( $attr['is_category'] !== $tax_obj->hierarchical ) {
			continue;
		}

		// get the terms related to post
		$terms  = get_the_terms( $post->ID, $tax_name );
		$output = '';

		if ( is_array( $terms ) ) :

			// $output .= ( empty( $attr['before'] ) ? $tax_name . ': ' : $attr['before'] );

			foreach ( $terms as $term ) {
				$output .= '<a href="' .get_term_link( $term->slug, $tax_name ) .'">' . $term->name . '</a> ';
			}

		endif;

	endforeach;

	if ( !isset( $output ) ) {
		return;
	}

	if ( !empty( $output ) ) {
		$output = str_replace( '</a> ', '</a>' . $attr['separator'], trim( $output ) );
	}

	$return = '<span class="terms-links">' . $attr['before'] . $output . $attr['after'] . '</span>';

	return apply_filters( 'cherry_entry_terms_shortcode', $return, $attr );
}

// get taxonomies terms links
function custom_taxonomies_terms_links( $is_category = true ) {
	global $post;

	// get post by post id
	$post = get_post( $post->ID );

	// get post type by post
	$post_type = $post->post_type;

	// get post type taxonomies
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	foreach ( $taxonomies as $tax_name => $tax_obj ) {

		if ( 'post_format' === $tax_name ) {
			continue;
		}

		if ( $is_category !== $tax_obj->hierarchical ) {
			continue;
		}

		// get the terms related to post
		$terms = get_the_terms( $post->ID, $tax_name );
		$output   = '';

		if ( is_array( $terms ) ) {
			$output .= $tax_name.": ";
			foreach ( $terms as $term ) {
				$output .= '<a href="' .get_term_link( $term->slug, $tax_name ) .'">' . $term->name . '</a> ';
			}
		}
	}
	return $output;
}

/**
 * Displays a post's number of comments.
 *
 * @since  4.0.0
 * @param  array  $attr
 * @return string
 */
function cherry_entry_comments_link_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'zero'      => false,
			'one'       => false,
			'more'      => false,
			'before'    => '',
			'after'     => '',
		),
		$attr,
		'entry-comments-link'
	);

	if ( !post_type_supports( get_post_type(), 'comments' ) ) {
		return;
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :

		ob_start();
		comments_number( $attr['zero'], $attr['one'], $attr['more'] );
		$comments = ob_get_clean();

		$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );

		$output = '<span class="comments-link">' . $attr['before'] . $comments . $attr['after'] . '</span>';

		return apply_filters( 'cherry_entry_comments_link_shortcode', $output, $attr );

	endif;
}

/**
 * Returns the output of the [entry-permalink] shortcode, which is a link back to the post permalink page.
 *
 * @since  4.0.0
 * @param  array  $attr The shortcode arguments.
 * @return string       A permalink back to the post.
 */
function cherry_entry_permalink_shortcode( $attr ) {

	$attr = shortcode_atts(
		array(
			'before' => '',
			'after'  => '',
			'text'   => __( 'Permalink', 'cherry' ),
		),
		$attr,
		'entry-permalink'
	);

	$output = $attr['before'] . '<a href="' . esc_url( get_permalink() ) . '" class="entry-permalink">' . $attr['text'] . '</a>' . $attr['after'];

	return apply_filters( 'cherry_entry_permalink_shortcode', $output, $attr );
}

/**
 * Displays the edit link for an individual post.
 *
 * @since  4.0.0
 * @param  array  $attr The shortcode arguments.
 * @return string
 */
function cherry_entry_edit_link_shortcode( $attr ) {

	$post_type = get_post_type_object( get_post_type() );

	if ( !current_user_can( $post_type->cap->edit_post, get_the_ID() ) ) {
		return '';
	}

	$attr = shortcode_atts(
		array(
			'before' => '',
			'after'  => '',
			'text'   => __( 'Edit', 'cherry' ),
		),
		$attr,
		'entry-edit-link'
	);

	ob_start();
	edit_post_link( $attr['text'], $attr['before'], $attr['after'] );
	$edit = ob_get_clean();

	$output = $edit;

	return apply_filters( 'cherry_entry_edit_link_shortcode', $output, $attr );
}