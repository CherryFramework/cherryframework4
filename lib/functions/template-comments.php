<?php
/**
 * Functions for handling how comments are displayed and used on the site. This allows more precise
 * control over their display and makes more filter and action hooks available to developers to use in their
 * customizations.
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

add_action( 'cherry_comments_list', 'cherry_comments_default_list' );
add_action( 'cherry_comments_nav',  'cherry_comments_nav' );

/**
 * Dispaly the list of comments.
 *
 * @since 4.0.0
 */
function cherry_comments_default_list() {
	$defaults = array(
		'style'       => 'ol',
		'type'        => 'all',
		'avatar_size' => 48,
		'short_ping'  => true,
		'callback'    => 'cherry_rewrite_comment_item',
	);

	/**
	 * Filter the defaults list arguments of comments.
	 *
	 * @since 4.0.0
	 * @param array $defaults Defaults arguments.
	 */
	$args = apply_filters( 'cherry_comment_list_args', $defaults );

	// Set argument 'echo' to the function 'wp_list_comments' for return result.
	$args = array_merge( $args, array( 'echo' => false ) );

	printf( '<%1$s class="comment-list">%2$s</%1$s>',
		tag_escape( $args['style'] ),
		wp_list_comments( $args )
	);
}

/**
 * Display the navigation for comments.
 *
 * @since 4.0.0
 * @param string $position Navigation position - above or below?
 */
function cherry_comments_nav( $position ='' ) {

	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {

		printf( '<nav id="comment-nav-%3$s" class="comment-navigation" role="navigation"><div class="nav-previous">%1$s</div><div class="nav-next">%2$s</div></nav>',
			get_previous_comments_link( __( '&larr; Older Comments', 'cherry' ) ),
			get_next_comments_link( __( 'Newer Comments &rarr;', 'cherry' ) ),
			$position
		);

	}
}

/**
 * A custom function to use to open and display each comment.
 *
 * @since 4.0.4
 * @param object $_comment Comment to display.
 * @param array  $args     An array of arguments.
 * @param int    $depth    Depth of comment.
 */
function cherry_rewrite_comment_item( $_comment, $args, $depth ) {
	global $comment;

	$_comment->cherry_comment_list_args = $args;
	$comment = $_comment;

	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; ?>

	<<?php echo $tag; ?> <?php comment_class( $args['has_children'] ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">

	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

	<?php $comment_item = cherry_parse_tmpl(
		apply_filters(
			'cherry_comment_item_template_hierarchy',
			array( 'content/comment.tmpl' )
		)
	);

	echo $comment_item; ?>

	</article><!-- .comment-body -->
<?php }

/**
 * Retrieve the avatar of the author of the current comment.
 *
 * @since  4.0.4
 * @param  array  $args   Arguments.
 * @return string $output Avatar of the author of the comment.
 */
function cherry_get_the_post_comment_author_avatar( $args ) {
	global $comment;

	if ( ! empty( $comment->cherry_comment_list_args['avatar_size'] ) ) {
		$size = $comment->cherry_comment_list_args['avatar_size'];
	}

	if ( ! empty( $args['size'] ) ) {
		$size = intval( $args['size'] );
	}

	/**
	 * Filter the avatar of the author of the current comment.
	 *
	 * @since 4.0.4
	 * @param array $output Avatar.
	 * @param array $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comment_author_avatar', get_avatar( $comment, $size ), $args );
}

/**
 * Retrieve the html link to the url of the author of the current comment.
 *
 * @since  4.0.4
 * @param  array  $args   Arguments.
 * @return string $output URL of the author of the comment.
 */
function cherry_get_the_post_comment_author_link( $args ) {
	/**
	 * Filter a URL of the author of the current comment.
	 *
	 * @since 4.0.4
	 * @param array $output URL of the author of the comment.
	 * @param array $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comment_author_link', sprintf( '<b class="fn">%s</b>', get_comment_author_link() ), $args );
}

/**
 * Retrieve the html-formatted comment date of the current comment.
 *
 * @since  4.0.4
 * @param  array  $args   Arguments.
 * @return string $output The comment date of the current comment.
 */
function cherry_get_the_post_comment_date( $args ) {
	$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );

	if ( ! empty( $args['format'] ) ) {
		$format = esc_attr( $args['format'] );
	}

	/**
	 * Filter a html-formatted comment date of the current comment.
	 *
	 * @since 4.0.4
	 * @param string $output The comment date.
	 * @param array  $args   Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comment_date', sprintf( '<time datetime="%1$s">%2$s</time>', get_comment_time( 'c' ), get_comment_date( $format ) ), $args );
}

/**
 * Retrieve a link to edit the current comment, if the user is logged in and allowed to edit the comment.
 *
 * @since  4.0.4
 * @param  array  $args   Arguments.
 * @return string $output HTML-link to edit the current comment.
 */
function cherry_get_the_post_comment_link_edit( $args ) {
	global $comment;

	$text = __( 'Edit', 'cherry' );

	if ( ! empty( $args['text'] ) ) {
		$text = esc_attr( $args['text'] );
	}

	$url = get_edit_comment_link( $comment->comment_ID );

	if ( null === $url ) {
		return;
	}

	$link = '<a class="comment-edit-link" href="' . esc_url( $url ) . '">' . $text . '</a>';

	/**
	 * Filter the comment edit link anchor tag.
	 *
	 * @since 4.0.4
	 * @param string $link       Anchor tag for the edit link.
	 * @param int    $comment_id Comment ID.
	 * @param array  $args       Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comment_link_edit', $link, $comment->comment_ID, $args );
}

/**
 * Retrieve the text of a comment.
 *
 * @since  4.0.4
 * @global int    $comment_depth
 * @param  array  $args   Arguments.
 * @return string $output Comment's text.
 */
function cherry_get_the_post_comment_text( $args ) {
	global $comment_depth;

	ob_start();

	comment_text( get_comment_id(), array_merge( $args, array(
		'add_below' => 'div-comment',
		'depth'     => $comment_depth,
		'max_depth' => get_option( 'thread_comments_depth' ) ? get_option( 'thread_comments_depth' ) : -1,
	) ) );

	$comment_text = ob_get_contents();
	ob_end_clean();

	/**
	 * Filter the text of a comment.
	 *
	 * @since 4.0.4
	 * @param string $comment_text Comment's text.
	 * @param array  $args         Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comment_text', $comment_text, $args );
}

/**
 * Returns a string that can be echoed to create a `reply` link for comments.
 *
 * @since  4.0.4
 * @global int    $comment_depth
 * @param  array  $args   Arguments.
 * @return string $output `Reply` link.
 */
function cherry_get_the_post_comment_reply_link( $args ) {
	global $comment_depth;

	$reply = get_comment_reply_link( array_merge( $args, array(
			'add_below' => 'div-comment',
			'depth'     => $comment_depth,
			'max_depth' => get_option( 'thread_comments_depth' ) ? get_option( 'thread_comments_depth' ) : -1,
			'before'    => '',
			'after'     => '',
		) ) );

	/**
	 * Filter a `reply` link for comments.
	 *
	 * @since 4.0.4
	 * @param string $reply `reply` link.
	 * @param array  $args  Arguments.
	 */
	return apply_filters( 'cherry_get_the_post_comment_reply_link', $reply, $args );
}
