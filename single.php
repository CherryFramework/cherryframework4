<?php
/**
 * The template for displaying all single posts.
 *
 */

while ( have_posts() ) : the_post();

	do_action( 'cherry_post_before' );

	do_action( 'cherry_post' );

	do_action( 'cherry_post_after' );

	do_action( 'cherry_get_comments' );

endwhile; ?>