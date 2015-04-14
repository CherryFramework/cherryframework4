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
 * Moto slider static
 */
class cherry_moto_slider_static extends cherry_register_static {

	function __construct( $options ) {
		add_filter( 'cherry_header_options_list', array( $this, 'set_slider_options' ) );
		parent::__construct( $options );
	}

	/**
	 * Callbck method for registered static
	 * @since 4.0.0
	 */
	public function callback() {

		$alias = cherry_get_option( 'moto_slider_alias' );

		if ( ! $alias ) {
			return;
		}
		motoPressSlider($alias);

	}

	/**
	 * Define slider options
	 * @since 4.0.0
	 */
	public function set_slider_options( $options ) {

		$select_options = $this->get_sliders_list();

		$options['moto_slider_alias'] = array(
			'type'        => 'select',
			'label'       => __( 'Select MotoSlider to show in header', 'cherry' ),
			'decsription' => __( 'Select main theme slider', 'cherry' ),
			'value'       => '',
			'class'       => 'width-full',
			'options'     => $select_options,
		);

		return $options;
	}


	/**
	 * Get avaliable motopress sliders list
	 * @since  4.0.0
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
 * Call Moto slider static registration (only if mot slider plugin is active)
 */
if ( in_array(
	'motopress-slider/motopress-slider.php',
	apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
) ) {
	new cherry_moto_slider_static(
		array(
			'id'       => 'moto-slider',
			'name'     => __( 'Moto Slider', 'cherry' ),
			'options'  => array(
				'col-lg'   => 'col-lg-12',
				'col-md'   => 'col-md-12',
				'col-sm'   => 'col-sm-12',
				'col-xs'   => 'col-xs-12',
				'class'    => 'moto-slider',
				'priority' => 1,
				'area'     => 'showcase-area',
			)
		)
	);

}