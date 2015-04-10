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

add_action( 'cherry_comments_list', 'cherry_comments_default_list' );
add_action( 'cherry_comments_nav',  'cherry_comments_nav' );

/**
 * Output the list of comments.
 *
 * @since 4.0.0
 */
function cherry_comments_default_list() {
	$defaults = array(
		'style'       => 'ol',
		'type'        => 'all',
		'avatar_size' => 48,
		'short_ping'  => true,
	);

	/**
	 * Filters the defaults list arguments of comments.
	 *
	 * @since 4.0.0
	 * @param array $defaults
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
 * Output the navigation for comments.
 *
 * @since  4.0.0
 * @param  string $position Navigation position - above or below?
 */
function cherry_comments_nav( $position ='' ) {

	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :

		printf( '<nav id="comment-nav-%3$s" class="comment-navigation" role="navigation"><div class="nav-previous">%1$s</div><div class="nav-next">%2$s</div></nav>',
			get_previous_comments_link( __( '&larr; Older Comments', 'cherry' ) ),
			get_next_comments_link( __( 'Newer Comments &rarr;', 'cherry' ) ),
			$position
		);

	endif;
}