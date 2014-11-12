<?php
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
	 *     name           - The name or title of the static area displayed in the admin dashboard.
	 *     id             - The unique identifier by which the static area will be called.
	 *     before         - HTML content that will be prepended to each widget's HTML output
	 *                      when assigned to this static area.
	 *     after          - HTML content that will be appended to each widget's HTML output
	 *                      when assigned to this static area.
	 *     before_static  - HTML content that will be prepended to each static's HTML output
	 *                      when assigned to this static area.
	 *     after_static   - HTML content that will be appended to each static's HTML output
	 *                      when assigned to this static area.
	 *     container_wrap - Add or not a container wrapper?
	 *     row_wrap       - Add or not a row wrapper?
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
			'name'           => sprintf( __( 'Static Area %d', 'cherry' ), $i ),
			'id'             => "static-area-$i",
			'before'         => '',
			'after'          => '',
			'before_static'  => '<div class="static clearfix">',
			'after_static'   => '</div>',
			'container_wrap' => true,
			'row_wrap'       => true,
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
		$defaults = apply_filters( 'cherry_register_static_default_args', array(
			'name' => sprintf( __( 'Static %d', 'cherry' ), $i ),
			'id'   => "static-$i",
		), $args, $i );

		$static = wp_parse_args( $args, $defaults );
		$id     = strtolower( $static['id'] );

		if ( !isset( $static['options']['priority'] )) {
			$static['options'] = array_merge( $static['options'], array( 'priority' => $i ) );
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
			$_index = $index;
			$index  = "static-area-$index";
		} else {
			$index = $_index = sanitize_title( $index );
		}

		if ( !isset( $cherry_registered_static_areas[ $index ] ) || empty( $cherry_registered_static_areas[ $index ] ) ) {

			/**
			 * Filters returned boolean variable when a static area is not found
			 * or static area is empty.
			 *
			 * @since 4.0.0
			 * @param bool
			 * @param int   $index Index, name or ID of static area.
			 */
			return apply_filters( 'cherry_static_area_has_statics', false, $index );
		}

		/**
		 * Fires before statics are rendered in a static area.
		 *
		 * @since 4.0.0
		 * @param int|string $index Index, name, or ID of the static area.
		 */
		do_action( 'cherry_static_area_before', $index );

		$static_area = $cherry_registered_static_areas[ $index ];
		$wrap_class  = '';
		$container   = false;
		$row         = false;

		// 'Before' wrap open.
		echo $static_area['before'];

		if ( isset( $static_area['container_wrap'] ) ) {
			$container = (bool) $static_area['container_wrap'];
			$wrap_class = ( $container ) ? $wrap_class : $wrap_class . ' no-container';
		}

		if ( isset( $static_area['row_wrap'] ) ) {
			$row = (bool) $static_area['row_wrap'];
			$wrap_class = ( $row ) ? $wrap_class : $wrap_class . ' no-row';
		}

		// Wrap open (default).
		printf( '<div id="static-area-%1$s" class="static-area%2$s">', $_index, $wrap_class );

		if ( $container ) {
			/**
			 * Filters a HTML tag (open) for container.
			 *
			 * @since 4.0.0
			 * @param int   $index Index, name, or ID of the static area.
			 */
			$container_open  = apply_filters( 'cherry_static_area_container_open', '<div class="%1$s">', $index );

			/**
			 * Filters a CSS-class for container.
			 *
			 * @since 4.0.0
			 * @param int   $index Index, name, or ID of the static area.
			 */
			$container_class = apply_filters( 'cherry_static_area_container_class', 'container', $index );

			// 'Container' wrap open.
			printf( $container_open, $container_class );
		}

		if ( $row ) {
			/**
			 * Filters a HTML tag (open) for row.
			 *
			 * @since 4.0.0
			 * @param int   $index Index, name, or ID of the static area.
			 */
			$row_open  = apply_filters( 'cherry_static_area_row_open', '<div class="%1$s">', $index );

			/**
			 * Filters a CSS-class for row.
			 *
			 * @since 4.0.0
			 * @param int   $index Index, name, or ID of the static area.
			 */
			$row_class = apply_filters( 'cherry_static_area_row_class', 'row', $index );

			// 'Row' wrap open.
			printf( $row_open, $row_class );
		}

		// Sort an array with a user-defined comparison function and maintain index association.
		uasort( $cherry_registered_statics, array( 'self', 'compare' ) );

		foreach ( $cherry_registered_statics as $id => $data ) :

			if ( !isset( $data['options']['area'] ) ) {
				continue;
			}

			if ( $index === $data['options']['area'] ) {

				$options = $data['options'];

				$cols = array(
					'col-lg' => '',
					'col-md' => '',
					'col-sm' => '',
					'col-xs' => '',
				);

				foreach ( (array) $cols as $key => $col ) {

					if ( !isset( $options[ $key ] ) ) {
						continue;
					}

					if ( $options[ $key ] == null ) {
						continue;
					}

					$cols[ $key ] = $options[ $key ];
				}

				// Prepare a column CSS classes.
				$cols_class = join( ' ', $cols );
				$cols_class = trim( $cols_class );

				// Prepare a custom CSS class.
				$extra_class = str_replace( '_', '-', $id );
				$extra_class = sanitize_html_class( 'static-' . $extra_class );
				$extra_class = ( isset( $options['class'] ) ) ? $extra_class . ' ' . sanitize_html_class( $options['class'] ) : $extra_class;
				$extra_class = ( empty( $cols_class ) ) ? $extra_class : $cols_class . ' ' . $extra_class;

				/**
				 * Fires before a static's display callback is called.
				 *
				 * @since 4.0.0
				 * @param array $static An associative array of static arguments.
				 */
				do_action( 'cherry_static_area', $cherry_registered_statics[ $id ] );

				if ( is_callable( $data['callback'] ) ) {

					printf( '<div class="%1$s">%2$s', $extra_class, $static_area['before_static'] );
						call_user_func( $data['callback'], $options );
					printf( '%s</div>', $static_area['after_static'] );

				}
			}

		endforeach;

		if ( $row ) {
			/**
			 * Filters a HTML tag (close) for row.
			 *
			 * @since 4.0.0
			 * @param int   $index Index, name, or ID of the static area.
			 */
			$row_close = apply_filters( 'cherry_static_area_row_close', '</div>', $index );

			// 'Row' wrap close.
			echo $row_close;
		}

		if ( $container ) {
			/**
			 * Filters a HTML tag (close) for container.
			 *
			 * @since 4.0.0
			 * @param int   $index Index, name, or ID of the static area.
			 */
			$container_close = apply_filters( 'cherry_static_area_container_close', '</div>', $index );

			// 'Container' wrap close.
			echo $container_close;
		}

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
	 * Custom compare function.
	 *
	 * @since  4.0.0
	 * @param  int $a
	 * @param  int $b
	 */
	public static function compare( $a, $b ) {

		if ( $a['options']['priority'] == $b['options']['priority'] ) {
			return 0;
		}

		return ( $a['options']['priority'] < $b['options']['priority'] ) ? -1 : 1;
	}

	/**
	 * Callback-function for a 'header_logo' static.
	 *
	 * @since 4.0.0
	 */
	public static function header_logo( $options ) {

		if ( cherry_get_site_title() || cherry_get_site_description() ) {

			printf( '<div class="site-branding">%1$s %2$s</div>',
				cherry_get_site_title(),
				cherry_get_site_description()
			);

		}
	}

	/**
	 * Callback-function for a 'footer_logo' static.
	 *
	 * @since 4.0.0
	 */
	public static function footer_logo( $options ) {

		if ( cherry_get_site_title() ) {
			printf( '%s', cherry_get_site_title() );
		}
	}

	/**
	 * Callback-function for a 'header_menu' static.
	 *
	 * @since 4.0.0
	 */
	public static function header_menu( $options ) {
		cherry_get_menu_template( 'primary' );
	}

	/**
	 * Callback-function for a 'footer_menu' static.
	 *
	 * @since 4.0.0
	 */
	public static function footer_menu( $options ) {
		cherry_get_menu_template( 'secondary' );
	}

	/**
	 * Prints HTML with Search Form.
	 *
	 * @since 4.0.0
	 */
	public static function searchform( $options ) {
		get_search_form( true );
	}

	/**
	 * Callback-function for a 'loginout' static.
	 *
	 * @since 4.0.0
	 */
	public static function loginout( $options ) {
		wp_loginout();
	}

}