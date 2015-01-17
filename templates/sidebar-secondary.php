<?php do_action( 'cherry_sidebar_before', 'secondary' ); ?>

<div <?php cherry_attr( 'sidebar', 'tertiary' ); ?>>

	<?php do_action( 'cherry_sidebar_start', 'secondary' );

		if ( is_active_sidebar( 'sidebar-secondary' ) ) :

			dynamic_sidebar( 'sidebar-secondary' );

		else :

			do_action( 'cherry_sidebar_empty', 'secondary' );

		endif;

	do_action( 'cherry_sidebar_end', 'secondary' ); ?>

</div>

<?php do_action( 'cherry_sidebar_after', 'secondary' ); ?>