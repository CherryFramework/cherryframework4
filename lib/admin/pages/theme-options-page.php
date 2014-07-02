<?php
	//Cherry options page
	function cherry_options() {
		$optioninteface = new Cherry_Interface_Bilder(array('pattern' => 'grid'));

////////// General options ////////////////////////////////////////////////////
		$general_options = array();

		$general_options['general-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>General options</h2>'
		);
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
				);
////////// General options ////////////////////////////////////////////////////
		$homepage_options = array();

		$homepage_options['homepage-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Hone page</h2>'
		);
				$homepage_options['homepage-type'] = array(
							'type'			=> 'radio',
							'title'			=> __('Home-page type', 'cherry'),
							'label'			=> __('Home-page type', 'cherry'),
							'decsription'	=> __('Select home-page type for Your site', 'cherry'),
							'value'			=> 'homepage_type_1',
							'default_value'	=> 'homepage_type_1',
							'class'			=> '',
							'display_input'	=> true,
							'options'		=> array(
								'homepage_type_1' => array(
									'label' => 'Standart',
									'img_src' => ''
								),
								'homepage_type_2' => array(
									'label' => 'Onepage',
									'img_src' => ''
								),
								'homepage_type_3' => array(
									'label' => 'News(Blog) page',
									'img_src' => ''
								)
								,
								'homepage_type_4' => array(
									'label' => 'Portfolio page',
									'img_src' => ''
								)
							)
				);
				$homepage_options['homepage-parallax-effect'] = array(
							'type'			=> 'switcher',
							'title'			=> 'Parallax effect',
							'label'			=> 'Parallax effect',
							'decsription'	=> 'Enable/Disable parallax effect',
							'value'			=> 'true',
							'default_value'	=> 'default_value'
				);
				$homepage_options['homepage-effect'] = array(
							'type'			=> 'switcher',
							'title'			=> 'Parallax effect',
							'label'			=> 'Parallax effect',
							'decsription'	=> 'Enable/Disable parallax effect',
							'value'			=> 'true',
							'default_value'	=> 'default_value'
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
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-header-top-static.png'
								),
								'header_type_layout_radio_2' => array(
									'label' => 'Left static',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-header-left-static.png'
								),
								'header_type_layout_radio_3' => array(
									'label' => 'Right static',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-header-right-static.png'
								),
								'header_type_layout_radio_4' => array(
									'label' => 'Top toogle',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-header-top-toggle.png'
								),
								'header_type_layout_radio_5' => array(
									'label' => 'Left toogle',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-header-left-toggle.png'
								),
								'header_type_layout_radio_6' => array(
									'label' => 'Right toogle',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-header-right-toggle.png'
								)
							)
				);
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
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-none.png'
								),
								'header_widgetarea_layout_radio_2' => array(
									'label' => 'Single area',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-1.png'
								),
								'header_widgetarea_layout_radio_3' => array(
									'label' => 'Double area',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-2.png'
								),
								'header_widgetarea_layout_radio_4' => array(
									'label' => 'Quad area',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-4.png'
								)
							)
				);
				$header_options['header-style'] = array(
							'type'			=> 'background',
							'title'			=> 'Header styling',
							'label'			=> 'Header styling section',
							'decsription'	=> 'Change the Header style',
							'return_data_type'	=> 'id',
							'value'			=> array(
									'image'	=> 'http://192.168.9.83/wodrpress-git/wp-cherry4-master/wordpress/wp-content/uploads/2014/05/site5.jpg',
									'color'	=> '#a4cc3f',
									'repeat'	=> 'repeat',
									'position'	=> 'left',
									'attachment'=> 'fixed'
								)
				);
				$header_options['header-parallax-effect'] = array(
							'type'			=> 'switcher',
							'title'			=> 'Parallax effect',
							'label'			=> 'Parallax effect',
							'decsription'	=> 'Enable/Disable header parallax effect',
							'value'			=> 'false',
							'default_value'	=> 'default_value'
				);
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
				);
				
////////// Footer options /////////////////////////////////////////////////////
		$footer_options = array();

		$footer_options['footer-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Footer options</h2>'
		);
					$footer_options['footer-widgetarea-layout'] = array(
							'type'			=> 'radio',
							'title'			=> __('Widget area layout', 'cherry'),
							'label'			=> __('Widget area layout', 'cherry'),
							'decsription'	=> __('Choose widget area layout.', 'cherry'),
							'value'			=> 'footer_widgetarea_layout_radio_1',
							'default_value'	=> 'footer_widgetarea_layout_radio_1',
							'class'			=> '',
							'display_input'	=> false,
							'options'		=> array(
								'footer_widgetarea_layout_radio_1' => array(
									'label' => 'None',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-none.png'
								),
								'footer_widgetarea_layout_radio_2' => array(
									'label' => 'Single area',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-1.png'
								),
								'footer_widgetarea_layout_radio_3' => array(
									'label' => 'Double area',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-2.png'
								),
								'footer_widgetarea_layout_radio_4' => array(
									'label' => 'Quad area',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-widgets-layouts-4.png'
								)
							)
					);
					$footer_options['footer-style'] = array(
								'type'			=> 'background',
								'title'			=> 'Footer styling',
								'label'			=> 'Footer styling section',
								'decsription'	=> 'Change the Footer style',
								'return_data_type'	=> 'id',
								'value'			=> array(
										'image'	=> 'http://192.168.9.83/wodrpress-git/wp-cherry4-master/wordpress/wp-content/uploads/2014/05/site5.jpg',
										'color'	=> '#a4cc3f',
										'repeat'	=> 'repeat',
										'position'	=> 'left',
										'attachment'=> 'fixed'
									)
					);
					$footer_options['footer-parallax-effect'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Parallax effect',
								'label'			=> 'Parallax effect',
								'decsription'	=> 'Enable/Disable footer parallax effect',
								'value'			=> 'false',
								'default_value'	=> 'default_value'
					);
					$footer_options['footer-social-list'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Footer social list',
								'label'			=> 'Display footer social list?',
								'decsription'	=> 'Enable/Disable footer social list.',
								'value'			=> 'false',
								'default_value'	=> 'default_value'
					);
					$footer_options['footer-menu'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Footer Menu',
								'label'			=> 'Display Footer Menu?',
								'decsription'	=> 'Enable/Disable footer menu.',
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$footer_options['footer-menu-typography'] = array(
								'type'			=> 'typography',
								'title'			=> 'Footer menu typography',
								'label'			=> 'Footer menu typography style',
								'decsription'	=> 'Choose your prefered font for menu.',
								'value'			=> array(
									'size'			=> '14',
									'lineheight'	=> '14',
									'color'			=> '#aa00aa',
									'family'		=> 'Abril Fatface',
									'character'		=> 'latin-ext',
									'style'			=> 'italic'
								)
					);
					$footer_options['footer-copyright-text'] = array(
								'type'			=> 'textarea',
								'title'			=> 'Footer copyright text',
								'label'			=> 'Input copyright text',
								'decsription'	=> 'Enter text used in the right side of the footer. HTML tags are allowed.',
								'value'			=> '',
								'default_value'	=> ''
					);
					$footer_options['google-analytics-code'] = array(
								'type'			=> 'textarea',
								'title'			=> 'Google Analytics Code',
								'label'			=> 'Google Analytics Code',
								'decsription'	=> 'You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.',
								'value'			=> '',
								'default_value'	=> ''
					);
					
////////// Typography options /////////////////////////////////////////////////
		$typography_options = array();

		$typography_options['typography-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Typography options</h2>'
		);
				$typography_options['linkcolor'] = array(
							'type'			=> 'colorpicker',
							'title'			=> 'Link color',
							'label'			=> 'Link color',
							'decsription'	=> 'Change the color of link',
							'value'			=> '#dddddd',
							'default_value'	=> '#dddddd'
				);
				$typography_options['linkhovercolor'] = array(
							'type'			=> 'colorpicker',
							'title'			=> 'Link hover color',
							'label'			=> 'Link hover color',
							'decsription'	=> 'Change the hover color of link',
							'value'			=> '#ff0000',
							'default_value'	=> '#ff0000'
				);
				$typography_options['bodyfontstyle'] = array(
							'type'			=> 'typography',
							'title'			=> 'Base font style',
							'label'			=> 'Base font style',
							'decsription'	=> 'Choose your prefered font for base text style.',
							'value'			=> array(
								'size'			=> '30',
								'lineheight'	=> '30',
								'color'			=> '#000000',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
							)
				);
				$typography_options['h1-heading'] = array(
							'type'			=> 'typography',
							'title'			=> 'H1 Heading',
							'label'			=> 'H1 Heading style',
							'decsription'	=> 'Choose your prefered font for H1 heading and titles.',
							'value'			=> array(
								'size'			=> '30',
								'lineheight'	=> '30',
								'color'			=> '#000000',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
							)
				);
				$typography_options['h2-heading'] = array(
							'type'			=> 'typography',
							'title'			=> 'H2 Heading',
							'label'			=> 'H2 Heading style',
							'decsription'	=> 'Choose your prefered font for H2 heading and titles.',
							'value'			=> array(
								'size'			=> '25',
								'lineheight'	=> '25',
								'color'			=> '#000000',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
							)
				);
				$typography_options['h3-heading'] = array(
							'type'			=> 'typography',
							'title'			=> 'H3 Heading',
							'label'			=> 'H3 Heading style',
							'decsription'	=> 'Choose your prefered font for H3 heading and titles.',
							'value'			=> array(
								'size'			=> '20',
								'lineheight'	=> '20',
								'color'			=> '#aaaaaa',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
							)
				);
				$typography_options['h4-heading'] = array(
							'type'			=> 'typography',
							'title'			=> 'H4 Heading',
							'label'			=> 'H4 Heading style',
							'decsription'	=> 'Choose your prefered font for H4 heading and titles.',
							'value'			=> array(
								'size'			=> '18',
								'lineheight'	=> '18',
								'color'			=> '#aaaaaa',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
							)
				);
				$typography_options['h5-heading'] = array(
							'type'			=> 'typography',
							'title'			=> 'H5 Heading',
							'label'			=> 'H5 Heading style',
							'decsription'	=> 'Choose your prefered font for H5 heading and titles.',
							'value'			=> array(
								'size'			=> '16',
								'lineheight'	=> '16',
								'color'			=> '#aaaaaa',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
							)
				);
				$typography_options['h6-heading'] = array(
							'type'			=> 'typography',
							'title'			=> 'H6 Heading',
							'label'			=> 'H6 Heading style',
							'decsription'	=> 'Choose your prefered font for H6 heading and titles.',
							'value'			=> array(
								'size'			=> '14',
								'lineheight'	=> '14',
								'color'			=> '#aaaaaa',
								'family'		=> 'Abril Fatface',
								'character'		=> 'latin-ext',
								'style'			=> 'italic'
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
								'default_value'		=> 'http://192.168.9.83/wodrpress-git/wp-cherry4-master/wordpress/wp-content/themes/cherryframework4/favicon.ico',
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
					);
////////// Navigation options /////////////////////////////////////////////////
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
									'style'			=> 'italic'
								)
					);
////////// Dropdown options ///////////////////////////////////////////////////
		$dropdown_options = array();
		$dropdown_options['sub-navigation-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Sub menu options</h2>'
		);
					$dropdown_options['dropdown'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Dropdown',
								'label'			=> 'Dropdown menu',
								'decsription'	=> 'Enable/Disable dropdown menu.',
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$dropdown_options['dropdown-fadein-animation'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Drop down fade-in animation',
								'label'			=> 'Fade-in animation',
								'decsription'	=> 'Enable/Disable drop down fade-in animation.',
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$dropdown_options['dropdown-slidedown-animation'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Drop down Slide-down animation',
								'label'			=> 'Slide-down animation',
								'decsription'	=> 'Enable/Disable drop down slide-down animation.',
								'value'			=> 'false',
								'default_value'	=> 'default_value'
					);
					$dropdown_options['dropdown-animation-speed'] = array(
								'type'			=> 'select',
								'title'			=> 'Drop down animation speed',
								'label'			=> 'Animation speed',
								'decsription'	=> 'dDrop down animation speed',
								'value'			=> 'Normal',
								'default_value'	=> 'Normal',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'Slow',
									'select_2'	=> 'Normal',
									'select_3'	=> 'Fast'
								)
					);
					$dropdown_options['dropdown-animation-delay'] = array(
								'type'			=> 'text',
								'title'			=> 'Drop down animation delay',
								'label'			=> 'Animation delay',
								'decsription'	=> 'Miliseconds delay on mouseout.',
								'value'			=> '1000',
								'default_value'	=> 'default_value'
					);
////////// Mobile navigation options //////////////////////////////////////////
		$mobile_navigation_options = array();
			$mobile_navigation_options['mobile-navigation-options'] = array(
						'type'			=> 'info',
						'title'			=> '',
						'decsription'	=> 'decsription info',
						'value'			=> '<h2>Mobile navigation options</h2>'
			);
			$mobile_navigation_options['mobile-menu-label'] = array(
						'type'			=> 'text',
						'title'			=> 'Mobile menu label',
						'label'			=> 'Text for mobile menu label',
						'decsription'	=> 'This text is visible in mobile select menu.',
						'value'			=> 'Navigate to...',
						'default_value'	=> 'default_value'
			);
////////// Blog options ///////////////////////////////////////////////////////
		$blog_options = array();

		$blog_options['blog-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Blog options</h2>'
		);
					$blog_options['blog-layout'] = array(
							'type'			=> 'radio',
							'title'			=> __('Blog layout', 'cherry'),
							'label'			=> __('Blog layout', 'cherry'),
							'decsription'	=> __('Choose blog layout.', 'cherry'),
							'value'			=> 'blog_layout_radio_image_1',
							'default_value'	=> 'blog_layout_radio_image_1',
							'class'			=> '',
							'display_input'	=> false,
							'options'		=> array(
								'blog_layout_radio_image_1' => array(
									'label' => 'Container',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-container.png'
								),
								'blog_layout_radio_image_2' => array(
									'label' => 'Full widht',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-fullwidth.png'
								),
								'blog_layout_radio_image_3' => array(
									'label' => 'Left sidebar',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-left-sidebar.png'
								),
								'blog_layout_radio_image_4' => array(
									'label' => 'Right sidebar',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-right-sidebar.png'
								),
								'blog_layout_radio_image_5' => array(
									'label' => 'Both sidebars',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-both-sidebar.png'
								),
								'blog_layout_radio_image_6' => array(
									'label' => 'Two same-side sidebars',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-sameside-sidebar.png'
								)
							)
					);
					$blog_options['blog-type'] = array(
							'type'			=> 'radio',
							'title'			=> __('Blog type', 'cherry'),
							'label'			=> __('Blog type', 'cherry'),
							'decsription'	=> __('Choose blog type.', 'cherry'),
							'value'			=> 'blog_type_radio_image_1',
							'default_value'	=> 'blog_type_radio_image_1',
							'class'			=> '',
							'display_input'	=> false,
							'options'		=> array(
								'blog_type_radio_image_1' => array(
									'label' => '2 col.Grid',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-grid2.png'
								),
								'blog_type_radio_image_2' => array(
									'label' => '3 col.Grid',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-grid3.png'
								),
								'blog_type_radio_image_3' => array(
									'label' => '4 col.Grid',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-grid4.png'
								),
								'blog_type_radio_image_4' => array(
									'label' => 'List',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-list.png'
								),
								'blog_type_radio_image_5' => array(
									'label' => 'Checker list',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-checkerlist.png'
								),
								'blog_type_radio_image_6' => array(
									'label' => 'Masonry',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-masonry.png'
								),
								'blog_type_radio_image_7' => array(
									'label' => 'Justified',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-justified.png'
								)
							)
					);
					$blog_options['blog-title'] = array(
								'type'			=> 'text',
								'title'			=> 'Blog Title',
								'label'			=> 'Blog Title',
								'decsription'	=> 'Enter Your Blog Title used on Blog page.',
								'value'			=> 'Blog',
								'default_value'	=> 'default_value',
								/*'class'			=> 'width-small'*/
					);
					$blog_options['blog-image-size'] = array(
								'type'			=> 'select',
								'title'			=> 'Blog image size',
								'label'			=> 'Blog image size',
								'decsription'	=> 'Featured image size on the blog page.',
								'value'			=> 'select_1',
								'default_value'	=> 'select_1',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'Normal size',
									'select_2'	=> 'Large size'
								)
					);
					$blog_options['blog-excerpt'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Blog excerpt',
								'label'			=> 'Enable excerpt for blog posts?',
								'decsription'	=> 'Enable/Disable excerpt for blog posts.',
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_options['blog-excerpt-word'] = array(
								'type'			=> 'stepper',
								'title'			=> 'Excerpt words',
								'label'			=> 'Number of words',
								'decsription'	=> 'Excerpt length (words).',
								'value'			=> '10',
								'default_value'	=> '10',
								'value_step'	=> '1',
								'max_value'		=> '50',
								'min_value'		=> '1'
					);

////////// Blog view options ///////////////////////////////////////////////////////
		$blog_meta_options = array();

		$blog_meta_options['blog-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Blog view options</h2>'
		);
					$blog_meta_options['blog-meta-view-type'] = array(
								'type'			=> 'select',
								'title'			=> __('View meta of the blog', 'cherry'),
								'label'			=> __('View meta of the blog', 'cherry'),
								'decsription'	=> __('Select meta block type which will be displayed on blog and post pages.', 'cherry'),
								'value'			=> 'select_1',
								'default_value'	=> 'select_1',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'Lines',
									'select_2'	=> 'Icons',
									'select_3'	=> 'Do not show'
								)
					);
					$blog_meta_options['meta-publish-date'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Post publication date', 'cherry'),
								'label'			=> __('Enable/Disable publication date', 'cherry'),
								'decsription'	=> __('Should the post publication date be displayed?', 'cherry'),
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-author'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Author of the post', 'cherry'),
								'label'			=> __('Enable/Disable author of the post', 'cherry'),
								'decsription'	=> __('Display the author of the post?', 'cherry'),
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-direct-link'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Direct link to the post', 'cherry'),
								'label'			=> __('Enable/Disable direct link to the post', 'cherry'),
								'decsription'	=> __('Should the direct link to the post be displayed?', 'cherry'),
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-categories'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Post categories', 'cherry'),
								'label'			=> __('Enable/Disable post categories', 'cherry'),
								'decsription'	=> __('Should the post categories be displayed?', 'cherry'),
								'value'			=> 'false',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-tags'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Tags', 'cherry'),
								'label'			=> __('Enable/Disable tags', 'cherry'),
								'decsription'	=> __('Should the tags be displayed?', 'cherry'),
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-comments'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Number of comments', 'cherry'),
								'label'			=> __('Enable/Disable number of comments', 'cherry'),
								'decsription'	=> __('Should the number of comments be displayed?', 'cherry'),
								'value'			=> 'false',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-views'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Number of views', 'cherry'),
								'label'			=> __('Enable/Disable number of views', 'cherry'),
								'decsription'	=> __('Should the number of views be displayed?', 'cherry'),
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-likes'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Number of likes', 'cherry'),
								'label'			=> __('Enable/Disable number of likes', 'cherry'),
								'decsription'	=> __('Should the number of likes be displayed?', 'cherry'),
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
					$blog_meta_options['meta-post-dislikes'] = array(
								'type'			=> 'switcher',
								'title'			=> __('Number of dislikes', 'cherry'),
								'label'			=> __('Enable/Disable number of dislikes', 'cherry'),
								'decsription'	=> __('Should the number of dislikes be displayed?', 'cherry'),
								'value'			=> 'false',
								'default_value'	=> 'default_value'
					);
////////// Blog single post options ///////////////////////////////////////////////////////
		$blog_single_post_options = array();

		$blog_single_post_options['blog-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Blog view options</h2>'
		);
					$blog_single_post_options['blog-single-layout'] = array(
							'type'			=> 'radio',
							'title'			=> __('Single post layout', 'cherry'),
							'label'			=> __('Single post', 'cherry'),
							'decsription'	=> __('Choose single post layout.', 'cherry'),
							'value'			=> 'blog_single_radio_image_1',
							'default_value'	=> 'blog_single_radio_image_1',
							'class'			=> '',
							'display_input'	=> false,
							'options'		=> array(
								'blog_single_radio_image_1' => array(
									'label' => 'Container',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-container.png'
								),
								'blog_single_radio_image_2' => array(
									'label' => 'Full widht',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-fullwidth.png'
								),
								'blog_single_radio_image_3' => array(
									'label' => 'Left sidebar',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-left-sidebar.png'
								),
								'blog_single_radio_image_4' => array(
									'label' => 'Right sidebar',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-right-sidebar.png'
								),
								'blog_single_radio_image_5' => array(
									'label' => 'Both sidebars',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-both-sidebar.png'
								),
								'blog_single_radio_image_6' => array(
									'label' => 'Two same-side sidebars',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-sameside-sidebar.png'
								)
							)
					);
					$blog_single_post_options['single-post-image-size'] = array(
								'type'			=> 'select',
								'title'			=> 'Single post image size',
								'label'			=> 'Single post image size',
								'decsription'	=> 'Featured image size on the single page.',
								'value'			=> 'select_1',
								'default_value'	=> 'select_1',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'Normal size',
									'select_2'	=> 'Large size'
								)
					);
					$blog_single_post_options['share-button'] = array(
								'type'			=> 'switcher',
								'title'			=> 'Share button',
								'label'			=> 'Display share button',
								'decsription'	=> 'Display share button in single post?',
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);
////////// Portfolio options //////////////////////////////////////////////////
		$portfolio_options = array();

		$portfolio_options['portfolio-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Portfolio options</h2>'
		);
					$portfolio_options['portfolio-layout'] = array(
							'type'			=> 'radio',
							'title'			=> __('Portfolio layout', 'cherry'),
							'label'			=> __('Portfolio', 'cherry'),
							'decsription'	=> __('Choose portfolio layout.', 'cherry'),
							'value'			=> 'portfolio_layout_radio_image_1',
							'default_value'	=> 'portfolio_layout_radio_image_1',
							'class'			=> '',
							'display_input'	=> false,
							'options'		=> array(
								'portfolio_layout_radio_image_1' => array(
									'label' => 'Container',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-container.png'
								),
								'portfolio_layout_radio_image_2' => array(
									'label' => 'Full widht',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-fullwidth.png'
								),
								'portfolio_layout_radio_image_3' => array(
									'label' => 'Left sidebar',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-left-sidebar.png'
								),
								'portfolio_layout_radio_image_4' => array(
									'label' => 'Right sidebar',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-right-sidebar.png'
								),
								'portfolio_layout_radio_image_5' => array(
									'label' => 'Both sidebars',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-both-sidebar.png'
								),
								'portfolio_layout_radio_image_6' => array(
									'label' => 'Two same-side sidebars',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-layout-sameside-sidebar.png'
								)
							)
					);
					$portfolio_options['portfolio-type'] = array(
							'type'			=> 'radio',
							'title'			=> __('Portfolio type', 'cherry'),
							'label'			=> __('Portfolio', 'cherry'),
							'decsription'	=> __('Choose portfolio type.', 'cherry'),
							'value'			=> 'portfolio_type_radio_image_1',
							'default_value'	=> 'portfolio_type_radio_image_1',
							'class'			=> '',
							'display_input'	=> false,
							'options'		=> array(
								'portfolio_type_radio_image_1' => array(
									'label' => '2 col.Grid',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-grid2.png'
								),
								'portfolio_type_radio_image_2' => array(
									'label' => '3 col.Grid',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-grid3.png'
								),
								'portfolio_type_radio_image_3' => array(
									'label' => '4 col.Grid',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-grid4.png'
								),
								'portfolio_type_radio_image_4' => array(
									'label' => 'List',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-list.png'
								),
								'portfolio_type_radio_image_5' => array(
									'label' => 'Checker list',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-checkerlist.png'
								),
								'portfolio_type_radio_image_6' => array(
									'label' => 'Masonry',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-masonry.png'
								),
								'portfolio_type_radio_image_7' => array(
									'label' => 'Justified',
									'img_src' => PARENT_URI.'/lib/admin/assets/images/cherry-type-justified.png'
								)
							)
					);
					$portfolio_options['portfolio-filter'] = array(
								'type'			=> 'select',
								'title'			=> 'Filter',
								'label'			=> 'Filter',
								'decsription'	=> 'Select portfolio filter.',
								'value'			=> 'select_1',
								'default_value'	=> 'select_1',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'By category',
									'select_2'	=> 'By tags',
									'select_3'	=> 'None'
								)
					);
					$portfolio_options['portfolio-order-filter'] = array(
								'type'			=> 'select',
								'title'			=> 'Sort order for filter',
								'label'			=> 'Sort order for filter',
								'decsription'	=> 'Sort order for filter (either ascending or descending).',
								'value'			=> 'select_1',
								'default_value'	=> 'select_1',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'ASC',
									'select_2'	=> 'DESC'
								)
					);
					$portfolio_options['category-filter-multiselect'] = array(
								'type'			=> 'multiselect',
								'title'			=> 'Display category',
								'label'			=> 'label multiselect',
								'decsription'	=> 'Select category for portfolio-page',
								'placeholder'	=> 'Select value',
								'value'			=> '',
								'default_value'	=> '',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'Category 1',
									'select_2'	=> 'Category 2',
									'select_3'	=> 'Category 3',
									'select_4'	=> 'Category 4',
									'select_5'	=> 'Category 5',
									'select_6'	=> 'Category 6',
									'select_7'	=> 'Category 2',
									'select_8'	=> 'Category 8'
								)
					);
////////// Submit wrapper /////////////////////////////////////////////////////
		$submitSection = array();

		$submitSection['save-options'] = array(
					'type'			=> 'submit',
					'value'			=> 'Save Options'
		);
		$submitSection['restore-options'] = array(
					'type'			=> 'submit',
					'value'			=> 'Restore Options'
		);
////////// Demo options ///////////////////////////////////////////////////////
		$demo_options = array();

		$demo_options['demo-options'] = array(
					'type'			=> 'info',
					'title'			=> '',
					'decsription'	=> 'decsription info',
					'value'			=> '<h2>Demo options</h2>'
		);
					$demo_options['text'] = array(
								'type'			=> 'text',
								'title'			=> 'title text',
								'label'			=> 'label text',
								'decsription'	=> 'decsription text',
								'value'			=> 'value',
								'default_value'	=> 'default_value',
								/*'class'			=> 'width-small'*/
					);

					$demo_options['textarea'] = array(
								'type'			=> 'textarea',
								'title'			=> 'title textarea',
								'label'			=> 'label textarea',
								'decsription'	=> 'decsription textarea',
								'value'			=> 'value',
								'default_value'	=> 'default_value',
								/*'class'			=> 'width-medium'*/
					);

					$demo_options['select'] = array(
								'type'			=> 'select',
								'title'			=> 'title select',
								'label'			=> 'label select',
								'decsription'	=> 'decsription select',
								'value'			=> 'select_1',
								'default_value'	=> 'select_1',
								'class'			=> 'width-full',
								'options'		=> array(
									'select_1'	=> 'select 1',
									'select_2'	=> 'select 2',
									'select_3'	=> 'select 3'
								)
					);

					$demo_options['filterselect'] = array(
								'type'			=> 'filterselect',
								'title'			=> 'title filterselect',
								'label'			=> 'label filterselect',
								'decsription'	=> 'decsription filterselect',
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

					$demo_options['multiselect'] = array(
								'type'			=> 'multiselect',
								'title'			=> 'title multiselect',
								'label'			=> 'label multiselect',
								'decsription'	=> 'decsription multiselect',
								'placeholder'	=> 'Select value',
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

					$demo_options['checkbox'] = array(
								'type'			=> 'checkbox',
								'title'			=> 'title checkbox',
								'label'			=> 'label checkbox',
								'decsription'	=> 'decsription checkbox',
								'value'			=> 'value',
								'default_value'	=> 'default_value'
					);

					$demo_options['switcher'] = array(
								'type'			=> 'switcher',
								'title'			=> 'title switcher',
								'label'			=> 'label switcher',
								'decsription'	=> 'decsription switcher',
								'value'			=> 'true',
								'default_value'	=> 'default_value'
					);

					$demo_options['multicheckbox'] = array(
								'type'			=> 'multicheckbox',
								'title'			=> 'title multicheckbox',
								'label'			=> 'label multicheckbox',
								'decsription'	=> 'decsription multicheckbox',
								'class'			=> '',
								'value'			=> array(
									'checkbox_1'	=> false,
									'checkbox_2'	=> true,
									'checkbox_3'	=> true
								),
								'default_value'	=> array(
									'checkbox_1'	=> false,
									'checkbox_2'	=> false,
									'checkbox_3'	=> true
								),
								'options'		=> array(
									'checkbox_1'	=> 'checkbox 1',
									'checkbox_2'	=> 'checkbox 2',
									'checkbox_3'	=> 'checkbox 3'
								)
					);

					$demo_options['radio'] = array(
								'type'			=> 'radio',
								'title'			=> 'title radio',
								'label'			=> 'label radio',
								'decsription'	=> 'decsription radio',
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

					$demo_options['radio_image'] = array(
								'type'			=> 'radio',
								'title'			=> 'title radio',
								'label'			=> 'label radio',
								'decsription'	=> 'decsription radio',
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

					$demo_options['image'] = array(
								'type'				=> 'image',
								'title'				=> 'title image',
								'label'				=> 'label image',
								'decsription'		=> 'decsription image',
								'value'				=> '',
								'default_value'		=> 'http://192.168.9.76/wordpress_git/01_new_wordpress/wp-content/uploads/2014/03/logo.png',
								'display_image'		=> true,
								'multi_upload'		=> true,
								'return_data_type'	=> 'url'
					);

					$demo_options['image_2'] = array(
								'type'				=> 'image',
								'title'				=> 'title image',
								'label'				=> 'label image',
								'decsription'		=> 'decsription image',
								'value'				=> '',
								'default_value'		=> 'http://192.168.9.76/wordpress_git/01_new_wordpress/wp-content/uploads/2014/03/logo.png',
								'display_image'		=> true,
								'multi_upload'		=> true,
								'return_data_type'	=> 'url'
					);

					$demo_options['colorpicker'] = array(
								'type'			=> 'colorpicker',
								'title'			=> 'title colorpicker',
								'label'			=> 'label colorpicker',
								'decsription'	=> 'decsription colorpicker',
								'value'			=> '#ff0000',
								'default_value'	=> '#ff0000'
					);

					$demo_options['stepper'] = array(
								'type'			=> 'stepper',
								'title'			=> 'title stepper',
								'label'			=> 'label stepper',
								'decsription'	=> 'decsription stepper',
								'value'			=> '0',
								'default_value'	=> '0',
								'value_step'	=> '1',
								'max_value'		=> '50',
								'min_value'		=> '-50'
					);

					$demo_options['editor'] = array(
								'type'			=> 'editor',
								'title'			=> 'title editor',
								'label'			=> 'label editor',
								'decsription'	=> 'decsription editor',
								'value'			=> 'editor',
								'default_value'	=> 'editor'
					);

					$demo_options['background'] = array(
								'type'			=> 'background',
								'title'			=> 'title background',
								'label'			=> 'label background',
								'decsription'	=> 'decsription background',
								'return_data_type'	=> 'id',
								'value'			=> array(
										'image'	=> '5',
										'color'	=> '#ff0000',
										'repeat'	=> 'repeat',
										'position'	=> 'left',
										'attachment'=> 'fixed'
									)
					);

					$demo_options['info'] = array(
								'type'			=> 'info',
								'title'			=> 'title info',
								'decsription'	=> 'decsription info',
								'value'			=> '<h2>info</h2>'
					);

					$demo_options['typography'] = array(
								'type'			=> 'typography',
								'title'			=> 'title typography',
								'label'			=> 'label typography',
								'decsription'	=> 'decsription typography',
								'value'			=> array(
									'size'			=> '10',
									'lineheight'	=> '10',
									'color'			=> 'blue',
									'family'		=> 'Abril Fatface',
									'character'		=> 'latin-ext',
									'style'			=> 'italic'
								)
					);

					$demo_options['submit'] = array(
								'type'			=> 'submit',
								'value'			=> 'get value'
					);


///////////////////options section data array///////////////////////////////////////////////////////////////////
		$optionsSectionArray = array(
					array(
							'id' => 'general-options',
							'name' => 'General',
							'icon' => 'fa fa-cogs',
							'parent' => '',
							'option-list' => $general_options
					),
					array(
							'id' => 'homepage-options',
							'name' => 'Home page',
							'icon' => 'fa fa-home',
							'parent' => '',
							'option-list' => $homepage_options
					),
					array(
							'id' => 'header-options',
							'name' => 'Header',
							'icon' => 'fa fa-header',
							'parent' => '',
							'option-list' => $header_options
					),
					array(
							'id' => 'footer-options',
							'name' => 'Footer',
							'icon' => 'fa fa-cog',
							'parent' => '',
							'option-list' => $footer_options
					),
					array(
							'id' => 'typography-options',
							'name' => 'Typography',
							'icon' => 'fa fa-font',
							'parent' => '',
							'option-list' => $typography_options
					),
					array(
							'id' => 'logo-options',
							'name' => 'Logo',
							'icon' => 'fa fa-cog',
							'parent' => '',
							'option-list' => $logo_options
					),
					array(
							'id' => 'navigation-options',
							'name' => 'Navigation',
							'icon' => 'fa fa-align-left',
							'parent' => '',
							'option-list' => $navigation_options
					),
						array(
								'id' => 'dropdown-options',
								'name' => 'Dropdown',
								'icon' => 'fa fa-caret-right',
								'parent' => 'navigation-options',
								'option-list' => $dropdown_options
						),
						array(
								'id' => 'mobile-navigation-options',
								'name' => 'Mobile menu',
								'icon' => 'fa fa-caret-right',
								'parent' => 'navigation-options',
								'option-list' => $mobile_navigation_options
						),
					array(
							'id' => 'blog-options',
							'name' => 'Blog',
							'icon' => 'fa fa-bold',
							'parent' => '',
							'option-list' => $blog_options
					),
						array(
							'id' => 'blog-meta-options',
							'name' => 'Blog meta',
							'icon' => 'fa fa-caret-right',
							'parent' => 'blog-options',
							'option-list' => $blog_meta_options
						),
						array(
							'id' => 'blog-single-post-options',
							'name' => 'Single post',
							'icon' => 'fa fa-caret-right',
							'parent' => 'blog-options',
							'option-list' => $blog_single_post_options
						),
					array(
							'id' => 'portfolio-options',
							'name' => 'Portfolio',
							'icon' => 'fa fa-picture-o',
							'parent' => '',
							'option-list' => $portfolio_options
					),
					array(
							'id' => 'demo-options',
							'name' => 'All interface elements',
							'icon' => 'fa fa-hand-o-right',
							'parent' => '',
							'option-list' => $demo_options
					)
		);

		$dom_part_output = '';
		$dom_part_output .= '<form id="cherry_options">';
			$dom_part_output .= '<div class="options-framework-wrapper">';
				$dom_part_output .= '<ul class="cherry-tab-menu">';
					foreach ($optionsSectionArray as $section_key => $section_value) {
						($section_value["parent"] != '')? $subClass = 'subitem' : $subClass = '';
						$dom_part_output .= '<li class="'.$section_value["parent"].' '.$subClass.' tabitem-'.$section_key.'"><a href="javascript:void(0)"><i class="'.$section_value["icon"].'"></i><span>'.$section_value["name"].'</span></a></li>';
					}
				$dom_part_output .= '</ul>';
				$dom_part_output .= '<div class="cherry-option-group-list">';
					foreach ($optionsSectionArray as $section_key => $section_value) {
						$dom_part_output .= '<div class="options_group">'.$optioninteface -> multi_output_items($section_value["option-list"]).'</div>';
					}
				$dom_part_output .= '</div><div class="clear"></div>';
			$dom_part_output .= '</div>';
		$dom_part_output .= '<div class="cherry-option-submit-wrapper">'.$optioninteface -> multi_output_items($submitSection).'</div>';
		$dom_part_output .= '</form>';
		echo $dom_part_output;
	}

?>