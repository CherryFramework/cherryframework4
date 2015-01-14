<?php do_action( 'cherry_sidebar_before', 'main' ); ?>

<div <?php cherry_attr( 'sidebar', 'secondary' ); ?>>

	<?php do_action( 'cherry_sidebar_start', 'main' );

		if ( is_active_sidebar( 'sidebar-main' ) ) :

			dynamic_sidebar( 'sidebar-main' );

		else :

			do_action( 'cherry_sidebar_empty', 'main' );

		endif;

	do_action( 'cherry_sidebar_end', 'main' ); ?>

</div>

<?php do_action( 'cherry_sidebar_after', 'main' ); ?>