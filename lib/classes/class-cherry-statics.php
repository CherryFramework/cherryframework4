<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Builds the definition for a single static area and returns the ID.
 *
 * @since  4.0.0
 */
function cherry_register_static_area( $args = array() ) {
	Cherry_Statics::register_static_area( $args );
}

/**
 * Removes a static area from the list.
 *
 * @since 4.0.0
 */
function cherry_unregister_static_area( $id = '' ) {
	Cherry_Statics::unregister_static_area( $id );
}

/**
 * Register static for use in static area.
 *
 * @since 4.0.0
 */
function cherry_register_static( $args = array() ) {
	Cherry_Statics::register_static( $args );
}

/**
 * Removes static from static area.
 *
 * @since 4.0.0
 */
function cherry_unregister_static( $id = '' ) {
	Cherry_Statics::unregister_static( $id );
}

/**
 * Display static area.
 */
function cherry_static_area( $index = 1 ) {
	Cherry_Statics::static_area( $index );
}

class Cherry_Statics {

	/**
	 * Constructor.
	 */
	public function __construct() {}

	/**
	 * Builds the definition for a single static area and returns the ID.
	 *
	 * Arguments:
	 *     name          - The name or title of the static area displayed in the admin dashboard.
	 *     id            - The unique identifier by which the static area will be called.
	 *     before        - HTML content that will be prepended to each widget's HTML output
	 *                     when assigned to this static area.
	 *     after         - HTML content that will be appended to each widget's HTML output
	 *                     when assigned to this static area.
	 *     before_static - HTML content that will be prepended to each static's HTML output
	 *                     when assigned to this static area.
	 *     after_static  - HTML content that will be appended to each static's HTML output
	 *                     when assigned to this static area.
	 *     container     - Add or not a container wrapper?
	 *     row           - Add or not a row wrapper?
	 *
	 * @since  4.0.0
	 * @param  string|array $args Arguments for the static area being registered.
	 * @return string             Static Area ID added to $cherry_registered_static_areas global.
	 */
	public static function register_static_area( $args = array() ) {
		global $cherry_registered_static_areas;

		$i = count( $cherry_registered_static_areas ) + 1;

		/**
		 * Filter the array of default arguments.
		 *
		 * @since 4.0.0
		 * @param array Default arguments.
		 * @param array Passed arguments.
		 * @param int   Counter.
		 */
		$defaults = apply_filters( 'cherry_register_static_area_default_args', array(
			'id'            => "static-area-$i",
			'name'          => sprintf( __( 'Static Area %d', 'cherry' ), $i ),
			'before'        => '',
			'after'         => '',
			'before_static' => '',
			'after_static'  => '',
			'fluid'         => false,
			// 'row'           => true,
		), $args, $i );

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

	/**
	 * Removes a static area from the list.
	 *
	 * @since 4.0.0
	 * @param string $id The ID of the static area when it was added.
	 */
	public static function unregister_static_area( $id = '' ) {
		if ( !$id ) {
			return;
		}

		global $cherry_registered_static_areas;

		if ( isset( $cherry_registered_static_areas[ $id ] ) ) {
			unset( $cherry_registered_static_areas[ $id ] );
		}
	}

	/**
	 * Register static for use in static area.
	 *
	 * @since 4.0.0
	 * @param array $args Static Options.
	 */
	public static function register_static( $args = array() ) {
		global $cherry_registered_statics;

		$i = count( $cherry_registered_statics ) + 1;

		/**
		 * Filter the array of default arguments.
		 *
		 * @since 4.0.0
		 * @param array Default arguments.
		 * @param array Passed arguments.
		 * @param int   Counter.
		 */
		$defaults = apply_filters( 'cherry_register_static_defaults', array(
			'id'      => "static-$i",
			'name'    => sprintf( __( 'Static %d', 'cherry' ), $i ),
			'options' => array(
				'col-xs'   => '',
				'col-sm'   => '',
				'col-md'   => '',
				'col-lg'   => '',
				'class'    => '',
				'collapse' => false,
			),
		), $args, $i );

		$options           = wp_parse_args( $args['options'], $defaults['options'] );
		$static            = wp_parse_args( $args, $defaults );
		$static['options'] = $options;
		$id                = strtolower( $static['id'] );

		if ( !isset( $static['options']['position'] )) {
			$static['options'] = wp_parse_args( $static['options'], array( 'position' => $i ) );
		}

		if ( isset( $static['callback'] ) && is_callable( $static['callback'] ) ) {
			$callback = $static['callback'];
		} elseif ( is_callable( array( 'self', $id ) ) ) {
			$callback = array( 'self', $id );
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

			// Sort an array with a user-defined comparison function and maintain index association.
			uasort( $cherry_registered_statics, array( 'self', 'compare' ) );
		}
	}

	/**
	 * Remove static from static area.
	 *
	 * @since 4.0.0
	 * @param int|string $id Static ID.
	 */
	public static function unregister_static( $id = '' ) {
		if ( !$id ) {
			return;
		}

		global $cherry_registered_statics;

		if ( isset( $cherry_registered_statics[ $id ] ) ) {
			unset( $cherry_registered_statics[ $id ] );
		}
	}

	/**
	 * Display static area.
	 *
	 * @since  4.0.0
	 * @param  int|string $index Optional, default is 1. Index, name or ID of static area.
	 * @return bool              True, if static area was found and called. False if not found or not called.
	 */
	public static function static_area( $index = 1 ) {
		global $cherry_registered_static_areas, $cherry_registered_statics;

		if ( is_int( $index ) ) {
			$index  = "static-area-$index";
		} else {
			$index = sanitize_title( $index );
		}

		if ( empty( $cherry_registered_static_areas[ $index ] ) ) {

			/**
			 * Filters returned boolean variable when a static area is not found
			 * or static area without params.
			 *
			 * @since 4.0.0
			 * @param bool
			 * @param int   $index Index, name or ID of static area.
			 */
			return apply_filters( 'cherry_static_area_has_statics', false, $index );
		}

		if ( !self::is_active_static_area( $index ) ) {

			/**
			 * Filters returned boolean variable when a static area is empty.
			 *
			 * @since 4.0.0
			 * @param bool
			 * @param int   $index Index, name or ID of static area.
			 */
			return apply_filters( 'cherry_is_active_static_area', false, $index );
		}

		// Get statics from options.
		$theme_options = get_option( 'cherry-options' );
		$args = get_option( $theme_options['id'] . '_statics' );
		//$option_name = apply_filters( 'cherry_statics_option_name', 'static-area-editor', $index );
		//$args        = cherry_get_option( $option_name );

		if ( !$args ) {
			return false;
		}

		foreach ( $args as $id => $data ) :

			if ( empty( $cherry_registered_statics[ $id ] ) ) {
				continue;
			}

			$args[ $id ]['options'] = wp_parse_args(
				$args[ $id ]['options'],
				$cherry_registered_statics[ $id ]['options']
			);

		endforeach;

		/**
		 * Fires before statics are rendered in a static area.
		 *
		 * @since 4.0.0
		 * @param int|string $index Index, name, or ID of the static area.
		 */
		do_action( 'cherry_static_area_before', $index );

		$static_area = $cherry_registered_static_areas[ $index ];
		$fluid       = false;

		// 'Before' wrap open.
		echo $static_area['before'];

		if ( isset( $static_area['fluid'] ) ) {
			$fluid = (bool) $static_area['fluid'];
		}

		// Wrap open (default).
		printf( '<div id="static-area-%1$s" class="%s static-area">', $index );

		/**
		 * Filters a HTML tag (open) for container.
		 *
		 * @since 4.0.0
		 * @param int   $index Index, name, or ID of the static area.
		 */
		$container_open  = apply_filters( 'cherry_static_area_container_open', '<div class="%1$s">', $index );
		$container_class = ( true === $fluid ) ? 'container-fluid' : 'container';

		/**
		 * Filters a CSS-class for container.
		 *
		 * @since 4.0.0
		 * @param string $container_class CSS-class name.
		 * @param int    $index           Index, name, or ID of the static area.
		 */
		$container_class = apply_filters( 'cherry_static_area_container_class', $container_class, $index );

		// 'Container' wrap open.
		printf( $container_open, $container_class );

		/**
		 * Filters a HTML tag (open) for row.
		 *
		 * @since 4.0.0
		 * @param int   $index Index, name, or ID of the static area.
		 */
		$row_open = apply_filters( 'cherry_static_area_row_open', '<div class="%1$s">', $index );

		/**
		 * Filters a CSS-class for row.
		 *
		 * @since 4.0.0
		 * @param int   $index Index, name, or ID of the static area.
		 */
		$row_class = apply_filters( 'cherry_static_area_row_class', 'row', $index );

		// 'Row' wrap open.
		printf( $row_open, $row_class );

		foreach ( $args as $id => $data ) :

			if ( ! isset( $data['options']['area'] ) ) {
				continue;
			}

			if ( $index != $data['options']['area'] ) {
				continue;
			}

			if ( empty( $cherry_registered_statics[ $id ] ) ) {
				continue;
			}

			if ( ! is_callable( $cherry_registered_statics[ $id ]['callback'] ) ) {
				continue;
			}

			$options = $data['options'];
			$cols    = apply_filters( 'cherry_static_options_cols', array(
				'col-xs' => '',
				'col-sm' => '',
				'col-md' => '',
				'col-lg' => '',
			), $id );

			foreach ( (array) $cols as $key => $col ) {

				if ( empty( $options[ $key ] ) ) {
					continue;
				}

				if ( 'none' == $options[ $key ] ) {
					continue;
				}

				$cols[ $key ] = $key . '-' . preg_replace( '/[^0-9]/', '', $options[ $key ] );
			}

			// Prepare a column CSS classes.
			$cols_class = join( ' ', $cols );
			$cols_class = trim( $cols_class );

			// Prepare a custom CSS class.
			$extra_class = str_replace( '_', '-', $id );
			$extra_class = sanitize_html_class( 'static-' . $extra_class );
			$extra_class = ( empty( $options['class'] ) ) ? $extra_class : $extra_class . ' ' . sanitize_html_class( $options['class'] );
			$extra_class = ( false == $options['collapse'] ) ? $extra_class : 'collapse-col ' . $extra_class;
			$extra_class = ( empty( $cols_class ) ) ? $extra_class : $cols_class . ' ' . $extra_class;

			/**
			 * Fires before a static's display callback is called.
			 *
			 * @since 4.0.0
			 * @param array $index Index, name or ID of static area.
			 */
			do_action( 'cherry_static_area', $index );

			printf( '<div class="%1$s">%2$s', $extra_class, $static_area['before_static'] );
				call_user_func( $cherry_registered_statics[ $id ]['callback'], $options );
			printf( '%s</div>', $static_area['after_static'] );

		endforeach;

		/**
		 * Filters a HTML tag (close) for row.
		 *
		 * @since 4.0.0
		 * @param int   $index Index, name, or ID of the static area.
		 */
		$row_close = apply_filters( 'cherry_static_area_row_close', '</div>', $index );

		// 'Row' wrap close.
		echo $row_close;

		/**
		 * Filters a HTML tag (close) for container.
		 *
		 * @since 4.0.0
		 * @param int   $index Index, name, or ID of the static area.
		 */
		$container_close = apply_filters( 'cherry_static_area_container_close', '</div>', $index );

		// 'Container' wrap close.
		echo $container_close;

		// Wrap close (default).
		echo '</div>';

		// 'After' wrap close.
		echo $static_area['after'];

		/**
		 * Fires after statics are rendered in a static area.
		 *
		 * @since 4.0.0
		 * @param int|string $index Index, name, or ID of the static area.
		 */
		do_action( 'cherry_static_area_after', $index );

		return true;
	}

	/**
	 * Whether a static area is in use (not empty).
	 *
	 * @since 4.0.0
	 *
	 * @param  mixed $index Static area id.
	 * @return bool         true if the static area is in use, false otherwise.
	 */
	public static function is_active_static_area( $index ) {
		global $cherry_registered_statics;

		//$option_name   = apply_filters( 'cherry_statics_option_name', 'static-area-editor', $index );
		//$saved_statics = cherry_get_option( $option_name, false );
		$theme_options = get_option( 'cherry-options' );
		$saved_statics = get_option( $theme_options['id'] . '_statics' );

		if ( !$saved_statics ) {
			$saved_statics = $cherry_registered_statics;
		}

		if ( empty( $saved_statics ) ) {
			return false;
		}

		foreach ( $saved_statics as $id => $static ) :

			if ( !isset( $static['options']['area'] ) ) {
				continue;
			}

			if ( $index === $static['options']['area'] ) {
				return true;
			}

		endforeach;

		return false;
	}

	/**
	 * Custom compare function.
	 *
	 * @since  4.0.0
	 * @param  int $a
	 * @param  int $b
	 */
	public static function compare( $a, $b ) {

		if ( intval( $a['options']['position'] ) == intval( $b['options']['position'] ) ) {
			return 0;
		}

		return ( $a['options']['position'] < $b['options']['position'] ) ? -1 : 1;
	}

}