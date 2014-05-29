<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 */
		do_action( 'cherry_footer_before' );

		do_action( 'cherry_footer' );

		do_action( 'cherry_footer_after' ); ?>

	</div>

<?php wp_footer(); ?>

<?php do_action( 'cherry_body_end' ); ?>
</body>
</html>