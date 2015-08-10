<?php
/**
 * Class for the base update
 *
 * @package    Cherry_Base_Update
 * @subpackage Base_Update
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
				'cloud_url'			=> 'https://cloud.cherryframework.com/cherry-update/',
				'product_name'		=> 'CherryFramework',
				'repository_name'	=> ''
			);

		protected function base_init( $attr = array() ){
			$this->api = array_merge( $this->api, $attr );
		}

		protected function check_update() {
			$args = array(
				'user-agent' => 'WordPress',
				'github_repository' => $this->api[ 'product_name' ] . '/' . $this->api[ 'repository_name' ],
				'current_version' => $this->api[ 'version' ],
				'up_query_limit' => false,
				'get_alpha' => false,
				'get_beta' => false
			);

			if( defined ( 'CHERRY_ALPHA_UPDATE' ) ){
				$args[ 'get_alpha' ] = true;
			}

			if( defined ( 'CHERRY_BETA_UPDATE' ) ){
				$args[ 'get_beta' ] = true;
			}

			if( defined ( 'CHERRY_UP_QUERY_LIMIT' ) ){
				$args[ 'up_query_limit' ] = true;
			}

			$response = $this -> remote_query( $args );

			if( $response && $response !=='not_update' ){
				$this->api[ 'details_url' ] = $response->details_url;
				return array( 'version' => $response->new_version, 'package' => $response->package );
			}

			return array( 'version' => false);
		}

		protected function remote_query( $args ) {
			$query = add_query_arg( $args, $this->api['cloud_url'] );

			$response = wp_remote_get( $query );

			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != '200') {
				return false;
			}

			$response = json_decode( $response[ 'body' ] );

			return $response;
		}

		public function rename_github_folder( $upgrate_dir, $remote_dir, $skin_upgrader ){

			$slug = $this->api[ 'slug' ];
			$is_theme = isset($skin_upgrader->skin->theme) || isset($skin_upgrader->skin->theme_info) ? true : false ;
			$is_plugin = isset($skin_upgrader->skin->plugin_info) ? true : false ;
			$domain_plugin = $is_plugin ? $skin_upgrader->skin->plugin_info[ 'TextDomain' ] : '' ;
			$title_plugin = $is_plugin ? str_replace(' ', '-', strtolower( $skin_upgrader->skin->plugin_info[ 'Title' ] ) ) : '' ;
			$name_plugin = $is_plugin ? str_replace(' ', '-', strtolower( $skin_upgrader->skin->plugin_info[ 'Name' ] ) ) : '' ;

			if( $is_theme && strpos($upgrate_dir, $slug) !== false
				|| $is_plugin && $domain_plugin === $slug
				|| $is_plugin && $title_plugin === $slug
				|| $is_plugin && $name_plugin === $slug
			){
				$upgrate_dir_path = pathinfo( $upgrate_dir );
				$new_upgrate_dir = trailingslashit( $upgrate_dir_path[ 'dirname' ] ) . trailingslashit( $slug );

				rename( $upgrate_dir, $new_upgrate_dir );

				$upgrate_dir = $new_upgrate_dir;

				remove_filter( 'upgrader_source_selection', array( $this, 'rename_github_folder' ), 11, 3 );
			}

			return $upgrate_dir;
		}
	}
}
?>