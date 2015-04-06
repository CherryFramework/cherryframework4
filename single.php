<?php
/**
 * The template for displaying all single posts.
 *
 */

while ( have_posts() ) : the_post();

	do_action( 'cherry_entry_before' );

	do_action( 'cherry_entry' );

	do_action( 'cherry_entry_after' );

endwhile; ?>