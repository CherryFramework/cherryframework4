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

	/**
	 * Hook fires immediately before posts loop output start
	 * @since  4.0.0
	 * @hooked 10  cherry_paging_nav  lib/functions/template-tags.php
	 */
	do_action( 'cherry_loop_before' );

	while ( have_posts() ) : the_post();

		do_action( 'cherry_entry_before' );

		do_action( 'cherry_entry' );

		do_action( 'cherry_entry_after' );

	endwhile;

	/**
	 * Hook fires immediately after posts loop output end
	 * @since  4.0.0
	 * @hooked 10  cherry_paging_nav  lib/functions/template-tags.php
	 */
	do_action( 'cherry_loop_after' );

else :

	/**
	 * Hook fires if main loop haven't any posts
	 * @since  4.0.0
	 * @hooked 10  cherry_noposts  lib/functions/template.php
	 */
	do_action( 'cherry_loop_empty' );

endif; ?>