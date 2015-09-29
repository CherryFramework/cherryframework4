<?php
/**
 * Class for the building ui notice.
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

if ( ! class_exists( 'UI_Notice' ) ) {
	class UI_Notice {

		private static $settings = array(
				'id'				=> '',
				'type'				=> 'error', //error, info, warning
				'class'				=> '',
				'content'			=> '',
				'button_text'		=> '',
				'button_close'		=> true,
				'display_on_page'	=> array(),
		);

		/**
		 * Constructor method for the UI_Notice class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {
			self::$settings = wp_parse_args( $args, self::$settings );

			add_action( 'admin_enqueue_scripts',  array( __CLASS__ , 'enqueue_assets' ) );

			add_action( 'admin_notices', array( __CLASS__ , 'add_notice' ), 1 );
			add_action( 'admin_init', array( __CLASS__ , 'hide_notice' ), 1 );
		}

		/**
		 * Action show notice.
		 *
		 * @since  4.0.0
		 */
		public static function add_notice() {
			global $pagenow;
			if ( is_admin()
				 && !get_user_meta( get_current_user_id(), '_wp_hide_notice', true )
				 && in_array( $pagenow, self::$settings['display_on_page'] ) ){

				$id = self::$settings['id'];
				$class = self::$settings['type'] . ' notice hidden ' . self::$settings['class'];

				$html = '<div id="' . $id . '" class="' . $class . '">';
					if(self::$settings['button_close']){
						$html .= '<a href = "' . esc_url( add_query_arg( $id, wp_create_nonce( $id ) ) ) . '" title = "' . __( self::$settings['button_text'], 'cherry' ) . '">';
						$html .= self::$settings['button_text'] ? '<span>' . __( self::$settings['button_text'], 'cherry' ) . '</span>' : '' ;
						$html .= '</a>';
						$html .= self::$settings['content'];
					}
				$html .= '</div>';
				echo  $html;
			}
		}

		/**
		 * Action hide notice.
		 *
		 * @since  4.0.0
		 */
		public static function hide_notice() {
			$id = self::$settings['id'];

			if ( ! isset( $_GET[$id] ) ) {
				return;
			}

			check_admin_referer( $id, $id );
			update_user_meta( get_current_user_id(), '_wp_hide_notice', 1 );
		}

		/**
		 * Enqueue javascript and stylesheet UI_Notice.
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'ui-notice-min',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-notice/assets/min/ui-notice.min.js',
				array( 'jquery' ),
				CHERRY_VERSION,
				true
			);
			wp_enqueue_style(
				'ui-notice-min',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-notice/assets/min/ui-notice.min.css',
				array(),
				CHERRY_VERSION,
				'all'
			);
		}
	}
}