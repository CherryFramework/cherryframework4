<?php
/**
 * The sidebar containing the header widget area.
 */

/**
 * Fires before sidebar wrapper are opened.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_before', 'sidebar-header' );

printf( '<div %s>', cherry_get_attr( 'sidebar', 'sidebar-header' ) );

if ( is_active_sidebar( 'sidebar-header' ) ) {
	dynamic_sidebar( 'sidebar-header' );
} else {

	/**
	 * Fires if sidebar are empty.
	 *
	 * @since 4.0.5.2
	 * @param string $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_empty', 'sidebar-header' );
}

echo '</div>';

/**
 * Fires after sidebar wrapper are closed.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_after', 'sidebar-header' );