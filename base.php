<?php do_action( 'cherry_get_header' ); ?>

<div id="content" class="site-content">
	<div class="container">
		<div class="row">

			<?php do_action( 'cherry_get_content' ); ?>

			<?php do_action( 'cherry_get_sidebar', 'sidebar-main' ); ?>

		</div>
	</div>
</div>

<?php do_action( 'cherry_get_footer' ); ?>