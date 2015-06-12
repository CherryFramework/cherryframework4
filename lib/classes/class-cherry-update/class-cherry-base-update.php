<?php
/**
 * Class for the base update
 *
 * @package    Cherry_Base_Update
 * @subpackage Bace_Update
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if( !class_exists( 'Cherry_Base_Update' ) ) {

	//define('CHERRY_UPDATE', false);
	//define('CHERRY_ALPHA_UPDATE', true);
	//define('CHERRY_BETA_UPDATE', true);

	class Cherry_Base_Update {
		protected $api = array(
				'version'			=> '',
				'slug'				=> '',
				'hub_url'			=> 'https://github.com/',
				'api_url'			=> 'https://api.github.com/repos/',
				'product_name'		=> 'CherryFramework',
				'repository_name'	=> '',
				'brunch_name'		=> 'master',
				'important_release'	=> '-imp',
				'alpha_release'		=> '-alpha', //To alpha update need constant CHERRY_ALPHA_UPDATE - true
				'beta_release'		=> '-beta', //To beta update need constant CHERRY_BETA_UPDATE - true
				'sslverify'			=> true
			);

		protected function bace_init( $attr = array() ){
			$this ->api = array_merge( $this ->api, $attr );

			add_filter( 'upgrader_source_selection', array( $this, 'rename_github_folder' ), 11, 3 );
		}

		protected function check_update() {
			$query = $this -> api[ 'api_url' ] . $this -> api[ 'product_name' ] . '/' . $this -> api[ 'repository_name' ] . '/tags';
			$response = $this -> remote_query( $query );
			$new_version = false;
			$url = '';
			$package = '';

			if( $response ){

				$response = array_reverse( $response );
				$last_update = count( $response )-1;
				$current_version = $this -> api[ 'version' ];

				foreach ($response as $key => $update) {

					$get_new_version = strtolower( $update->name );
					$update_label = preg_replace( '/[v]?[\d\.]+[v]?/', '', $get_new_version );
					$get_new_version = preg_replace( '/[^\d\.]/', '', $get_new_version );

					$this -> api[ 'details_url' ] = 'https://github.com/' . $this -> api[ 'product_name' ] . '/' . $this -> api[ 'slug' ] . '/releases/tag/' . $update->name;
					$package = $update->zipball_url;

					if( version_compare ( $get_new_version, $current_version ) > 0 && strpos( $update_label, $this -> api[ 'important_release' ] ) !== false ){

						$new_version = $get_new_version;
						break;
					}

					if( version_compare ( $get_new_version, $current_version ) > 0 && $key === $last_update ){

						if($update_label !== $this -> api[ 'alpha_release' ] && $update_label !== $this -> api[ 'beta_release' ]
						 || $update_label === $this -> api[ 'alpha_release' ] && @constant ( 'CHERRY_ALPHA_UPDATE' ) == true
						 || $update_label === $this -> api[ 'beta_release' ] && @constant ( 'CHERRY_BETA_UPDATE' ) == true ){

							$new_version = $get_new_version;

						}
						break;
					}
				}

				return array( 'version' => $new_version, 'package' => $package );
			}
		}

		protected function remote_query( $query ) {
			$response = wp_remote_get( $query , array( 'sslverify' => $this -> api[ 'sslverify' ] , 'user-agent' => $this -> api[ 'product_name' ] ) );

			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != '200') {
				return false;
			}

			$response = json_decode( $response[ 'body' ] );

			return $response;
		}

		public function rename_github_folder( $upgrate_dir, $remote_dir, $skin_upgrader ){
			$skin_theme = isset($skin_upgrader ->skin ->theme) ? $skin_upgrader ->skin ->theme : '' ;
			$skin_plugin = isset($skin_upgrader ->skin ->plugin) ? $skin_upgrader ->skin ->plugin : '' ;

			if( $skin_theme === $this -> api[ 'slug' ] || $skin_plugin === $this -> api[ 'slug' ] ){
				$upgrate_dir_path = pathinfo( $upgrate_dir );
				$new_upgrate_dir = trailingslashit( $upgrate_dir_path[ 'dirname' ] ) . trailingslashit( $this -> api[ 'slug' ] );

				rename( $upgrate_dir, $new_upgrate_dir );

				$upgrate_dir = $new_upgrate_dir;
			}
			return $upgrate_dir;
		}
	}
}
?>