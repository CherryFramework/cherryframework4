<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Cherry Framework
 */

while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'templates/content', 'single' ); ?>

	<?php cherry_post_nav(); ?>

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template('/templates/comments.php');
		endif;
	?>

<?php endwhile; // end of the loop. ?>