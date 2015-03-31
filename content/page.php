<article <?php cherry_attr( 'post' ); ?>>
	<?php
		/**
		 * Default page structure hooks
		 */

		do_action( 'cherry_entry_header' );

		if ( is_singular() ) {

			do_action( 'cherry_entry_content' );

		} else {

			do_action( 'cherry_entry_excerpt' );

		}

		do_action( 'cherry_entry_footer' );
	?>
</article>