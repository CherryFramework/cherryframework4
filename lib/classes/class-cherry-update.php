<?php
/**
 * Class for the update framework.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if( !class_exists('Cherry_Update') ) {

	class Cherry_Update {
		public static $api = array(
				'versions' => CHERRY_VERSION,
				'product_name' => 'CherryFramework',
				'repository_name' => 'cherryframework4',
				'brunch_name' => 'master',
				'hub_url' => 'https://github.com/',
				'api_url' => 'https://api.github.com/repos/',
				'html_url' => 'www.cherryframework.com/blog',//www.cherryframework.com/blog/version-4.0.0
				'sslverify' => true,
				'important_release' => '-imp',
				'alpha_release' => '-alpha', //To alpha update need constant CHERRY_ALPHA_UPDATE - true
				'beta_release' => '-beta', //To beta update need constant CHERRY_BETA_UPDATE - true 
				'template' => 'cherryframework4',
			);

		public function __construct($attr = array()){
			
			if( @constant ( 'CHERRY_UPDATE' ) !== false ){

				self::init($attr);
				//Need for test update
				//set_site_transient('update_themes', null);
				
				add_filter( 'pre_set_site_transient_update_themes', array( 'Cherry_Update' , 'update' ), 99, 1 );
				add_filter( 'upgrader_source_selection', array( 'Cherry_Update', 'rename_github_zip' ), 1, 3 );

				$current = get_transient('update_themes');
			}
		}

		public static function init($attr = array()){
			self::$api = array_merge(self::$api, $attr);

			$framework_info = wp_get_theme();
			self::$api[ 'template' ] = $framework_info->template;
		}

		public static function update($data) {
			$new_update = self::check_update();

			if($new_update['version']){
				$update = array(
					'theme' 		=> self::$api[ 'template' ],
					'new_version' 	=> $new_update['version'],
					'url'        	=> $new_update['url'],
					'package'     	=> $new_update['package'],
				);

				$data->response[ $update['theme'] ] = $update;
			}
			
			return $data;
		}

		public static function check_update() {
			$query = self::$api['api_url'].self::$api['product_name'].'/'.self::$api['repository_name'].'/tags';
			$response = self::remote_query( $query );
			$new_update = array( 'version' => false, 'url' => '', 'package' => '');

			if($response){

				$response = array_reverse($response);
				$last_update = count($response)-1;
				$current_version = self::$api['versions'];

				foreach ($response as $key => $update) {

					$get_version = strtolower ($update->name);
					$update_label = preg_replace('/[\d\.]/', '', $get_version);;
					$get_version = preg_replace('/[^\d\.]/', '', $get_version);
					

					if( version_compare ( $get_version, $current_version ) > 0 && strpos($update_label, self::$api['important_release']) !==false ){
						$new_update['version'] = $get_version;
						$new_update['url'] = self::$api['html_url'].'/version-'.$get_version;
						$new_update['package'] = $update->zipball_url;
						break;
					}

					if( version_compare ( $get_version, $current_version ) > 0 && $key === $last_update ){

						if($update_label !== self::$api[ 'alpha_release' ] && $update_label !== self::$api[ 'beta_release' ]
						 || $update_label === self::$api[ 'alpha_release' ] && @constant ( 'CHERRY_ALPHA_UPDATE' ) == true
						 || $update_label === self::$api[ 'beta_release' ] && @constant ( 'CHERRY_BETA_UPDATE' ) == true ){

							$new_update['version'] = $get_version;
							$new_update['url'] = self::$api['html_url'].'/version-'.$get_version;
							$new_update['package'] = $update->zipball_url;
						}

						break;
					}
				}

				return $new_update;
			}
		}

		public static function remote_query( $query ) {
			$response = wp_remote_get( $query , array('sslverify' => self::$api['sslverify'] , 'user-agent' => self::$api['product_name']) );

			if ( is_wp_error($response) || wp_remote_retrieve_response_code( $response ) != '200') {
				return false;
			}

			$response = json_decode($response['body']);

			return $response;
		}

		public function rename_github_zip( $upgrate_dir, $remote_dir, $theme_upgrader ){
		    if(  strpos( $upgrate_dir, self::$api['product_name'] ) === false ){
		        return $upgrate_dir;
		    }

		    $upgrate_dir_path = pathinfo($upgrate_dir);
		    $new_upgrate_dir = trailingslashit( $upgrate_dir_path['dirname'] ) . trailingslashit( self::$api['template'] );

		    rename($upgrate_dir, $new_upgrate_dir);
		    return $new_upgrate_dir;
		}
	}
	$Update = new Cherry_Update();
}
?>