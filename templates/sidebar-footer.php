<?php
/**
 * The Sidebar located in the footer of the site.
 *
 * @package Cherry Framework
 */
?>
<!-- Subsidiary widget area -->
<?php do_action( 'cherry_sidebar_footer_before' ); ?>

<div <?php cherry_attr( 'sidebar', 'subsidiary' ); ?>>

	<?php do_action( 'cherry_sidebar_footer_start' );

		if ( is_active_sidebar( 'sidebar-footer' ) ) :

			dynamic_sidebar( 'sidebar-footer' );

		else :

			do_action( 'cherry_sidebar_footer_empty' );

		endif;

	do_action( 'cherry_sidebar_footer_end' ); ?>

</div>

<?php do_action( 'cherry_sidebar_footer_after' ); ?>