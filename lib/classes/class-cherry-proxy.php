<?php
/**
 * Class for the set proxy framework.
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

if( !class_exists('Cherry_Set_Proxy') ) {

	class Cherry_Set_Proxy {
		/**
		 * Holds the instances of this class.
		 *
		 * @since 4.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Initialize the .
		 *
		 * @since 4.0.0
		 */
		public function __construct() {
			if(self::is_proxy()){
				$proxy_settings = get_option('proxy_settings');
				if( isset($proxy_settings['ip']) && isset($proxy_settings['port']) ){
					if( self::set_proxy_settings($proxy_settings) ){
						return;
					}
				}

				$proxy_settings = self::get_proxy_settings();
				if( $proxy_settings['ip'] && $proxy_settings['port'] ){
					if( self::set_proxy_settings($proxy_settings) ){
						return;
					}
				}

				$proxy_settings = isset($_POST['cherry']) ? $_POST['cherry'] : false ;
				if(isset($proxy_settings['ip']) && isset($proxy_settings['port'])){
					if( self::set_proxy_settings($proxy_settings) ){
						return;
					}
				}

				add_action( 'admin_init', array( __CLASS__ , 'add_notice' ) );
			}
		}

		/**
		 * Check use proxy or not.
		 *
		 * @since 4.0.0
		 * @return boolean [If server use proxy function return true else false]
		 */
		public static function is_proxy(){
			$server_port = array(
				'8080',
				'80',
				'81',
				'1080',
				'6588',
				'8000',
				'3128',
				'553',
				'554',
				'4480'
			);
			foreach($server_port as $port) {
				$response = @fsockopen($_SERVER['REMOTE_ADDR'], $port, $errno, $errstr, 30);
				if ($response) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Get server proxy settings.
		 *
		 * @since 4.0.0
		 * @return array [Return proxy ip and port]
		 */
		public static function get_proxy_settings() {
			$proxy_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '' ;
			$proxy_port = isset($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_VIA'] : '' ;

			return array( 'ip' => $proxy_ip, 'port' => $proxy_port);
		}

		/**
		 * Set constant WP_PROXY_HOST and WP_PROXY_PORT.
		 *
		 * @since 4.0.0
		 *
		 */
		public static function set_proxy_settings($proxy_settings) {
			$proxy_ip = preg_replace('/[^\d\.]/', '', $proxy_settings['ip']);
			$proxy_port = preg_replace('/\D+/', '', $proxy_settings['port']);

			if ( !defined('WP_PROXY_HOST') ){
				define( 'WP_PROXY_HOST', $proxy_ip );
			}
			if ( !defined('WP_PROXY_PORT') ){
				define( 'WP_PROXY_PORT', $proxy_port );
			}

			$connect = @fsockopen($proxy_ip, $proxy_port, $errn, $errst, 30);

			update_option('proxy_settings',  array( 'ip' => $proxy_ip, 'port' => $proxy_port));

			if(!$connect){
				return false;
			}

			return true;
		}
		/**
		 * Outputs settings form
		 *
		 * @since 4.0.0
		 *
		 */
		public static function add_notice(){
			$builder = new Cherry_Interface_Builder(array('pattern'=> ''));

			$proxy_settings = get_option('proxy_settings');
			$proxy_info_text = !$proxy_settings ? __( 'CherryFramework can not access updates server. Please make sure your proxy settings are correct.', 'cherry' ) : __( 'Proxy setting incorrect.', 'cherry' );

			$content = '<p>';
				$content .= '<strong>';
					$content .= $proxy_info_text;
				$content .= '</strong>';
			$content .= '</p>';
			$content .= '<form class="cherry-ui-core" method="post" action="" >';

				$content .= '<div>';
				$content .= $builder->add_form_item( array(
					'id' => 'ip',
					'type'=>'text',
					'class'=>'required',
					'label' => __( 'Proxy IP:', 'cherry' )));
				$content .= '</div>';

				$content .= '<div>';
				$content .= $builder->add_form_item( array(
					'id' => 'port',
					'type'=>'text',
					'class'=>'required',
					'label' => __( 'Proxy Port:', 'cherry' )));
				$content .= '</div>';

				$content .= '<div id="submit-button">';
				$content .= get_submit_button( __( 'Save Settings', 'cherry' ), 'button-primary_', 'submit', false);
				$content .= '</div>';
			$content .= '</form>';

			$notice = new UI_Notice( array( 'id' => 'proxy-settings', 'content' => $content, 'type' => 'warning', 'display_on_page' => array("themes.php", "update-core.php") ) );
		}
		/**
		 * Returns the instance.
		 *
		 * @since  4.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
	Cherry_Set_Proxy::get_instance();
}
?>