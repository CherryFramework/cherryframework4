<?php

function cherry_defaults_settings() {
	$optSectionsArray = array();
////////// Demo options ///////////////////////////////////////////////////////
	$demo_options = array();
	
	$demo_options['title_demo'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Demo options</h2>'
	);
	$demo_options['accordion-demo'] = array(
				'type'			=> 'accordion',
				'title'			=> 'title accordion',
				'label'			=> 'label accordion',
				'decsription'	=> 'decsription accordion',
				'hint'      	=>  array(
					'type'		=> 'image',
					'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
				),
				'value'			=> array(
					'cherry_header_logo' => array(
						'col'	   => 3,
						'class'	   => 'custom_logo',
						'itemname' => 'Logo',
						'priority' => 0
					),
					'cherry_header_menu' => array(
						'col'	   => 6,
						'class'	   => 'custom_menu',
						'itemname' => 'Menu',
						'priority' => 1
					),
					'cherry_header_search' => array(
						'col'	   => 3,
						'class'	   => 'custom_search',
						'itemname' => 'Search',
						'priority' => 2
					)
				),
				'default_value'	=> 'default_value',
				'options' => array(
					'cherry_header_logo' => array(
						'itemname' => 'Logo',
						'priority' => 1
					),
					'cherry_header_menu'   => array(
						'itemname' => 'Menu',
						'priority' => 5
					),
					'cherry_header_search' => array(
						'itemname' => 'Search',
						'priority' => 10
					),
					'cherry_header_info' => array(
						'itemname' => 'Info Block',
						'priority' => 15
					),
					'cherry_header_login' => array(
						'itemname' => 'Login form',
						'priority' => 20
					)
				)
	);
	$demo_options['text_demo'] = array(
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
	$demo_options['textarea_demo'] = array(
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
	$demo_options['select_demo'] = array(
				'type'			=> 'select',
				'title'			=> 'title select',
				'label'			=> 'label select',
				'decsription'	=> 'decsription select',
				'hint'      	=>  array(
					'type'		=> 'video',
					'content'	=> 'https://www.youtube.com/watch?v=2kodXWejuy0'
				),
				'value'			=> 'select_1',
				'default_value'	=> 'select_1',
				'class'			=> 'width-full',
				'options'		=> array(
					'select_1'	=> 'select 1',
					'select_2'	=> 'select 2',
					'select_3'	=> 'select 3'
				)
	);
	$demo_options['filterselect_demo'] = array(
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
					'select_1'	=> 'select 1',
					'select_2'	=> 'select 2',
					'select_3'	=> 'select 3',
					'select_4'	=> 'select 4',
					'select_5'	=> 'select 5',
					'select_6'	=> 'select 6',
					'select_7'	=> 'select 2',
					'select_8'	=> 'select 8'
				)
	);
	$demo_options['multiselect_demo'] = array(
				'type'			=> 'multiselect',
				'title'			=> 'title multiselect',
				'label'			=> 'label multiselect',
				'decsription'	=> 'decsription multiselect',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'placeholder'	=> 'Select value',
				'value'			=> array('select_1','select_8'),
				'default_value'	=> array('select_1','select_8'),
				'class'			=> 'width-full',
				'options'		=> array(
					'select_1'	=> 'Item 1',
					'select_2'	=> 'Item 2',
					'select_3'	=> 'Item 3',
					'select_4'	=> 'Item 4',
					'select_5'	=> 'Item 5',
					'select_6'	=> 'Item 6',
					'select_7'	=> 'Item 7',
					'select_8'	=> 'Item 8'
				)
	);
	$demo_options['checkbox_demo'] = array(
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
	$demo_options['switcher_demo'] = array(
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
	$demo_options['slider-demo'] = array(
				'type'			=> 'slider',
				'title'			=> 'title Slider',
				'label'			=> 'label Slider',
				'decsription'	=> 'decsription Slider',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'max_value'		=> 100,
				'min_value'		=> 0,
				'value'			=> 50,
				'default_value' => 50
	);
	$demo_options['rangeslider-demo'] = array(
				'type'			=> 'rangeslider',
				'title'			=> 'title Range Slider',
				'label'			=> 'label Range Slider',
				'decsription'	=> 'decsription Range Slider',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'max_value'		=> 100,
				'min_value'		=> 0,
				'value'			=> array(
					'left_value'	=> 20,
					'right_value'	=> 50,
				),
				'default_value' => array(
					'left_value'	=> 0,
					'right_value'	=> 100,
				)
	);
	$demo_options['multicheckbox_demo'] = array(
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
					'checkbox_1'	=> true,
					'checkbox_2'	=> false,
					'checkbox_3'	=> true
				),
				'default_value'	=> array(
					'checkbox_1'	=> false,
					'checkbox_2'	=> true,
					'checkbox_3'	=> true
				),
				'options'		=> array(
					'checkbox_1'	=> 'checkbox 1',
					'checkbox_2'	=> 'checkbox 2',
					'checkbox_3'	=> 'checkbox 3'
				)
	);
	$demo_options['radio_demo'] = array(
				'type'			=> 'radio',
				'title'			=> 'title radio',
				'label'			=> 'label radio',
				'decsription'	=> 'decsription radio',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'radio_2',
				'default_value'	=> 'radio_1',
				'class'			=> '',
				'display_input'	=> true,
				'options'		=> array(
					'radio_1' => array(
						'label' => 'radio 1',
						'img_src' => ''
					),
					'radio_2' => array(
						'label' => 'radio 2',
						'img_src' => ''
					),
					'radio_3' => array(
						'label' => 'radio 3',
						'img_src' => ''
					),
				)
	);
	$demo_options['radio_image_demo'] = array(
				'type'			=> 'radio',
				'title'			=> 'title radio',
				'label'			=> 'label radio',
				'decsription'	=> 'decsription radio',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'radio_image_1',
				'default_value'	=> 'radio_image_1',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'radio_image_1' => array(
						'label' => 'radio image 1',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_2' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_3' => array(
						'label' => 'radio image 3',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
				)
	);
	$demo_options['image_demo'] = array(
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
				'display_image'		=> true,
				'multi_upload'		=> true,
				'return_data_type'	=> 'url'
	);
	$demo_options['colorpicker_demo'] = array(
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
	$demo_options['stepper_demo'] = array(
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
				'value_step'	=> '1',
				'max_value'		=> '50',
				'min_value'		=> '-50'
	);
	$demo_options['editor_demo'] = array(
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
	
	$demo_options['background_demo'] = array(
				'type'			=> 'background',
				'title'			=> 'title background',
				'label'			=> 'label background',
				'decsription'	=> 'decsription background',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'return_data_type'	=> 'url',
				'value'			=> array(
						'image'	=> '',
						'color'	=> '#ff0000',
						'repeat'	=> 'repeat',
						'position'	=> 'left',
						'attachment'=> 'fixed'
					)
	);
	
	$demo_options['info_demo'] = array(
				'type'			=> 'info',
				'title'			=> 'title info',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>info</h2>'
	);
	$demo_options['typography_demo'] = array(
				'type'			=> 'typography',
				'title'			=> 'title typography',
				'label'			=> 'label typography',
				'decsription'	=> 'decsription typography',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> array(
					'size'			=> '10',
					'lineheight'	=> '10',
					'color'			=> 'blue',
					'family'		=> 'Abril Fatface',
					'character'		=> 'latin-ext',
					'style'			=> 'italic'
				)
	);
	$demo_options['submit_demo'] = array(
				'type'			=> 'submit',
				'value'			=> 'get value'
	);

	$optSectionsArray['demo-options-section'] = array(
			'name' => 'All interface elements',
			'icon' => 'dashicons dashicons-carrot',
			'parent' => '',
			'priority' => 10,
			'options-list' => $demo_options
	);


////////// General options ////////////////////////////////////////////////////

	
	$general_options = array();
	$general_options['general-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=> '<h2>General options</h2>'
	);

	$general_options['general_logo'] = array(
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

	$general_options['general_favicon'] = array(
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


/*
	$general_options['layout-style'] = array(
			'type'			=> 'radio',
			'title'			=> 'Layout Style',
			'label'			=> 'Layout Style',
			'decsription'	=> 'Select layout for Your site',
			'value'			=> 'radio_1',
			'default_value'	=> 'radio_1',
			'class'			=> '',
			'display_input'	=> true,
			'options'		=> array(
				'radio_1' => array(
					'label' => 'Full width',
					'img_src' => ''
				),
				'radio_2' => array(
					'label' => 'Container',
					'img_src' => ''
				)
			)
	);
*/


	$general_options['general_page_comments'] = array(
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
	$general_options['general_featured_images'] = array(
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

	$general_options['general_general_user_css'] = array(
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

	$general_options['general_google_analytics'] = array(
				'type'			=> 'textarea',
				'title'			=> 'Google Analytic',
				/*'label'			=> 'Enter the code',*/
				'decsription'	=> 'Google Analytic code goes here',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'This code will be added into the footer template of your theme.'
				),
				'value'			=> 'value',
				'default_value'	=> 'default_value'
	);


	/*
	$general_options['responsive-layout'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Responsive layout',
			'label'			=> 'Responsive layout',
			'decsription'	=> 'Enable/Disable responsive layout.',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$general_options['base-parallax-effect'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Parallax effect',
			'label'			=> 'Parallax effect',
			'decsription'	=> 'Enable/Disable parallax effect',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$general_options['background-style'] = array(
			'type'			=> 'background',
			'title'			=> 'Background styling',
			'label'			=> __('Background styling section', 'cherry'),
			'decsription'	=> __('Change the background style', 'cherry'),
			'return_data_type'	=> 'id',
			'value'			=> array(
					'image'	=> 'http://192.168.9.83/wodrpress-git/wp-cherry4-master/wordpress/wp-content/uploads/2014/05/site5.jpg',
					'color'	=> '#a4cc3f',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
	$general_options['favicon'] = array(
			'type'				=> 'image',
			'title'				=> 'Favicon',
			'label'				=> __('Click Upload or Enter the direct path to your favicon.', 'cherry'),
			'decsription'		=> __('For example //your_website_url_here/wp-content/themes/themeXXXX/favicon.ico', 'cherry'),
			'value'				=> '',
			'default_value'		=> 'http://192.168.9.83/wodrpress-git/wp-cherry4-master/wordpress/wp-content/themes/cherryframework4/favicon.ico',
			'display_image'		=> true,
			'multi_upload'		=> true,
			'return_data_type'	=> 'url'
	);
	$general_options['breadcrumbs'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Breadcrumbs',
			'label'			=> 'Display breadcrumbs?',
			'decsription'	=> 'Enable/Disable drop down fade-in animation.',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);
	$general_options['general-custom-css'] = array(
			'type'			=> 'textarea',
			'title'			=> 'Custom CSS',
			'label'			=> 'Custom CSS',
			'decsription'	=> 'Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}',
			'value'			=> '',
			'default_value'	=> ''
	);*/


	$optSectionsArray['general-options-section'] = array(
			'name' => 'General',
			'icon' => 'dashicons dashicons-admin-generic',
			'parent' => '',
			'priority' => 20,
			'options-list' => $general_options
	);


////////// Header options /////////////////////////////////////////////////////


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
			'value'			=> 'header_type_layout_radio_1',
			'default_value'	=> 'header_type_layout_radio_1',
			'class'			=> '',
			'display_input'	=> false,
			'options'		=> array(
				'header_type_layout_radio_1' => array(
					'label' => 'Top static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-static.png'
				),
				'header_type_layout_radio_2' => array(
					'label' => 'Left static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-static.png'
				),
				'header_type_layout_radio_3' => array(
					'label' => 'Right static',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-static.png'
				),
				'header_type_layout_radio_4' => array(
					'label' => 'Top toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-toggle.png'
				),
				'header_type_layout_radio_5' => array(
					'label' => 'Left toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-toggle.png'
				),
				'header_type_layout_radio_6' => array(
					'label' => 'Right toogle',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-toggle.png'
				)
			)
	);
/*
	$header_options['header-widgetarea-layout'] = array(
			'type'			=> 'radio',
			'title'			=> __('Widget area layout', 'cherry'),
			'label'			=> __('Widget area layout', 'cherry'),
			'decsription'	=> __('Choose widget area layout.', 'cherry'),
			'value'			=> 'header_widgetarea_layout_radio_1',
			'default_value'	=> 'header_widgetarea_layout_radio_1',
			'class'			=> '',
			'display_input'	=> false,
			'options'		=> array(
				'header_widgetarea_layout_radio_1' => array(
					'label' => 'None',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/widgets-layouts-none.png'
				),
				'header_widgetarea_layout_radio_2' => array(
					'label' => 'Single area',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/widgets-layouts-1.png'
				),
				'header_widgetarea_layout_radio_3' => array(
					'label' => 'Double area',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/widgets-layouts-2.png'
				),
				'header_widgetarea_layout_radio_4' => array(
					'label' => 'Quad area',
					'img_src' => PARENT_URI.'/lib/admin/assets/images/widgets-layouts-4.png'
				)
			)
	);
*/

/*
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
*/

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
			'value'			=> 'false',
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

	/*
	$header_options['search-form'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Search',
			'label'			=> 'Display search form in the header?',
			'decsription'	=> 'Enable/Disable search form.',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$header_options['header-social-list'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header social list',
			'label'			=> 'Display header social list?',
			'decsription'	=> 'Enable/Disable header social list.',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);*/
	$optSectionsArray['header-options-section'] = array(
			'name' => 'Header',
			/*'icon' => 'dashicons dashicons-admin-appearance',*/
			'icon' => 'dashicons',
			'parent' => '',
			'priority' => 30,
			'options-list' => $header_options
	);



////////// Footer options /////////////////////////////////////////////////////


	$footer_options = array();
	$footer_options['footer-options'] = array(
			'type'			=> 'info',
			'title'			=> '',
			'decsription'	=> 'decsription info',
			'value'			=> '<h2>Header options</h2>'
	);
	$footer_options['footer-background'] = array(
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

	$footer_options['footer-background-full-scale'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header full scale background',
			'label'			=> 'Enable / Disable',
			'decsription'	=> 'Enable/Disable header full scale background',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);

	$footer_options['footer-parallax-effect'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Parallax effect',
			'label'			=> 'Parallax effect',
			'decsription'	=> 'Enable/Disable header parallax effect',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);

	$footer_options['footer-sticky'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header sticky',
			'label'			=> 'Enable/Disable',
			'decsription'	=> 'Enable/Disable header sticky',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);

	/*
	$header_options['search-form'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Search',
			'label'			=> 'Display search form in the header?',
			'decsription'	=> 'Enable/Disable search form.',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$header_options['header-social-list'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Header social list',
			'label'			=> 'Display header social list?',
			'decsription'	=> 'Enable/Disable header social list.',
			'value'			=> 'false',
			'default_value'	=> 'default_value'
	);*/
	$optSectionsArray['footer-options-section'] = array(
			'name' => 'Footer',
			/*'icon' => 'dashicons dashicons-admin-appearance',*/
			'parent' => '',
			'priority' => 30,
			'options-list' => $footer_options
	);



////////// Logo options ///////////////////////////////////////////////////////


	$logo_options = array();

	$logo_options['logo-options'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Logo options</h2>'
	);
	/*$logo_options['logo-kind'] = array(
				'type'			=> 'radio',
				'title'			=> 'Logo type',
				'label'			=> 'What kind of logo?',
				'decsription'	=> 'Select whether you want your main logo to be an image or text. If you select "image" you can put in the image url in the next option, and if you select "text" your Site Title will be shown instead.',
				'value'			=> 'radio_1',
				'default_value'	=> 'radio_1',
				'class'			=> '',
				'display_input'	=> true,
				'options'		=> array(
					'radio_1' => array(
						'label' => 'Image logo',
						'img_src' => ''
					),
					'radio_2' => array(
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
				'display_image'		=> true,
				'multi_upload'		=> true,
				'return_data_type'	=> 'url'
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
					'style'			=> 'italic'
				)
	);*/
	$optSectionsArray['logo-options'] = array(
			'name' => 'Logo',
			'icon' => 'dashicons dashicons-arrow-right',
			'parent' => 'header-options-section',
			'priority' => 2,
			'options-list' => $logo_options
	);


////////// Navigation options ///////////////////////////////////////////////////

		
		$navigation_options = array();
		$navigation_options['navigation-options'] = array(
				'type'			=> 'info',
				'title'			=> '',
				'decsription'	=> 'decsription info',
				'value'			=> '<h2>Navigation options</h2>'
		);
		/*$navigation_options['stickup-menu'] = array(
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
					'style'			=> 'italic'
				)
		);*/
		$optSectionsArray['navigation-options-section'] = array(
				'name' => 'Navigation',
				'icon' => 'dashicons dashicons-menu',
				'parent' => '',
				'priority' => 40,
				'options-list' => $navigation_options
		);


////////// Styling options /////////////////////////////////////////////////////
//dashicons-art



	$styling_options = array();
	$styling_options['general-options'] = array(
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
				/*'decsription'	=> 'decsription background',*/
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Background for main container'
				),
				'return_data_type'	=> 'url',
				'value'			=> array(
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
				/*'decsription'	=> '',*/
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Enable this option to have scale according to the browzer size. Background image display at 100% in width and height'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);

	$styling_options['styling-main-arallax-background'] = array(
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
				'value'			=> 'radio_image_1',
				'default_value'	=> 'radio_image_1',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'radio_image_1' => array(
						'label' => 'radio image 1',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_2' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_3' => array(
						'label' => 'radio image 3',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_4' => array(
						'label' => 'radio image 4',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_5' => array(
						'label' => 'radio image 5',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_6' => array(
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
				'value'			=> 'radio_image_1',
				'default_value'	=> 'radio_image_1',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'radio_image_1' => array(
						'label' => 'radio image 1',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_2' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio_image_3' => array(
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





	$optSectionsArray['styling-options-section'] = array(
			'name' => 'Styling',
			'icon' => 'dashicons dashicons-art',
			'parent' => '',
			'priority' => 30,
			'options-list' => $styling_options
	);


	
	return apply_filters( 'cherry_defaults_settings', $optSectionsArray );		
}