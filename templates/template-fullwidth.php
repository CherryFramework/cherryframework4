<?php
/**
 * Template Name: Full Width
 *
 * The template for displaying pages without sidebar.
 *
 * @package Cherry Framework
 */
while ( have_posts() ) : the_post();

	// get_template_part( 'content', 'page' );
	// Loads the content/page.php template.
	cherry_get_content_template();

	// If comments are open or we have at least one comment, load up the comment template
	if ( comments_open() || '0' != get_comments_number() ) :
		comments_template( '/templates/comments.php', true );
	endif;

endwhile; ?>