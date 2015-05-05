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
 * Header Logo static.
 */
class cherry_footer_logo_static extends cherry_register_static {

	function __construct( $args ) {
		add_action( 'cherry-options-updated',  array( $this, 'clear_cache' ) );
		add_action( 'cherry-section-restored', array( $this, 'clear_cache' ) );
		add_action( 'cherry-options-restored', array( $this, 'clear_cache' ) );
		add_action( 'customize_save_after', array( $this, 'clear_cache' ) );
		add_action( 'update_option', array( $this, 'clear_cache_options' ) );
		parent::__construct( $args );
	}

	/**
	 * Callback-method for registered static.
	 *
	 * @since 4.0.0
	 */
	public function callback() {

		global $wp_customize;

		if ( isset( $wp_customize ) ) {
			echo cherry_get_footer_logo();
			return;
		}

		$logo = get_transient( 'cherry_footer_logo' );

		if ( $logo ) {
			echo $logo;
			return;
		}

		$result = cherry_get_footer_logo();

		echo $result;

		set_transient( 'cherry_footer_logo', $result, DAY_IN_SECONDS );
	}

	/**
	 * Clear logo cache.
	 *
	 * @since 4.0.0
	 */
	public function clear_cache() {
		delete_transient( 'cherry_footer_logo' );
	}

	/**
	 * Clear cache on options update.
	 *
	 * @since 4.0.0
	 */
	function clear_cache_options( $option ) {

		if ( ! in_array( $option, array( 'blogname' ) ) ) {
			return;
		}

		delete_transient( 'cherry_footer_logo' );
	}
}

/**
 * Registration for Header Logo static.
 */
new cherry_footer_logo_static(
	array(
		'id'      => 'footer_logo',
		'name'    => __( 'Footer Logo', 'cherry' ),
		'options' => array(
			'col-xs'   => 'col-xs-12',
			'col-sm'   => 'col-sm-12',
			'col-md'   => 'col-md-6',
			'col-lg'   => 'col-lg-6',
			'position' => 1,
			'area'     => 'footer-top',
		)
	)
);