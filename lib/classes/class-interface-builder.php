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
					'class' => array(
						'text' => 'widefat',
						'textarea' => 'large-text code',
						'select' => 'widefat',
						'checkbox' => '',
						'multicheckbox' => '',
						'reset' => 'button button-primary',
						'submit' => 'button button-primary',
						'info' => 'info',
						'image' => 'button button-primary',
						'colorpicker' => '',
						'stepper' => 'widefat',
						'label' => 'cherry-label',
						'section' => ''
					),
					'html_wrappers' => array(
						'before_section'		=> '<section %1s %2s>',
						'after_section'			=> '</section>',
						'before_item'			=> '<p>',
						'after_item'			=> '</p>',
						'label_start'			=> '<label for="%1s">',
						'label_end'				=> '</label>',
						'before_title'			=> '<h4>',
						'after_title'			=> '</h4>',
						'before_decsription'	=> '<small>',
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
		$this -> google_font_url = PARENT_DIR . "/assets/font-list/google-fonts.json";

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
				$default[$key] = array_merge($value , $argument[$key]);
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
						'label_class'			=> '',
						'type'					=> '',
						'value'					=> '',
						'max_value'				=> '100',
						'min_value'				=> '0',
						'value_step'			=> '1',
						'default_value'			=> '',
						'options'				=> '',
						'upload_button_text'	=> __( 'Choose Image', 'cherry' ),
						'remove_button_text'	=> __( 'Remove Image', 'cherry' ),
						'display_image'			=> true,
						'display_input'			=> false,
						'label'					=> '',
						'title'					=> '',
						'decsription'			=> ''
					);
		extract(array_merge($default, $args));

		$value = $value == '' || $value == false &&  $value != 0 ? $default_value : $value ;
		$name = $this -> generate_field_name($id);
		$item_id = $id ? $this -> generate_field_id($id) : '' ;
		$class_name = isset($args['class']) ? $class : $this->options['class'][$type] ;
		$class = $class_name ? 'class="' . $class_name . '"' : '' ;
		$label_class = $label_class ? $label_class : $this->options['class']['label'] ;
		$item_inline_style = $inline_style ? 'style="' . $inline_style . '"' : '' ;
		$wrapper_class = 'section';
		$output = '';
		$wrap = true;
		$decsription_positon = 'after';

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
				label_class: cherry-label
				item_inline_style: ''
			*/
			case 'submit':
				$output = '<input ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '" >';
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
				label_class: cherry-label
				item_inline_style: ''
			*/
			case 'reset':
				$output = '<input ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" type="reset" value="' . esc_html( $value ) . '" >';
			break;
			/*
			arg:
				type: text
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: widefat
				label_class: cherry-label
				item_inline_style: ''
			*/
			case 'text':
				$item = '<input ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" type="'.$type.'" value="' . esc_html( $value ) . '" >';
				$output = $this -> add_label($item, $id, $label, $label_class, 'before');
			break;
			/*
			arg:
				type: textarea
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: ''
				label_class: cherry-label
				item_inline_style: ''
			*/
			case 'textarea':
				$item = '<textarea ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" rows="16" cols="20">' . esc_html( $value ) . '</textarea>';
				$output = $this -> add_label($item, $id, $label, $label_class, 'before');
			break;
			/*
			arg:
				type: select
				title: ''
				label: ''
				decsription: ''
				value: ''
				default_value: ''
				class: widefat
				label_class: cherry-label
				item_inline_style: ''
				options:
					key => value
			*/
			case 'select':
				$item = '<select ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '">';
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$item .= '<option value="' . $option . '" ' . selected( $value, $option, false ) . '>'. esc_html( $option_value ) .'</option>';
					}
				}
				$item .= '</select>';
				$output = $this -> add_label($item, $id, $label, $label_class, 'before');
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
				label_class: cherry-label
				item_inline_style: ''
			*/
			case 'checkbox':
				$item = '<input type="'.$type.'" ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" ' . checked( $default_value, $value, false ) . ' value="' . esc_html( $value ) . '" >';
				$output = $this -> add_label($item, $id, $label, $label_class, 'after');
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
				label_class: cherry-label
				item_inline_style: ''
				options:
					key => ''
			*/
			case 'multicheckbox':
				if($options && !empty($options) && is_array($options)){
					foreach ($options as $option => $option_value) {
						$name = $this -> generate_field_name($option);
						$item_id = $id ? $this -> generate_field_id($option) : '' ;

						$item = '<input type="checkbox" ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" ' . checked( $value, $option, false ) . ' value="' . esc_html( $option ) . '" >';
						$output .= $this -> add_label($item, $option, $option_value, $label_class, 'after');
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
				label_class: cherry-label
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
					foreach ($options as $option => $option_value) {
						$checked = $option == $value ? ' checked' : '' ;
						$item_id = $id ? $this -> generate_field_id($option) : '' ;
						$item_inline_style = $display_input ? $item_inline_style : 'style="' . $inline_style . ' display:none;"' ;
						$img = isset($option_value['img_src']) ? '<img src="'.$option_value['img_src'].'" alt="'.$option_value['label'].'"> ' : '' ;
						$label = $option_value['label'];

						$item = '<input type="'.$type.'" ' . $item_inline_style . ' ' . $class . ' id="' . $item_id . '" name="' . $name . '" '.$checked.' value="' . esc_html( $option ) . '" >'.$img;
						$output .= $this -> add_label($item, $option, $label, $label_class, 'after');
					}
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
				label_class: cherry-label
				item_inline_style: ''
				display_image: true/false
				upload_button_text:Choose Image
				remove_button_text:Remove Image
			*/
			case 'image':
				$img_style = !$value ? 'style="display:none;"' : '' ;
				$item = '<input ' . $item_inline_style . ' class="cherry-upload-input '.$this->options['class']['text'].'" id="' . $item_id . '" name="' . $name . '" type="text" value="' . esc_html( $value ) . '" >';
				$item .= '<input class="cherry-upload-image '.$this->options['class']['submit'].'" type="button" value="' . $upload_button_text . '" data-title="'.__( 'Choose Image', 'cherry' ).'" />';
				$item .= '<input class="cherry-remove-image '.$this->options['class']['submit'].'" type="button" value="' . $remove_button_text . '" />';
				$item .= $display_image ? '<span '.$img_style.' class="cherry-upload-preview" ><img  src="' . esc_html( $value ) . '" alt="'.__( 'Current Image', 'cherry' ).'"></span>' : '' ;
				$output .= $this -> add_label($item, $id, $label, $label_class, 'before');

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
				label_class: cherry-label
				class: ''
				item_inline_style: ''
			*/
			case 'colorpicker':
				$item = '<input id="' . $item_id . '" name="' . $name . '" value="' . esc_html( $value ) . '" ' . $item_inline_style . ' class="cherry-color-picker '. $class_name . '" type="text" />';
				$output .= $this -> add_label($item, $id, $label, $label_class, 'before');

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
				label_class: cherry-label
				class: widefat
				item_inline_style: ''
			*/
			case 'stepper':
				$item = $this -> add_label('', $id, $label, $label_class, 'before');
				$item .= '<input id="' . $item_id . '" name="' . $name . '" ' . $item_inline_style . ' class="cherry-stepper '.$class_name.'" type="text" value="' . esc_html( $value ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="' . esc_html( $min_value ) . '" data-value-step="' . esc_html( $value_step ) . '">';
				$item .= '<span class="cherry-stepper-controls"><a class="step-up" title="'.__( 'Step Up', 'cherry' ).'" href="#">+</a><a class="step-down" title="'.__( 'Step Down', 'cherry' ).'" href="#">-</a></span>';
				$output = $item;

				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
			/*
			arg:
				type: editor
				title: ''
				decsription: ''
				value: ''
				default_value: ''
				label_class: cherry-label
			*/
			case 'editor':
				$wrap = false;
				$decsription_positon = 'before';
				ob_start();
					$settings = array(
						'textarea_name' => $name,
						'media_buttons' => 1,
						'tinymce' => array( 'plugins' => 'wordpress' )
					);
					wp_editor( $value, $item_id, $settings );
				$item .= ob_get_clean();
				$output = $item;
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
				label_class: cherry-label
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
				$item = $this -> add_label('', $id, $label, $label_class, 'before');
				$item .= '<input id="' . $item_id . '[color]" name="' . $name . '[color]" value="' . esc_html( $value['color'] ) . '" class="cherry-color-picker '. $class_name . '" type="text" />';
				$item .= '<input class="cherry-upload-input '.$this->options['class']['text'].'" id="' . $item_id . '[image]" name="' . $name . '[image]" type="text" value="' . esc_html( $value['image'] ) . '" >';
				$item .= '<input class="cherry-upload-image '.$this->options['class']['submit'].'" type="button" value="' . esc_html( $upload_button_text ) . '" data-title="'.__( 'Choose Image', 'cherry' ).'" />';
				$item .= '<input class="cherry-remove-image '.$this->options['class']['submit'].'" type="button" value="' . esc_html( $remove_button_text ) . '" />';
				$item .= '<span '.$img_style.' class="cherry-upload-preview" >';
				$item .= $display_image ? '<img src="' . esc_html( $value['image'] ) . '" alt="'.__( 'Current Image', 'cherry' ).'">' : '' ;
				foreach ($background_options as $options_key => $options_value) {
					$item .= '<select class="'.$this->options['class']['select'].'" id="' . $item_id . '['.$options_key.']" name="' . $name . '['.$options_key.']">';
					foreach ($options_value as $option => $option_value) {
						$item .= '<option value="'.$option.'" ' . selected( $value[$options_key], $option, false ) . '>' . esc_html( $option_value ). '</option>';
					}
					$item .= '</select>';
				}
				$item .= '</span>';
				$output = $item;

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
				$wrapper_class = $type;
				$output = $value;
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
				label_class: cherry-label
			*/
			case 'typography':
				//size
				$item .= '<div class="field">';
				$item .= sprintf($this -> options['html_wrappers']['label_start'], $item_id . '[size]' ) . __( 'Font Size', 'cherry' ) . $this -> options['html_wrappers']['label_end'] ;
				$item .= '<input id="' . $item_id . '[size]" name="' . $name . '[size]" class="cherry-stepper font-size" type="text" value="' . esc_html(  $value['size'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
				$item .= '<span class="cherry-stepper-controls"><a class="step-up" title="'.__( 'Step Up', 'cherry' ).'" href="#">+</a><a class="step-down" title="'.__( 'Step Down', 'cherry' ).'" href="#">-</a></span>';
				$item .= ' px </div>';
				//lineheight
				$item .= '<div class="field">';
				$item .= sprintf($this -> options['html_wrappers']['label_start'], $item_id . '[lineheight]' ) . __( 'Lineheight', 'cherry' ) . $this -> options['html_wrappers']['label_end'] ;
				$item .= '<input id="' . $item_id . '[lineheight]" name="' . $name . '[lineheight]" class="cherry-stepper font-lineheight" type="text" value="' . esc_html( $value['lineheight'] ) . '" data-max-value="' . esc_html( $max_value ) . '" data-min-value="1" data-value-step="1">';
				$item .= '<span class="cherry-stepper-controls"><a class="step-up" title="'.__( 'Step Up', 'cherry' ).'" href="#">+</a><a class="step-down" title="'.__( 'Step Down', 'cherry' ).'" href="#">-</a></span>';
				$item .= ' px </div>';

				$font_array = $this -> get_google_font();
				$character_array = array();
				$style_array = array();
				//Font Family
				$item .= '<div class="field">';
				$item .= sprintf($this -> options['html_wrappers']['label_start'], $item_id . '[family]' ) . __( 'Font Family', 'cherry' ) . $this -> options['html_wrappers']['label_end'] ;
				$item .= '<select class="cherry-font-family" id="' . $item_id . '[family]" name="' . $name . '[family]">';
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

						$item .= '<option value="' . $font_value['family'] . '" data-category="' . $category . '" data-style="' . $style . '" data-character="' . $character . '" ' . selected( $value['family'], $font_value['family'], false ) . '>'. esc_html( $font_value['family'] ) .'</option>';
					}
				}
				$item .= '</select>';
				$item .= '</div>';

				//Font style
				$item .= '<div class="field">';
				$item .= sprintf($this -> options['html_wrappers']['label_start'], $item_id . '[style]' ) . __( 'Font Style', 'cherry' ) . $this -> options['html_wrappers']['label_end'] ;
				$item .= '<select class="cherry-font-style" id="' . $item_id . '[style]" name="' . $name . '[style]">';
				if($style_array && !empty($style_array) && is_array($style_array)){
					foreach ($style_array as $style_key => $style_value) {
						$item .= '<option value="' . $style_key . '" ' . selected( $value['style'], $style_key, false ) . '>'. esc_html( $style_value ) .'</option>';
					}
				}
				$item .= '</select>';
				$item .= '</div>';

				//Font character
				$item .= '<div class="field">';
				$item .= sprintf($this -> options['html_wrappers']['label_start'], $item_id . '[character]' ) . __( 'Character Sets', 'cherry' ) . $this -> options['html_wrappers']['label_end'] ;
				$item .= '<select class="cherry-font-character" id="' . $item_id . '[character]" name="' . $name . '[character]">';
				if($character_array && !empty($character_array) && is_array($character_array)){
					foreach ($character_array as $character_key => $character_value) {
						$item .= '<option value="' . $character_key . '" ' . selected( $value['character'], $character_key, false ) . '>'. esc_html( $character_value ) .'</option>';
					}
				}
				$item .= '</select>';
				$item .= '</div>';

				//color
				$item .= '<div class="field">';
				$item .= sprintf($this -> options['html_wrappers']['label_start'], $item_id . '[color]' ) . __( 'Font color', 'cherry' ) . $this -> options['html_wrappers']['label_end'] ;
				$item .= '<input id="' . $item_id . '[color]" name="' . $name . '[color]" value="' . esc_html( $value['color'] ) . '" class="cherry-color-picker" type="text" />';
				$item .= '</div>';

				$item .= '<input name="' . $name . '[category]" value="" class="cherry-font-category" type="hidden" />';

				$output = $item;

				add_action( 'admin_footer', array($this, 'include_colorpicker_script_style'));
				add_action( 'admin_footer', array($this, 'include_scripts'));
			break;
		}

		return $this -> wrap_item($output, $id, $this->options['class'][$wrapper_class].' section cherry-' . $type, $title, $decsription, $wrap, $decsription_positon);
	}

	/**
	* Add label to form items
	*
	* @since 4.0.0
	* @return string
	*/
	private function add_label($item, $id, $label, $label_class, $label_position){
		$output = $label ? sprintf($this -> options['html_wrappers']['label_start'], $this -> generate_field_id($id) ) : '' ;
		$output .= !$label_position || $label_position == 'before' ? '<span class="' . $label_class . '">' . $label . '</span>' . ' ' . $item : $item . ' <span class="' . $label_class . '">' . $label . '</span>';
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
		return $this->options['html_wrappers']['before_decsription'] . $decsription . $this->options['html_wrappers']['after_decsription'];
	}

	/**
	* Add title to form items
	*
	* @since 4.0.0
	* @return string
	*/
	private function add_title($title){
		return $this->options['html_wrappers']['before_title'] . $title . $this->options['html_wrappers']['after_title'];
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
	* Wrap the generated item
	*
	* @since 4.0.0
	* @return string
	*/
	private function wrap_item($item, $id, $class, $title, $decsription, $wrap = true, $decsription_positon = 'after'){
		$decsription = $decsription ? $this -> add_description($decsription) : '' ;

		$output = sprintf($this -> options['html_wrappers']['before_section'], 'id="wrap-'.$id.'"', 'class="'.$class.'"');
		$output .= $title ? $this -> add_title($title) : '' ;
		$output .= $decsription_positon != 'after' ? $decsription : '' ;
		$output .= $wrap ? $this -> options['html_wrappers']['before_item'] : '' ;
		$output .= $item;
		$output .= $wrap ? $this -> options['html_wrappers']['after_item'] : '' ;
		$output .= $decsription_positon == 'after' ? $decsription : '' ;
		$output .= $this -> options['html_wrappers']['after_section'];

		return $output;
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
		wp_print_media_templates();
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