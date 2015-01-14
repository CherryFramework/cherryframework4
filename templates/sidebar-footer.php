<?php do_action( 'cherry_sidebar_before', 'footer' ); ?>

<div <?php cherry_attr( 'sidebar', 'subsidiary' ); ?>>

	<?php do_action( 'cherry_sidebar_start', 'footer' );

		if ( is_active_sidebar( 'sidebar-footer' ) ) :

			dynamic_sidebar( 'sidebar-footer' );

		else :

			do_action( 'cherry_sidebar_empty', 'footer' );

		endif;

	do_action( 'cherry_sidebar_end', 'footer' ); ?>

</div>

<?php do_action( 'cherry_sidebar_after', 'footer' ); ?>