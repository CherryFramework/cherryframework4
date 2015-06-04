<?php
/**
 * Class for the building ui-repeater elements.
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

if ( ! class_exists( 'UI_Repeater' ) ) {
	class UI_Repeater {

		private $settings = array();
		private $defaults_settings = array(
			'id'		=> 'cherry-ui-repeater-id',
			'name'		=> 'cherry-ui-repeater-name',
			'value'		=> array(
					array(
						'external-link'	=> 'http://google.com',
						'font-class'	=> 'dashicons-admin-site',
						'link-label'	=> 'custom text',
					),
					array(
						'external-link'	=> 'https://www.youtube.com/',
						'font-class'	=> 'dashicons-admin-generic',
						'link-label'	=> 'custom text',
					),
					array(
						'external-link'	=> 'https://vimeo.com/',
						'font-class'	=> 'dashicons-admin-media',
						'link-label'	=> 'custom text',
					),
				),
			'class'		=> '',
		);

		/**
		 * Constructor method for the UI_Repeater class.
		 *
		 * @since  4.0.0
		 */
		function __construct( $args = array() ) {

			$this->defaults_settings['id'] = 'cherry-ui-repeater-'.uniqid();
			$this->settings = wp_parse_args( $args, $this->defaults_settings );

			add_action( 'admin_enqueue_scripts', array( get_called_class(), 'enqueue_assets' ) );

			self::enqueue_assets();
		}

		/**
		 * Render html UI_Repeater.
		 *
		 * @since  4.0.0
		 */
		public function render() {
			$html = '';

			$html .= '<div class="cherry-repeater-wrap" data-name="' . $this->settings['name'] . '">';
				$html .= '<div class="cherry-repeater-item-list">';
					$html .= '<div class="cherry-repeater-dublicate-item">';
						$html .= '<div class="col">';
							$html .= '<input class="' . $this->settings['class'] . 'external-link" name="" type="text" placeholder="' . __( 'External link', 'cherry' ) . '" value="">';
						$html .= '</div>';
						$html .= '<div class="col">';
							$html .= '<input class="' . $this->settings['class'] . 'font-class" name="" type="text" placeholder="' . __( 'Font class', 'cherry' ) . '" value="">';
						$html .= '</div>';
						$html .= '<div class="col">';
							$html .= '<input class="' . $this->settings['class'] . 'link-label" name="" type="text" placeholder="' . __( 'Link label', 'cherry' ) . '" value="">';
						$html .= '</div>';
						$html .= '<div class="repeater-delete-button-holder"><a class="repeater-delete-button" href="javascript:void(0);"><i class="dashicons dashicons-trash"></i></a></div>';
					$html .= '</div>';
					if( is_array( $this->settings['value'] ) ){
						foreach ( $this->settings['value']  as $handle => $handleArray ) {
							$html .= '<div class="cherry-repeater-item">';
								$html .= '<div class="col">';
									$html .= '<input class="' . $this->settings['class'] . 'external-link" name="' . $this->settings['name'] . '[' . $handle. '][external-link]" type="text" placeholder="' . __( 'External link', 'cherry' ) . '" value="' . esc_html( $handleArray['external-link'] ) . '">';
								$html .= '</div>';
								$html .= '<div class="col">';
									$html .= '<input class="' . $this->settings['class'] . 'font-class" name="' . $this->settings['name'] . '[' . $handle. '][font-class]" type="text" placeholder="' . __( 'Font class', 'cherry' ) . '" value="' . esc_html( $handleArray['font-class'] ) . '">';
								$html .= '</div>';
								$html .= '<div class="col">';
									$html .= '<input class="' . $this->settings['class'] . 'link-label" name="' . $this->settings['name'] . '[' . $handle. '][link-label]" type="text" placeholder="' . __( 'Link label', 'cherry' ) . '" value="' . esc_html( $handleArray['link-label'] ) . '">';
								$html .= '</div>';
								$html .= '<div class="repeater-delete-button-holder"><a class="repeater-delete-button" href="javascript:void(0);"><i class="dashicons dashicons-trash"></i></a></div>';
							$html .= '</div>';
						}
					}
				$html .= '</div>';
				$html .= '<div class="repeater-add-button-holder">';
					$html .= '<a class="repeater-add-button" href="javascript:void(0);"><i class="dashicons dashicons-plus"></i></a>';
				$html .= '</div>';
			$html .= '</div>';

			return $html;
		}

		/**
		 * Enqueue javascript and stylesheet UI_Repeater
		 *
		 * @since  4.0.0
		 */
		public static function enqueue_assets(){
			wp_enqueue_script(
				'cherry-repeater-plugin.min',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-repeater/assets/min/cherry-repeater-plugin.min.js',
				array( 'jquery', 'jquery-ui-sortable' ),
				'1.0.0',
				true
			);

			wp_enqueue_script(
				'ui-repeater.min',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-repeater/assets/min/ui-repeater.min.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);

			wp_enqueue_style(
				'ui-repeater',
				trailingslashit( CHERRY_URI ) . 'admin/ui-elements/ui-repeater/assets/ui-repeater.css',
				array(),
				'1.0.0',
				'all'
			);
		}
	}
}