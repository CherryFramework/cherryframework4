<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		do_action( 'cherry_post_before' );

		do_action( 'cherry_post' );

		do_action( 'cherry_post_after' );

	endwhile;

	do_action( 'cherry_endwhile_after' );

else :

	do_action( 'cherry_loop_else' );

endif; ?>