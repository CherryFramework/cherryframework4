<?php
/**
 * The template for displaying Comments.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * Fire before a comment area.
 *
 * @since 4.0.0
 */
do_action( 'cherry_comments_before' ); ?>

<div id="comments" class="comments-area">
	<div class="comments">

	<?php if ( have_comments() ) : // Check if there are any comments.

		$title_comments = sprintf( _n( 'Comment', 'Comments (%s)', get_comments_number(), 'cherry' ),
					number_format_i18n( get_comments_number() ) );

		/**
		 * Filter a comment's title with markup.
		 *
		 * @since 4.0.0
		 */
		printf( apply_filters( 'cherry_title_comments', '<h3 class="comments-title">%s</h3>', $title_comments ), $title_comments );

		/**
		 * Fire when the navigation are printed before comments.
		 *
		 * @since 4.0.0
		 */
		do_action( 'cherry_comments_nav', 'above' );

		/**
		 * Fire when all comments are printed.
		 *
		 * @since 4.0.0
		 */
		do_action( 'cherry_comments_list' );

		/**
		 * Fire when the navigation are printed after comments.
		 *
		 * @since 4.0.0
		 */
		do_action( 'cherry_comments_nav', 'below' );

	endif;

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() ) : ?>

		<p class="no-comments">
			<?php
				/**
				 * Filter a message when comments are closed.
				 *
				 * @since 4.0.0
				 */
				echo apply_filters( 'cherry_comments_closed_text', __( 'Comments are closed.', 'cherry' ) );
			?>
		</p>

	<?php endif;

	/**
	 * Fire before a comment form.
	 *
	 * @since 4.0.6
	 */
	do_action( 'cherry_comment_form_before' );

	/**
	 * Filter the comment form arguments.
	 *
	 * @since 4.0.0
	 * @param array $comments_args The comment form arguments.
	 * @param array $post_type     The post type of the current post.
	 */
	$comments_args = apply_filters( 'cherry_comment_form_args', array(
		'comment_notes_after' => '', // remove "Text or HTML to be displayed after the set of comment fields"
	), get_post_type() );

	// Loads the comment form.
	comment_form( $comments_args );

	/**
	 * Fire after a comment form.
	 *
	 * @since 4.0.6
	 */
	do_action( 'cherry_comment_form_before' ); ?>

	</div>
</div>

<?php
/**
 * Fire after a comment area.
 *
 * @since 4.0.0
 */
do_action( 'cherry_comments_after' ); ?>