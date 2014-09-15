<!-- Post entry view -->
<article <?php cherry_attr( 'post' ); ?>>

<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post.

		do_action( 'cherry_post_single', 'content' );

	else : // If not viewing a single post.

		do_action( 'cherry_post_loop', 'content' );

	endif;
?>

</article>