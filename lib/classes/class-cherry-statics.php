<?php
/**
 * API for creating static areas and statics.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Builds the definition for a single static area and returns the ID.
 *
 * @since  4.0.0
 * @param  array  $args Arguments.
 * @return string       Static Area ID.
 */
function cherry_register_static_area( $args = array() ) {
	Cherry_Statics::register_static_area( $args );
}

/**
 * Removes a static area from the list.
 *
 * @since  4.0.0
 * @param  string $id Static area ID.
 * @return void
 */
function cherry_unregister_static_area( $id = '' ) {
	Cherry_Statics::unregister_static_area( $id );
}

/**
 * Register static for use in static area.
 *
 * @since  4.0.0
 * @param  array $args Arguments.
 * @return void
 */
function cherry_register_static( $args = array() ) {
	Cherry_Statics::register_static( $args );
}

/**
 * Removes static from static area.
 *
 * @since  4.0.0
 * @param  string $id Static ID.
 * @return void
 */
function cherry_unregister_static( $id = '' ) {
	Cherry_Statics::unregister_static( $id );
}

/**
 * Display static area.
 *
 * @since 4.0.0
 * @param int|string $index Static area ID.
 */
function cherry_static_area( $index = 1 ) {
	Cherry_Statics::static_area( $index );
}

/**
 * Class for creating static areas and statics.
 *
 * @since 4.0.0
 */
class Cherry_Statics {

	/**
	 * Set of visible statics.
	 *
	 * @since 4.0.0
	 * @access public
	 * @var array $visible_statics Array with statics.
	 */
	public static $visible_statics = array();

	/**
	 * Constructor.
	 *
	 * @since 4.0.0
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
	 * @global array        $cherry_registered_static_areas Registered static areas.
	 * @param  string|array $args                           Arguments for the static area being registered.
	 * @return string                                       Static Area ID added to $cherry_registered_static_areas global.
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
	 * @since  4.0.0
	 * @global array  $cherry_registered_static_areas Registered static areas.
	 * @param  string $id                             The ID of the static area when it was added.
	 */
	public static function unregister_static_area( $id = '' ) {

		if ( ! $id ) {
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
	 * @since  4.0.0
	 * @global array $cherry_registered_statics Registered statics.
	 * @param  array $args                      Static Options.
	 */
	public static function register_static( $args = array() ) {
		global $cherry_registered_static_areas, $cherry_registered_statics;

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
				'area'     => '',
				'collapse' => false,
			),
			'conditions' => array(
				'action' => '',
				'rules'  => '',
			),
		), $args, $i );

		$options           = wp_parse_args( $args['options'], $defaults['options'] );
		$static            = wp_parse_args( $args, $defaults );
		$static['options'] = $options;
		$id                = strtolower( $static['id'] );

		if ( ! isset( $static['options']['position'] ) ) {
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

		if ( ! self::is_registered_area( $static['options']['area'] ) ) {
			$static['options']['area'] = 'available-statics';
		}

		if ( ! isset( $cherry_registered_statics[ $id ] ) ) {

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
	 * @since  4.0.0
	 * @global array      $cherry_registered_statics Registered statics.
	 * @param  int|string $id                        Static ID.
	 */
	public static function unregister_static( $id = '' ) {

		if ( ! $id ) {
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
	 * @global array      $cherry_registered_static_areas Registered static areas.
	 * @global array      $cherry_registered_statics      Registered statics.
	 * @param  int|string $index                          Optional, default is 1. Index, name or ID of static area.
	 * @return bool                                       True, if static area was found and called. False if not found or not called.
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
			 * Filter a returned boolean variable when a static area is not found
			 * or static area without params.
			 *
			 * @since 4.0.0
			 * @param bool|mixed $result Value to return when current static area are empty.
			 * @param int        $index  Index, name or ID of static area.
			 */
			return apply_filters( 'cherry_static_area_has_statics', false, $index );
		}

		// Get statics from options.
		$theme_options = get_option( 'cherry-options' );
		$args          = get_option( $theme_options['id'] . '_statics' );

		/**
		 * Filter a current saved static settings.
		 *
		 * @since 4.0.5
		 * @param array $args Current static settings.
		 */
		$args = apply_filters( 'cherry_static_current_statics', $args );

		if ( ! $args ) {
			$args = $cherry_registered_statics;
		}

		if ( empty( $args ) ) {
			return false;
		}

		if ( ! self::is_active_static_area( $index, $args ) ) {

			/**
			 * Filter a returned boolean variable when a static area is empty.
			 *
			 * @since 4.0.0
			 * @param bool
			 * @param int  $index Index, name or ID of static area.
			 */
			return apply_filters( 'cherry_is_active_static_area', false, $index );
		}

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
		 * Filter a HTML tag (open) for container.
		 *
		 * @since 4.0.0
		 * @param string $container_open HTML tag.
		 * @param int    $index          Index, name, or ID of the static area.
		 */
		$container_open  = apply_filters( 'cherry_static_area_container_open', '<div class="%1$s">', $index );
		$container_class = ( true === $fluid ) ? 'container-fluid' : 'container';

		/**
		 * Filter a CSS-class for container.
		 *
		 * @since 4.0.0
		 * @param string $container_class CSS-class name.
		 * @param int    $index           Index, name, or ID of the static area.
		 */
		$container_class = apply_filters( 'cherry_static_area_container_class', $container_class, $index );

		// 'Container' wrap open.
		printf( $container_open, $container_class );

		/**
		 * Filter a HTML tag (open) for row.
		 *
		 * @since 4.0.0
		 * @param string $row_open HTML tag.
		 * @param int    $index    Index, name, or ID of the static area.
		 */
		$row_open = apply_filters( 'cherry_static_area_row_open', '<div class="%1$s">', $index );

		/**
		 * Filter a CSS-class for row.
		 *
		 * @since 4.0.0
		 * @param string $row_class CSS-class name.
		 * @param int    $index     Index, name, or ID of the static area.
		 */
		$row_class = apply_filters( 'cherry_static_area_row_class', 'row', $index );

		// 'Row' wrap open.
		printf( $row_open, $row_class );

		foreach ( $args as $id => $data ) :

			if ( empty( self::$visible_statics[ $index ] ) ) {
				continue;
			}

			if ( ! in_array( $id, self::$visible_statics[ $index ] ) ) {
				continue;
			}

			if ( empty( $cherry_registered_statics[ $id ] ) ) {
				continue;
			}

			if ( ! is_callable( $cherry_registered_statics[ $id ]['callback'] ) ) {
				continue;
			}

			$options = $data['options'];

			/**
			 * Filter a columns CSS-class prefixes.
			 *
			 * @since 4.0.0
			 * @param array      $cols CSS-class prefixes.
			 * @param int|string $id   Static ID.
			 */
			$cols = apply_filters( 'cherry_static_options_cols', array(
				'col-xs',
				'col-sm',
				'col-md',
				'col-lg',
			), $id );

			array_walk( $cols, array( 'self', 'prepare_column_class' ), $options );

			// Prepare a column CSS classes.
			$cols_class = join( ' ', $cols );
			$cols_class = trim( $cols_class );

			// Prepare a custom CSS class.
			$extra_class = str_replace( '_', '-', $id );
			$extra_class = sanitize_html_class( 'static-' . $extra_class );
			$extra_class = ( empty( $options['class'] ) ) ? $extra_class : $extra_class . ' ' . esc_attr( $options['class'] );
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
		 * Filter a HTML tag (close) for row.
		 *
		 * @since 4.0.0
		 * @param string $row_close HTML tag.
		 * @param int    $index     Index, name, or ID of the static area.
		 */
		$row_close = apply_filters( 'cherry_static_area_row_close', '</div>', $index );

		// 'Row' wrap close.
		echo $row_close;

		/**
		 * Filter a HTML tag (close) for container.
		 *
		 * @since 4.0.0
		 * @param string $container_close HTML tag.
		 * @param int    $index           Index, name, or ID of the static area.
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
	 * Prepare a CSS-class for columns.
	 *
	 * @since  4.0.0
	 * @param  string &$col_value CSS-class prefix.
	 * @param  string $col_key    Key for current value.
	 * @param  array  $options    Static options.
	 * @return void
	 */
	public static function prepare_column_class( &$col_value, $col_key, $options ) {

		if ( empty( $options[ $col_value ] ) ) {
			$col_value = '';
			return;
		}

		if ( 'none' == $options[ $col_value ] ) {
			$col_value = '';
			return;
		}

		$col_value = $col_value . '-' . preg_replace( '/[^0-9]/', '', $options[ $col_value ] );
	}

	/**
	 * Whether a static area is in use (not empty).
	 *
	 * @since  4.0.0
	 * @global array $cherry_registered_static_areas Registered static areas.
	 * @param  mixed $index         Static area id.
	 * @param  mixed $saved_statics Saved static options.
	 * @return bool                 True if the static area is in use, false otherwise.
	 */
	public static function is_active_static_area( $index, $saved_statics ) {
		global $cherry_registered_statics;

		foreach ( $saved_statics as $id => $static ) :

			if ( empty( $cherry_registered_statics[ $id ] ) ) {
				continue;
			}

			if ( ! isset( $static['options']['area'] ) ) {
				continue;
			}

			if ( $index != $static['options']['area'] ) {
				continue;
			}

			if ( true !== self::is_visible_static( $static ) ) {
				continue;
			}

			self::$visible_statics[ $static['options']['area'] ][] = $static['id'];

		endforeach;

		if ( ! empty( self::$visible_statics[ $index ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Determine whether the static should be displayed based on conditions set by the user.
	 *
	 * @since  4.0.0
	 * @author JP Bot
	 * @author Cherry Team <support@cherryframework.com>
	 * @param  array $static The static settings.
	 * @return array         Settings to display or bool false to hide.
	 */
	public static function is_visible_static( $static ) {
		global $wp_query;

		if ( empty( $static['conditions'] ) || empty( $static['conditions']['rules'] ) ) {
			return true;
		}

		/**
		 * Store the results of all in-page condition lookups so that multiple widgets
		 * with the same visibility conditions don't result in duplicate DB queries.
		 */
		static $condition_result_cache = array();

		$condition_result = false;

		foreach ( $static['conditions']['rules'] as $rule ) {
			$condition_key = $rule['major'] . ':' . $rule['minor'];

			if ( isset( $condition_result_cache[ $condition_key ] ) ) {

				$condition_result = $condition_result_cache[ $condition_key ];
			} else {

				switch ( $rule['major'] ) {
					case 'date':
						switch ( $rule['minor'] ) {
							case '':
								$condition_result = is_date();
								break;
							case 'month':
								$condition_result = is_month();
								break;
							case 'day':
								$condition_result = is_day();
								break;
							case 'year':
								$condition_result = is_year();
								break;
						}
					break;
					case 'page':
						switch ( $rule['minor'] ) {
							case '404':
								$condition_result = is_404();
								break;
							case 'search':
								$condition_result = is_search();
								break;
							case 'archive':
								$condition_result = is_archive();
								break;
							case 'posts':
								$condition_result = $wp_query->is_posts_page;
								break;
							case 'front':
								$condition_result = is_front_page() && !is_paged();
								break;
							default:
								$post_type = substr( $rule['minor'], 10 );

								if ( 'post_type-' == substr( $rule['minor'], 0, 10 ) ) {
									$condition_result = ( 'page' == $post_type ) ? is_singular( $post_type ) || $wp_query->is_posts_page : is_singular( $post_type );
								} elseif ( get_post_field( 'post_name', get_option( 'page_for_posts' ) ) == $rule['minor'] ) {
									// If $rule['minor'] is a page slug which is also the posts page.
									$condition_result = $wp_query->is_posts_page;
								} else {
									// $rule['minor'] is a page slug.
									$condition_result = is_page( $rule['minor'] );
								}
								break;
						}
						break;
					case 'tag':
						if ( ! $rule['minor'] && is_tag() ) {
							$condition_result = true;
						} else if ( is_singular() && $rule['minor'] && has_tag( $rule['minor'] ) ) {
							$condition_result = true;
						} else {
							$tag = get_term_by( 'slug', $rule['minor'], 'post_tag' );

							if ( $tag && is_tag( $tag->slug ) )
								$condition_result = true;
						}
						break;
					case 'category':
						if ( ! $rule['minor'] && is_category() ) {
							$condition_result = true;
						} else if ( is_category( $rule['minor'] ) ) {
							$condition_result = true;
						} else if ( is_singular() && $rule['minor'] && in_array( 'category', get_post_taxonomies() ) && has_category( $rule['minor'] ) ) {
							$condition_result = true;
						}
						break;
					case 'loggedin':
						$condition_result = is_user_logged_in();

						if ( 'loggedin' !== $rule['minor'] ) {
							$condition_result = ! $condition_result;
						}
						break;
					case 'author':
						$post = get_post();

						if ( ! $rule['minor'] && is_author() ) {
							$condition_result = true;
						} else if ( $rule['minor'] && is_author( $rule['minor'] ) ) {
							$condition_result = true;
						} else if ( is_singular() && $rule['minor'] && $rule['minor'] == $post->post_author ) {
							$condition_result = true;
						}
						break;
					case 'role':
						if( is_user_logged_in() ) {
							global $current_user;

							get_currentuserinfo();

							$user_roles = $current_user->roles;

							if( in_array( $rule['minor'], $user_roles ) ) {
								$condition_result = true;
							} else {
								$condition_result = false;
							}

						} else {
							$condition_result = false;
						}
						break;
					case 'taxonomy':
						// $term[0] = taxonomy name; $term[1] = term slug
						$term = explode( '_tax_', $rule['minor'] );

						if ( ! isset( $term[1] ) ) {

							if ( ! $rule['minor'] && is_tax() ) {
								$condition_result = true;
							} else if ( is_tax( $rule['minor'] ) ) {
								$condition_result = true;
							}

						} else {

							if ( is_tax( $term[0], $term[1] ) ) {
								$condition_result = true;
							} else if ( is_singular() && $term[1] && has_term( $term[1], $term[0] ) ) {
								$condition_result = true;
							} else if ( is_singular() && $post_id = get_the_ID() ) {
								$terms = get_the_terms( $post_id, $rule['minor'] );

								if ( $terms && ! is_wp_error( $terms ) ) {
									$condition_result = true;
								}
							}
						}

					break;
				}

				if ( $condition_result ) {
					$condition_result_cache[ $condition_key ] = $condition_result;
				}
			}

			if ( $condition_result ) {
				break;
			}
		}

		$result = true;

		if ( ( 'show' == $static['conditions']['action'] && ! $condition_result )
			|| ( 'hide' == $static['conditions']['action'] && $condition_result )
			) {
			$result = false;
		}

		/**
		 * Filter a some condition rule.
		 *
		 * @since 4.0.0
		 * @param bool  $result Condition rule result.
		 * @param array $static Static options.
		 */
		return apply_filters( 'cherry_is_visible_static', $result, $static );
	}

	/**
	 * Check if static area are registered.
	 *
	 * @since  4.0.6
	 * @global array   $cherry_registered_statics Registered statics.
	 * @param  string  $id                        Area ID.
	 * @return boolean
	 */
	public static function is_registered_area( $id ) {
		global $cherry_registered_static_areas;

		return isset( $cherry_registered_static_areas[ $id ] ) ? true : false;
	}

	/**
	 * Custom compare function.
	 *
	 * @since  4.0.0
	 * @param  int $a Operand 1.
	 * @param  int $b Operand 2.
	 * @return int    Result.
	 */
	public static function compare( $a, $b ) {

		if ( intval( $a['options']['position'] ) == intval( $b['options']['position'] ) ) {
			return 0;
		}

		return ( $a['options']['position'] < $b['options']['position'] ) ? -1 : 1;
	}
}
