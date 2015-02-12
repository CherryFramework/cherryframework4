<?php cherry_get_header(); ?>

<div id="content" class="site-content">
	<div class="<?php echo apply_filters( 'cherry_get_container_class', 'cherry-container' ); ?>">

		<?php
			do_action( 'cherry_content_before' );
			include cherry_template_path();
			do_action( 'cherry_content' );
			do_action( 'cherry_content_after' );

			cherry_get_sidebar( 'main' );
			cherry_get_sidebar( 'secondary' );
		?>

	</div>
</div>

<?php cherry_get_footer(); ?>