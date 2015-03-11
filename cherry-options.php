<?php

function cherry_defaults_settings() {
	global $cherry_registered_statics, $cherry_registered_static_areas;
	$all_statics = $cherry_registered_statics;

	//var_dump($all_statics);
////////// Demo options ///////////////////////////////////////////////////////
	$demo_options = array();
	$demo_options['repeater-demo'] = array(
				'type'			=> 'repeater',
				'title'			=> 'repeater text',
				'label'			=> 'repeater text',
				'decsription'	=> 'repeater text',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> array(
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
				)
	);
	$demo_options['text-demo'] = array(
				'type'			=> 'text',
				'title'			=> 'title text',
				'label'			=> 'label text',
				'decsription'	=> 'decsription text',
				'hint'			=>  array(
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
					'type'		=> 'text',
					//'content'	=> 'https://www.youtube.com/watch?v=2kodXWejuy0'
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor'
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
					'type'		=> 'text',
					//'content'	=> 'https://player.vimeo.com/video/97337577'
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor'
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
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'placeholder'	=> 'Select value',
				'value'			=> array('select-1','select-8'),
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
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> 'true',
	);
	$demo_options['switcher-demo'] = array(
				'type'			=> 'switcher',
				'title'			=> 'title switcher',
				'label'			=> 'label switcher',
				'decsription'	=> 'decsription switcher',
				'hint'			=>  array(
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
				'max_value'		=> 100,
				'min_value'		=> 20,
				'value'			=> array(
					'left-value'	=> 30,
					'right-value'	=> 50,
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
				'value'			=> array( 'checkbox-2', 'checkbox-3' ),
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
					),
					'radio-2' => array(
						'label' => 'radio 2',
					),
					'radio-3' => array(
						'label' => 'radio 3',
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
				'type'				=> 'media',
				'title'				=> 'title image',
				'label'				=> 'label image',
				'decsription'		=> 'decsription image',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'				=> '',
				'display-image'		=> true,
				'multi-upload'		=> true,
				'library_type'		=> 'image'
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
				'value'			=> 'info'
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
	$general_options['general-logo-type'] = array(
			'type'				=> 'radio',
			'title'				=> __('Logo type', 'cherry'),
			'decsription'		=> __('What kind of logo?', 'cherry'),
			'value'				=> 'general-logo-type-image',
			'display-input'		=> true,
			'library_type'		=> 'image',
			'options'			=> array(
				'general-logo-type-image' => array(
					'label' => 'image'
				),
				'general-logo-type-text' => array(
					'label' => 'text'
				),
			)
	);
	$general_options['general-logo-image'] = array(
			'type'				=> 'media',
			'title'				=> __('Logo image', 'cherry'),
			'decsription'		=> __('Choose image for logo', 'cherry'),
			'hint'				=>  array(
				'type'			=> 'text',
				'content'		=> __('Choose normal and retina(x2) image for logo', 'cherry'),
			),
			'value'				=> '',
			'display_image'		=> true,
			'multi_upload'		=> true,
			'return_data_type'	=> 'url',
			'library_type'		=> 'image'
	);
	$general_options['general-logo-text'] = array(
			'type'				=> 'typography',
			'title'				=> __('Logo typography style', 'cherry'),
			'decsription'		=> __('Choose image for logo', 'cherry'),
			'value'				=> array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> '000',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
	$general_options['general-favicon'] = array(
			'type'				=> 'media',
			'title'				=> __('Favicon image', 'cherry'),
			'decsription'		=> __('Favicon image', 'cherry'),
			'hint'				=>  array(
				'type'			=> 'text',
				'content'		=> __('Favicon image', 'cherry'),'Icon for Apple iPhone (57px * 57px) <br>Icon for Apple iPhone Retina (114px * 114px)<br>Icon for Apple iPad (72px * 72px)<br>Icon for Apple iPad Retina (144px * 144px )'
			),
			'value'				=> '',
			'display_image'		=> true,
			'multi_upload'		=> true,
			'return_data_type'	=> 'url',
			'library_type'	=> 'image'
	);
	$general_options['general-page-comments'] = array(
			'type'			=> 'switcher',
			'title'			=> 'page comments',
			'label'			=> 'Enable / Disable',
			'decsription'	=> 'Display comments on regular page',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> "Disable or enable comments by default on new pages and custom post types. You can change the default for new posts or pages, as well as enable/disable comments on posts or pages you've already published."
			),
			'value'			=> 'true',
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
	$general_options['general-maintenance mode'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Maintenance mode',
			'decsription'	=> 'Hide your site from regular visitors',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Logged in administrator gets full access to the site, while regular visitors will
				be redirected to the chosen page.'
			),
			'value'			=> 'true',
	);
	$general_options['general-maintenance-page'] = array(
				'type'			=> 'select',
				'title'			=> 'maintenance page',
				'decsription'	=> 'Select template of maintenance page, which you gonna used.',
				'hint'      	=>  array(
					'type'		=> 'video',
					'content'	=> 'https://www.youtube.com/watch?v=2kodXWejuy0'
				),
				'value'			=> 'select-1',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'page_template_1',
					'select-2'	=> 'page_template_2',
					'select-3'	=> 'page_template_3'
				)
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

////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Footer options /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
	$footer_options = array();
	$footer_options['footer-background'] = array(
			'type'			=> 'background',
			'title'			=> 'Footer background',
			'label'			=> 'Footer styling section',
			'decsription'	=> 'Change the footer background',
			'return_data_type'	=> 'id',
			'library_type'		=> 'image',
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
	$grid_options['grid-responsive'] = array(
				'type'			=> 'switcher',
				'title'			=> 'Responsive grid',
				'label'			=> 'Enable / Disable',
				/*'decsription'	=> 'decsription switcher',*/
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'If for any reason you want to disable responsive layout for your site, you are able to turn it off here.'
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$grid_options['grid-type'] = array(
		'type'        => 'radio',
		'title'       => __( 'Grid type', 'cherry' ),
		'label'       => __( 'Select one of them', 'cherry' ),
		'decsription' => __( 'Grid type for main container', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Background pattern for main container', 'cherry' ),
		),
		'value'         => 'grid-type-boxed',
		'class'         => '',
		'display_input' => false,
		'options'       => array(
			'grid-type-wide' => array(
				'label'   => __( 'Wide', 'cherry' ),
				'img_src' => PARENT_URI . '/screenshot.png',
			),
			'grid-type-boxed' => array(
				'label'   => __( 'Boxed', 'cherry' ),
				'img_src' => PARENT_URI . '/screenshot.png',
			),
		),
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// Page layout options ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
	$page_layout_options = array();
	$page_layout_options['page-layout-container-width'] = array(
		'type' => 'slider',
		'title' => __( 'Container width', 'cherry' ),
		'decsription' => __( 'Width of main container (px)', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Width of main container (px)', 'cherry' ),
		),
		'max_value' => 1920, // Full HD
		'min_value' => 970,
		'value' => 1170,
	);
	$page_layout_options['page-layout-type'] = array(
		'type'			=> 'radio',
		'title'			=> __('Header type layout', 'cherry'),
		'label'			=> __('Header type layout', 'cherry'),
		'decsription'	=> __('Choose header type layout.', 'cherry'),
		'value'			=> 'page-layout-type-1',
		'display_input'	=> false,
		'options'		=> array(
			'page-layout-type-1' => array(
				'label' => 'Top static',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-static.png'
			),
			'page-layout-type-2' => array(
				'label' => 'Left static',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-static.png'
			),
			'page-layout-type-3' => array(
				'label' => 'Right static',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-static.png'
			),
			'page-layout-type-4' => array(
				'label' => 'Top toogle',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/header-top-toggle.png'
			),
			'page-layout-type-5' => array(
				'label' => 'Left toogle',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/header-left-toggle.png'
			),
			'page-layout-type-6' => array(
				'label' => 'Right toogle',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/header-right-toggle.png'
			)
		)
	);
/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// Blog layout options ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
	$blog_options = array();
	$blog_options['blog-list-layout'] = array(
		'type'          => 'radio',
		'title'         => __( 'Blog list layout', 'cherry' ),
		'label'         => __( 'Blog list layout', 'cherry' ),
		'decsription'   => __( 'Choose blog page layout.', 'cherry' ),
		'value'         => 'blog-list-layout-masonry',
		'display_input' => false,
		'options'       => array(
			'blog-list-layout-masonry' => array(
				'label'   => 'Masonry',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/inherit.png',
			),
			'blog-list-layout-grid' => array(
				'label'   => 'Grid',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/inherit.png',
			),
			'blog-list-layout-list' => array(
				'label'   => 'List',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/inherit.png',
			),
			'blog-list-layout-timeline' => array(
				'label'   => 'Timeline',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/inherit.png',
			),
		)
	);
	$blog_options['blog-page-layout'] = array(
		'type'          => 'radio',
		'title'         => __( 'Blog page layout', 'cherry' ),
		'label'         => __( 'Blog page layout', 'cherry' ),
		'decsription'   => __( 'Choose blog page layout.', 'cherry' ),
		'value'         => 'blog-page-layout-right',
		'display_input' => false,
		'options'       => array(
			'blog-page-layout-left-2-right' => array(
				'label'   => __( 'Left and right sidebar', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-both-sidebar.png',
			),
			'blog-page-layout-left' => array(
				'label'   => __( 'Left sidebar', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-left-sidebar.png',
			),
			'blog-page-layout-right' => array(
				'label'   => __( 'Right sidebar', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-right-sidebar.png',
			),
			'blog-page-layout-left-2-left' => array(
				'label'   => __( 'Sameside left sidebar', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-sameside-left-sidebar.png',
			),
			'blog-page-layout-right-2-right' => array(
				'label'   => __( 'Sameside right sidebar', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-sameside-right-sidebar.png',
			),
			'blog-page-layout-no-sidebar' => array(
				'label'   => __( 'No sidebar', 'cherry' ),
				'img_src' => CHERRY_URI . '/admin/assets/images/layout-fullwidth.png',
			),
		)
	);
	$blog_options['blog-button-text'] = array(
		'type'        => 'text',
		'title'       => 'title text',
		'label'       => '',
		'decsription' => 'Button text for blog posts.',
		'hint'        => array(
			'type'    => 'image',
			'content' => PARENT_URI.'/lib/admin/assets/images/cherry-logo.png',
		),
		'value' => 'Read more',
	);
	$blog_options['blog-social-sharing'] = array(
		'type'        => 'switcher',
		'title'       => 'Social networks sharing buttons',
		'label'       => 'Enable / Disable',
		'decsription' => 'Activate this to enable social sharing buttons on your blog posts',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
	);
	$blog_options['blog-comments'] = array(
		'type'        => 'switcher',
		'title'       => 'Comment hide',
		'label'       => 'Enable / Disable',
		'decsription' => 'Enabling this option will hide comments on blog List',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'false',
	);

///////////////////////////////////Blog image size
	$blog_options['blog-images-page-scroll'] = array(
		'type'        => 'switcher',
		'title'       => 'Should images be uploaded on page scroll?',
		'label'       => 'Enable / Disable',
		'decsription' => 'You can enable images load only as you scroll down the page. Otherwise images will load all at once.',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-button-text'] = array(
		'type'        => 'text',
		'title'       => 'title text',
		'label'       => '',
		'decsription' => 'Button text for blog posts.',
		'hint'        => array(
			'type'    => 'image',
			'content' => PARENT_URI.'/lib/admin/assets/images/cherry-logo.png',
		),
		'value' => 'Read more',
	);

	$blog_options['blog-meta-type-view'] = array(
		'type'			=> 'radio',
		'title'			=> 'view meta of the blog.',
		'label'			=> 'choose one of them',
		'decsription'	=> '',
		'hint'      	=> array(
			'type'    => 'text',
			'content' => 'Select meta block type which will be displayed on blog and post pages.',
		),
		'value'         => 'blog-meta-type-view-line',
		'class'         => '',
		'display-input' => true,
		'options'       => array(
			'blog-meta-type-view-line' => array(
				'label'   => 'Do not show.',
			),
			'blog-meta-type-view-icon' => array(
				'label'   => 'Lines',
			),
		)
	);

	$blog_options['blog-display-meta'] = array(
		'type'        => 'radio',
		'title'       => 'Display meta info block',
		'label'       => 'choose one of them',
		'decsription' => '',
		'hint'        => array(
			'type'    => 'text',
			'content' => 'Select where to display meta block.',
		),
		'value'         => 'radio-2',
		'default_value' => 'radio-1',
		'class'         => '',
		'display-input' => true,
		'options'       => array(
			'radio-1' => array(
				'label'   => 'Only blog.',
				'img_src' => '',
			),
			'radio-2' => array(
				'label'   => 'Only post.',
				'img_src' => '',
			),
			'radio-3' => array(
				'label'   => 'Blog and post.',
				'img_src' => '',
			),
			'radio-4' => array(
				'label'   => 'Do not show.',
				'img_src' => '',
			),
		)
	);

	$blog_options['blog-related-posts'] = array(
		'type'        => 'switcher',
		'title'       => 'Related posts',
		'decsription' => 'Show related posts?',
		'hint'        => array(
			'type'    => 'text',
			'content' => 'Show related posts?',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-post-publication-date'] = array(
		'type'        => 'switcher',
		'title'       => 'Post publication date.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the post publication date be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-post-author'] = array(
		'type'        => 'switcher',
		'title'       => 'Author of the post.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Display the author of the post?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-direct-link'] = array(
		'type'        => 'switcher',
		'title'       => 'Direct link to the post.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the direct link to the post be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-tags'] = array(
		'type'        => 'switcher',
		'title'       => 'Tags be displayed',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the tags be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-post-categories'] = array(
		'type'        => 'switcher',
		'title'       => 'Post categories.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the post categories be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-comments-number'] = array(
		'type'        => 'switcher',
		'title'       => 'Number of comments.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the number of comments be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-view-number'] = array(
		'type'        => 'switcher',
		'title'       => 'Number of view.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the number of view be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-likes-number'] = array(
		'type'        => 'switcher',
		'title'       => 'Number of likes.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the number of likes be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

	$blog_options['blog-dislikes-number'] = array(
		'type'        => 'switcher',
		'title'       => 'Number of dislikes.',
		'label'       => 'Enable / Disable',
		'decsription' => 'Should the number of dislikes be displayed?',
		'hint'        => array(
			'type'    => 'text',
			'content' => '',
		),
		'value'         => 'true',
		'default_value' => 'true',
	);

////////// Logo options ///////////////////////////////////////////////////////

	$logo_options = array();

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
				'type'				=> 'media',
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
	$navigation_options['navigation-stickup-menu'] = array(
			'type'			=> 'switcher',
			'title'			=> 'StickUp menu',
			'label'			=> 'Using stickUp menu',
			'decsription'	=> 'Do you want to use stickUp menu?',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);
	$navigation_options['navigation-menu-typography'] = array(
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

	$navigation_options['navigation-smooth-scroll'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Smooth scroll',
			'decsription'	=> 'Enable to use smooth scrolling on pages',
			'value'			=> 'true',
			'default_value'	=> 'default_value'
	);

	$navigation_options['navigation-scroll-effect'] = array(
			'type'			=> 'radio',
			'title'			=> 'Scroll effect',
			'label'			=> 'label radio',
			'decsription'	=> 'decsription radio',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> ''
			),
			'value'			=> 'radio-2',
			'class'			=> '',
			'display-input'	=> true,
			'options'		=> array(
				'radio-1' => array(
					'label' => 'Linear',
					'img_src' => ''
				),
				'radio-2' => array(
					'label' => 'Ease-In',
					'img_src' => ''
				),
				'radio-3' => array(
					'label' => 'Ease-in-out',
					'img_src' => ''
				),
				'radio-4' => array(
					'label' => 'Ease-out',
					'img_src' => ''
				)
			)
	);



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Breadcrumbs options ////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$breadcrumbs_options = array();

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

	$pagination_option['pagination-display'] = array(
			'type'			=>  'switcher',
			'title' 		=>  'pagination',
			'label'			=>	'Enable / Disable',
			'value'			=>	'true',
			'default_value'	=>	'true'
	);

	$pagination_option['pagination-below'] = array(
			'type'			=>  'switcher',
			'title' 		=>  'Show Pagination Below of the Posts',
			'label'			=>	'Enable / Disable',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Enable pagination links for portfolio index pages on bottom side of the posts (after showing posts).'
			),
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
				'select-1'	=> 'standart pagination',
				'select-2'	=> 'infinite scroll',
				'select-3'	=> 'load more button',
				'select-4'	=> 'ajax pagination',
			)
	);
	$pagination_option['pagination-next-previous'] = array(
			'type'			=>  'switcher',
			'title' 		=>  'previous an next page navigation',
			'decsription'	=> 'Enable or disable previous an next page navigation',
			'value'			=>	'true'
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
			'decsription'	=> 'The text/HTML to display for the previous page link.',
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
			'decsription'	=> 'The text/HTML to display for the next page link.',
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
			'decsription'	=> 'The number of page links to show before and after the current page.',
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
			'decsription'	=> 'The number of links to always show at beginning and end of pagination.',
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
			'title'			=> 'page gap',
			'decsription'	=> 'The minimum number of pages in a gap before an ellipsis (...) is added.',
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
				'library_type'		=> 'image',
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
			'library_type'		=> 'image',
			'value'			=> array(
					'image'	=> '',
					'color'	=> '#FF7766',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);

//////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Color scheme options /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

	$color_options = array();
	$color_options['color-primary'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Primary color',
			'decsription'	=> 'Primary color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
			),
			'value'			=> '#286090',
			'default_value'	=> '#286090'
	);
	$color_options['color-success'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Success color',
			'decsription'	=> 'Success color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
			),
			'value'			=> '#DFF0D8',
			'default_value'	=> '#DFF0D8'
	);
	$color_options['color-info'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Info color',
			'decsription'	=> 'Info color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
			),
			'value'			=> '#D9EDF7',
			'default_value'	=> '#D9EDF7'
	);
	$color_options['color-warning'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Warning color',
			'decsription'	=> 'Warning color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
			),
			'value'			=> '#FCF8E3',
			'default_value'	=> '#FCF8E3'
	);
	$color_options['color-danger'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Danger color',
			'decsription'	=> 'Danger color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
			),
			'value'			=> '#F2DEDE',
			'default_value'	=> '#F2DEDE'
	);
	$color_options['color-gray-variations'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Gray color variations',
			'decsription'	=> 'Gray variations color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Gray color variations </br>
								<hr>
								gray-darker:           darken(20%)</br>
								gray-dark:             darken(15%)</br>
								gray-light:            lighten(15%)</br>
								gray-lighter:          lighten(20%)</br>'
							),
			'value'			=> '#555555',
			'default_value'	=> '#555555'
	);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Header options //////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$header_options = array();

	$header_options['header-static-area-editor'] = array(
				'type'			=> 'static_area_editor',
				'title'			=> 'header static area editor',
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
			'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> 'Рекомендуемый минимальный размер картинки при использовании на всю ширину окна 2560X1600. Загруженная фоновая картинка будет оптимизированная для отображения на мобильных и retina устройствах'
				),
			'return_data_type'	=> 'id',
			'library_type'		=> 'image',
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

//////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Typography options /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

	$typography_options = array();

	$typography_options['typography-body-text'] = array(
			'type'			=> 'typography',
			'title'			=> 'Body text',
			'label'			=> '',
			'decsription'	=> 'decsription typography',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> '343434',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

	$typography_options['typography-link'] = array(
			'type'			=> 'typography',
			'title'			=> 'Base link color',
			'label'			=> '',
			'decsription'	=> 'decsription typography',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'dd7566',
				'family'		=> 'Arial',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);


	$typography_options['typography-link-hover'] = array(
			'type'			=> 'typography',
			'title'			=> 'Base link hover color',
			'label'			=> '',
			'decsription'	=> 'decsription typography',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'dd3344',
				'family'		=> 'Arial',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

	$typography_options['typography-input-text'] = array(
			'type'			=> 'typography',
			'title'			=> 'Input text settings',
			'label'			=> '',
			'decsription'	=> 'Use this for setting default values of text input',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'dd3344',
				'family'		=> 'Arial',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

//+++++++++++++++++++++++++++++++++CUSTOM FONTS UPLOAD

	$typography_options['typography-h1'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 1',
			'label'			=> '',
			'decsription'	=> 'Font settings for H1',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'grey',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
	$typography_options['typography-h2'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 2',
			'label'			=> '',
			'decsription'	=> 'Font settings for H1',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'grey',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
	$typography_options['typography-h3'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 3',
			'label'			=> '',
			'decsription'	=> 'Font settings for H3',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'grey',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
	$typography_options['typography-h4'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 4',
			'label'			=> '',
			'decsription'	=> 'Font settings for H4',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'grey',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
	$typography_options['typography-h5'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 5',
			'label'			=> '',
			'decsription'	=> 'Font settings for H5',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'grey',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);
	$typography_options['typography-h6'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 6',
			'label'			=> '',
			'decsription'	=> 'Font settings for H6',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> 'grey',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

//////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Typography options /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

	$lists_options = array();

	$lists_options['lists-text-color'] = array(
			'type'			=> 'typography',
			'title'			=> 'Lists text',
			'label'			=> '',
			'decsription'	=> 'decsription typography',
			'value' => array(
				'size'			=> '10',
				'lineheight'	=> '10',
				'color'			=> '343434',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

	$lists_options['lists-mark-color'] = array(
				'type'			=> 'colorpicker',
				'title'			=> 'List mark color',
				'label'			=> 'label colorpicker',
				'decsription'	=> 'Choose color',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
				),
				'value'			=> '#ff0000',
				'default_value'	=> '#ff0000'
	);

	$lists_options['lists-mark-icon'] = array(
				'type'			=> 'filterselect',
				'title'			=> 'icon before list item',
				'label'			=> 'List marker item',
				'decsription'	=> 'decsription filterselect',
				'hint'      	=>  array(
					'type'		=> 'video',
					'content'	=> 'https://player.vimeo.com/video/97337577'
				),
				'value'			=> 'icon_caret_down',
				'default_value'	=> 'icon_caret_down',
				'class'			=> 'width-full',
				'options'		=> array(
					'select-1'	=> 'icon_caret_down',
					'select-2'	=> 'icon_caret_up',
					'select-3'	=> 'icon_caret_right',
					'select-4'	=> 'icon_caret_left'
				)
	);

/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// Optimization options ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

	$optimization_options = array();

	$optimization_options['concatenate-css'] = array(
		'type'          => 'switcher',
		'title'         => 'Concatenate CSS',
		'label'         => 'Concatenate CSS',
		'decsription'   => 'Concatenate and minify CSS files to perfomance optimization',
		'hint'          =>  array(
			'type'    => 'text',
			'content' => 'Merge Cherry CSS into one file or not.'
		),
		'value'         => 'true',
		'default_value' => 'true',
		'toggle'        => array(
			'true_toggle'  => __( 'Yes', 'cherry' ),
			'false_toggle' => __( 'No', 'cherry' )
		)
	);

	$optimization_options['dynamic-css'] = array(
		'type'			=> 'select',
		'title'			=> 'Dynamic CSS output',
		'label'			=> 'Dynamic CSS output',
		'decsription'	=> 'Output dynamic CSS into separate file or into style tag',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> 'Output dynamic CSS into separate file or into style tag'
		),
		'value'			=> 'file',
		'class'			=> 'width-full',
		'options'		=> array(
			'file'	=> 'Separate file',
			'tag'	=> 'Style tag in HEAD'
		)
	);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sections_array = array();
	$sections_array['demo-options-section'] = array(
		'name'			=> 'All interface elements',
		'icon'			=> 'dashicons dashicons-carrot',
		'priority'		=> 1,
		'options-list'	=> apply_filters( 'cherry_demo_options_list', $demo_options )
	);
	$sections_array['general-options-section'] = array(
		'name'			=> 'General',
		'icon' 			=> 'dashicons dashicons-admin-generic',
		'priority'		=> 10,
		'options-list'	=> apply_filters( 'cherry_general_options_list', $general_options )
	);
	$sections_array['grid-options-section'] = array(
		'name'			=> 'Grid',
		'icon'			=> 'dashicons dashicons-admin-appearance',
		'priority'		=> 20,
		'options-list'	=> apply_filters( 'cherry_grid_options_list', $grid_options )
	);
	$sections_array['blog-options-section'] = array(
		'name'			=> 'Blog layouts',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'grid-options-section',
		'priority'		=> 1,
		'options-list'	=> apply_filters( 'cherry_blog_options_list', $blog_options )
	);
	$sections_array['page-layout-options-section'] = array(
		'name'			=> 'Page layouts',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'grid-options-section',
		'priority'		=> 2,
		'options-list'	=> apply_filters( 'cherry_page_layout_options_list', $page_layout_options )
	);
	$sections_array['styling-options-section'] = array(
		'name' 			=> 'Styling',
		'icon' 			=> 'dashicons dashicons-art',
		'priority'		=> 30,
		'options-list'	=> apply_filters( 'cherry_styling_options_list', $styling_options )
	);

	$sections_array['color-options-section'] = array(
		'name'			=>'Color scheme',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'styling-options-section',
		'priority'		=> 31,
		'options-list'	=> apply_filters( 'cherry_color_options_list', $color_options )
	);

	$sections_array['navigation-options-section'] = array(
		'name'			=> 'Navigation',
		'icon' 			=> 'dashicons dashicons-menu',
		'priority'		=> 40,
		'options-list'	=> apply_filters( 'cherry_navigation_options_list', $navigation_options )
	);
	$sections_array['breadcrumbs-options-section'] = array(
		'name'			=>'Breadcrumbs',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'navigation-options-section',
		'priority'		=> 41,
		'options-list'	=> apply_filters( 'cherry_breadcrumbs_options_list', $breadcrumbs_options )
	);
	$sections_array['pagination-options-section'] = array(
		'name'			=> 'Pagination',
		'icon'			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'navigation-options-section',
		'priority'		=> 42,
		'options-list'	=> apply_filters( 'cherry_pagination_options_list', $pagination_option )
	);
	$sections_array['header-options-section'] = array(
		'name'			=> 'Header',
		'icon'			=> 'dashicons dashicons-admin-appearance',
		'priority'		=> 50,
		'options-list'	=> apply_filters( 'cherry_header_options_list', $header_options )
	);
	$sections_array['logo-options-section'] = array(
		'name'			=> 'Logo',
		'icon'			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'header-options-section',
		'priority'		=> 51,
		'options-list'	=> apply_filters( 'cherry_logo_options_list', $logo_options )
	);
	$sections_array['footer-options-section'] = array(
		'name' 			=> 'Footer',
		'icon' 			=> 'dashicons dashicons-admin-appearance',
		'priority'		=> 60,
		'options-list'	=> apply_filters( 'cherry_footer_options_list', $footer_options )
	);
	$sections_array['typography-options-section'] = array(
		'name' => 'Typography',
		'icon' => 'dashicons dashicons-admin-generic',
		'priority' => 70,
		'options-list' => apply_filters( 'cherry_typography_options_list', $typography_options )
	);
	$sections_array['lists-options-section'] = array(
		'name'			=>'Lists',
		'icon' 			=> 'dashicons dashicons-arrow-right',
		'parent'		=> 'typography-options-section',
		'priority'		=> 71,
		'options-list'	=> apply_filters( 'cherry_lists_options_list', $lists_options )
	);
	$sections_array['optimization-options-section'] = array(
		'name'         => 'Optimization',
		'icon'         => 'dashicons dashicons-admin-tools',
		'parent'       => '',
		'priority'     => 90,
		'options-list' => apply_filters( 'cherry_optimization_options_list', $optimization_options )
	);

	return apply_filters( 'cherry_defaults_settings', $sections_array );
	//return $sections_array;
}