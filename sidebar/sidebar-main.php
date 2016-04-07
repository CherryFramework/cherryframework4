<?php
/**
 * The sidebar containing the main widget area.
 */

/**
 * Fires before sidebar wrapper are opened.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_before', 'sidebar-main' );

printf( '<div %s>', cherry_get_attr( 'sidebar', 'sidebar-main' ) );

if ( is_active_sidebar( 'sidebar-main' ) ) {
	dynamic_sidebar( 'sidebar-main' );
} else {

	/**
	 * Fires if sidebar are empty.
	 *
	 * @since 4.0.5.2
	 * @param string $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_empty', 'sidebar-main' );
}

echo '</div>';

/**
 * Fires after sidebar wrapper are closed.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_after', 'sidebar-main' );