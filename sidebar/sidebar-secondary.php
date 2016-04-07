<?php
/**
 * The sidebar containing the secondary widget area.
 */

/**
 * Fires before sidebar wrapper are opened.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_before', 'sidebar-secondary' );

printf( '<div %s>', cherry_get_attr( 'sidebar', 'sidebar-secondary' ) );

if ( is_active_sidebar( 'sidebar-secondary' ) ) {
	dynamic_sidebar( 'sidebar-secondary' );
} else {

	/**
	 * Fires if sidebar are empty.
	 *
	 * @since 4.0.5.2
	 * @param string $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_empty', 'sidebar-secondary' );
}

echo '</div>';

/**
 * Fires after sidebar wrapper are closed.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_after', 'sidebar-secondary' );