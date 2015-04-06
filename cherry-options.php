<?php

function cherry_defaults_settings() {
	global $cherry_registered_statics, $cherry_registered_static_areas;
	$all_statics = $cherry_registered_statics;

	$all_pages     = array();
	$all_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$all_pages[''] = __( 'Select a page:', 'cherry' );

	foreach ( $all_pages_obj as $page ) {
		$all_pages[$page->ID] = $page->post_title;
	}

	//var_dump($all_statics);

//////////////////////////////////////////////////////////////////////
// General
//////////////////////////////////////////////////////////////////////

	$general_options = array();
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
	);
	$general_options['general-maintenance-mode'] = array(
			'type'			=> 'switcher',
			'title'			=> __( 'Maintenance mode', 'cherry' ),
			'decsription'	=> __( 'Hide your site from regular visitors', 'cherry' ),
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> __( 'Logged in administrator gets full access to the site, while regular visitors will
				be redirected to the chosen page.', 'cherry' )
			),
			'value'			=> 'true',
	);
	$general_options['general-maintenance-page'] = array(
				'type'			=> 'select',
				'title'			=> __( 'Maintenance page', 'cherry' ),
				'decsription'	=> __( 'Use this page content as maintenance page content', 'cherry' ),
				'value'			=> '',
				'class'			=> 'width-full',
				'options'		=> $all_pages
	);
	$general_options['general-smoothscroll'] = array(
			'type'			=> 'switcher',
			'title'			=> 'Document smooth scroll',
			'decsription'	=> 'Enable smooth scrolling',
			'hint'			=>  array(
				'type'		=> 'text',
				'content'	=> 'Jquery vertical mousewheel smooth scrolling for desktop chrome version only.'
			),
			'value'			=> 'true',
	);

//////////////////////////////////////////////////////////////////////
// Footer options
//////////////////////////////////////////////////////////////////////
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
//////////////////////////////////////////////////////////////////////
// Grid options
//////////////////////////////////////////////////////////////////////
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
		'value'         => 'boxed',
		'class'         => '',
		'display_input' => false,
		'options'       => array(
			'wide' => array(
				'label'   => __( 'Wide', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/grid-type-fullwidth.svg',
			),
			'boxed' => array(
				'label'   => __( 'Boxed', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/grid-type-container.svg',
			),
		),
	);
//////////////////////////////////////////////////////////////////////
// Page layout options
//////////////////////////////////////////////////////////////////////
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
	$page_layout_options['page-layout'] = array(
		'type'          => 'radio',
		'title'         => __( 'Blog page layout', 'cherry' ),
		'label'         => __( 'Blog page layout', 'cherry' ),
		'decsription'   => __( 'Choose blog page layout.', 'cherry' ),
		'value'         => '1-right',
		'display_input' => false,
		'options'       => array(
			'1-left' => array(
				'label'   => __( 'Left sidebar', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/page-layout-left-sidebar.svg',
			),
			'1-right' => array(
				'label'   => __( 'Right sidebar', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/page-layout-right-sidebar.svg',
			),
			'1-left-2-right' => array(
				'label'   => __( 'Left and right sidebar', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/page-layout-both-sidebar.svg',
			),
			'1-left-2-left' => array(
				'label'   => __( 'Sameside left sidebar', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/page-layout-sameside-left-sidebar.svg',
			),
			'1-right-2-right' => array(
				'label'   => __( 'Sameside right sidebar', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/page-layout-sameside-right-sidebar.svg',
			),
			'no-sidebar' => array(
				'label'   => __( 'No sidebar', 'cherry' ),
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/page-layout-fullwidth.svg',
			),
		)
	);
//////////////////////////////////////////////////////////////////////
// Blog layout options
//////////////////////////////////////////////////////////////////////
	$blog_options = array();

	// Featured
	// $blog_options['blog-list-layout'] = array(
	// 	'type'          => 'radio',
	// 	'title'         => __( 'Blog list layout', 'cherry' ),
	// 	'label'         => __( 'Blog list layout', 'cherry' ),
	// 	'decsription'   => __( 'Choose blog page layout.', 'cherry' ),
	// 	'value'         => 'masonry',
	// 	'display_input' => false,
	// 	'options'       => array(
	// 		'masonry' => array(
	// 			'label'   => 'Masonry',
	// 			'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/list-layout-masonry.svg'
	// 		),
	// 		'grid' => array(
	// 			'label'   => 'Grid',
	// 			'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/list-layout-grid.svg'
	// 		),
	// 		'list' => array(
	// 			'label'   => 'List',
	// 			'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/list-layout-checkerlist.svg',
	// 		),
	// 	)
	// );

	// $blog_options['blog-images-page-scroll'] = array(
	// 	'type'        => 'switcher',
	// 	'title'       => 'Should images be uploaded on page scroll?',
	// 	'label'       => 'Enable / Disable',
	// 	'decsription' => 'You can enable images load only as you scroll down the page. Otherwise images will load all at once.',
	// 	'hint'        => array(
	// 		'type'    => 'text',
	// 		'content' => '',
	// 	),
	// 	'value'         => 'true',
	// 	'default_value' => 'true',
	// );

	// $blog_options['blog-view-number'] = array(
	// 	'type'        => 'switcher',
	// 	'title'       => 'Number of view.',
	// 	'label'       => 'Enable / Disable',
	// 	'decsription' => 'Should the number of view be displayed?',
	// 	'hint'        => array(
	// 		'type'    => 'text',
	// 		'content' => '',
	// 	),
	// 	'value'         => 'true',
	// 	'default_value' => 'true',
	// );

	// $blog_options['blog-likes-number'] = array(
	// 	'type'        => 'switcher',
	// 	'title'       => 'Number of likes.',
	// 	'label'       => 'Enable / Disable',
	// 	'decsription' => 'Should the number of likes be displayed?',
	// 	'hint'        => array(
	// 		'type'    => 'text',
	// 		'content' => '',
	// 	),
	// 	'value'         => 'true',
	// 	'default_value' => 'true',
	// );

	// $blog_options['blog-dislikes-number'] = array(
	// 	'type'        => 'switcher',
	// 	'title'       => 'Number of dislikes.',
	// 	'label'       => 'Enable / Disable',
	// 	'decsription' => 'Should the number of dislikes be displayed?',
	// 	'hint'        => array(
	// 		'type'    => 'text',
	// 		'content' => '',
	// 	),
	// 	'value'         => 'true',
	// 	'default_value' => 'true',
	// );
	// $blog_options['blog-meta-type-view'] = array(
	// 	'type'			=> 'radio',
	// 	'title'			=> 'view meta of the blog.',
	// 	'label'			=> 'choose one of them',
	// 	'decsription'	=> '',
	// 	'hint'      	=> array(
	// 		'type'    => 'text',
	// 		'content' => 'Select meta block type which will be displayed on blog and post pages.',
	// 	),
	// 	'value'         => 'blog-meta-type-view-line',
	// 	'class'         => '',
	// 	'display-input' => true,
	// 	'options'       => array(
	// 		'blog-meta-type-view-line' => array(
	// 			'label'   => 'Do not show.',
	// 		),
	// 		'blog-meta-type-view-icon' => array(
	// 			'label'   => 'Lines',
	// 		),
	// 	)
	// );

	$blog_options['blog-content-type'] = array(
		'type'        => 'select',
		'title'       => __( 'Post content', 'cherry' ),
		'decsription' => __( 'Choose to display or not post content', 'cherry' ),
		'value'       => 'part',
		'options'     => array(
			'none' => __( 'None', 'cherry' ),
			'part' => __( 'Part', 'cherry' ),
			'full' => __( 'Full', 'cherry' ),
		)
	);

	$blog_options['blog-excerpt-length'] = array(
		'type'        => 'slider',
		'title'       => __( 'Part content length', 'cherry' ),
		'decsription' => __( 'Type the number of words in an excerpt', 'cherry' ),
		'max_value'   => 500,
		'min_value'   => 1,
		'value'       => 55,
	);

	$blog_options['blog-button'] = array(
		'type'        => 'switcher',
		'title'       => __( 'More button', 'cherry' ),
		'decsription' => __( 'Show more button?', 'cherry' ),
		'value'       => 'true',
	);

	$blog_options['blog-button-text'] = array(
		'type'  => 'text',
		'title' => __( 'More button text', 'cherry' ),
		'value' => __( 'read more', 'cherry' ),
	);

	// Post
	$post_single_options['blog-related-posts'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Related posts', 'cherry' ),
		'decsription' => __( 'Show related posts?', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Show related posts?', 'cherry' ),
		),
		'value' => 'true',
	);

	$post_single_options['blog-comment-status'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Allow comments', 'cherry' ),
		'decsription' => __( 'Enabling this option will show comments', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Enabling this option will show comments. <br> But remember that this can be overridden for individual articles.', 'cherry' ),
		),
		'value' => 'true',
	);

	$post_single_options['blog-gallery-shortcode'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Replace default gallery with slider', 'cherry' ),
		'decsription' => __( 'Enable this to replace default WP gallery with Slick slider', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Enable this to replace default WP gallery with Slick slider', 'cherry' ),
		),
		'value' => 'true',
	);

	// Meta
	$post_meta_options['blog-post-date'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Date', 'cherry' ),
		'label'       => __( 'Enable / Disable', 'cherry' ),
		'decsription' => __( 'Should the post publication date be displayed?', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Should the post publication date be displayed?', 'cherry' ),
		),
		'value' => 'true',
	);

	$post_meta_options['blog-post-author'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Author', 'cherry' ),
		'label'       => __( 'Enable / Disable', 'cherry' ),
		'decsription' => __( 'Should the post author be displayed?', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Should the post author be displayed?', 'cherry' ),
		),
		'value' => 'true',
	);

	$post_meta_options['blog-post-comments'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Comments', 'cherry' ),
		'label'       => __( 'Enable / Disable', 'cherry' ),
		'decsription' => __( 'Should the number of comments be displayed?', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Should the number of comments be displayed?', 'cherry' ),
		),
		'value' => 'true',
	);

	$post_meta_options['blog-categories'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Categories', 'cherry' ),
		'label'       => __( 'Enable / Disable', 'cherry' ),
		'decsription' => __( 'Should the post categories be displayed?', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Should the post categories be displayed?', 'cherry' ),
		),
		'value' => 'true',
	);

	$post_meta_options['blog-tags'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Tags', 'cherry' ),
		'label'       => __( 'Enable / Disable', 'cherry' ),
		'decsription' => __( 'Should the tags be displayed?', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Should the post tags be displayed?', 'cherry' ),
		),
		'value' => 'true',
	);

	// $blog_options['blog-direct-link'] = array(
	// 	'type'        => 'switcher',
	// 	'title'       => 'Direct link to the post.',
	// 	'label'       => 'Enable / Disable',
	// 	'decsription' => 'Should the direct link to the post be displayed?',
	// 	'hint'        => array(
	// 		'type'    => 'text',
	// 		'content' => '',
	// 	),
	// 	'value'         => 'true',
	// 	'default_value' => 'true',
	// );

//////////////////////////////////////////////////////////////////////
// Logo options
//////////////////////////////////////////////////////////////////////

	$logo_options = array();

	$logo_options['logo-type'] = array(
				'type'			=> 'radio',
				'title'			=> 'Logo type',
				'label'			=> 'What kind of logo?',
				'decsription'	=> 'Select whether you want your main logo to be an image or text. If you select "image" you can put in the image url in the next option, and if you select "text" your Site Title will be shown instead.',
				'value'			=> 'text',
				'default_value'	=> 'text',
				'class'			=> '',
				'display_input'	=> true,
				'options'		=> array(
					'image' => array(
						'label' => 'Image logo',
						'img_src' => ''
					),
					'text' => array(
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
				'multi-upload'		=> true,
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

//////////////////////////////////////////////////////////////////////
// Navigation options
//////////////////////////////////////////////////////////////////////

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



//////////////////////////////////////////////////////////////////////
// Breadcrumbs options
//////////////////////////////////////////////////////////////////////
	$breadcrumbs_options = array();

	$breadcrumbs_options['breadcrumbs'] = array(
			'type'			=> 'switcher',
			'title'			=> __( 'Breadcrumbs', 'cherry' ),
			'label'			=> __( 'Enable / Disable', 'cherry' ),
			'decsription'	=> __( 'Enable or disable breadcrumb navigation', 'cherry' ),
			'value'			=> 'true',
			'default_value'	=> 'true'
	);
	$breadcrumbs_options['breadcrumbs-display'] = array(
			'type'			=> 'multicheckbox',
			'title'			=> __( 'Breadcrumb display', 'cherry' ),
			'label'			=> __( 'Enable / Disable', 'cherry' ),
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> __( 'Enable or disable displaying on mobile devices', 'cherry' )
			),
			'class'			=> '',
			'value'			=> array(
				'tablet'	=> true,
				'mobile'	=> true,
			),
			'default_value'	=> array(
				'tablet'	=> true,
				'mobile'	=> true,
			),
			'options'		=> array(
				'tablet'	=> __( 'Tablet', 'cherry' ),
				'mobile'	=> __( 'Mobile', 'cherry' ),
			)
	);

	$breadcrumbs_options['breadcrumbs-show-on-front'] = array(
			'type'			=> 'switcher',
			'title' 		=> __( 'Show breadcrumbs on front page', 'cherry' ),
			'decsription'	=> __( 'Show or hide breadcrumbs trail on front page', 'cherry' ),
			'value'			=> 'false'
	);

	$breadcrumbs_options['breadcrumbs-show-title'] = array(
			'type'			=> 'switcher',
			'title' 		=> __( 'Page title', 'cherry' ),
			'decsription'	=> __( 'Show or hide page title in breadcrumbs trail', 'cherry' ),
			'value'			=> 'true'
	);

	$breadcrumbs_options['breadcrumbs-separator'] = array(
			'type'			=> 'text',
			'title'			=> __( 'Item separator', 'cherry' ),
			'label'			=> __( 'Select separator type', 'cherry' ),
			'value'			=> '&#47;',
			'default_value'	=> '&#47;',
			'class'			=> 'width-full'
	);
	$breadcrumbs_options['breadcrumbs-prefix-path'] = array(
			'type'			=> 'text',
			'title'			=> __( 'Breadcrumbs prefix path', 'cherry' ),
			'decsription'	=> __( 'Title before breadcrumb navigation', 'cherry' ),
			'hint'      	=> array(
				'type'		=> 'image',
				'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
			),
			'value'			=> __( 'You are here:', 'cherry' ),
			'default_value'	=> __( 'You are here:', 'cherry' )
	);
	$breadcrumbs_options['breadcrumbs-title-length'] = array(
			'type'			=> 'stepper',
			'title'			=> __( 'Breadcrumb title length', 'cherry' ),
			'label'			=> __( 'Max title length', 'cherry' ),
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> __( 'Limit the length of the breadcrumb title', 'cherry' )
			),
			'value'			=> '0',
			'default_value'	=> '0',
			'value-step'	=> '1',
			'max-value'		=> '200',
			'min-value'		=> '0'
	);

//////////////////////////////////////////////////////////////////////
// Page navigation options
//////////////////////////////////////////////////////////////////////

	$pagination_option = array();

	$pagination_option['pagination-position'] = array(
			'type'			=> 'select',
			'title' 		=> __( 'Pagination position', 'cherry' ),
			'decsription'	=> __( 'Select, where to display post pagination', 'cherry' ),
			'hint'      	=> array(
				'type'		=> 'text',
				'content'	=> __( 'Select, where to display post pagination', 'cherry' )
			),
			'value'			=> 'after',
			'options'    	=> array(
				'after'  => __( 'After posts loop', 'cherry' ),
				'before' => __( 'Before posts loop', 'cherry' ),
				'both'   => __( 'Both', 'cherry' )
			)
	);

	$pagination_option['pagination-next-previous'] = array(
			'type'			=> 'switcher',
			'title' 		=> __( 'Previous and next page buttons', 'cherry' ),
			'decsription'	=> __( 'Show or hide previous an next page buttons', 'cherry' ),
			'value'			=> 'true'
	);
	$pagination_option['pagination-label'] = array(
			'type'			=> 'text',
			'title'			=> __( 'Pagination label', 'cherry' ),
			'decsription'	=> __( 'The text/HTML to display before the list of pages', 'cherry' ),
			'value'			=> __( 'Pages:', 'cherry' ),
			'default_value'	=> __( 'Pages:', 'cherry' )
	);
	$pagination_option['pagination-previous-page'] = array(
			'type'			=> 'text',
			'title'			=> __( 'Previous page', 'cherry' ),
			'decsription'	=> __( 'The text/HTML to display for the previous page link.', 'cherry' ),
			'hint'      	=>  array(
				'type'		=> 'image',
				'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
			),
			'value'			=> '&laquo;',
			'default_value'	=> '&laquo;'
	);
	$pagination_option['pagination-next-page'] = array(
			'type'			=> 'text',
			'title'			=> __( 'Next page', 'cherry' ),
			'decsription'	=> __( 'The text/HTML to display for the next page link.', 'cherry' ),
			'hint'      	=>  array(
				'type'		=> 'image',
				'content'	=> PARENT_URI.'/lib/admin/assets/images/cherry-logo.png'
			),
			'value'			=> '&raquo;',
			'default_value'	=> '&raquo;'
	);
	$pagination_option['pagination-show-all'] = array(
			'type'			=> 'switcher',
			'title' 		=> __( 'Show all the pages', 'cherry' ),
			'decsription'	=> __( 'If set to On, then it will show all of the pages instead of a short list of the pages near the current page.', 'cherry' ),
			'value'			=> 'false'
	);
	$pagination_option['pagination-end-size'] = array(
			'type'			=> 'stepper',
			'title'			=> __( 'End size', 'cherry' ),
			'decsription'	=> __( 'How many numbers on either the start and the end list edges', 'cherry' ),
			'value'			=> '1',
			'default_value'	=> '1',
			'value-step'	=> '1',
			'max-value'		=> '99',
			'min-value'		=> '1'
			);
	$pagination_option['pagination-mid-size'] = array(
			'type'			=> 'stepper',
			'title'			=> __( 'Mid size', 'cherry' ),
			'decsription'	=> __( 'How many numbers to either side of current page, but not including current page', 'cherry' ),
			'value'			=> '2',
			'default_value'	=> '2',
			'value-step'	=> '1',
			'max-value'		=> '9999',
			'min-value'		=> '1'
	);

//////////////////////////////////////////////////////////////////////
// Styling options
//////////////////////////////////////////////////////////////////////

	$styling_options = array();
	//background image
	$styling_options['styling-body-content-background'] = array(
				'type'			=> 'background',
				'title'			=> 'Body background',
				'label'			=> 'set default background',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> 'Background for main container'
				),
				'return_data_type'	=> 'url',
				'library_type'		=> 'image',
				'value'				=> array(
					'image'	=> '',
					'color'	=> '#FFFFFF',
					'repeat'	=> 'repeat',
					'position'	=> 'left',
					'attachment'=> 'fixed'
				)
	);
	$styling_options['styling-body-background-full-scale'] = array(
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
	$styling_options['styling-body-parallax-background'] = array(
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
	$styling_options['styling-body-background-pattern'] = array(
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

//////////////////////////////////////////////////////////////////////
// Color scheme options
//////////////////////////////////////////////////////////////////////

	$color_options = array();
	$color_options['color-primary'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Primary color',
			'decsription'	=> 'Primary color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
			),
			'value'			=> '#f62e46',
			'default_value'	=> '#f62e46'
	);
	$color_options['color-secondary'] = array(
			'type'			=> 'colorpicker',
			'title'			=> 'Secondary color',
			'decsription'	=> 'Secondary color for text, backgrounds and etc.',
			'hint'      	=>  array(
				'type'		=> 'text',
				'content'	=> 'Secondary color for text, backgrounds and etc.'
			),
			'value'			=> '#333333',
			'default_value'	=> '#333333'
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

//////////////////////////////////////////////////////////////////////
// Header options
//////////////////////////////////////////////////////////////////////
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
	$header_options['header-layout'] = array(
		'type'			=> 'radio',
		'title'			=> __('Header type layout', 'cherry'),
		'label'			=> __('Header type layout', 'cherry'),
		'decsription'	=> __('Choose header type layout.', 'cherry'),
		'value'			=> 'header-layout-type-1',
		'display_input'	=> false,
		'options'		=> array(
			'type-1' => array(
				'label' => 'Top static',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/header-top-static.svg'
			),
			'type-2' => array(
				'label' => 'Left static',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/header-left-static.svg'
			),
			'type-3' => array(
				'label' => 'Right static',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/header-right-static.svg'
			),
			'type-4' => array(
				'label' => 'Top toogle',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/header-top-toggle.svg'
			),
			'type-5' => array(
				'label' => 'Left toogle',
				'img_src' => PARENT_URI.'/lib/admin/assets/images/svg/header-left-toggle.svg'
			),
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

//////////////////////////////////////////////////////////////////////
// Typography options
//////////////////////////////////////////////////////////////////////

	$typography_options = array();

	$typography_options['typography-body-text'] = array(
			'type'			=> 'typography',
			'title'			=> 'Body text',
			'label'			=> '',
			'decsription'	=> 'decsription typography',
			'value' => array(
				'size'			=> '14',
				'lineheight'	=> '25',
				'color'			=> '#777777',
				'family'		=> 'Roboto',
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
				'color'			=> '#dd7566',
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
				'color'			=> '#dd3344',
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
				'color'			=> '#dd3344',
				'family'		=> 'Arial',
				'character'		=> 'latin-ext',
				'style'			=> 'italic',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

//////////////////////////////////////////////////////////////////////
// CUSTOM FONTS UPLOAD
//////////////////////////////////////////////////////////////////////

	$typography_options['typography-h1'] = array(
			'type'			=> 'typography',
			'title'			=> 'Heading 1',
			'label'			=> '',
			'decsription'	=> 'Font settings for H1',
			'value' => array(
				'size'			=> '36',
				'lineheight'	=> '40',
				'color'			=> '#333333',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'normal',
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
				'size'			=> '30',
				'lineheight'	=> '33',
				'color'			=> '#333333',
				'family'		=> 'Roboto',
				'character'		=> 'latin-ext',
				'style'			=> 'normal',
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
				'size'			=> '24',
				'lineheight'	=> '26',
				'color'			=> '#333333',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'normal',
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
				'size'			=> '18',
				'lineheight'	=> '20',
				'color'			=> '#333333',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'normal',
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
				'size'			=> '14',
				'lineheight'	=> '16',
				'color'			=> '#333333',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'normal',
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
				'size'			=> '12',
				'lineheight'	=> '14',
				'color'			=> '#333333',
				'family'		=> 'Abril Fatface',
				'character'		=> 'latin-ext',
				'style'			=> 'normal',
				'letterspacing' => '0',
				'align'			=> 'notdefined'
			)
	);

//////////////////////////////////////////////////////////////////////
// List options
//////////////////////////////////////////////////////////////////////

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

//////////////////////////////////////////////////////////////////////
// Optimization options
//////////////////////////////////////////////////////////////////////

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

//////////////////////////////////////////////////////////////////////
// Demo options
//////////////////////////////////////////////////////////////////////

	$demo_options = array();

	$demo_options['description-demo'] = array(
				'title' 			=> __('Interface elements section contains Cherry Options interface elements. Interface developers can use these elements to build their own Cherry Framework based configuration pages.', 'cherry'),
	);
	$demo_options['typography-demo'] = array(
				'type'			=> 'typography',
				'title'			=> __('Typography'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Provides typography configuration options such as Google Font family name, font size, line height, style, letter spacing, characters sets, text align and color. Below options you can see font preview.', 'cherry'),
				),
				'value'			=> array(
					'size'			=> '20',
					'lineheight'	=> '20',
					'color'			=> '#222222',
					'family'		=> 'Abril Fatface',
					'character'		=> 'latin-ext',
					'style'			=> 'italic',
					'letterspacing' => '0',
					'align'			=> 'notdefined'
				)
	);
	$demo_options['repeater-demo'] = array(
				'type'			=> 'repeater',
				'title'			=> __('Links repeater', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('This option allows you to create a custom links list. For each link you can define URL, class and label.', 'cherry'),
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
				'title'			=> __('Text input', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Regular single line text input field.', 'cherry'),
				),
				'value'			=> 'value',
				'default_value'	=> 'default_value'
	);
	$demo_options['textarea-demo'] = array(
				'type'			=> 'textarea',
				'title'			=> __('Textarea input', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Multiline text input field ( 16 rows x 20 cols ).', 'cherry'),
				),
				'value'			=> 'value',
				'default_value'	=> 'default_value'
	);
	$demo_options['select-demo'] = array(
				'type'			=> 'select',
				'title'			=> __('Select box', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					//'content'	=> 'https://www.youtube.com/watch?v=2kodXWejuy0'
					'content'	=> __('Select box with single option.', 'cherry'),
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
				'title'			=> __('Filtered select', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Select box with filter option.', 'cherry'),
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
				'title'			=> __('Mulli-select box', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Select box with multiple select capability.', 'cherry'),
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
				'title'			=> __('Checkbox', 'cherry'),
				'label'			=> __('Checkbox label', 'cherry'),
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Regular HTML checkbox.', 'cherry'),
				),
				'value'			=> 'true',
	);
	$demo_options['switcher-demo'] = array(
				'type'			=> 'switcher',
				'title'			=> __('Switcher', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Analogue of the regular HTML radio buttons. ', 'cherry'),
				),
				'value'			=> 'true',
				'default_value'	=> 'true'
	);
	$demo_options['switcher-custom-toogle-demo'] = array(
				'type'			=> 'switcher',
				'title'			=> __('Switcher (alternative)', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Alternative switcher with custom labels.', 'cherry'),
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
				'title'			=> __('Slider', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Draggable slider with stepper. Used to define some numeric value.', 'cherry'),
				),
				'max_value'		=> 1920,
				'min_value'		=> 980,
				'value'			=> 1000
	);
	$demo_options['rangeslider-demo'] = array(
				'type'			=> 'rangeslider',
				'title'			=> __('Slider (ranged)', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'			=>  array(
					'type'		=> 'text',
					'content'	=> __('Draggable slider with range capability. Used to define numeric range.', 'cherry'),
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
				'title'			=> __('Multiple checkboxes', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Adds checkboxes group. Lets user to select several options from the list.', 'cherry'),
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
				'title'			=> __('Radio buttons', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Adds radio buttons group. Lets user to select one option from the list.', 'cherry'),
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
				'title'			=> __('Radio buttons (image)', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry'),
				),
				'value'			=> 'radio-1',
				'class'			=> '',
				'display_input'	=> false,
				'options'		=> array(
					'radio-1' => array(
						'label' => 'radio image 1',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio-2' => array(
						'label' => 'radio image 2',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
					'radio-3' => array(
						'label' => 'radio image 3',
						'img_src' => PARENT_URI.'/screenshot.png'
					),
				)
	);
	$demo_options['image-demo'] = array(
				'type'				=> 'media',
				'title'			=> __('Media library element', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Lets user to add content from Wordpress media library. ', 'cherry'),
				),
				'value'				=> '',
				'multi-upload'		=> true,
				'library_type'		=> 'image'
	);
	$demo_options['background-demo'] = array(
				'type'				=> 'background',
				'title'			=> __('Background image', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Lets user to add background image from the media library and define it\'s background settings like background repeat, position, attachment, origin.', 'cherry'),
				),
				'multi-upload'		=> true,
				'library_type'		=> 'image',
				'value'				=> array(
					'image'			=> '',
					'color'			=> '#ff0000',
					'repeat'		=> 'repeat',
					'position'		=> 'left',
					'attachment'	=> 'fixed',
					'origin'		=> 'padding-box'
				)
	);
	$demo_options['colorpicker-demo'] = array(
				'type'			=> 'colorpicker',
				'title'			=> __('Colorpicker', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Adds a color picker.', 'cherry'),
				),
				'value'			=> '#ff0000',
				'default_value'	=> '#ff0000'
	);
	$demo_options['stepper-demo'] = array(
				'type'			=> 'stepper',
				'title'			=> __('Stepper', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Adds a number input used to define numeric values.', 'cherry'),
				),
				'value'			=> '0',
				'default_value'	=> '0',
				'value-step'	=> '1',
				'max-value'		=> '50',
				'min-value'		=> '-50'
	);
	$demo_options['editordemo'] = array(
				'type'			=> 'editor',
				'title'			=> __('WYSIWYG editor', 'cherry'),
				'label'			=> '',
				'decsription'	=> '',
				'hint'      	=>  array(
					'type'		=> 'text',
					'content'	=> __('Adds an input section with WYSIWYG editor. Behaves as Wordpress post or page editing area.', 'cherry'),
				),
				'value'			=> 'Lorem ipsum',
				'default_value'	=> 'editor'
	);

	$demo_options['info-demo'] = array(
				'type'			=> 'info',
				'title'			=> __('Info panel', 'cherry'),
				'decsription'	=> '',
				'value'			=> '',
	);
	$demo_options['submit-demo'] = array(
				'type'			=> 'submit',
				'value'			=> 'get value'
	);


//////////////////////////////////////////////////////////////////////
// SECTIONS
//////////////////////////////////////////////////////////////////////

	$sections_array = array();

	$sections_array['general-section'] = array(
		'name'         => __( 'General', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-generic',
		'priority'     => 10,
		'options-list' => apply_filters( 'cherry_general_options_list', $general_options ),
	);

	$sections_array['grid-section'] = array(
		'name'         => __( 'Grid', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 20,
		'options-list' => apply_filters( 'cherry_grid_options_list', $grid_options ),
	);
	$sections_array['page-layout-subsection'] = array(
		'name'         => __( 'Page layouts', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'grid-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_page_layout_options_list', $page_layout_options ),
	);

	$sections_array['blog-section'] = array(
		'name'         => __( 'Blog', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-post',
		'priority'     => 25,
		'options-list' => apply_filters( 'cherry_blog_options_list', $blog_options ),
	);
	$sections_array['post-single-subsection'] = array(
		'name'         => __( 'Post', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'blog-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_post_single_options_list', $post_single_options ),
	);
	$sections_array['post-meta-subsection'] = array(
		'name'         => __( 'Meta', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'blog-section',
		'priority'     => 2,
		'options-list' => apply_filters( 'cherry_post_meta_options_list', $post_meta_options ),
	);

	$sections_array['styling-section'] = array(
		'name'         => __( 'Styling', 'cherry' ),
		'icon'         => 'dashicons dashicons-art',
		'priority'     => 30,
		'options-list' => apply_filters( 'cherry_styling_options_list', $styling_options ),
	);
	$sections_array['color-subsection'] = array(
		'name'         => __( 'Color scheme', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'styling-section',
		'priority'     => 31,
		'options-list' => apply_filters( 'cherry_color_options_list', $color_options ),
	);

	$sections_array['navigation-section'] = array(
		'name'         => __( 'Navigation', 'cherry' ),
		'icon'         => 'dashicons dashicons-menu',
		'priority'     => 40,
		'options-list' => apply_filters( 'cherry_navigation_options_list', $navigation_options ),
	);
	$sections_array['breadcrumbs-subsection'] = array(
		'name'         => __( 'Breadcrumbs', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'navigation-section',
		'priority'     => 41,
		'options-list' => apply_filters( 'cherry_breadcrumbs_options_list', $breadcrumbs_options ),
	);
	$sections_array['pagination-section'] = array(
		'name'         => __( 'Pagination', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'navigation-section',
		'priority'     => 42,
		'options-list' => apply_filters( 'cherry_pagination_options_list', $pagination_option ),
	);

	$sections_array['header-section'] = array(
		'name'         => __( 'Header', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 50,
		'options-list' => apply_filters( 'cherry_header_options_list', $header_options ),
	);
	$sections_array['logo-subsection'] = array(
		'name'         => __( 'Logo', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'header-section',
		'priority'     => 51,
		'options-list' => apply_filters( 'cherry_logo_options_list', $logo_options ),
	);

	$sections_array['footer-section'] = array(
		'name'         => __( 'Footer', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 60,
		'options-list' => apply_filters( 'cherry_footer_options_list', $footer_options ),
	);

	$sections_array['typography-section'] = array(
		'name'         => __( 'Typography', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-generic',
		'priority'     => 70,
		'options-list' => apply_filters( 'cherry_typography_options_list', $typography_options ),
	);
	$sections_array['lists-subsection'] = array(
		'name'         => __( 'Lists', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'typography-section',
		'priority'     => 71,
		'options-list' => apply_filters( 'cherry_lists_options_list', $lists_options ),
	);

	$sections_array['optimization-section'] = array(
		'name'         => __( 'Optimization', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-tools',
		'priority'     => 90,
		'options-list' => apply_filters( 'cherry_optimization_options_list', $optimization_options ),
	);

	$sections_array['demo-section'] = array(
		'name'         => __( 'Interface elements (for UI developers)', 'cherry' ),
		'icon'         => 'dashicons dashicons-editor-help',
		'priority'     => 100,
		'options-list' => apply_filters( 'cherry_demo_options_list', $demo_options ),
	);

	return apply_filters( 'cherry_defaults_settings', $sections_array );
}