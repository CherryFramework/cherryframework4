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
class Cherry_Interface_Bilder {
	private
	$google_font_url,
	$google_font = array(),
	//default class options
	$options = array(
					'name_prefix' => 'cherry',
					'pattern' => 'inline',
					'class' => array(
						'submit' => 'button',
						'text' => 'widefat',
						'label' => '',
						'section' => ''
					),
					'html_wrappers' => array(
						'label_start'			=> '<label %1s %2s>',
						'label_end'				=> '</label>',
						'before_title'			=> '<h4 %1s>',
						'after_title'			=> '</h4>',
						'before_decsription'	=> '<small %1s>',
						'after_decsription'		=> '</small>'
						),
					'widget' => array(
						'id_base'				=> '',
						'number'				=> ''
					)
				);

	/**
	* Cherry Interface builder constructor
	* 
	* @since 4.0.0
	*/

	function __construct($args = array()) {
		$this -> options = $this -> processed_input_data($this->options , $args);
		$this -> google_font_url = PARENT_DIR . "/lib/admin/assets/font-list/google-fonts.json";

		add_action( 'admin_footer', array($this, 'include_style'));
	}

	/**
	*  Process all form items. 
	*
	* @return Array. Input fields arguments and values
	* @since 4.0.0
	*/
	private function processed_input_data ($default = array(), $argument = array()){
		foreach ($default as $key => $value) {
			if(array_key_exists($key, $argument)){
				if(is_array($value)){
					$default[$key] = array_merge($value , $argument[$key]);
				}else{
					$default[$key] = $argument[$key];
				}
			}
		}
		return $default;
	}

	/**
	* Add form item. Returns form item with selected arguments. 
	* 
	* @param Array. Input argument name => argument value
	* @since 4.0.0
	* @return string
	*/
	public function add_form_item ($args = array()){
		$default = array(
						'class'					=> '',
						'inline_style'			=> '',
						'type'					=> '',
						'value'					=> '',
						'max_value'				=> '100',
						'min_value'				=> '0',
						'value_step'			=> '1',
						'default_value'			=> '',
						'options'				=> '',
						'upload_button_text'	=> __( 'Choose Image', 'cherry' ),
						'remove_button_text'	=> __( 'Remove Image', 'cherry' ),
						'return_data_type'		=> 'url',
						'multi_upload'			=> true,
						'display_image'			=> true,
						'display_input'			=> true,
						'label'					=> '',
						'title'					=> '',
						'decsription'			=> ''
					);
		extract(array_merge($default, $args));

		$value = $value == '' || $value == false &&  $value != 0 ? $default_value : $value ;
		$name = $this -> generate_field_name($id);
		$id = $this -> generate_field_id($id);
		$item_inline_style = $inline_style ? 'style="' . $inline_style . '"' : '' ;
		$output = '';

		switch ($type) {
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
				$output .= '<input ' . $item_inline_style . ' class="' . $class . ' '.$this->options['class']['submit'].'" id="' . $id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '" >';
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
				$output .= '<input ' . $item_inline_style . ' class="widefat ' . $class . '" id="' . $id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '" >';
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
				$output .= '<select ' . $item_inline_style . ' class="' . $class . ' cherry-multi-select" id="' . $id . '" name="' . $name . '" multiple="multiple" placeholder="'.$placeholder.'">';
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$output .= '<option value="' . $option . '" ' . selected( $value, $option, false ) . '>'. esc_html( $option_value ) .'</option>';
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
				$output .= '<label class="sw-enable"><span>On</span></label>';
				$output .= '<label class="sw-disable"><span>Off</span></label>';
				$output .= '<input type="hidden" ' . $item_inline_style . ' class="cherry-input ' . $class . '" name="' . $name . '" ' . checked( $default_value, $value, false ) . ' value="' . esc_html( $value ) . '" >';
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
				if($options && !empty($options) && is_array($options)){
					$output .= '<div>';
					foreach ($options as $option => $option_value) {
						$checked = $option == $value ? ' checked' : '' ;
						$radio_id = $this -> generate_field_id($option);
						$item_inline_style = $display_input ? $item_inline_style : 'style="' . $inline_style . ' display:none;"' ;
						$img = isset($option_value['img_src']) && !empty($option_value['img_src']) ? '<img src="'.$option_value['img_src'].'" alt="'.$option_value['label'].'"><span class="check"><span class="media-modal-icon"></span></span>' : '' ;
						$class_box= isset($option_value['img_src']) && !empty($option_value['img_src']) ? 'cherry-radio-img '. $checked : '' ;
						$item_label = $option_value['label'];

						$output .= '<div class="cherry-fegr '.$class_box.'">';
						$output .= '<input type="'.$type.'" ' . $item_inline_style . ' class="cherry-input ' . $class . '" id="' . $radio_id . '" name="' . $name . '" '.$checked.' value="' . esc_html( $option ) . '" >';
						$output .= $this -> add_label($radio_id, $img.$item_label);
						$output .= '</div>';
					}
					$output .= '</div>';
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
				$output .= '<input class="cherry-upload-image '.$this->options['class']['submit'].'" type="button" value="' . $upload_button_text . '" data-title="'.__( 'Choose Image', 'cherry' ).'" data-return-data="'.$return_data_type.'" data-multi-upload="'.$multi_upload.'" />';
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
				$output .= '<span class="cherry-stepper-controls"><a class="step-up" title="'.__( 'Step Up', 'cherry' ).'" href="#">+</a><a class="step-down" title="'.__( 'Step Down', 'cherry' ).'" href="#">-</a></span>';
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
							'top left' => __( 'Top Left', 'cherry' ),
							'top' => __( 'Top Center', 'cherry' ),
							'right top' => __( 'Top Right', 'cherry' ),
							'left' => __( 'Middle Left', 'cherry' ),
							'center' => __( 'Middle Center', 'cherry' ),
							'right' => __( 'Middle Right', 'cherry' ),
							'bottom left' => __( 'Bottom Left', 'cherry' ),
							'bottom' => __( 'Bottom Center', 'cherry' ),
							'bottom right' => __( 'Bottom Right', 'cherry' )
					),
					'attachment' => array(
							'fixed' => __( 'Scroll Normally', 'cherry' ),
							'scroll' => __( 'Fixed in Place', 'cherry' )
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
				$output .= '<input class="cherry-upload-image '.$this->options['class']['submit'].'" type="button" value="' . esc_html( $upload_button_text ) . '" data-title="'.__( 'Choose Image', 'cherry' ).'" data-return-data="'.$return_data_type.'" />';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '<div '.$img_style.' class="cherry-element-wrap cherry-upload-preview" >';
				$output .= $this -> add_label($id . '[repeat]',  __( 'Background Settings', 'cherry' ), $this->options['class']['label'].' cherry-block');
				foreach ($background_options as $options_key => $options_value) {
					$output .= '<select class="cherry-bgs widefat'.$this->options['class']['section'].'" id="' . $id . '['.$options_key.']" name="' . $name . '['.$options_key.']">';
					foreach ($options_value as $option => $option_value) {
						$output .= '<option value="'.$option.'" ' . selected( $value[$options_key], $option, false ) . '>' . esc_html( $option_value ). '</option>';
					}
					$output .= '</select>';
				}

				if($return_data_type == 'url'){
					$img_src = $value['image'];
				}else{
					$img_src = wp_get_attachment_image_src( $value['image'] );
					$img_src = $img_src[0];
				}
				$output .= '<div class="cherry-all-images-wrap">';
				$output .= $display_image ? '<div class="cherry-image-wrap"><img src="' . esc_html( $img_src ) . '" alt="'.__( 'Current Image', 'cherry' ).'" data-img-attr="'.$value['image'].'"><a class="media-modal-icon cherry-remove-image" href="#" title="' . $remove_button_text . '"></a></div>' : '' ;
				$output .= '</div></div>';

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
				$output .= '<div class="cherry-info-holder">' . $value . '</div>';
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
				$output .= '<div>';
				//size
				$output .= '<div class="field-font-size">';
				$output .= $this -> add_label($id . '[size]',  __( 'Font Size', 'cherry' ), $this->options['class']['label'].' cherry-block');
				$output .= '<input id="' . $id . '[size]" name="' . $name . '[size]" class="cherry-stepper-input font-size" type="text" value="' . esc_html(  $value['size'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
				$output .= '<span class="cherry-stepper-controls"><a class="step-up" title="'.__( 'Step Up', 'cherry' ).'" href="#">+</a><a class="step-down" title="'.__( 'Step Down', 'cherry' ).'" href="#">-</a></span>';
				$output .= ' px </div>';

				//lineheight
				$output .= '<div class="field-font-lineheight">';
				$output .= $this -> add_label($id . '[lineheight]',  __( 'Lineheight', 'cherry' ), $this->options['class']['label'].' cherry-block');
				$output .= '<input id="' . $id . '[lineheight]" name="' . $name . '[lineheight]" class="cherry-stepper-input font-lineheight" type="text" value="' . esc_html( $value['lineheight'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
				$output .= '<span class="cherry-stepper-controls"><a class="step-up" title="'.__( 'Step Up', 'cherry' ).'" href="#">+</a><a class="step-down" title="'.__( 'Step Down', 'cherry' ).'" href="#">-</a></span>';
				$output .= ' px </div>';


				//Font Family
				$font_array = $this -> get_google_font();
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

				//color
				$output .= '<div class="field-font-color">';
				$output .= $this -> add_label($id . '[color]',  __( 'Font color', 'cherry' ), $this->options['class']['label'].' cherry-block');
				$output .= '<input id="' . $id . '[color]" name="' . $name . '[color]" value="' . esc_html( $value['color'] ) . '" class="cherry-color-picker" type="text" />';
				$output .= '</div>';

				$output .= '<input name="' . $name . '[category]" value="" class="cherry-font-category" type="hidden" />';
				$output .= '</div>';

				add_action( 'admin_footer', array($this, 'include_colorpicker_script_style'));
				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
		}

		return $this -> wrap_item($output, $id, 'cherry-section cherry-' . $type. ' ' .$this->options['class']['section'], $title, $label, $decsription);
	}

	/**
	* Wrap the generated item
	*
	* @since 4.0.0
	* @return string
	*/
	private function wrap_item($item, $id, $class, $title, $label, $decsription){
		$decsription = $decsription ? $this -> add_description($decsription) : '' ;
		$class = 'cherry-section-'.$this->options['pattern'].' '.$class;

		$output = '<div id="wrap-'.$id.'" class="'.$class.'">';
		$output .= $title ? $this -> add_title($title) : '' ;
		if($this->options['pattern'] == 'inline'){
			$output .= $this -> add_label($id, $label) . $item . $decsription;
		}else{
			$output .= '<div class="cherry-col-1">' . $this -> add_label($id, $label). $decsription . '</div><div class="cherry-col-2">' . $item . '</div>';
		}
		$output .= '</div>';

		return $output;
	}

	/**
	* Add label to form items
	*
	* @since 4.0.0
	* @return string
	*/
	private function add_label($id, $label, $class = ''){
		$class = !$class ? $this->options['class']['label'] : $class ;

		$output = $label ? sprintf($this -> options['html_wrappers']['label_start'], 'for="' . $id . '"', 'class="cherry-label ' .$class . '"' ) : '' ;
		$output .= $label ;
		$output .= $label ? $this -> options['html_wrappers']['label_end'] : '' ;
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
	* Generated field id
	*
	* @since 4.0.0
	* @return string
	*/
	private function generate_field_id($id){
		$return_id = '';
		if($this->options['widget']['id_base'] && $this->options['widget']['number']){
			$return_id = 'widget-' . $this->options['widget']['id_base'] . '-' . $this->options['widget']['number'] . '-' . $id;
		}else{
			$return_id = $this -> options['name_prefix'] . '-' . $id;
		}
		return esc_attr($return_id);
	}

	/**
	* Generated field name
	*
	* @since 4.0.0
	* @return string
	*/
	private function generate_field_name($id){
		$return_name = '';
		if($id){
			if($this->options['widget']['id_base'] && $this->options['widget']['number']){
				$return_name = 'widget-' . $this->options['widget']['id_base'] . '[' . $this->options['widget']['number'] . '][' . $id . ']';
			}else{
				$return_name =  $this -> options['name_prefix'] . '[' . $id . ']';
			}
		}
		return esc_attr($return_name);
	}

	/**
	* Outputs generated items
	*
	* @param Array. Input argument name => argument value
	* @since 4.0.0
	* @return string
	*/
	public function multi_output_items($items){
		$output = '';
		foreach ($items as $item => $args) {
			$args['id'] = $item;
			$output .= $this -> add_form_item($args);
		}
		return $output;
	}

	/** 
	* Get list of available Google fonts.
	* 
	* @return Array. 
	* @since 4.0.0
	*/
	private function get_google_font(){
		if(empty($this -> google_font)){
			$json = file_get_contents( $this -> google_font_url );
			$content = json_decode ( $json, true );
			$font_array = $content['items'];
		}else{
			$font_array = $this -> google_font;
		}
		return $font_array;
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
		wp_enqueue_script( 'interface-bilder' );
	}
	/** 
	* Include interface builder CSS files
	* 
	* @since 4.0.0
	*/
	public function include_style(){
		wp_enqueue_style( 'interface-bilder' );
	}
}
?>