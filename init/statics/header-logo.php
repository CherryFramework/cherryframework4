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
class cherry_header_logo_static extends cherry_register_static {

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
			echo $this->get_logo();
			return;
		}

		$logo = get_transient( 'cherry_logo' );
		$page = is_front_page() ? 'home' : 'page';

		if ( is_array( $logo ) && ! empty( $logo[$page] ) ) {
			echo $logo[$page];
			return;
		}

		$result = $this->get_logo();

		echo $result;

		if ( is_array( $logo ) ) {
			$logo[ $page ] = $result;
		} else {
			$logo = array(
				$page => $result
			);
		}

		set_transient( 'cherry_logo', $logo, DAY_IN_SECONDS );
	}

	/**
	 * Get logo HTML
	 *
	 * @since  4.0.0
	 */
	public function get_logo() {

		$result = sprintf( '<div class="site-branding">%1$s %2$s</div>',
			cherry_get_site_logo( 'header' ),
			cherry_get_site_description()
		);

		return $result;

	}

	/**
	 * Clear logo cache.
	 *
	 * @since 4.0.0
	 */
	public function clear_cache() {
		delete_transient( 'cherry_logo' );
	}

	/**
	 * Clear cache on options update.
	 *
	 * @since 4.0.0
	 */
	function clear_cache_options( $option ) {

		if ( ! in_array( $option, array( 'blogname', 'blogdescription' ) ) ) {
			return;
		}

		delete_transient( 'cherry_logo' );
	}
}

/**
 * Registration for Header Logo static.
 */
new cherry_header_logo_static(
	array(
		'id'      => 'header_logo',
		'name'    => __( 'Logo', 'cherry' ),
		'options' => array(
			'col-xs'   => 'col-xs-12',
			'col-sm'   => 'col-sm-12',
			'col-md'   => 'col-md-6',
			'col-lg'   => 'col-lg-6',
			'position' => 1,
			'area'     => 'header-top',
		)
	)
);