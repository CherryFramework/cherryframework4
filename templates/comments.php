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

do_action( 'cherry_comments_before' ); ?>

<div id="comments" class="comments-area">
	<div class="comments">

	<?php if ( have_comments() ) : // Check if there are any comments.

		$title_comments = sprintf( _n( 'Comment', 'Comments (%s)', get_comments_number(), 'cherry' ),
					number_format_i18n( get_comments_number() ) );

		printf( apply_filters( 'cherry_title_comments', '<h3 class="comments-title">%s</h3>', $title_comments ), $title_comments );

		do_action( 'cherry_comments_nav', 'above' );

		do_action( 'cherry_comments_list' );

		do_action( 'cherry_comments_nav', 'below' );

	endif;

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( !comments_open() && get_comments_number() ) : ?>

		<p class="no-comments">
			<?php echo apply_filters( 'cherry_comments_closed_text', __( 'Comments are closed.', 'cherry' ) ); ?>
		</p>

	<?php endif;

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
	comment_form( $comments_args ); ?>

	</div>
</div>

<?php do_action( 'cherry_comments_after' ); ?>