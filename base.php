<?php do_action( 'cherry_get_header' );

$layout_type     = cherry_get_option('grid-type');
$container_class = '';

if ( 'grid-wide' === $layout_type ) {
	$container_class .= 'cherry-container-fluid';
} elseif ( 'grid-boxed' === $layout_type ) {
	$container_class .= 'cherry-container';
}
$container_class = ( empty( $container_class ) ) ? 'clearfix' : $container_class .= ' clearfix';
?>

<div id="content" class="site-content">
	<div class="<?php echo $container_class; ?>">

		<?php
			do_action( 'cherry_content_before' );
			include cherry_template_path();
			do_action( 'cherry_content' );
			do_action( 'cherry_content_after' );
		?>

		<?php do_action( 'cherry_get_sidebar', 'sidebar-main' ); ?>

	</div>
</div>

<?php do_action( 'cherry_get_footer' ); ?>