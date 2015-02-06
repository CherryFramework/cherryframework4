<?php
/**
 * Class for the building interface elements in admin panel.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
class Cherry_Interface_Builder {

	private $google_font_url = null;
	private $google_font     = array();

	/**
	 * Default class options.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	private $options = array(
		'name_prefix'   => 'cherry',
		'pattern'       => 'inline',
		'class'         => array(
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
		'widget'        => array(
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
		$this->options         = $this->processed_input_data( $this->options, $args );
		$this->google_font_url = trailingslashit( CHERRY_ADMIN ) . 'assets/fonts/google-fonts.json';

		// add_action( 'admin_footer', array( $this, 'enqueue_style' ) );
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
			'class'              => '',
			'inline_style'       => '',
			'type'               => '',
			'value'              => '',
			'max_value'          => '100',
			'min_value'          => '0',
			'value_step'         => '1',
			'default_value'      => '',
			'options'            => '',
			'upload_button_text' => __( 'Choose Image', 'cherry' ),
			'remove_button_text' => __( 'Remove Image', 'cherry' ),
			'return_data_type'   => 'url',
			'multi_upload'       => true,
			'display_image'      => true,
			'display_input'      => true,
			'label'              => '',
			'title'              => '',
			'decsription'        => '',
			'hint'               => '',
			'toggle'             => array(
				'true_toggle'	=> __( 'On', 'cherry' ),
				'false_toggle'	=> __( 'Off', 'cherry' )
			)
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
			/*
			arg:
				type: submit
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: button button-primary
				item_inline_style: ''
			*/

			case 'submit':
				// $output .= '<input ' . $item_inline_style . ' class="' . $class . ' '.$this->options['class']['submit'].'" id="' . $id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '" >';
				$type .= ' ' . $class;
				$item_inline_style .= ' id=' . $id;
				$output .= get_submit_button( $value, $type, $name, false, $item_inline_style );
				break;

			/*
			arg:
				type: reset
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: button button-primary
				item_inline_style: ''
			*/
			case 'reset':
				$output .= '<input ' . $item_inline_style . ' class="' . $class . ' '.$this->options['class']['submit'].'" id="' . $id . '" name="' . $name . '" type="reset" value="' . esc_html( $value ) . '" >';
			break;
			/*
			arg:
				type: text
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: width-small, width-medium, width-full
				item_inline_style: ''
			*/
			case 'text':
				$output .= '<input ' . $item_inline_style . ' class="widefat ' . $class . '" id="' . $id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '">';
				//$output .= '<div class="infohint dashicons dashicons-info" title="' . $hint .'"></div>';
			break;
			/*
			arg:
				type: textarea
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: width-small, width-medium, width-full
				item_inline_style: ''
			*/
			case 'textarea':
				$output .= '<textarea ' . $item_inline_style . ' class="' . $class . '" id="' . $id . '" name="' . $name . '" rows="16" cols="20">' . esc_html( $value ) . '</textarea>';
			break;
			/*
			arg:
				type: select
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: width-small, width-medium, width-full
				item_inline_style: ''
				options:
					key => value
			*/
			case 'select':
				$output .= '<select ' . $item_inline_style . ' class="' . $class . '" id="' . $id . '" name="' . $name . '">';
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$output .= '<option value="' . $option . '" ' . selected( $value, $option, false ) . '>'. esc_html( $option_value ) .'</option>';
					}
				}
				$output .= '</select>';
			break;
			/*
			arg:
				type: multiselect
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: width-small, width-medium, width-full
				item_inline_style: ''
				options:
					key => value
			*/
			case 'filterselect':
				$output .= '<select ' . $item_inline_style . ' class="' . $class . ' cherry-filter-select" id="' . $id . '" name="' . $name . '">';
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$output .= '<option value="' . $option . '" ' . selected( $value, $option, false ) . '>'. esc_html( $option_value ) .'</option>';
					}
				}
				$output .= '</select>';
			break;
			/*
			arg:
				type: multiselect
				title: ''
				label: ''
				decsription: ''
				placeholder: ''
				value: ''
				default_value: ''
				class: width-small, width-medium, width-full
				item_inline_style: ''
				options:
					key => value
			*/
			case 'multiselect':
				$output .= '<select ' . $item_inline_style . ' class="' . $class . ' cherry-multi-select" id="' . $id . '" name="' . $name . '[]" multiple="multiple" placeholder="'.$placeholder.'">';
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$tmp = '';
						foreach ($value as $k => $val) {
							$tmp = selected( $val, $option, false );
							if($tmp == " selected='selected'"){
								break;
							}
						}

						$output .= '<option value="' . $option . '" ' . $tmp . '>'. esc_html( $option_value ) .'</option>';
						//$output .= '<option value="' . $option . '" ' . selected( $value, $option, false ) . '>'. esc_html( $option_value ) .'</option>';
					}
				}
				$output .= '</select>';
			break;
			/*
			arg:
				type: checkbox
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
			*/
			case 'checkbox':
				$output .= '<div class="cherry-fegr">';
				$output .= '<input type="'.$type.'" ' . $item_inline_style . ' class="cherry-input ' . $class . '" id="' . $id . '" name="' . $name . '" ' . checked( $default_value, $value, false ) . ' value="' . esc_html( $value ) . '" >';
				$output .= $this -> add_label($id, $label);
				$output .= '</div>';
			break;
			/*
			arg:
				type: switcher
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
			*/
			case 'switcher':
				$output .= '<div class="cherry-switcher-wrap">';
				$output .= '<label class="sw-enable"><span>' . $toggle['true_toggle'] . '</span></label>';
				$output .= '<label class="sw-disable"><span>' . $toggle['false_toggle'] . '</span></label>';
				$output .= '<input type="hidden" ' . $item_inline_style . ' class="cherry-input ' . $class . '" name="' . $name . '" ' . checked( $default_value, $value, false ) . ' value="' . esc_html( $value ) . '" >';
				$output .= '</div>';
			break;
			/*
			arg:
				type: slider
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
			*/
			case 'slider':
				$output .= '<div class="cherry-slider-wrap">';
					$output .= '<div class="cherry-slider-input">';
						$output .= '<input type="text" ' . $item_inline_style . ' class="cherry-stepper-input cherry-input slider-input' . $class . '" name="' . $name . '" value="' . esc_html( $value ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
						$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span>';
					$output .= '</div>';
					$output .= '<div class="cherry-slider-holder">';
						$output .= '<div class="cherry-slider-unit" data-left-limit="' . $min_value . '" data-right-limit="' . $max_value . '" data-value="' . $value . '"></div>';
					$output .= '</div>';
					$output .= '<div class="clear"></div>';
				$output .= '</div>';
			break;
			/*
			arg:
				type: rangeslider
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
			*/
			case 'rangeslider':
				$left_limit = $id.'-left';
				$right_limit = $id.'-right';
				$output .= '<div class="cherry-rangeslider-wrap">';
					$output .= '<input type="hidden" class="cherry-input range-hidden-input' . $class . '" name="' . $name . '" value="" >';
					$output .= '<div class="cherry-rangeslider-left-input">';
						$output .= '<input type="text" ' . $item_inline_style . ' class="cherry-stepper-input cherry-input slider-input-left' . $class . '" name="' . $name . '[left-value]" value="' . esc_html( $value['left-value'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="' . esc_html( $min_value ) . '" data-value-step="1">';
						$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span>';
					$output .= '</div>';
					$output .= '<div class="cherry-range-slider-holder">';
						$output .= '<div class="cherry-range-slider-unit" data-left-limit="' . $min_value . '" data-right-limit="' . $max_value . '" data-left-value="' . $value['left-value'] . '" data-right-value="' . $value['right-value'] . '"></div>';
					$output .= '</div>';
					$output .= '<div class="cherry-rangeslider-right-input">';
						$output .= '<input type="text" ' . $item_inline_style . ' class="cherry-stepper-input cherry-input slider-input-right' . $class . '" name="' . $name . '[right-value]" value="' . esc_html( $value['right-value'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="' . esc_html( $min_value ) . '" data-value-step="1">';
						$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span>';
					$output .= '</div>';
					$output .= '<div class="clear"></div>';
				$output .= '</div>';
			break;
			/*
			arg:
				type: static_area_editor
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
			*/
			case 'static_area_editor':
				global $cherry_registered_static_areas;
				$available_areas = $cherry_registered_static_areas;
				$output .= '<div id="' . $id . '" class="cherry-static-area-editor-wrap" data-name="' . $name . '">';
					foreach ($available_areas as $area => $area_settings) {
						$output .= '<div class="area-unit" data-area="' . $area . '">';
							$output .= '<h3 class="title-primary_ title-mid_ text_center_">' . $area_settings['name'] . '</h3>';
							$output .= '<div class="accordion-unit">';
								foreach ($value as $handle => $handleArray) {
									if($area == $handleArray['options']['area']){
										$output .= '<div class="group" data-static-id="' . $handle . '">';
										$output .= '<h3><span class="label">' . $handleArray['name'] . '</span><div class="delete-group dashicons dashicons-trash"><span class="confirm-btn dashicons dashicons-yes"></span><span class="cancle-btn dashicons dashicons-no-alt"></span></div></h3>';
										$output .= '<div>';
											$output .= '<div class="field-col-xs">';
												$output .= $this -> add_label($id . '-col-xs',  __( 'Column class(.col-xs-*)', 'cherry' ), $this->options['class']['label'].' cherry-block');
												$output .= '<select ' . $item_inline_style . ' class="width-full key-col-xs" name="' . $name . '[' . $handle . '][options][col-xs]">';
													$output .= '<option value="none" ' . selected( $handleArray['options']['col-xs'], 'none', false ) . '>'. esc_html( 'none' ) .'</option>';
													for ($i=0; $i < 12; $i++) {
														$inc = $i+1;
														$output .= '<option value="col-xs-' . $inc . '" ' . selected( $handleArray['options']['col-xs'], 'col-xs-'.$inc, false ) . '>'. esc_html( 'col-xs-'.$inc ) .'</option>';
													}
												$output .= '</select>';
											$output .= '</div>';
											$output .= '<div class="field-col-sm">';
												$output .= $this -> add_label($id . '-col-sm',  __( 'Column class(.col-sm-*)', 'cherry' ), $this->options['class']['label'].' cherry-block');
												$output .= '<select ' . $item_inline_style . ' class="width-full key-col-sm" name="' . $name . '[' . $handle . '][options][col-sm]">';
													$output .= '<option value="none" ' . selected( $handleArray['options']['col-sm'], 'none', false ) . '>'. esc_html( 'none' ) .'</option>';
													for ($i=0; $i < 12; $i++) {
														$inc = $i+1;
														$output .= '<option value="col-sm-' . $inc . '" ' . selected( $handleArray['options']['col-sm'], 'col-sm-'.$inc, false ) . '>'. esc_html( 'col-sm-'.$inc ) .'</option>';
													}
												$output .= '</select>';
											$output .= '</div>';
											$output .= '<div class="field-col-md">';
												$output .= $this -> add_label($id . '-col-md',  __( 'Column class(.col-md-*)', 'cherry' ), $this->options['class']['label'].' cherry-block');
												$output .= '<select ' . $item_inline_style . ' class="width-full key-col-md" name="' . $name . '[' . $handle . '][options][col-md]">';
													$output .= '<option value="none" ' . selected( $handleArray['options']['col-md'], 'none', false ) . '>'. esc_html( 'none' ) .'</option>';
													for ($i=0; $i < 12; $i++) {
														$inc = $i+1;
														$output .= '<option value="col-md-' . $inc . '" ' . selected( $handleArray['options']['col-md'], 'col-md-'.$inc, false ) . '>'. esc_html( 'col-md-'.$inc ) .'</option>';
													}
												$output .= '</select>';
											$output .= '</div>';
											$output .= '<div class="field-col-lg">';
												$output .= $this -> add_label($id . '-col-lg',  __( 'Column class(.col-lg-*)', 'cherry' ), $this->options['class']['label'].' cherry-block');
												$output .= '<select ' . $item_inline_style . ' class="width-full key-col-lg" name="' . $name . '[' . $handle . '][options][col-lg]">';
													$output .= '<option value="none" ' . selected( $handleArray['options']['col-lg'], 'none', false ) . '>'. esc_html( 'none' ) .'</option>';
													for ($i=0; $i < 12; $i++) {
														$inc = $i+1;
														$output .= '<option value="col-lg-' . $inc . '" ' . selected( $handleArray['options']['col-lg'], 'col-lg-'.$inc, false ) . '>'. esc_html( 'col-lg-'.$inc ) .'</option>';
													}
												$output .= '</select>';
											$output .= '</div>';
											$output .= '<div class="field-class">';
												$output .= $this -> add_label($id . '-class',  __( 'Custom class', 'cherry' ), $this->options['class']['label'].' cherry-block');
												$output .= '<input class="width-full key-custom-class" name="' . $name . '[' . $handle . '][options][class]" value="' . esc_html( $handleArray['options']['class'] ) . '" type="text" />';
											$output .= '</div>';
											$output .= '<input type="hidden" class="key-item-name" name="' . $name . '[' . $handle . '][name]" value="' . $handleArray['name'] . '">';
											$output .= '<input type="hidden" class="key-area" name="' . $name . '[' . $handle . '][options][area]" value="' . $handleArray['options']['area'] . '">';
											$output .= '<input type="hidden" class="key-priority" name="' . $name . '[' . $handle . '][options][priority]" value="' . $handleArray['options']['priority'] . '">';
										$output .= '</div>';
									$output .= '</div>';
									}
								}
							$output .= '</div>';//end accordion-unit
						$output .= '</div>';//end area-unit
					}// end foreach $available_areas
					$output .= '<div class="cherry-accordion-control">';
						$output .= $this -> add_label($id.'-static',  __( 'Create new static', 'cherry' ), $this->options['class']['label'].' cherry-block');
						$output .= '<a href="javascript:void(0);" class="button-primary_ add-new-btn">'. __( 'Add new static', 'cherry' ) .'</a>';
						$output .= '<div class="field-static">';
							$output .= '<select ' . $item_inline_style . ' class="static-selector width-full">';
								foreach ($options as $static => $staticSettings) {
									$output .= '<option data-priority="'. $staticSettings['options']['priority'] .'" value="' . $static . '" ' . selected( $staticSettings['name'], $handleArray['name'], false ) . '>'. esc_html( $staticSettings['name'] ) .'</option>';
								}
							$output .= '</select>';
						$output .= '</div>';
					$output .= '<div class="clear"></div>';
					$output .= '</div>';
				$output .= '</div>';
			break;

			/*
			arg:
				type: multicheckbox
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
				options:
					key => ''
			*/
			case 'multicheckbox':
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$name = $this -> generate_field_name($option);
						$checkbox_id = $this -> generate_field_id($option);
						$option_checked = $value[$option] ? $option : '' ;
						$output .= '<div class="cherry-fegr">';
						$output .= '<input type="checkbox" ' . $item_inline_style . ' class="cherry-input ' . $class . '" id="' . $checkbox_id . '" name="' . $name . '" ' . checked( $option_checked, $option, false ) . ' value="' . esc_html( $option ) . '" >';
						$output .= $this -> add_label($checkbox_id, $option_value);
						$output .= '</div>';
					}
				}
			break;
			/*
			arg:
				type: radio
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
				display_input: true/false
				options:
					key => array(
						label => '',
						img_src => ''
					)
			*/
			case 'radio':

				if ( $options && !empty( $options ) && is_array( $options) ) {

					$output .= '<div>';

					foreach ( $options as $option => $option_value ) {

						$checked           = $option == $value ? ' checked' : '';
						$radio_id          = $this->generate_field_id( $option );
						$item_inline_style = $display_input ? $item_inline_style : 'style="' . $inline_style . ' display:none;"';
						$img               = isset( $option_value['img_src'] ) && !empty( $option_value['img_src'] ) ? '<img src="' . esc_url( $option_value['img_src'] ) . '" alt="' . esc_html( $option_value['label'] ) . '"><span class="check"><span class="media-modal-icon"></span></span>' : '';
						$class_box         = isset( $option_value['img_src'] ) && !empty( $option_value['img_src'] ) ? ' cherry-radio-img' . $checked : '';

						$output .= '<div class="cherry-fegr' . $class_box . '">';
						$output .= '<input type="' . $type . '" ' . $item_inline_style . ' class="cherry-input ' . sanitize_html_class( $class ) . '" id="' . esc_attr( $radio_id ) . '" name="' . esc_attr( $name ) . '" ' . checked( $option, $value, false ) . ' value="' . esc_attr( $option ) . '">';
						$output .= $this->add_label( $radio_id, $img . $option_value['label'] );
						$output .= '</div>';
					}

					$output .= '</div>';

					add_action( 'admin_footer', array( $this, 'include_scripts' ) );

				}

			break;
			/*
			arg:
				type: image
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				item_inline_style: ''
				display_image: true/false
				upload_button_text:Choose Image
				remove_button_text:Remove Image
				return_data_type:url, id
				multi_upload: true
			*/
			case 'image':
				$value = str_replace(' ', '', $value);
				$img_style = !$value ? 'style="display:none;"' : '' ;
				$images = explode(',', $value);

				$output .= '<div class="cherry-element-wrap">';
				$output .= '<div class="cherry-uiw">';
				$output .= '<input ' . $item_inline_style . ' class="cherry-upload-input '.$this->options['class']['text'].'" id="' . $id . '" name="' . $name . '" type="text" value="' . esc_html( $value ) . '" >';
				$output .= '</div>';
				$output .= '<div class="cherry-uicw">';
				$output .= '<input class="upload-button button-default_ '.$this->options['class']['submit'].'" type="button" value="' . $upload_button_text . '" data-title="'.__( 'Choose Image', 'cherry' ).'" data-return-data="'.$return_data_type.'" data-multi-upload="'.$multi_upload.'" />';
				$output .= '</div></div>';

				if($display_image){
					$output .= '<div '.$img_style.' class="cherry-upload-preview" ><div class="cherry-all-images-wrap">';
					if(is_array($images) && !empty($images)){
						foreach ($images as $images_key => $images_value) {
							if($return_data_type == 'url'){
								$img_src = $images_value;
							}else{
								$img_src = wp_get_attachment_image_src( $images_value );
								$img_src = $img_src[0];
							}
							$output .= '<div class="cherry-image-wrap"><img  src="' . esc_html( $img_src ) . '" alt="'.__( 'Current Image', 'cherry' ).'" data-img-attr="'.$images_value.'"><a class="media-modal-icon cherry-remove-image" href="#" title="' . $remove_button_text . '"></a></div>';
						}
					}
					$output .= '</div></div>';
				}

				add_action( 'admin_footer', array($this, 'include_media_script_style'));
				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
			/*
			arg:
				type: colorpicker
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				item_inline_style: ''
			*/
			case 'colorpicker':
				$output .= '<input id="' . $id . '" name="' . $name . '" value="' . esc_html( $value ) . '" ' . $item_inline_style . ' class="cherry-color-picker '. $class . '" type="text" />';
				add_action( 'admin_footer', array($this, 'include_colorpicker_script_style'));
				add_action( 'admin_footer', array($this, 'include_colorpicker_script_style'));
				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
			/*
			arg:
				type: stepper
				title: ''
				label: ''
				decsription: ''
				value: ''
				max_value: 100
				min_value: 0
				value_step: 1
				default_value: ''
				class: widefat
				item_inline_style: ''
			*/
			case 'stepper':
				$output .= '<div>';
				$output .= '<input id="' . $id . '" name="' . $name . '" ' . $item_inline_style . ' class="cherry-stepper-input '.$class.'" type="text" value="' . esc_html( $value ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="' . esc_html( $min_value ) . '" data-value-step="' . esc_html( $value_step ) . '">';
				$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span>';
				$output .= '</div>';

				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
			/*
			arg:
				type: editor
				title: ''
				decsription: ''
				value: ''
				default_value: ''
			*/
			case 'editor':
				$wrap = false;
				ob_start();
					$settings = array(
						'textarea_name' => $name,
						'media_buttons' => 1,
						'tinymce' => array('setup' => 'function(ed) {
														ed.onChange.add(function(ed) {
															tinyMCE.triggerSave();
														});
													}')
					);
					wp_editor( $value, $id, $settings );
				$output .= ob_get_clean();
			break;
			/*
			arg:
				type: background
				title: ''
				label: ''
				decsription: ''
				value: array(
							'image'		=> '',
							'color'		=> '',
							'repeat'	=> '',
							'position'	=> '',
							'attachment'=> ''
							)
				default_value: ''
				display_image: true/false
			*/
			case 'background':
				$background_options = array(
					'repeat' => array(
							'no-repeat' => __( 'No repeat', 'cherry' ),
							'repeat' => __( 'Repeat All', 'cherry' ),
							'repeat-x' => __( 'Repeat Horizontally', 'cherry' ),
							'repeat-y' => __( 'Repeat Vertically', 'cherry' )
					),
					'position' => array(
							'top-left' => __( 'Top Left', 'cherry' ),
							'top' => __( 'Top Center', 'cherry' ),
							'right-top' => __( 'Top Right', 'cherry' ),
							'left' => __( 'Middle Left', 'cherry' ),
							'center' => __( 'Middle Center', 'cherry' ),
							'right' => __( 'Middle Right', 'cherry' ),
							'bottom-left' => __( 'Bottom Left', 'cherry' ),
							'bottom' => __( 'Bottom Center', 'cherry' ),
							'bottom-right' => __( 'Bottom Right', 'cherry' )
					),
					'attachment' => array(
							'fixed' => __( 'Scroll Normally', 'cherry' ),
							'scroll' => __( 'Fixed in Place', 'cherry' )
					),
					'clip' => array(
							'padding-box' => __( 'Padding box', 'cherry' ),
							'border-box'  => __( 'Border box', 'cherry' ),
							'content-box' => __( 'Content box', 'cherry' )
					),
					'size' => array(
							'auto-auto' => __( 'Auto Auto', 'cherry' ),
							'cover'     => __( 'Cover', 'cherry' ),
							'contain'   => __( 'Contain', 'cherry' )
					),
					'origin' => array(
							'padding-box' => __( 'Padding box', 'cherry' ),
							'border-box'  => __( 'Border box', 'cherry' ),
							'content-box' => __( 'Content box', 'cherry' )
					)
				);
				$img_style = !$value['image'] ? 'style="display:none;"' : '' ;
				$output .= '<div class="cherry-ebm">';
					$output .= $this -> add_label($id . '[color]',  __( 'Background Color', 'cherry' ), $this->options['class']['label'].' cherry-block');
					$output .= '<input id="' . $id . '[color]" name="' . $name . '[color]" value="' . esc_html( $value['color'] ) . '" class="cherry-color-picker" type="text" />';
				$output .= '</div>';
				$output .= $this -> add_label($id . '[image]',  __( 'Background Image', 'cherry' ));
				$output .= '<div class="cherry-element-wrap">';
					$output .= '<div class="cherry-uiw">';
						$output .= '<input class="cherry-upload cherry-upload-input '.$this->options['class']['text'].'" id="' . $id . '[image]" name="' . $name . '[image]" type="text" value="' . esc_html( $value['image'] ) . '" >';
					$output .= '</div>';
					$output .= '<div class="cherry-uicw">';
						$output .= '<input class="upload-button button-default_ '.$this->options['class']['submit'].'" type="button" value="' . esc_html( $upload_button_text ) . '" data-title="'.__( 'Choose Image', 'cherry' ).'" data-return-data="'.$return_data_type.'" />';
					$output .= '</div>';
				$output .= '</div>';
				$output .= '<div '.$img_style.' class="cherry-element-wrap cherry-upload-preview" >';
					$output .= '<div class="cherry-group">';
						$output .= $this -> add_label($id,  __( 'Background Settings', 'cherry' ), $this->options['class']['label'].' cherry-block');
						foreach ($background_options as $options_key => $options_settings) {
							if( isset( $value[$options_key] ) ){
								$output .= '<div class="cherry-bgsetting">';
									$label = sprintf( __( 'Background %s', 'cherry' ), $options_key );
									$output .= $this->add_label( $id . '['. $options_key .']', $label, $this->options['class']['label'] . ' cherry-block');
									$output .= '<select class="widefat'.$this->options['class']['section'].'" id="' . $id . '['.$options_key.']" name="' . $name . '['.$options_key.']">';
										foreach ($options_settings as $option => $option_value) {
											$output .= '<option value="'.$option.'" ' . selected( $value[$options_key], $option, false ) . '>' . esc_html( $option_value ). '</option>';
										}
									$output .= '</select>';
								$output .= '</div>';
							}
						}
						$output .= '<div class="clear"></div>';
					$output .= '</div>';
				if($return_data_type == 'url'){
					$img_src = $value['image'];
				}else{
					$img_src = wp_get_attachment_image_src( $value['image'] );
					$img_src = $img_src[0];
				}
					$output .= '<div class="cherry-all-images-wrap">';
						$output .= $display_image ? '<div class="cherry-image-wrap"><img src="' . esc_html( $img_src ) . '" alt="'.__( 'Current Image', 'cherry' ).'" data-img-attr="'.$value['image'].'"><a class="media-modal-icon cherry-remove-image" href="#" title="' . $remove_button_text . '"></a></div>' : '' ;
					$output .= '</div>';
				$output .= '</div>';

				add_action( 'admin_footer', array($this, 'include_colorpicker_script_style'));
				add_action( 'admin_footer', array($this, 'include_media_script_style'));
				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
			/*
			arg:
				type: info
				title: ''
				decsription: ''
				value: ''
				default_value: ''
			*/
			case 'info':
				$output .= '<div class="main-title_">' . $value . '</div>';
			break;
			/*
			arg:
				type: typography
				title: ''
				label: ''
				decsription: ''
				value: array(
							'size'		=> '',
							'lineheight'=> '',
							'family'		=> '',
							'style'	=> '',
							'character'	=> '',
							'color'	=> ''
							)
				default_value: ''
			*/
			case 'typography':
				$text_align = array(
					'notdefined' => __( 'Not defined', 'cherry' ),
					'inherit'    => __( 'Inherit', 'cherry' ),
					'left'       => __( 'Left', 'cherry' ),
					'right'      => __( 'Right', 'cherry' ),
					'center'     => __( 'Center', 'cherry' ),
					'justify'    => __( 'Justify', 'cherry' )
				);

				$output .= '<div>';
				$output .= '<div class="cherry-type-wrap">';
					//size
					$output .= '<div class="field-font-size">';
					$output .= $this -> add_label($id . '[size]',  __( 'Font Size', 'cherry' ), $this->options['class']['label'].' cherry-block');
					$output .= '<input id="' . $id . '[size]" name="' . $name . '[size]" class="cherry-stepper-input font-size" type="text" value="' . esc_html(  $value['size'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
					$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span>';
					$output .= ' px </div>';

					//lineheight
					$output .= '<div class="field-font-lineheight">';
					$output .= $this -> add_label($id . '[lineheight]',  __( 'Lineheight', 'cherry' ), $this->options['class']['label'].' cherry-block');
					$output .= '<input id="' . $id . '[lineheight]" name="' . $name . '[lineheight]" class="cherry-stepper-input font-lineheight" type="text" value="' . esc_html( $value['lineheight'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
					$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span>';
					$output .= ' px </div>';

					//Font Family
					$font_array = $this->get_google_font();
					$character_array = array();
					$style_array = array();
						$output .= '<div class="field-font-family">';
						$output .= $this -> add_label($id . '[family]',  __( 'Font Family', 'cherry' ), $this->options['class']['label'].' cherry-block');
							$output .= '<select class="cherry-font-family" id="' . $id . '[family]" name="' . $name . '[family]">';
							if($font_array && !empty($font_array) && is_array($font_array)){
								foreach ($font_array as $font_key => $font_value) {
									$category = is_array($font_value['category']) ? implode(",", $font_value['category']): $font_value['category'] ;
									$style = is_array($font_value['variants']) ? implode(",", $font_value['variants']): $font_value['variants'] ;
									$character = is_array($font_value['subsets']) ? implode(",", $font_value['subsets']): $font_value['subsets'] ;

									foreach ($font_value['subsets'] as $character_key => $character_value) {
										if(!array_key_exists ($character_value, $character_array)){
											$value_text = str_replace('-ext', ' Extended', $character_value);
											$value_text = ucwords($value_text);
											$character_array[$character_value] = $value_text;
										}
									}

									foreach ($font_value['variants'] as $style_key => $style_value) {
										if(!array_key_exists ($style_value, $style_array)){
											$text_piece_1 = preg_replace ('/[0-9]/s', '', $style_value);
											$text_piece_2 = preg_replace ('/[A-Za-z]/s', ' ', $style_value);
											$value_text = ucwords($text_piece_2 . ' ' . $text_piece_1);
											$style_array[$style_value] = $value_text;
										}
									}

									$output .= '<option value="' . $font_value['family'] . '" data-category="' . $category . '" data-style="' . $style . '" data-character="' . $character . '" ' . selected( $value['family'], $font_value['family'], false ) . '>'. esc_html( $font_value['family'] ) .'</option>';
								}
							}
							$output .= '</select>';
						$output .= '</div>';
						//Font style
						$output .= '<div class="field-font-style">';
						$output .= $this -> add_label($id . '[style]',  __( 'Font Style', 'cherry' ), $this->options['class']['label'].' cherry-block');
							$output .= '<select class="cherry-font-style" id="' . $id . '[style]" name="' . $name . '[style]">';
							if($style_array && !empty($style_array) && is_array($style_array)){
								foreach ($style_array as $style_key => $style_value) {
									$output .= '<option value="' . $style_key . '" ' . selected( $value['style'], $style_key, false ) . '>'. esc_html( $style_value ) .'</option>';
								}
							}
							$output .= '</select>';
						$output .= '</div>';
						//Font character
						$output .= '<div class="field-font-character">';
						$output .= $this -> add_label($id . '[character]',  __( 'Character Sets', 'cherry' ), $this->options['class']['label'].' cherry-block');
							$output .= '<select class="cherry-font-character" id="' . $id . '[character]" name="' . $name . '[character]">';
							if($character_array && !empty($character_array) && is_array($character_array)){
								foreach ($character_array as $character_key => $character_value) {
									$output .= '<option value="' . $character_key . '" ' . selected( $value['character'], $character_key, false ) . '>'. esc_html( $character_value ) .'</option>';
								}
							}
							$output .= '</select>';
						$output .= '</div>';
					$output .= '</div>';

				$output .= '<div class="cherry-type-wrap">';
					$output .= '<div class="field-font-color">';
						$output .= $this -> add_label($id . '[align]',  __( 'Text align', 'cherry' ), $this->options['class']['label'].' cherry-block');
						$output .= '<select class="cherry-text-align" id="' . $id . '[align]" name="' . $name . '[align]">';
							foreach ($text_align as $align_key => $align_value) {
								$output .= '<option value="' . $align_key . '" ' . selected( $value['align'], $align_key, false ) . '>'. esc_html( $align_value ) .'</option>';
							}
					$output .= '</select>';
					$output .= '</div>';
					//letterspacing
					$output .= '<div class="field-font-letter-spacing">';
						$output .= $this -> add_label($id . '[letter-spacing]',  __( 'Letter-spacing', 'cherry' ), $this->options['class']['label'].' cherry-block');
						$output .= '<input id="' . $id . '[letterspacing]" name="' . $name . '[letterspacing]" class="cherry-stepper-input font-letterspacing" type="text" value="' . esc_html( $value['letterspacing'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="0" data-value-step="1">';
						$output .= '<span class="cherry-stepper-controls"><em class="step-up" title="'.__( 'Step Up', 'cherry' ).'">+</em><em class="step-down" title="'.__( 'Step Down', 'cherry' ).'">-</em></span> px';
					$output .= '</div>';
					//color
					$output .= '<div class="field-font-color">';
						$output .= $this -> add_label($id . '[color]',  __( 'Font color', 'cherry' ), $this->options['class']['label'].' cherry-block');
						$output .= '<input id="' . $id . '[color]" name="' . $name . '[color]" value="' . esc_html( $value['color'] ) . '" class="cherry-color-picker" type="text" />';
					$output .= '</div>';
				$output .= '</div>';



				$output .= '<input name="' . $name . '[category]" value="" class="cherry-font-category" type="hidden" />';
				$output .= '</div>';

				add_action( 'admin_footer', array($this, 'include_colorpicker_script_style'));
				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
		}

		return $this->wrap_item( $output, $id, 'cherry-section cherry-' . $type . ' ' . $this->options['class']['section'], $title, $label, $decsription, $hint );
	}

	/**
	 * Wrap the generated item.
	 *
	 * @since  4.0.0
	 * @return string
	 */
	private function wrap_item( $item, $id, $class, $title, $label, $decsription, $hint ) {
		$decsription = $decsription ? $this->add_description( $decsription ) : '';
		$class       = 'cherry-section-' . $this->options['pattern'] . ' ' . $class;
		$output      = '<div id="wrap-' . $id . '" class="' . $class . '">';
		$output      .= $title ? $this->add_title( $title ) : '';

		if ( $this->options['pattern'] == 'inline' ) :

			$output .= $this->add_label( $id, $label ) . $item . $decsription;

		else :

			$output .= '<div class="cherry-col-1">' . $this->add_label( $id, $label ) . $decsription . '</div>';

			if ( $hint ) {
				$output .= $this->add_hint( $hint );
			}

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
	private function add_description($decsription){
		return sprintf($this->options['html_wrappers']['before_decsription'], 'class="cherry-description"') . $decsription . $this->options['html_wrappers']['after_decsription'];
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
				$hint_content = '<div class="hint-text" title="' . $hint['content'] .'"></div>';
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
	private function generate_field_id( $_id ) {

		if ( $this->options['widget']['id_base'] && $this->options['widget']['number'] ) {
			$id = 'widget-' . $this->options['widget']['id_base'] . '-' . $this->options['widget']['number'] . '-' . $_id;
		} else {
			$id = $this->options['name_prefix'] . '-' . $_id;
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
	 * Retrieve a list of available Google web fonts.
	 *
	 * @since  4.0.0
	 * @return array
	 */
	private function get_google_font() {

		if ( empty( $this->google_font ) ) {

			// Get cache.
			$fonts = get_transient( 'cherry_google_fonts' );

			if ( false === $fonts ) {

				if ( !function_exists( 'WP_Filesystem' ) ) {
					include_once( ABSPATH . '/wp-admin/includes/file.php' );
				}

				WP_Filesystem();
				global $wp_filesystem;

				if ( !$wp_filesystem->exists( $this->google_font_url ) ) { // Check for existence.
					return false;
				}

				// Read the file.
				$json = $wp_filesystem->get_contents( $this->google_font_url );

				if ( !$json ) {
					return new WP_Error( 'reading_error', 'Error when reading file' ); // Return error object.
				}

				$content = json_decode( $json, true );
				$fonts   = $content['items'];

				// Set cache.
				set_transient( 'cherry_google_fonts', $fonts, WEEK_IN_SECONDS );
			}

			$this->google_font = $fonts;
		}

		return $this->google_font;
	}

	/**
	* Include media library files. Enables media library modal window.
	*
	* @since 4.0.0
	*/
	public function include_media_script_style(){
		wp_enqueue_media();
	}

	/**
	* Include color picker JS and CSS files.
	*
	* @since 4.0.0
	*/
	public function include_colorpicker_script_style(){
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker');
	}

	/**
	* Include interface builder JS files
	*
	* @since 4.0.0
	*/
	public function include_scripts(){
		wp_enqueue_script( 'interface-builder' );
	}

	/**
	* Include interface builder CSS files
	*
	* @since 4.0.0
	*/
	public function enqueue_style(){
		wp_enqueue_style( 'interface-builder' );
	}
}
