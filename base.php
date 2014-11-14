<?php do_action( 'cherry_get_header' ); ?>

<?php //$container_class = ( is_home() ) ? 'container' : 'container-fluid'; ?>
<?php $container_class = 'container'; ?>

<div id="content" class="site-content">
	<div class="<?php echo $container_class; ?>">
		<div class="row">

			<?php
				do_action( 'cherry_content_before' );
				include cherry_template_path();
				do_action( 'cherry_content' );
				do_action( 'cherry_content_after' );
			?>

			<?php do_action( 'cherry_get_sidebar', 'sidebar-main' ); ?>

		</div>
	</div>
</div>

<?php do_action( 'cherry_get_footer' ); ?>