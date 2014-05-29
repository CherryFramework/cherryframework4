<!-- Post entry view -->
<article <?php cherry_attr( 'post' ); ?>>

<?php if ( is_page() ) : // If viewing a single page.

		do_action( 'cherry_post_single', 'page' );

	else : // If not viewing a single page.

		do_action( 'cherry_post_loop', 'page' );

	endif;
?>

</article>