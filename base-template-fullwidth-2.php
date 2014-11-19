<?php do_action( 'cherry_get_header' ); ?>

<?php
global $cherry_layout;
$cherry_layout   = 'boxed'; // boxed or wide
$container_class = '';

if ( 'wide' === $cherry_layout ) {
	$container_class .= 'cherry-container-fluid';
} elseif ( 'boxed' === $cherry_layout ) {
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