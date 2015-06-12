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
if ( !defined( 'WPINC' ) ) {
	die;
}

if( !class_exists( 'Cherry_Theme_Update' ) ) {
	require( 'class-cherry-base-update.php' );

	class Cherry_Theme_Update extends Cherry_Base_Update {

		public function init( $attr = array() ){
			if( @constant ( 'CHERRY_UPDATE' ) !== false ){
				$this -> bace_init( $attr );

				//Need for test update
				//set_site_transient('update_themes', null);

				add_action( 'pre_set_site_transient_update_themes', array( $this, 'update' ), 99, 1 );
				add_filter( 'wp_prepare_themes_for_js', array( $this, 'change_details_url' ) );
			}
		}

		public function update( $data ) {
			$new_update = $this -> check_update();

			if( $new_update[ 'version' ] ){

				$update = array(
					'theme' 		=> $this -> api[ 'slug' ],
					'new_version'	=> $new_update['version'],
					'url'			=> $this -> api[ 'details_url' ],
					'package'		=> $new_update['package'],
				);

				$data -> response[ $this -> api[ 'slug' ] ] = $update;
			}

			return $data;
		}

		public function change_details_url( $prepared_themes ){
			if( !empty( $prepared_themes ) ){

				foreach ( $prepared_themes as $theme_key => $theme_value ) {

					if( $theme_key === 'cherryframework4' || $theme_value['parent'] === 'Cherry Framework' ){

						if( $theme_value['hasUpdate'] ){

							$prepared_themes[$theme_key]['update'] = str_replace( 'class="thickbox"', 'target ="_blank"', $theme_value['update'] );
						}
					}
				}
			}
			return $prepared_themes;
		}
	}

	$Cherry_Theme_Update = new Cherry_Theme_Update();
	$Cherry_Theme_Update -> init( array(
			'slug'				=> get_template(),
			'version'			=> CHERRY_VERSION,
			'repository_name'	=> 'cherryframework4'
	));
}
?>