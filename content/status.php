<!-- Post entry view -->
<article <?php cherry_attr( 'post' ); ?>>
	<?php
		/**
		 * Default page structure hooks
		 */

		do_action( 'cherry_entry_content' );

		do_action( 'cherry_entry_meta' );

		do_action( 'cherry_entry_footer' );
	?>
</article>