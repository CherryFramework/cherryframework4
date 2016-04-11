<?php
/**
 * The general template for all theme sidebars.
 */

/**
 * Fires before sidebar wrapper are opened.
 *
 * @since 4.0.5.2
 * @param string  $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_before', $name );

printf( '<div %s>', cherry_get_attr( 'sidebar', $name ) );

if ( is_active_sidebar( $name ) ) {
	dynamic_sidebar( $name );
} else {

	/**
	 * Fires if sidebar are empty.
	 *
	 * @since 4.0.5.2
	 * @param string  $name The name of the specialised sidebar.
	 */
	do_action( 'cherry_sidebar_empty', $name );
}

echo '</div>';

/**
 * Fires after sidebar wrapper are closed.
 *
 * @since 4.0.5.2
 * @param string $name The name of the specialised sidebar.
 */
do_action( 'cherry_sidebar_after', $name );
