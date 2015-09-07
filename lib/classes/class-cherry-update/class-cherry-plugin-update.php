<?php
/**
 * Class for the update plugins.
 *
 * @package    Cherry_Base_Update
 * @subpackage Plugins_Update
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

if( !class_exists( 'Cherry_Plugin_Update' ) ) {
	require( 'class-cherry-base-update.php' );

	class Cherry_Plugin_Update extends Cherry_Base_Update {

		public function init( $attr = array() ){
			if( @constant ( 'CHERRY_UPDATE' ) !== false ){
				$this -> base_init( $attr );

				//Need for test update
				//set_site_transient('update_plugins', null);

				add_action( 'pre_set_site_transient_update_plugins', array( $this, 'update' ) );
				add_filter( 'upgrader_source_selection', array( $this, 'rename_github_folder' ), 11, 3 );
				add_action( 'admin_footer', array( $this, 'change_details_url' ) );
			}
		}

		public function update( $data ) {
			$new_update = $this -> check_update();

			if( $new_update[ 'version' ] ){
				$this->api[ 'plugin' ] = $this->api[ 'slug' ] . '/' . $this->api[ 'slug' ] . '.php';

				$update = new stdClass();

				$update -> slug = $this->api[ 'slug' ];
				$update -> plugin = $this->api[ 'plugin' ];
				$update -> new_version = $new_update[ 'version' ];
				$update -> url = $this->api[ 'details_url' ];
				$update -> package = $new_update[ 'package' ];

				$data -> response[ $this->api[ 'plugin' ] ] = $update;

			}

			return $data;
		}

		public function change_details_url(){
			global $change_details_plugin_url_script, $pagenow;

			$plugins = get_plugin_updates();

			if(!$change_details_plugin_url_script && in_array($pagenow, array( 'update-core.php', 'plugins.php' ) ) && !empty( $plugins ) ){

				$plugins_string = '';

				foreach ( $plugins as $plugin_key => $plugin_value ) {
					$plugin_key = strtolower( $plugin_key );
					if( strpos( $plugin_key, 'cherry' ) !== false ){
						$plugins_string .= '"' . $plugin_value ->update ->slug . '" : "' . $plugin_value ->update ->url .'", ';
					}
				}

				?>
				<script>
					( function( $ ){
						var plugin_updates = {<?php echo $plugins_string; ?>};
						for ( var plugin in plugin_updates ) {
							$('[href*="' + plugin + '"].thickbox').removeClass('thickbox').attr( {'href': plugin_updates[plugin], 'target' : "_blank" } );
						};
					}( jQuery ) )
				</script>
				<?php
			}

			$change_details_plugin_url_script = true;
		}
	}
}
?>