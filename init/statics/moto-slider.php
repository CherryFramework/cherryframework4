<?php
/**
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
/**
 * MotoPress Slider static.
 */
class cherry_moto_slider_static extends cherry_register_static {
	function __construct( $options ) {
		add_filter( 'cherry_header_options_list', array( $this, 'set_slider_options' ) );
		parent::__construct( $options );
	}
	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.0
	 * @since 4.0.4 - prevent PHP errors if MotoPress slider not installed
	 */
	public function callback() {
		$alias = cherry_get_option( 'moto-slider-alias' );

		if ( ! $alias ) {
			return;
		}

		if ( ! function_exists( 'motoPressSlider' ) ) {
			return;
		}

		motoPressSlider($alias);
	}
	/**
	 * Define a slider options.
	 *
	 * @since 4.0.0
	 */
	public function set_slider_options( $options ) {
		$select_options = $this->get_sliders_list();
		$options['moto-slider-alias'] = array(
			'type'        => 'select',
			'title'       => __( 'Select MotoSlider to appear in header', 'cherry' ),
			'decsription' => __( 'Select main theme slider', 'cherry' ),
			'value'       => '',
			'class'       => 'width-full',
			'options'     => $select_options,
		);
		return $options;
	}
	/**
	 * Get avaliable MotoPress sliders list.
	 *
	 * @since 4.0.0
	 */
	public function get_sliders_list() {
		global $wpdb;
		$table = $wpdb->prefix . 'mpsl_sliders';
		$result = $wpdb->get_results(
			"SELECT * FROM $table ORDER BY id ASC",
			ARRAY_A
		);
		if ( empty( $result ) ) {
			return array( '0' => __( 'No Moto Sliders was found ', 'cherry' ) );
		}
		foreach ( $result as $row ) {
			$return[$row['alias']] = $row['title'];
		}
		return $return;
	}
}
/**
 * Registration for MotoPress Slider static (only if MotoPress Slider plugin is active).
 */
if ( in_array(
	'motopress-slider/motopress-slider.php',
	apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
) ) {
	new cherry_moto_slider_static(
		array(
			'id'       => 'moto-slider',
			'name'     => __( 'MotoPress Slider', 'cherry' ),
			'options'  => array(
				'col-lg'   => 'col-lg-12',
				'col-md'   => 'col-md-12',
				'col-sm'   => 'col-sm-12',
				'col-xs'   => 'col-xs-12',
				'class'    => 'moto-slider',
				'position' => 1,
				'area'     => 'showcase-area',
			)
		)
	);
}
