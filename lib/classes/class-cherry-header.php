<?php
/**
 * Class for the control static elements in a header.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
class Cherry_Header {

	public static $columns = 12;
	public static $columns_count = 0;
	public static $row_class = 0;
	public static $row_closed = true;
	protected static $instance = null;

	public function __construct() {
		$this->init();
	}

	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init() {
		// Define the array of defaults.
		$defaults = self::statics();
		$statics  = get_option( 'cherry_header_statics', array() );

		// if ( empty( $statics ) ) {
		// 	$statics = $defaults;
		// 	update_option( 'cherry/header/statics', $statics );
		// } else {
		// 	$diff = array_diff( $defaults, $statics );
		// 	var_dump($diff);

		// 	if ( !empty( $diff ) ) {
				$statics = wp_parse_args( $statics, $defaults );
				// update_option( 'cherry_header_statics', $statics );
		// 	}
		// }

		// Sort an array with a user-defined comparison function and maintain index association.
		uasort( $statics, array( $this, 'compare') );
		update_option( 'cherry_header_statics', $statics );

		// foreach ( (array) $statics as $id => $data ) :

		// 	if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) {
		// 		$func = $data['function'];
		// 	} elseif ( is_callable( array( $this, $id ) ) ) {
		// 		$func = array( $this, $id );
		// 	} else {
		// 		continue;
		// 	}

		// 	self::$columns_count += $data['col'];

		// 	// Open (first) row.
		// 	if ( self::$row_closed ) {
		// 		$this->row_open( ++self::$row_class );
		// 		self::$row_closed = false;
		// 	}

		// 	if ( self::$columns_count > self::$columns ) {
		// 		$this->row_close( self::$row_class );
		// 		$this->row_open( ++self::$row_class );
		// 		self::$columns_count = 0;
		// 	}

		// 		// Open column.
		// 		$this->col_open( $data['col'] );
		// 			;

		// 			// Call a static function.
		// 			call_user_func( $func );

		// 		// Close column.
		// 		$this->col_close();

		// endforeach;

		// // Close row.
		// $this->row_close( self::$row_class );

		
	}

	public function row_open( $class) {
		$row_open = apply_filters( 'cherry_header_row_open', sprintf( '<div class="full-row-%s"><div class="container"><div class="row">', esc_attr( $class ) ) );
		echo $row_open;
	}

	public function row_close( $class ) {
		$row_close = apply_filters( 'cherry_header_row_close', "</div></div></div><!--.full-row-$class-->" );
		echo $row_close;
	}

	public function col_open( $column ) {
		$output = sprintf( '<div class="col-lg-%s">', absint( $column ) );
		$output = apply_filters( 'cherry_header_col_open', $output );
		echo $output;
	}

	public function col_close() {
		$output = apply_filters( 'cherry_header_col_close', '</div>' );
		echo $output;
	}

	/**
	 * Prints HTML with Header Logo.
	 *
	 * @since 4.0.0
	 */
	public function logo() {

		if ( cherry_get_site_title() || cherry_get_site_description() ) {

			$data = self::statics( 'logo' );
			printf( '<div class="site-branding %1$s">%2$s %3$s</div>',
				esc_attr( $data['class'] ),
				cherry_get_site_title(),
				cherry_get_site_description()
			);

		}
	}

	/**
	 * Prints HTML with Primary Menu.
	 *
	 * @since 4.0.0
	 */
	public function menu() {
		cherry_get_menu_template( 'primary' );
	}

	/**
	 * Prints HTML with Search Form.
	 *
	 * @since 4.0.0
	 */
	public function searchform() {
		get_search_form( true );
	}

	/**
	 * Statics.
	 *
	 * @since  4.0.0
	 * @return array
	 */
	public static function statics( $static = false ) {
		/**
		 * Filters an array with default static elements.
		 *
		 * @since 4.0.0
		 * @var   array
		 */
		$statics = apply_filters( 'cherry_header_statics_defaults', array(
			'logo' => array(
				'name'     => __( 'Logo', 'cherry' ),
				'col'      => 6,
				'class'    => 'custom_logo',
				'priority' => 1,
				'area' => 1,
			),
			'menu' => array(
				'name'     => __( 'Main Menu', 'cherry' ),
				'col'      => 6,
				'class'    => 'custom_main_menu',
				'priority' => 2,
				'area' => 1,
			),
			'searchform' => array(
				'name'     => __( 'Search Form', 'cherry' ),
				'col'      => 8,
				'class'    => 'custom_search_form',
				'priority' => 3,
				'area' => 1,
			),
			'loginout' => array(
				'name'     => __( 'Login/Logout Menu', 'cherry' ),
				'col'      => 4,
				'class'    => 'custom_loginout_menu',
				'priority' => 11,
				'area' => 1,
			),
			'custom_menu' => array(
				'name'     => __( 'Custom Menu', 'cherry' ),
				'col'      => 5,
				'class'    => 'custom_menu',
				'priority' => 15,
				'area' => 1,
			),
		) );

		if ( is_string( $static ) ) {
			return $statics[ sanitize_text_field( $static ) ];
		}

		// Get a supported statics.
		$support = get_theme_support( 'cherry-header-statics' );

		foreach ( $statics as $id => $data ) {
			if ( !in_array( $id, $support[0] ) ) {
				unset( $statics[ $id ] );
			}
		}

		/**
		 * Filters an array with static elements.
		 *
		 * Must used for add a custom static elements in header.
		 *
		 * @since 4.0.0
		 * @var   array
		 */
		$statics = apply_filters( 'cherry_header_statics', $statics );

		return $statics;
	}

	/**
	 * Custom compare function
	 *
	 * @since  4.0.0
	 * @param  int $v1
	 * @param  int $v2
	 * @return [type]     [description]
	 */
	public function compare( $v1, $v2 ) {

		if ( $v1['priority'] == $v2['priority'] ) {
			return 0;
		}

		return ( $v1['priority'] < $v2['priority'] ) ? -1 : 1;
	}

}

add_action( 'cherry_header', array( 'Cherry_Header', 'get_instance') );