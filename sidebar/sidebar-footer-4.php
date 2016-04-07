<?php
/**
 * The sidebar containing the footer widget area.
 */

/**
 * Fires before sidebar wrapper are opened.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_before', 'sidebar-footer-4' );

printf( '<div %s>', cherry_get_attr( 'sidebar', 'sidebar-footer-4' ) );

if ( is_active_sidebar( 'sidebar-footer-4' ) ) {
	dynamic_sidebar( 'sidebar-footer-4' );
} else {

	/**
	 * Fires if sidebar are empty.
	 *
	 * @since 4.0.5.2
	 * @param string $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_empty', 'sidebar-footer-4' );
}

echo '</div>';

/**
 * Fires after sidebar wrapper are closed.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_after', 'sidebar-footer-4' );