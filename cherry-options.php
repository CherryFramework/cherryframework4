<?php

function cherry_defaults_settings() {
	global $cherry_registered_statics, $cherry_registered_static_areas;
	$all_statics = $cherry_registered_statics;

	//var_dump($all_statics);
////////// Demo options ///////////////////////////////////////////////////////
	$demo_options = array();
	$demo_options['title-demo'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Demo options</h2>'
	);
	$demo_options['icons-editor'] = array(
				'type'			=> 'icon_editor',
				'title'			=> 'title icon-editor',
				'label'			=> 'label icon-editor',
				'decsription'	=> 'decsription icon-editor',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> array(
					'icon_1' => array(
						'title'		=> __('Facebook', 'cherry'),
						'type'		=> 'label',
						'text'		=> 'Facebook',
						'link'		=> 'https://facebook.com/',
					),
					'icon_2' => array(
						'title'		=> __('Facebook', 'cherry'),
						'type'		=> 'img',
						'upload'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png',
						'link'		=> 'https://facebook.com/',
					),
					'icon_3' => array(
						'title'		=> __('Facebook', 'cherry'),
						'type'		=> 'font',
						'class'		=> 'dashicons dashicons-carrot',
						'link'		=> 'https://facebook.com/',
					),
					'icon_4' => array(
						'title'		=> __('Facebook', 'cherry'),
						'type'		=> 'sprite',
						'class'		=> 'sprite-class',
						'link'		=> 'https://facebook.com/',
					)
				),
				'default_value'	=> 'default_value'
	);
	$demo_options['static-area-editor'] = array(
				'type'			=> 'static_area_editor',
				'title'			=> 'title static-area-editor',
				'label'			=> 'label static-area-editor',
				'decsription'	=> 'decsription static-area-editor',
				'hint'			=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> $all_statics,
				'default_value'	=> 'default_value',
				'options' => $all_statics
	);
	$demo_options['text-demo'] = array(
				'type'			=> 'text',
				'title'			=> 'title text',
				'label'			=> 'label text',
				'decsription'	=> 'decsription text',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'value',
				'default_value'	=> 'default_value'
	);
	$demo_options['textarea-demo'] = array(
				'type'			=> 'textarea',
				'title'			=> 'title textarea',
				'label'			=> 'label textarea',
				'decsription'	=> 'decsription textarea',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> 'value',
				'default_value'	=> 'default_value'
	);
	$demo_options['select-demo'] = array(
				'type'			=> 'select',
				'title'			=> 'title select',
				'label'			=> 'label select',
				'decsription'	=> 'decsription select',
				'hint'      	=>  array(
					'type'		=> 'video',
					'content'	=> 'https://www.youtube.com/watch?v=2kodXWejuy0'
				),
				'value'			=> 'select-1',
				'default_value'	=> 'select-1',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'select 1',
					'select-2'	=> 'select 2',
					'select-3'	=> 'select 3'
				)
	);
	$demo_options['filterselect-demo'] = array(
				'type'			=> 'filterselect',
				'title'			=> 'title filterselect',
				'label'			=> 'label filterselect',
				'decsription'	=> 'decsription filterselect',
				'hint'      	=>  array(
					'type'		=> 'video',
					'content'	=> 'https://player.vimeo.com/video/97337577'
				),
				'value'			=> 'select_1',
				'default_value'	=> 'select_1',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'select 1',
					'select-2'	=> 'select 2',
					'select-3'	=> 'select 3',
					'select-4'	=> 'select 4',
					'select-5'	=> 'select 5',
					'select-6'	=> 'select 6',
					'select-7'	=> 'select 2',
					'select-8'	=> 'select 8'
				)
	);
	$demo_options['multiselect-demo'] = array(
				'type'			=> 'multiselect',
				'title'			=> 'title multiselect',
				'label'			=> 'label multiselect',
				'decsription'	=> 'decsription multiselect',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'placeholder'	=> 'Select value',
				'value'			=> array('select-1','select-8'),
				'default_value'	=> array('select-1','select-8'),
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'Item 1',
					'select-2'	=> 'Item 2',
					'select-3'	=> 'Item 3',
					'select-4'	=> 'Item 4',
					'select-5'	=> 'Item 5',
					'select-6'	=> 'Item 6',
					'select-7'	=> 'Item 7',
					'select-8'	=> 'Item 8'
				)
	);
	$demo_options['checkbox-demo'] = array(
				'type'			=> 'checkbox',
				'title'			=> 'title checkbox',
				'label'			=> 'label checkbox',
				'decsription'	=> 'decsription checkbox',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$demo_options['switcher-demo'] = array(
				'type'			=> 'switcher',
				'title'			=> 'title switcher',
				'label'			=> 'label switcher',
				'decsription'	=> 'decsription switcher',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$demo_options['switcher-custom-toogle-demo'] = array(
				'type'			=> 'switcher',
				'title'			=> 'title custom switcher',
				'label'			=> 'label custom switcher',
				'decsription'	=> 'decsription custom switcher',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'true',
				'default_value'	=> 'true',
				'toggle'		=> array(
					'true_toggle'	=> __( 'Enabled', 'cherry' ),
					'false_toggle'	=> __( 'Disabled', 'cherry' )
				),
				'nested_items' => array(
					'true_relative' => 'wrap-cherry-title-demo-sw-enable',
					'false_relative' => 'wrap-cherry-title-demo-sw-disable'
				)
	);
	$demo_options['slider-demo'] = array(
				'type'			=> 'slider',
				'title'			=> 'title Slider',
				'label'			=> 'label Slider',
				'decsription'	=> 'decsription Slider',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'max_value'		=> 1920,
				'min_value'		=> 980,
				'value'			=> 1000
	);
	$demo_options['rangeslider-demo'] = array(
				'type'			=> 'rangeslider',
				'title'			=> 'title Range Slider',
				'label'			=> 'label Range Slider',
				'decsription'	=> 'decsription Range Slider',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'max-value'		=> 100,
				'min-value'		=> 0,
				'value'			=> array(
					'left-value'	=> 20,
					'right-value'	=> 50,
				),
				'default_value' => array(
					'left-value'	=> 0,
					'right-value'	=> 100,
				)
	);
	$demo_options['multicheckbox-demo'] = array(
				'type'			=> 'multicheckbox',
				'title'			=> 'title multicheckbox',
				'label'			=> 'label multicheckbox',
				'decsription'	=> 'decsription multicheckbox',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'class'			=> '',
				'value'			=> array(
					'checkbox-1'	=> true,
					'checkbox-2'	=> false,
					'checkbox-3'	=> true
				),
				'default_value'	=> array(
					'checkbox-1'	=> false,
					'checkbox-2'	=> true,
					'checkbox-3'	=> true
				),
				'options'		=> array(
					'checkbox-1'	=> 'checkbox 1',
					'checkbox-2'	=> 'checkbox 2',
					'checkbox-3'	=> 'checkbox 3'
				)
	);
	$demo_options['radio-demo'] = array(
				'type'			=> 'radio',
				'title'			=> 'title radio',
				'label'			=> 'label radio',
				'decsription'	=> 'decsription radio',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'radio-2',
				'default_value'	=> 'radio-1',
				'class'			=> '',
				'display-input'	=> true,
				'options'		=> array(
					'radio-1' => array(
						'label' => 'radio 1',
						'img_src' => ''
					),
					'radio-2' => array(
						'label' => 'radio 2',
						'img_src' => ''
					),
					'radio-3' => array(
						'label' => 'radio 3',
						'img_src' => ''
					),
				)
	);
	$demo_options['radio-image-demo'] = array(
				'type'			=> 'radio',
				'title'			=> 'title radio',
				'label'			=> 'label radio',
				'decsription'	=> 'decsription radio',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'radio-image-1',
				'default_value'	=> 'radio-image-1',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'radio-image-1' => array(
						'label' => 'radio image 1',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio-image-2' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio-image-3' => array(
						'label' => 'radio image 3',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
				)
	);
	$demo_options['image-demo'] = array(
				'type'				=> 'image',
				'title'				=> 'title image',
				'label'				=> 'label image',
				'decsription'		=> 'decsription image',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'				=> '',
				'default_value'		=> '',
				'display-image'		=> true,
				'multi-upload'		=> true,
				'return-data_type'	=> 'url'
	);
	$demo_options['colorpicker-demo'] = array(
				'type'			=> 'colorpicker',
				'title'			=> 'title colorpicker',
				'label'			=> 'label colorpicker',
				'decsription'	=> 'decsription colorpicker',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> '#ff0000',
				'default_value'	=> '#ff0000'
	);
	$demo_options['stepper-demo'] = array(
				'type'			=> 'stepper',
				'title'			=> 'title stepper',
				'label'			=> 'label stepper',
				'decsription'	=> 'decsription stepper',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> '0',
				'default_value'	=> '0',
				'value-step'	=> '1',
				'max-value'		=> '50',
				'min-value'		=> '-50'
	);
	$demo_options['editor-demo'] = array(
				'type'			=> 'editor',
				'title'			=> 'title editor',
				'label'			=> 'label editor',
				'decsription'	=> 'decsription editor',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'Lorem ipsum',
				'default_value'	=> 'editor'
	);
	$demo_options['background-demo'] = array(
				'type'				=> 'background',
				'title'				=> 'title background',
				'label'				=> 'label background',
				'decsription'		=> 'decsription background',
				'hint'      		=>  array(
					'type'			=> 'text',
					'content'		=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'return_data_type'	=> 'url',
				'value'				=> array(
					'image'			=> '',
					'color'			=> '#ff0000',
					'repeat'		=> 'repeat',
					'position'		=> 'left',
					'attachment'	=> 'fixed',
					'origin'		=> 'padding-box'
				)
	);
	$demo_options['info-demo'] = array(
				'type'			=> 'info',
				'title'			=> 'title info',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>info</h2>'
	);
	$demo_options['typography-demo'] = array(
				'type'			=> 'typography',
				'title'			=> 'title typography',
				'label'			=> 'label typography',
				'decsription'	=> 'decsription typography',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> array(
					'size'			=> '10',
					'lineheight'	=> '10',
					'color'			=> 'blue',
					'family'		=> 'Abril Fatface',
					'character'		=> 'latin-ext',
					'style'			=> 'italic',
					'letterspacing' => '0',
					'align'			=> 'notdefined'
				)
	);
	$demo_options['submit-demo'] = array(
				'type'			=> 'submit',
				'value'			=> 'get value'
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// General options //////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$general_options = array();
	$general_options['general-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=> '<h2>General options</h2>'
	);
	$general_options['general-logo'] = array(
			'type'				=> 'image',
			'title'				=> 'Logo',
			'label'				=> 'Choose four images',
			'decsription'		=> 'Retina ready logo set',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Logo for Apple iPhone<br>
								Logo for Apple iPhone Retina<br>
								Logo for Apple iPad<br>
								Logo for Apple iPad Retina<br>'
			),
			'value'				=> '',
			'default_value'		=> '',
			'display_image'		=> true,
			'multi_upload'		=> true,
			'return_data_type'	=> 'url'
	);
	$general_options['general-logo-type'] = array(
				'type'			=> 'radio',
				'title'			=> 'what kind of logo?',
				'value'			=> 'text-logo',
				'default_value'	=> 'image-logo',
				'class'			=> '',
				'display-input'	=> true,
				'options'		=> array(
					'radio-1' => array(
						'label' => 'radio 1',
						'img_src' => ''
					),
					'radio-2' => array(
						'label' => 'radio 2',
						'img_src' => ''
					),
					'radio-3' => array(
						'label' => 'radio 3',
						'img_src' => ''
					),
				)
	);
	$general_options['general-favicon'] = array(
				'type'				=> 'image',
				'title'				=> 'Favicon',
				'label'				=> 'Choose four images',
				'decsription'		=> 'Retina ready favicon set',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Icon for Apple iPhone (57px * 57px) <br>
									Icon for Apple iPhone Retina (114px * 114px)<br>
									Icon for Apple iPad (72px * 72px)<br>
									Icon for Apple iPad Retina (144px * 144px )<br>'
				),
				'value'				=> '',
				'default_value'		=> '',
				'display_image'		=> true,
				'multi_upload'		=> true,
				'return_data_type'	=> 'url'
	);
	$general_options['general-page-comments'] = array(
				'type'			=> 'switcher',
				'title'			=> 'page comments',
				'label'			=> 'Enable / Disable',
				'decsription'	=> 'Display comments on regular page',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Disable or enable comments by default on new pages and custom post types. You can change the default for new posts or pages, as well as enable/disable comments on posts or pages you’ve already published.'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$general_options['general-featured-images'] = array(
				'type'			=> 'switcher',
				'title'			=> 'featured images',
				'label'			=> 'Enable / Disable',
				'decsription'	=> 'Display featured images on page',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Disable or enable displaying of featured images'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$general_options['general-user-css'] = array(
				'type'			=> 'switcher',
				'title'			=> 'User CSS',
				'label'			=> 'ON / OFF',
				'decsription'	=> 'Include user css file',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Disable or enable user css file'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$general_options['general-google-analytics'] = array(
				'type'			=> 'textarea',
				'title'			=> 'Google Analytic',
				'decsription'	=> 'Google Analytic code goes here',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'This code will be added into the footer template of your theme.'
				),
				'value'			=> 'value',
				'default_value'	=> 'default_value'
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Header options //////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$header_options = array();
	$header_options['header-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=> '<h2>Header options</h2>'
	);
	$header_options['header-type-layout'] = array(
			'type'			=> 'radio',
			'title'			=> __('Header type layout', 'cherry'),
			'label'			=> __('Header type layout', 'cherry'),
			'decsription'	=> __('Choose header type layout.', 'cherry'),
			'value'			=> 'header-type-layout-radio-1',
			'default_value'	=> 'header-type-layout-radio-1',
			'class'			=> '',
			'display_input'	=> false,
			'options'		=> array(
				'header-type-layout-radio-1' => array(
					'label' => 'Top static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-static.png'
				),
				'header-type-layout-radio-2' => array(
					'label' => 'Left static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-static.png'
				),
				'header-type-layout-radio-3' => array(
					'label' => 'Right static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-static.png'
				),
				'header-type-layout-radio-4' => array(
					'label' => 'Top toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-toggle.png'
				),
				'header-type-layout-radio-5' => array(
					'label' => 'Left toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-toggle.png'
				),
				'header-type-layout-radio-6' => array(
					'label' => 'Right toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-toggle.png'
				)
			)
	);
	$header_options['header-background'] = array(
			'type'			=> 'background',
			'title'			=> 'Header background',
			'label'			=> 'Header styling section',
			'decsription'	=> 'Change the Header background',
			'return_data_type'	=> 'id',
			'value'			=> array(
					'image'	=> '',
					'color'	=> '#a4cc3f',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
	$header_options['header-background-full-scale'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header full scale background',
			'label'			=> 'Enable / Disable',
			'decsription'	=> 'Enable/Disable header full scale background',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
	$header_options['header-parallax-effect'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Parallax effect',
			'label'			=> 'Parallax effect',
			'decsription'	=> 'Enable/Disable header parallax effect',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$header_options['header-sticky'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header sticky',
			'label'			=> 'Enable/Disable',
			'decsription'	=> 'Enable/Disable header sticky',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
	$header_options['header-sticky-tablets'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header sticky on tablets',
			'label'			=> 'Enable/Disable',
			'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'For enable a fixed header when scrolling on tablets select enable or unselect to disable'
				),
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$header_options['header-sticky-mobiles'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header sticky on mobiles',
			'label'			=> 'Enable/Disable',
			'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'For enable a fixed header when scrolling on mobiles select enable or unselect to disable'
				),
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Footer options /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
	$footer_options = array();
	$footer_options['footer-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=> '<h2>Footer options</h2>'
	);
	$footer_options['footer-background'] = array(
			'type'			=> 'background',
			'title'			=> 'Footer background',
			'label'			=> 'Footer styling section',
			'decsription'	=> 'Change the footer background',
			'return_data_type'	=> 'id',
			'value'			=> array(
					'image'	=> '',
					'color'	=> '#a4cc3f',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
	$footer_options['footer-background-full-scale'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Footer full scale background',
			'label'			=> 'Enable / Disable',
			'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Enable this option to have footer area scale according to the browzer size. Background image display at 100% in width and height'
				),
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
	$footer_options['footer-parallax-effect'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Parallax effect',
			'label'			=> 'Parallax effect',
			'decsription'	=> 'Enable/Disable footer parallax effect',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
	$footer_options['footer-sticky'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Footer sticky',
			'label'			=> 'Enable/Disable',
			'decsription'	=> 'Enable/Disable footer sticky',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Grid options /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
	$grid_options = array();
	$grid_options['grid-options'] = array(
		'type'        => 'info',
		'title'       => '',
		'decsription' => 'decsription info',
		'value'       => '<h2>Grid Options</h2>',
	);
	$grid_options['grid-type'] = array(
				'type'        => 'radio',
				'title'       => __( 'Grid type', 'cherry' ),
				'label'       => __( 'select one of them', 'cherry' ),
				'decsription' => __( 'Grid type for main container', 'cherry' ),
				'hint'        => array(
					'type'    => 'text',
					'content' => __( 'Background pattern for main container', 'cherry' ),
				),
				'value'         => 'grid-boxed',
				'default_value' => 'grid-boxed',
				'class'         => '',
				'display_input' => false,
				'options'       => array(
					'grid-wide' => array(
						'label'   => __( 'Wide', 'cherry' ),
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'grid-boxed' => array(
						'label'   => __( 'Boxed', 'cherry' ),
						'img_src' => PARENT_URI.'/screenshot.png'
					),
				),
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// Page layout options ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////


		$page_layout_options = array();
		$page_layout_options['page-layout-options'] = array(
			'type'  => 'info',
			'value' =>'<h2>Page layouts</h2>',
		);

		$page_layout_options['page-layout-container-width'] = array(
			'type'        => 'slider',
			'title'       => __( 'Container width', 'cherry' ),
			'decsription' => __( 'Width of main container (px)', 'cherry' ),
			'hint'        => array(
				'type'    => 'text',
				'content' => __( 'Width of main container (px)', 'cherry' ),
			),
			'max_value' => 1920, // Full HD
			'min_value' => 970,
			'value'     => 1170,
		);

		$page_layout_options['page-layout-type-options'] = array(
			'type'			=> 'radio',
			'title'			=> __('Header type layout', 'cherry'),
			'label'			=> __('Header type layout', 'cherry'),
			'decsription'	=> __('Choose header type layout.', 'cherry'),
			'value'			=> 'header-type-layout-radio-1',
			'default-value'	=> 'header-type-layout-radio-1',
			'class'			=> '',
			'display_input'	=> false,
			'options'		=> array(
				'header-type-layout-radio-1' => array(
					'label' => 'Top static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-static.png'
				),
				'header-type-layout-radio-2' => array(
					'label' => 'Left static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-static.png'
				),
				'header-type-layout-radio-3' => array(
					'label' => 'Right static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-static.png'
				),
				'header-type-layout-radio-4' => array(
					'label' => 'Top toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-toggle.png'
				),
				'header-type-layout-radio-5' => array(
					'label' => 'Left toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-toggle.png'
				),
				'header-type-layout-radio-6' => array(
					'label' => 'Right toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-toggle.png'
				)
			)
	);

////////// Logo options ///////////////////////////////////////////////////////

	$logo_options = array();
	$logo_options['logo-options'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Logo options</h2>'
	);
	$logo_options['logo-kind'] = array(
				'type'			=> 'radio',
				'title'			=> 'Logo type',
				'label'			=> 'What kind of logo?',
				'decsription'	=> 'Select whether you want your main logo to be an image or text. If you select "image" you can put in the image url in the next option, and if you select "text" your Site Title will be shown instead.',
				'value'			=> 'radio-1',
				'default_value'	=> 'radio-1',
				'class'			=> '',
				'display_input'	=> true,
				'options'		=> array(
					'radio-1' => array(
						'label' => 'Image logo',
						'img_src' => ''
					),
					'radio-2' => array(
						'label' => 'Text logo',
						'img_src' => ''
					)
				)
	);
	$logo_options['logo-image-path'] = array(
				'type'				=> 'image',
				'title'				=> 'Logo Image Path',
				'label'				=> 'Click Upload or Enter the direct path to your logo image.',
				'decsription'		=> 'For example //your_website_url_here/wp-content/themes/themeXXXX/images/logo.png',
				'value'				=> '',
				'default_value'		=> '',
				'display-image'		=> true,
				'multi-upload'		=> true,
				'return-data_type'	=> 'url'
	);
	$logo_options['logo-typography'] = array(
				'type'			=> 'typography',
				'title'			=> 'Logo Typography',
				'label'			=> 'Logo Typography style',
				'decsription'	=> 'Choose your prefered font for menu.',
				'value'			=> array(
					'size'			=> '14',
					'lineheight'	=> '14',
					'color'			=> '#aa00aa',
					'family'		=> 'Abril Fatface',
					'character'		=> 'latin-ext',
					'style'			=> 'italic',
					'letterspacing' => '0',
					'align'			=> 'notdefined'
				)
	);
////////// Navigation options ///////////////////////////////////////////////////
		$navigation_options = array();
		$navigation_options['navigation-options'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Navigation options</h2>'
		);
		$navigation_options['stickup-menu'] = array(
				'type'			=> 'switcher',
				'title'			=> 'StickUp menu',
				'label'			=> 'Using stickUp menu',
				'decsription'	=> 'Do you want to use stickUp menu?',
				'value'			=> 'true',
				'default_value'	=> 'default_value'
		);
		$navigation_options['menu-typography'] = array(
				'type'			=> 'typography',
				'title'			=> 'Menu Typography',
				'label'			=> 'Menu Typography style',
				'decsription'	=> 'Choose your prefered font for menu.',
				'value'			=> array(
					'size'			=> '14',
					'lineheight'	=> '14',
					'color'			=> '#aa00aa',
					'family'		=> 'Abril Fatface',
					'character'		=> 'latin-ext',
					'style'			=> 'italic',
					'letterspacing' => '0',
					'align'			=> 'notdefined'
				)
		);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Breadcrumbs options ////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$breadcrumbs_options = array();
		$breadcrumbs_options['breadcrumbs-options'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'description'	=>'description',
				'value'			=>'<h2>Breadcrumbs options'
		);
		$breadcrumbs_options['breadcrumbs'] = array(
				'type'			=> 'switcher',
				'title'			=> 'Breadcrumbs',
				'label'			=> 'Enable / Disable',
				'decsription'	=> 'Enable or disable breadcrumb navigation',
				'value'			=> 'true',
				'default_value'	=> 'default_value'
		);
		$breadcrumbs_options['breadcrumbs-display'] = array(
				'type'			=> 'multicheckbox',
				'title'			=> 'Breadcrumb display',
				'label'			=> 'Enable / Disable',
				'decsription'	=> 'decsription multicheckbox',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Enable or disable displaying on mobile devices'
				),
				'class'			=> '',
				'value'			=> array(
					'checkbox-1'	=> true,
					'checkbox-2'	=> true,
				),
				'default_value'	=> array(
					'checkbox-1'	=> true,
					'checkbox-2'	=> true,
				),
				'options'		=> array(
					'checkbox-1'	=> 'tablet',
					'checkbox-2'	=> 'mobile',
				)
		);
		$breadcrumbs_options['breadcrumbs-bg-color'] = array(
				'type'			=> 'background',
				'title'			=> 'title background',
				'label'			=> 'set default background',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Background for main breadcrumb container'
				),
				'return_data_type'	=> 'url',
				'value'			=> array(
					'image'	=> '',
					'color'	=> '#ffCCCC',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
		);
		$breadcrumbs_options['breadcrumbs-bg-hover-color'] = array(
				'type'			=> 'background',
				'title'			=> 'title background',
				'label'			=> 'set default background',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Background hover for main breadcrumb container'
				),
				'return_data_type'	=> 'url',
				'value'			=> array(
					'image'		=> '',
					'color'		=> '#ffCCCC',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
		);
		$breadcrumbs_options['breadcrumbs-separator'] = array(
				'type'			=> 'filterselect',
				'title'			=> 'Item separator',
				'label'			=> 'select separator type',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> 'arrow-outline',
				'default_value'	=> 'arrow-outline',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'box-outline',
					'select-2'	=> 'arrow-outline',
					'select-3'	=> 'divider-outline',
					'select-4'	=> 'divider-arrow-outline'
				)
		);
		$breadcrumbs_options['breadcrumbs-separator-icon'] = array(
				'type'			=> 'filterselect',
				'title'			=> 'Item icon separator',
				'label'			=> 'select separator type',
				//'decsription'	=> 'decsription filterselect',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> 'icon-right-dir',
				'default_value'	=> 'icon-right-dir',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'icon-right-open',
					'select-2'	=> 'icon-right-open-mini',
					'select-3'	=> 'icon-right-dir',
					'select-4'	=> 'icon-right-bold',
					'select-5'	=> 'icon-right-thin'
				)
		);
		$breadcrumbs_options['breadcrumbs-style'] = array(
				'type'			=> 'select',
				'title'			=> 'Breadcrumb style',
				'label'			=> 'Select one of theme',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'For a stylized display breadcrumbs select one of the types'
				),
				'value'			=> 'simple',
				'default_value'	=> 'simple',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'simple',
					'select-2'	=> 'tabbed',
				)
		);
		$breadcrumbs_options['breadcrumbs-link-color'] = array(
				'type'			=> 'colorpicker',
				'title'			=> 'color for breadcrumbs link',
				'label'			=> 'select color',
				'value'			=> '#ff5566',
				'default_value'	=> '#ff5566'
		);
		$breadcrumbs_options['breadcrumbs-link-hover-color'] = array(
				'type'			=> 'colorpicker',
				'title'			=> 'hover color for breadcrumbs link',
				'label'			=> 'select color',
				'value'			=> '#ff5566',
				'default_value'	=> '#ff5566'
		);
		$breadcrumbs_options['breadcrumbs-active-link-color'] = array(
				'type'			=> 'colorpicker',
				'title'			=> 'color for active breadcrumbs link',
				'label'			=> 'select color',
				'value'			=> '#ff5566',
				'default_value'	=> '#ff5566'
		);
		$breadcrumbs_options['breadcrumbs-home-link-color'] = array(
				'type'			=> 'colorpicker',
				'title'			=> 'color for breadcrumbs home link',
				'label'			=> 'select color',
				'value'			=> '#454545',
				'default_value'	=> '#454545'
		);
		$breadcrumbs_options['breadcrumbs-prefix-path'] = array(
				'type'			=> 'text',
				'title'			=> 'breadcrumbs prefix path',
				'decsription'	=> 'Title before breadcrumb navigation',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> 'You are here',
				'default_value'	=> 'You are here'
		);
		$breadcrumbs_options['breadcrumbs-hierarchical-attachments'] = array(
				'type'			=> 'switcher',
				'title'			=> 'breadcrumb hierarchical attachments',
				'label'			=> 'Enable / Disable',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Show the taxonomy leading to a post in the breadcrumb trail.'
				),
				'value'			=> 'false',
				'default_value'	=> 'default_value'

		);
		$breadcrumbs_options['breadcrumbs-post-hierarchy'] = array(
				'type'			=> 'select',
				'title'			=> 'Breadcrumbs post hierarchy',
				'label'			=> 'Select one of them',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'The hierarchy which the breadcrumb trail will show. Note that the "Post Parent" option may require an additional plugin to behave as expected since this is a non-hierarchical post type.'
				),
				'value'			=> 'Categories',
				'default_value'	=> 'Categories',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'Categories',
					'select-2'	=> 'Dates',
					'select-3'	=> 'Tags',
					'select-4'	=> 'Post Parent',
				)
		);
		$breadcrumbs_options['breadcrumbs-title-length'] = array(
				'type'			=> 'stepper',
				'title'			=> 'breadcrumb title length',
				'label'			=> 'max title length',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Limit the length of the breadcrumb title'
				),
				'value'			=> '0',
				'default_value'	=> '0',
				'value-step'	=> '1',
				'max-value'		=> '150',
				'min-value'		=> '1'
		);

//////////////////////////////// Page navigation options /////////////////////////////////////////////
		$pagination_option = array();
		$pagination_option['pagination-options'] = array(
				'type'			=> 'info',
				'title'			=>	'',
				'description'	=>	'description info',
				'value' 		=>	'<h2>Pagination options</h2>'
		);
		$pagination_option['pagination-display'] = array(
				'type'			=>  'switcher',
				'title' 		=>  'pagination',
				'label'			=>	'Enable / Disable',
				'value'			=>	'true',
				'default_value'	=>	'true'
		);
		$pagination_option['pagination-type'] = array(
				'type'			=> 'select',
				'title'			=> 'Page navigation type',
				'label'			=> 'Select one of them',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Select the pagination type'
				),
				'value'			=> 'pagination',
				'default_value'	=> 'pagination',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'pagination',
					'select-2'	=> 'infinite scroll',
					'select-3'	=>	'title navigation'
				)
		);
		$pagination_option['pagination-next-previous'] = array(
				'type'			=>  'switcher',
				'title' 		=>  'pagination',
				'label'			=>	'Enable / Disable',
				'value'			=>	'true',
				'default_value'	=>	'true'
		);
		$pagination_option['pagination-label'] = array(
				'type'			=> 'text',
				'title'			=> 'pagination label',
				'decsription'	=> 'The text/HTML to display before the list of pages',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> 'Pages:',
				'default_value'	=> 'Pages:'
		);
		$pagination_option['pagination-previous-page'] = array(
				'type'			=> 'text',
				'title'			=> 'previous page',
				'decsription'	=> 'The text/HTML to display for the next page link',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> '&laquo;',
				'default_value'	=> '&laquo;'
		);
		$pagination_option['pagination-next-page'] = array(
				'type'			=> 'text',
				'title'			=> 'next page',
				'decsription'	=> 'Limit the length of the breadcrumb title',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> '&raquo;',
				'default_value'	=> '&raquo;'
		);
		$pagination_option['pagination-page-range'] = array(
				'type'			=> 'stepper',
				'title'			=> 'page range',
				'decsription'	=> 'decsription stepper',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'The number of page links to show before and after the current page. Recommended value: 4'
				),
				'value'			=> '4',
				'default_value'	=> '4',
				'value-step'	=> '1',
				'max-value'		=> '9999',
				'min-value'		=> '1'
		);
		$pagination_option['pagination-page-anchors'] = array(
				'type'			=> 'stepper',
				'title'			=> 'page anchors',
				'decsription'	=> 'decsription stepper',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'The number of links to always show at beginning and end of pagination. Recommended value: 1'
				),
				'value'			=> '1',
				'default_value'	=> '1',
				'value-step'	=> '1',
				'max-value'		=> '99',
				'min-value'		=> '1'
				);
		$pagination_option['pagination-page-gap'] = array(
				'type'			=> 'stepper',
				'title'			=> 'page anchors',
				'decsription'	=> 'decsription stepper',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'The minimum number of pages in a gap before an ellipsis (...) is added. Recommended value: 3'
				),
				'value'			=> '3',
				'default_value'	=> '3',
				'value-step'	=> '1',
				'max-value'		=> '9999',
				'min-value'		=> '1'
		);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Styling options /////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$styling_options = array();
	$styling_options['styling-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=> '<h2>Styling Options</h2>'
	);
	//background image
	$styling_options['styling-main-content-background'] = array(
				'type'			=> 'background',
				'title'			=> 'title background',
				'label'			=> 'set default background',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Background for main container'
				),
				'return_data_type'	=> 'url',
				'value'				=> array(
					'image'	=> '',
					'color'	=> '#ff0000',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
	$styling_options['styling-main-background-full-scale'] = array(
				'type'			=> 'switcher',
				'title'			=> 'Full scale background',
				'label'			=> 'Enable / Disable',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Enable this option to have scale according to the browzer size. Background image display at 100% in width and height'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$styling_options['styling-main-parallax-background'] = array(
				'type'			=> 'switcher',
				'title'			=> 'Parallax background',
				'label'			=> 'Enable / Disable',
				'decsription'	=> 'Parallax background on main container',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'For using parallax effect on background press ON.'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$styling_options['styling-main-background-pattern'] = array(
				'type'			=> 'radio',
				'title'			=> 'background pattern',
				'label'			=> 'select one of them',
				'decsription'	=> 'Background pattern for main container',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Background pattern for main container'
				),
				'value'			=> 'background-pattern-radio-2',
				'default_value'	=> 'background-pattern-radio-2',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'background-pattern-radio-1' => array(
						'label' => 'radio image 1',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'background-pattern-radio-2' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'background-pattern-radio-3' => array(
						'label' => 'radio image 3',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'background-pattern-radio-4' => array(
						'label' => 'radio image 4',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'background-pattern-radio-5' => array(
						'label' => 'radio image 5',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'background-pattern-radio-6' => array(
						'label' => 'radio image 6',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
				)
	);
	$styling_options['styling-color-scheme'] = array(
				'type'			=> 'radio',
				'title'			=> 'color scheme',
				'label'			=> 'select one of them',
				'decsription'	=> 'decsription radio',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'radio-image-8',
				'default_value'	=> 'radio-image-8',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'radio-image-8' => array(
						'label' => 'radio image 8',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio-image-9' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio-image-10' => array(
						'label' => 'radio image 3',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
				)
	);
	$styling_options['styling-primary-field-background'] = array(
			'type'			=> 'background',
			'title'			=> 'Primary input field background',
			'label'			=> 'Select background color',
			'decsription'	=> 'Primary input field background',
			'return_data_type'	=> 'id',
			'value'			=> array(
					'image'	=> '',
					'color'	=> '#a4cc3f',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
	$styling_options['styling-primary-invalid-field-background'] = array(
			'type'			=> 'background',
			'title'			=> 'Primary invalid field background',
			'label'			=> 'Select invalid background color',
			'decsription'	=> 'Primary input invalid field background ',
			'return_data_type'	=> 'id',
			'value'			=> array(
					'image'	=> '',
					'color'	=> '#FF7766',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
//////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Typography options /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

	$typography_options = array();
	$typography_options['typography-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=>'<h2>Typography options</h2>'
	);

	$typography_options['typography-body'] = array(
			'type'			=> 'typography',
			'title'			=> '',
			'label'			=> 'Body text',
			'decsription'	=> 'decsription typography',
			'hint'			=>  array(
				'type'			=> 'text',
				'content'		=> ''
			),
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'blue',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$sections_array = array();
	$sections_array['demo-options-section'] = array(
		'name'			=> 'All interface elements',
		'icon'			=> 'dashicons dashicons-carrot',
		'parent'		=> '',
		'priority'		=> 1,
		'options-list'	=> $demo_options
	);
	$sections_array['general-options-section'] = array(
		'name'			=> 'General',
		'icon' 			=> 'dashicons dashicons-admin-generic',
		'parent'		=> '',
		'priority'		=> 10,
		'options-list'	=> $general_options
	);
	$sections_array['grid-options-section'] = array(
		'name'			=> 'Grid',
		'icon'			=> 'dashicons dashicons-admin-appearance',
		'parent'		=> '',
		'priority'		=> 20,
		'options-list'	=> $grid_options
	);
	$sections_array['page-layout-options-section'] = array(
		'name'			=> 'Page layouts',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'grid-options-section',
		'priority'		=> 21,
		'options-list'	=> $page_layout_options
	);
	$sections_array['styling-options-section'] = array(
		'name' 			=> 'Styling',
		'icon' 			=> 'dashicons dashicons-art',
		'parent'		=> '',
		'priority'		=> 30,
		'options-list'	=> $styling_options
	);
	$sections_array['navigation-options-section'] = array(
		'name'			=> 'Navigation',
		'icon' 			=> 'dashicons dashicons-menu',
		'parent' 		=> '',
		'priority'		=> 40,
		'options-list'	=> $navigation_options
	);
	$sections_array['breadcrumbs-options-section'] = array(
		'name'			=>'Breadcrumbs',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'navigation-options-section',
		'priority'		=> 91,
		'options-list'	=> $breadcrumbs_options
	);
	$sections_array['pagination-options-section'] = array(
		'name'			=> 'Pagination',
		'icon'			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'navigation-options-section',
		'priority'		=> 42,
		'options-list'	=> $pagination_option
	);
	$sections_array['header-options-section'] = array(
		'name'			=> 'Header',
		'icon'			=> 'dashicons dashicons-admin-appearance',
		'parent'		=> '',
		'priority'		=> 50,
		'options-list'	=> $header_options
	);
	$sections_array['logo-options-section'] = array(
		'name'			=> 'Logo',
		'icon'			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'header-options-section',
		'priority'		=> 51,
		'options-list'	=> $logo_options
	);
	$sections_array['footer-options-section'] = array(
		'name' 			=> 'Footer',
		'icon' 			=> 'dashicons dashicons-admin-appearance',
		'parent' 		=> '',
		'priority'		=> 60,
		'options-list'	=> $footer_options
	);
	$sections_array['typography-options-section'] = array(
		'name' => 'Typography',
		'icon' => 'dashicons dashicons-admin-generic',
		'parent' => '',
		'priority' => 70,
		'options-list' => $typography_options
	);

	return apply_filters( 'cherry_defaults_settings', $sections_array );
}