<?php
/**
 * Class for the update framework.
 *
 * @package    Cherry_Base_Update
 * @subpackage Themes_Update
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Cherry_Theme_Update' ) ) {
	require( 'class-cherry-base-update.php' );

	/**
	 * Define theme updater class.
	 *
	 * @since 4.0.0
	 */
	class Cherry_Theme_Update extends Cherry_Base_Update {

		/**
		 * Init class parameters.
		 *
		 * @since  4.0.0
		 * @param  array $attr Input attributes array.
		 * @return void
		 */
		public function init( $attr = array() ) {

			if ( defined( 'CHERRY_UPDATE' ) && false === CHERRY_UPDATE ) {
				return;
			}

			$this->base_init( $attr );

			/**
			 * Need for test update - set_site_transient( 'update_plugins', null );
			 */

			add_action( 'pre_set_site_transient_update_themes', array( $this, 'update' ), 99, 1 );
			add_filter( 'upgrader_source_selection', array( $this, 'rename_github_folder' ), 11, 3 );
			add_filter( 'wp_prepare_themes_for_js', array( $this, 'change_details_url' ) );
		}

		/**
		 * Process update.
		 *
		 * @since  4.0.0
		 * @param  object $data Update data.
		 * @return object
		 */
		public function update( $data ) {
			$new_update = $this->check_update();

			if ( $new_update['version'] ) {

				$update = array(
					'theme'       => $this->api[ 'slug' ],
					'new_version' => $new_update['version'],
					'url'         => $this->api[ 'details_url' ],
					'package'     => $new_update['package'],
				);

				$data->response[ $this->api['slug'] ] = $update;
			}

			return $data;
		}

		/**
		 * Change plugin detail URL.
		 *
		 * @since  4.0.0
		 * @param  array $prepared_themes
		 * @return void
		 */
		public function change_details_url( $prepared_themes ) {

			if ( ! empty( $prepared_themes ) ) {

				foreach ( $prepared_themes as $theme_key => $theme_value ) {

					if ( 'cherryframework4' === $theme_key || 'Cherry Framework' === $theme_value['parent'] ){

						if ( $theme_value['hasUpdate'] ) {

							$prepared_themes[$theme_key]['update'] = str_replace( 'class="thickbox"', 'target ="_blank"', $theme_value['update'] );
						}

						remove_filter( 'wp_prepare_themes_for_js', array( $this, 'change_details_url' ) );
					}
				}
			}

			return $prepared_themes;
		}
	}

	$Cherry_Theme_Update = new Cherry_Theme_Update();
	$Cherry_Theme_Update->init( array(
		'slug'            => get_template(),
		'version'         => CHERRY_VERSION,
		'repository_name' => 'cherryframework4',
	) );
}
