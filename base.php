<?php cherry_get_header(); ?>

<div id="content" class="site-content">
	<div class="<?php echo apply_filters( 'cherry_get_container_class', 'cherry-container' ); ?>">

		<?php cherry_get_content(); ?>

		<?php cherry_get_sidebar( 'sidebar-main' ); ?>
		<?php cherry_get_sidebar( 'sidebar-secondary' ); ?>

	</div>
</div>

<?php cherry_get_footer(); ?>