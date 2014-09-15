<!-- Post entry view -->
<article <?php cherry_attr( 'post' ); ?>>

<?php if ( is_attachment() ) : // If viewing a single attachment.

		do_action( 'cherry_post_single', 'attachment' );

	else : // If not viewing a single attachment.

		do_action( 'cherry_post_loop', 'attachment' );

	endif;
?>

</article>