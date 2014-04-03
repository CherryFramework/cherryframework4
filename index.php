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
 * @package Cherry Framework
 */

if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		// Loads the content/*.php template.
		cherry_get_content_template();

		// If viewing a single post/page/CPT.
		if ( is_singular() ) :

			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() ) :

				// Loads the comments.php template.
				comments_template( '/templates/comments.php', true );
			endif;

		endif;

	endwhile;

	// Display navigation to next/previous set of posts when applicable.
	cherry_paging_nav();

else :
	// If no posts were found.
	get_template_part( 'content/none' );

endif; ?>