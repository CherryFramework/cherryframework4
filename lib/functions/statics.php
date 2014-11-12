<?php
/* Global Variables */
global $cherry_registered_static_areas, $cherry_registered_statics;

/**
 * Stores the static areas, since many themes can have more than one.
 *
 * @global array $cherry_registered_static_areas
 * @since  4.0.0
 */
$cherry_registered_static_areas = array();

/**
 * Stores the registered static elements.
 *
 * @global array $cherry_registered_statics
 * @since  4.0.0
 */
$cherry_registered_statics = array();


/**
 * Builds the definition for a single static area and returns the ID.
 *
 * Arguments:
 *     name         - The name or title of the static area displayed in the admin dashboard.
 *     id           - The unique identifier by which the static area will be called.
 *     before       - HTML content that will be prepended to each widget's HTML output
 *                     when assigned to this static area.
 *     after        - HTML content that will be appended to each widget's HTML output
 *                     when assigned to this static area.
 *     before_title - HTML content that will be prepended to the static area title when displayed.
 *     after_title  - HTML content that will be appended to the static area title when displayed.
 *
 * @since  4.0.0
 * @param  string|array $args Arguments for the sidebar being registered.
 * @return string             Sidebar ID added to $wp_registered_sidebars global.
 */
function cherry_register_static_area( $args = array() ) {
	global $cherry_registered_static_areas;

	$i = count( $cherry_registered_static_areas ) + 1;

	$defaults = apply_filters( 'cherry_register_static_area_default_args', array(
		'name'          => sprintf( __( 'Static Area %d', 'cherry' ), $i ),
		'id'            => "static-area-$i",
		'before'        => '<div id="%1$s" class="static-area %2$s">',
		'after'         => '</div>',
		'before_static' => '<div id="%1$s" class="static %2$s">',
		'after_static'  => '</div>',
		'priority'      => 10,
	) );

	$static_area = wp_parse_args( $args, $defaults );

	$cherry_registered_static_areas[ $static_area['id'] ] = $static_area;

	/**
	 * Fires once a static area has been registered.
	 *
	 * @since 4.0.0
	 * @param array $static_area Parsed arguments for the registered static area.
	 */
	do_action( 'cherry_register_static_area', $static_area );

	return $static_area['id'];
}

function cherry_register_static( $args = array() ) {
	global $cherry_registered_statics;

	$i = count( $cherry_registered_statics ) + 1;

	$defaults = apply_filters( 'cherry_register_static_default_args', array(
		'id'       => "static-$i",
		'name'     => sprintf( __( 'Static %d', 'cherry' ), $i ),
		'callback' => '',
	) );

	$static = wp_parse_args( $args, $defaults );
	$id     = strtolower( $static['id'] );

	if ( isset( $static['callback'] ) && !empty( $static['callback'] ) && is_callable( $static['callback'] ) ) {
		$callback = $static['callback'];
	} elseif ( is_callable( array( 'Cherry_Static', $id ) ) ) {
		$callback = array( 'Cherry_Static', $id );
	} else {
		return;
	}

	$static['callback'] = $callback;
	
	if ( !isset( $cherry_registered_statics[ $id ] ) ) {
		/**
		 * Fires once for each registered static.
		 *
		 * @since 4.0.0
		 * @param array $static An array of default static arguments.
		 */
		do_action( 'cherry_register_static', $static );
		$cherry_registered_statics[ $id ] = $static;
	}
	
}

function cherry_static_area( $index = 1 ) {
	global $cherry_registered_static_areas, $cherry_registered_statics, $wp_filter, $wp_actions, $wp_current_filter, $merged_filters;

	if ( is_int( $index ) ) {
		$index = "static-area-$index";
	} else {
		$index = sanitize_title( $index );
	}

	if ( !isset( $cherry_registered_static_areas[ $index ] ) || empty( $cherry_registered_static_areas[ $index ] ) ) {
		return apply_filters( 'dynamic_static_area_has_statics', false, $index );
	}

	do_action( 'dynamic_static_area_before', $index, true );

	$static_area         = $cherry_registered_static_areas[ $index ];
	$column_class_prefix = apply_filters( 'cherry_column_class_prefix', 'col-md-' );

	$before = sprintf( '<div id="row-%1$s" class="row-%1$s">%2$s', $index, $static_area['before'] );
	$before = apply_filters( 'cherry_cherry_static_area_before', $before );
	echo $before;

	foreach ( $cherry_registered_statics as $id => $data ) :

		if ( !isset( $data['options']['area'] ) ) {
			continue;
		}

		if ( $index === $data['options']['area'] ) {

			$before_static = sprintf( $static_area['before_static'], $data['options']['class'] );
			$before_static = apply_filters( 'cherry_static_area_before', $before_static );
			// $after_static  = apply_filters( 'cherry_static_area_after' $static_area['after_static'] );
			$callback      = $data['callback'];

			do_action( 'cherry_static_area', $cherry_registered_statics[ $id ] );

			if ( is_callable( $callback ) ) {

				printf( '<div class="%1$s%2$d">%3$s', $column_class_prefix, $data['options']['column'], $before_static );
					call_user_func( $callback, $data['options'] );
				printf( '%s</div>', $static_area['after_static'] );
			}
		}

	endforeach;

	$after = sprintf( '%s</div>', $static_area['after'] );
	$after = apply_filters( 'cherry_cherry_static_area_after', $after );
	echo $after;

	do_action( 'dynamic_static_area_after', $index, true );

	return true;
}