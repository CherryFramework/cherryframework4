<?php
/**
 * Class for the building interface elements in admin panel.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @version    4.0.0
 * @link       http://www.cherryframework.com/
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright © 2012 - 2015, Cherry Team
 * @license    GNU General Public License version 3. See LICENSE.txt or http://www.gnu.org/licenses/
 *
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

class Cherry_Interface_Builder {

	/**
	 * Default class options.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	private $options = array(
		'name_prefix'	=> 'cherry',
		'pattern'		=> 'inline',
		'class'			=> array(
								'submit'  => '',
								'text'    => 'widefat',
								'label'   => '',
								'section' => '',
							),
		'html_wrappers' => array(
								'label_start'        => '<label %1s %2s>',
								'label_end'          => '</label>',
								'before_title'       => '<h4 %1s>',
								'after_title'        => '</h4>',
								'before_decsription' => '<small %1s>',
								'after_decsription'  => '</small>',
							),
		'widget'		=> array(
								'id_base' => '',
								'number'  => '',
							),
		'hidden_items'	=> array(),
	);

	/**
	 * Cherry Interface builder constructor.
	 *
	 * @since 4.0.0
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		// Load admin javascript and stylesheet.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_builder_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_builder_styles' ) );

		$this->options = $this->processed_input_data( $this->options, $args );

	/*	require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-text/ui-text.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-textarea/ui-textarea.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-select/ui-select.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-checkbox/ui-checkbox.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-radio/ui-radio.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-switcher/ui-switcher.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-colorpicker/ui-colorpicker.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-repeater/ui-repeater.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-media/ui-media.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-stepper/ui-stepper.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-slider/ui-slider.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-range-slider/ui-range-slider.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-background/ui-background.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-typography/ui-typography.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-ace-editor/ui-ace-editor.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-layout-editor/ui-layout-editor.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-static-area-editor/ui-static-area-editor.php' );
		require_once( trailingslashit( CHERRY_ADMIN ) . 'ui-elements/ui-tooltip/ui-tooltip.php' );*/
	}

	/**
	 * Process all form items.
	 *
	 * @since  4.0.0
	 * @param  array  $default
	 * @param  array  $argument
	 * @return array
	 */
	private function processed_input_data( $default = array(), $args = array() ) {

		foreach ( $default as $key => $value ) :

			if ( array_key_exists( $key, $args ) ) {

				if ( is_array( $value ) ) {
					$default[ $key ] = array_merge( $value, $args[ $key ] );
				} else {
					$default[ $key ] = $args[ $key ];
				}

			}

		endforeach;

		return $default;
	}

	/**
	 * Add form item. Returns form item with selected arguments.
	 *
	 * @since 4.0.0
	 * @param array $args Input argument name => argument value
	 */
	public function add_form_item( $args = array() ) {
		$default = array(
			'class'					=> '',
			'inline_style'			=> '',
			'type'					=> '',
			'value'					=> '',
			'multiple'				=> false,
			'max_value'				=> '100',
			'min_value'				=> '0',
			'step_value'			=> '1',
			'default_value'			=> '',
			'options'				=> '',
			'placeholder'			=> '',
			'upload_button_text'	=> __( 'Choose Media', 'cherry' ),
			'remove_button_text'	=> __( 'Remove Media', 'cherry' ),
			'return_data_type'		=> 'id',
			'multi_upload'			=> true,
			'display_image'			=> true,
			'display_input'			=> true,
			'library_type'			=> '',
			'label'					=> '',
			'title'					=> '',
			'description'			=> '',
			'hint'					=> '',
			'toggle'				=> array(
				'true_toggle'		=> __( 'On', 'cherry' ),
				'false_toggle'		=> __( 'Off', 'cherry' ),
				'true_slave'		=> '',
				'false_slave'		=> ''
			),
			'master'				=> '',
		);
		extract( array_merge( $default, $args ) );

		$value             = $value == '' || $value == false && $value != 0 ? $default_value : $value;
		$item_id           = $id;
		$name              = $this->generate_field_name( $id );
		$id                = $this->generate_field_id( $id );
		$item_inline_style = $inline_style ? 'style="' . $inline_style . '"' : '';
		$output            = '';

		if(is_array($this->options['hidden_items']) && in_array($item_id, $this->options['hidden_items']) ){
			return;
		}
		switch ( $type ) {

			case 'submit':
				// $output .= '<input ' . $item_inline_style . ' class="' . $class . ' '.$this->options['class']['submit'].'" id="' . $id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '" >';
				$type .= ' ' . $class;
				$item_inline_style .= ' id=' . $id;
				$output .= get_submit_button( $value, $type, $name, false, $item_inline_style );
			break;

			case 'reset':
				$output .= '<input ' . $item_inline_style . ' class="' . $class . ' '.$this->options['class']['submit'].'" id="' . $id . '" name="' . $name . '" type="reset" value="' . esc_html( $value ) . '" >';
			break;

			case 'text':
				$ui_text = new UI_Text(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'placeholder'	=> $placeholder,
						'class'			=> $class,
					)
				);
				$output .= $ui_text->render();
			break;

			case 'textarea':
				$ui_textarea = new UI_Textarea(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'placeholder'	=> $placeholder,
						'class'			=> $class,
					)
				);
				$output .= $ui_textarea->render();
			break;

			case 'select':
				$ui_select = new UI_Select(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'multiple'		=> $multiple,
						'value'			=> $value,
						'options'		=> $options,
						'class'			=> $class,
					)
				);
				$output .= $ui_select->render();
			break;

			case 'checkbox':
				$ui_checkbox = new UI_Checkbox(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'options'		=> $options,
						'class'			=> $class,
					)
				);
				$output .= $ui_checkbox->render();
			break;

			case 'radio':
				$ui_radio = new UI_Radio(
					array(
						'id'		=> $id,
						'name'		=> $name,
						'value'		=> $value,
						'options'	=> $options,
						'class'		=> $class,
					)
				);
				$output .= $ui_radio->render();
			break;

			case 'switcher':
				$ui_switcher = new UI_Switcher(
					array(
						'id'		=> $id,
						'name'		=> $name,
						'value'		=> $value,
						'toggle'	=> $toggle,
						'class'		=> $class,
					)
				);
				$output .= $ui_switcher->render();

			break;

			case 'stepper':
				$ui_stepper = new UI_Stepper(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'max_value'		=> $max_value,
						'min_value'		=> $min_value,
						'step_value'	=> $step_value,
						'class'			=> $class,
					)
				);
				$output .= $ui_stepper->render();
			break;

			case 'slider':
				$ui_slider = new UI_Slider(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'max_value'		=> $max_value,
						'min_value'		=> $min_value,
						'step_value'	=> $step_value,
						'class'			=> $class,
					)
				);
				$output .= $ui_slider->render();
			break;

			case 'rangeslider':
				$ui_range_slider = new UI_Range_Slider(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'max_value'		=> $max_value,
						'min_value'		=> $min_value,
						'step_value'	=> $step_value,
						'class'			=> $class,
					)
				);
				$output .= $ui_range_slider->render();
			break;

			case 'colorpicker':
				$ui_colorpicker = new UI_Colorpicker(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'class'			=> $class,
					)
				);
				$output .= $ui_colorpicker->render();
			break;

			case 'media':
				$ui_media = new UI_Media(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'multi_upload'	=> $multi_upload,
						'library_type'	=> $library_type,
						'class'			=> $class,
					)
				);
				$output .= $ui_media->render();
			break;

			case 'background':
				$ui_background = new UI_Background(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'multi_upload'	=> $multi_upload,
						'library_type'	=> $library_type,
						'class'			=> $class,
					)
				);
				$output .= $ui_background->render();
			break;

			case 'typography':
				$ui_typography = new UI_Typography(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'class'			=> $class,
					)
				);
				$output .= $ui_typography->render();
			break;

			case 'ace-editor':
				$ui_ace_editor = new UI_Ace_Editor(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'class'			=> $class,
					)
				);
				$output .= $ui_ace_editor->render();
			break;

			case 'repeater':
				$ui_repeater = new UI_Repeater(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'class'			=> $class,
					)
				);
				$output .= $ui_repeater->render();
			break;

			case 'static_area_editor':
				$ui_statics = new UI_Static_Area_Editor(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'options'		=> $options,
						'class'			=> $class,
					)
				);
				$output .= $ui_statics->render();
			break;

			case 'layouteditor':
				$ui_layout_editor= new UI_Layout_Editor(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'class'			=> $class,
					)
				);
				$output .= $ui_layout_editor->render();
			break;

			case 'webfont':
				$ui_webfont = new UI_Webfont(
					array(
						'id'			=> $id,
						'name'			=> $name,
						'value'			=> $value,
						'class'			=> $class,
					)
				);
				$output .= $ui_webfont->render();
			break;

			case 'editor':
				//$wrap = false;
				ob_start();
					$settings = array(
						'textarea_name' => $name,
						'media_buttons' => 1,
						'teeny'			=> 0,
						'textarea_rows' => 10, //Wordpress default
						'tinymce' => array(
							'setup' => 'function(ed) {
								ed.onChange.add(function(ed) {
									tinyMCE.triggerSave();
								});
							}'
						)
					);
					wp_editor( $value, $id, $settings );

				$output .= ob_get_clean();

				_WP_Editors::editor_js();
				_WP_Editors::enqueue_scripts();

				//Cherry_Shortcodes_Generator::popup();

			break;
		}

		return $this->wrap_item( $output, $id, $item_id, 'cherry-section cherry-' . $type . ' ' . $this->options['class']['section'], $title, $label, $description, $master, $hint );
	}

	/**
	 * Wrap the generated item.
	 *
	 * @since  4.0.0
	 * @return string
	 */
	private function wrap_item( $item, $id, $item_id, $class, $title, $label, $description, $master, $hint ) {

		$description = $description ? $this->add_description( $description ) : '';
		$class       = 'cherry-section-' . $this->options['pattern'] . ' ' . $class;
		$master_class = preg_replace('/\s*,\s*/', ' ', $master);
		$class .= !empty( $master_class ) && isset( $master_class ) ? ' ' . $master_class : '';
		$hint_html	= '';
		$data_master = ( !empty( $master ) ) ? 'data-master="' . $master . '"' : '';
		$output = '<div id="wrap-' . $id . '" class="' . $class . '" ' . $data_master . '>';
		$output .= $title ? $this->add_title( $title ) : '';

		$export_check = new UI_Switcher(
			array(
				'id'	=> $id . '-exclusion',
				'name'	=> 'exclusion[' . $item_id . ']',
				'value'	=> 'false',
				'class'	=> 'exclusion-switcher',
				'style'	=> 'small',
				'toggle'		=> array(
					'true_toggle'	=> __( 'Yes', 'cherry' ),
					'false_toggle'	=> __( 'No', 'cherry' ),
				),
			)
		);
		$output .= sprintf('<div class="exclusion-check"><span>%1$s</span>%2$s</div>', __( 'Use for partial export', 'cherry' ), $export_check->render() );

		if ( $this->options['pattern'] == 'inline' ) :

			$output .= $this->add_label( $id, $label ) . $item . $description;

		else :

			if ( $hint ) {
				$ui_tooltip = new UI_Tooltip(
					array(
						'id' => $id.'-tooltip',
						'hint' => $hint,
						'class' => $class
					)
				);
				$hint_html .=  $ui_tooltip->render();
			}

			$output .= '<div class="cherry-col-1">' . $this->add_label( $id, $label ) . $description . $hint_html. '</div>';
			$output .= '<div class="cherry-col-2">' . $item . '</div>';
		endif;

		$output .= '</div>';

		return $output;
	}

	/**
	 * Add label to form item.
	 *
	 * @since 4.0.0
	 * @param string $id
	 * @param string $label
	 * @param string $class
	 */
	private function add_label( $id, $label, $class = '' ){
		$class = !$class ? $this->options['class']['label'] : $class;

		$output = $label ? sprintf( $this->options['html_wrappers']['label_start'], 'for="' . $id . '"', 'class="cherry-label ' . $class . '"' ) : '';
		$output .= $label;
		$output .= $label ? $this->options['html_wrappers']['label_end'] : '';

		return $output;
	}

	/**
	* Add description to form items
	*
	* @since 4.0.0
	* @return string
	*/
	private function add_description($description){
		return sprintf($this->options['html_wrappers']['before_decsription'], 'class="cherry-description"') . $description . $this->options['html_wrappers']['after_decsription'];
	}

	/**
	* Add title to form items
	*
	* @since 4.0.0
	* @return string
	*/
	private function add_title($title){
		return sprintf($this->options['html_wrappers']['before_title'], 'class="cherry-title"') . $title . $this->options['html_wrappers']['after_title'];
	}

	/**
	* Add hint to form items
	*
	* @since 4.0.0
	* @return string
	*/
	private function add_hint($hint){
		$type_hint = $hint['type'];
		switch ($type_hint) {
			case 'image':
				$hint_content = '<div class="hint-image"  data-hint-image="' . $hint['content'] .'"></div>';
				break;
			case 'video':
				$embed_code = wp_oembed_get($hint['content'], array('width' => 400));
				$hint_content = '<div class="hint-video"  data-hint-video="">'. $embed_code .'</div>';
				break;
			default:
				$hint_content = '<div class="hint-text" title="' . esc_html( $hint['content'] ) .'"></div>';
				break;
		}

		return $hint_content;
	}

	/**
	 * Generated field id.
	 *
	 * @since  4.0.0
	 * @param  string $id
	 * @return string
	 */
	private function generate_field_id( $_id, $prefix = true ) {

		if ( $this->options['widget']['id_base'] && $this->options['widget']['number'] ) {
			$id = 'widget-' . $this->options['widget']['id_base'] . '-' . $this->options['widget']['number'] . '-' . $_id;
		} else {
			if($prefix){
				$id = $this->options['name_prefix'] . '-' . $_id;
			}else{
				$id = $_id;
			}
		}

		return esc_attr( $id );
	}

	/**
	 * Generated field name.
	 *
	 * @since  4.0.0
	 * @param  string $id
	 * @return string
	 */
	private function generate_field_name( $id ) {

		if ( $this->options['widget']['id_base'] && $this->options['widget']['number'] ) {
			$name = 'widget-' . $this->options['widget']['id_base'] . '[' . $this->options['widget']['number'] . '][' . $id . ']';
		} else {
			$name = $this->options['name_prefix'] . '[' . $id . ']';
		}

		return esc_attr( $name );
	}

	/**
	 * Outputs generated items.
	 *
	 * @since  4.0.0
	 * @param  array $items Input argument name => argument value
	 * @return string
	 */
	public function multi_output_items( $items ) {
		$output = '';

		foreach ( $items as $item => $args ) {
			$args['id'] = $item;
			$output .= $this->add_form_item( $args );
		}

		return $output;
	}

	/**
	 * Enqueue admin-specific javascript.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_builder_scripts( $hook_suffix = false ) {
		UI_Text::enqueue_assets();
		UI_Textarea::enqueue_assets();
		UI_Select::enqueue_assets();
		UI_Checkbox::enqueue_assets();
		UI_Radio::enqueue_assets();
		UI_Switcher::enqueue_assets();
		UI_Colorpicker::enqueue_assets();
		UI_Repeater::enqueue_assets();
		UI_Media::enqueue_assets();
		UI_Stepper::enqueue_assets();
		UI_Slider::enqueue_assets();
		UI_Range_Slider::enqueue_assets();
		UI_Background::enqueue_assets();
		UI_Typography::enqueue_assets();
		UI_Ace_Editor::enqueue_assets();
		UI_Layout_Editor::enqueue_assets();
		UI_Tooltip::enqueue_assets();
		UI_Webfont::enqueue_assets();

		wp_enqueue_script( 'editor');
		wp_enqueue_script( 'jquery-ui-dialog' );

		wp_enqueue_script( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/js/interface-builder.js', array( 'jquery' ), CHERRY_VERSION, true );
	}

	/**
	 * Enqueue admin-specific stylesheet.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_builder_styles( $hook_suffix = false ) {
		wp_enqueue_style( 'interface-builder', trailingslashit( CHERRY_URI ) . 'admin/assets/css/interface-builder.css', array(), CHERRY_VERSION );
	}
}
