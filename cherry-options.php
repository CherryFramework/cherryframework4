<?php

function cherry_defaults_settings() {
	global $cherry_registered_statics;

	$all_pages     = array();
	$all_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$all_pages[''] = __( 'Select a page:', 'cherry' );

	foreach ( $all_pages_obj as $page ) {
		$all_pages[$page->ID] = $page->post_title;
	}

	$maintenance_preview = esc_url(
		add_query_arg(
			array(
				'maintenance-preview' => true,
				'nonce'               => wp_create_nonce( 'cherry-maintenance-preview' )
			),
			home_url( '/' )
		)
	);

	$sticky_selectors = apply_filters( 'cherry_sticky_selectors', array(
		'.site-header'            => __( 'Header', 'cherry' ),
		'#menu-primary'           => __( 'Main menu', 'cherry' ),
		'#static-area-header-top' => __( 'Header top static area', 'cherry' ),
	) );

	$default_selector = array_keys($sticky_selectors);
	$default_selector = $default_selector[0];

	//////////////////////////////////////////////////////////////////////
	// General
	//////////////////////////////////////////////////////////////////////
	$general_options = array();
	$general_options['general-favicon'] = array(
		'type'  => 'media',
		'title' => __( 'Favicon image', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Icon image that is displayed in the browser address bar and browser tab heading. Max icon size: 32x32 px <br>You can also upload favicon for retina displays. Max retina icon size: 152x152 px', 'cherry' ),
		),
		'value'            => '',
		'display_image'    => true,
		'multi_upload'     => true,
		'return_data_type' => 'url',
		'library_type'     => 'image',
	);
	$general_options['general-page-comments-status'] = array(
		'type'  => 'switcher',
		'title' => __( 'Page comments', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( "Enable/disable comments by default for pages. For pages that have already been published you need to enable comments individually in page settings.", 'cherry' ),
		),
		'value' => 'false',
	);
	$general_options['general-page-featured-images'] = array(
		'type'  => 'switcher',
		'title' => __( 'Featured Images', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Enable/disable featured images for pages.', 'cherry' ),
		),
		'value' => 'false',
	);
	$general_options['general-maintenance-mode'] = array(
		'type'  => 'switcher',
		'title' => sprintf(
			__( 'Maintenance mode. <a href="%s" target="_blank">Preview</a>', 'cherry' ),
			$maintenance_preview
		),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( "Enable/disable maintenance mode. Logged in administrator gets full access to the site, while regular visitors will\won't be redirected to the page chosen below.", 'cherry' )
		),
		'value' => 'false',
	);
	$general_options['general-maintenance-page'] = array(
		'type'    => 'select',
		'title'   => __( 'Maintenance page', 'cherry' ),
		'value'   => '',
		'class'   => 'width-full',
		'options' => $all_pages,
		'hint'    => array(
			'type'    => 'text',
			'content' => __( 'Select page that regular visitors will see if maintenance mode is enabled.', 'cherry' ),
		),
	);
	$general_options['general-smoothscroll'] = array(
		'type'  => 'switcher',
		'title' => __( 'Document smooth scroll', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Enable/disable smooth vertical mousewheel scrolling (Chrome browser only).', 'cherry' ),
		),
		'value' => 'false',
	);
	$general_options['general-user-css'] = array(
		'type'  => 'ace-editor',
		'title' => __( 'User CSS', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Define custom CSS styling.', 'cherry' ),
		),
		'editor_mode'  => 'css',
		'editor_theme' => 'monokai',
		'value'        => ''
	);
	///////////////////////////////////////////////////////////////////
	// Static Area Editor
	///////////////////////////////////////////////////////////////////
	$static_area_editor_options = array();
	$static_area_editor_options['static-area-editor'] = array(
		'type'  => 'static_area_editor',
		'title' => __( 'Static areas', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( "Use static area editor to arrange static blocks. You can drag-n-drop static blocks, remove them or add new ones using 'Create new static' field below.", 'cherry' ),
		),
		'value'   => $cherry_registered_statics,
		'options' => $cherry_registered_statics,
	);

	//////////////////////////////////////////////////////////////////////
	// Grid options
	//////////////////////////////////////////////////////////////////////
	$grid_options = array();
	$grid_options['grid-responsive'] = array(
		'type'  => 'switcher',
		'title' => __( 'Responsive grid', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __('Enable/disable responsive grid. If for any reason you want to disable responsive layout for your site, you are able to turn it off here.', 'cherry' ),
		),
		'value' => 'true',
	);
	$grid_options['page-layout'] = array(
		'type'  => 'radio',
		'title' => __( 'Layout', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Select blog page layout. You can choose if you want to display sidebars and how you want to display them.', 'cherry' ),
		),
		'value'         => '1-right',
		'display_input' => false,
		'options'       => array(
			'1-left' => array(
				'label'   => __( 'Left sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-left-sidebar.svg',
			),
			'1-right' => array(
				'label'   => __( 'Right sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-right-sidebar.svg',
			),
			'1-left-2-right' => array(
				'label'   => __( 'Left and right sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-both-sidebar.svg',
			),
			'1-left-2-left' => array(
				'label'   => __( 'Two sidebars on the left', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-sameside-left-sidebar.svg',
			),
			'1-right-2-right' => array(
				'label'   => __( 'Two sidebars on the right', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-sameside-right-sidebar.svg',
			),
			'no-sidebar' => array(
				'label'   => __( 'No sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-fullwidth.svg',
			),
		)
	);
	$grid_options['grid-container-width'] = array(
		'type'  => 'slider',
		'title' => __( 'Container width', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Width of main website container in pixels.', 'cherry' ),
		),
		'max_value' => 1920, // Full HD
		'min_value' => 970,
		'value'     => 1170,
	);
	$grid_options['header-grid-type'] = array(
		'type'  => 'radio',
		'title' => __( 'Header grid type', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Select layout pattern for header website. Wide layout will fit window width. Boxed layout will have fixed width.', 'cherry' ),
		),
		'value'         => 'wide',
		'display_input' => false,
		'options'       => array(
			'wide' => array(
				'label'   => __( 'Wide', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/grid-type-fullwidth.svg',
			),
			'boxed' => array(
				'label'   => __( 'Boxed', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/grid-type-container.svg',
			),
		),
	);
	$grid_options['content-grid-type'] = array(
		'type'  => 'radio',
		'title' => __( 'Content grid type', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Select layout pattern for main website container. Wide layout will fit window width. Boxed layout will have fixed width and left/right indents. ', 'cherry' ),
		),
		'value'         => 'boxed',
		'display_input' => false,
		'options'       => array(
			'wide' => array(
				'label'   => __( 'Wide', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/grid-type-fullwidth.svg',
			),
			'boxed' => array(
				'label'   => __( 'Boxed', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/grid-type-container.svg',
			),
		),
	);
	$grid_options['footer-grid-type'] = array(
		'type'  => 'radio',
		'title' => __( 'Footer grid type', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Select layout pattern for footer website. Wide layout will fit window width. Boxed layout will have fixed width.', 'cherry' ),
		),
		'value'         => 'wide',
		'display_input' => false,
		'options'       => array(
			'wide' => array(
				'label'   => __( 'Wide', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/grid-type-fullwidth.svg',
			),
			'boxed' => array(
				'label'   => __( 'Boxed', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/grid-type-container.svg',
			),
		),
	);

//////////////////////////////////////////////////////////////////////
// Blog layout options
//////////////////////////////////////////////////////////////////////

	$blog_options = array();
	$blog_options['blog-featured-images'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Featured Media', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Displays Featured Image, Gallery, Audio, Video in blog posts listing depending on post type.', 'cherry' ),
		),
		'value'       => 'true',
	);
	$blog_options['blog-featured-images-size'] = array(
		'type'        => 'select',
		'title'       => __( 'Featured Image Size', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Set dimensions for post featured images in pixels.', 'cherry' ),
		),
		'value'       => 'thumb-l',
		'options'     => array(
			'thumb-s' => __( 'Small', 'cherry' ),
			'thumb-l' => __( 'Large', 'cherry' ),
		)
	);
	$blog_options['blog-featured-images-align'] = array(
		'type'        => 'select',
		'title'       => __( 'Featured Image Alignment', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Set alignment for post featured images.', 'cherry' ),
		),
		'value'       => 'aligncenter',
		'options'     => array(
			'alignnone'   => __( 'None', 'cherry' ),
			'alignleft'   => __( 'Left', 'cherry' ),
			'alignright'  => __( 'Right', 'cherry' ),
			'aligncenter' => __( 'Center', 'cherry' ),
		)
	);
	$blog_options['blog-content-type'] = array(
		'type'        => 'select',
		'title'       => __( 'Post content', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Select how you want to display post content in blog listing: full - display full post content, excerpt - display part of the post (you can specify excerpt length below), none - hide post content.', 'cherry' ),
		),
		'value'       => 'part',
		'options'     => array(
			'none' => __( 'None', 'cherry' ),
			'part' => __( 'Part', 'cherry' ),
			'full' => __( 'Full', 'cherry' ),
		)
	);
	$blog_options['blog-excerpt-length'] = array(
		'type'        => 'slider',
		'title'       => __( 'Excerpt length', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Specify number of words displayed in excerpt in blog listing.', 'cherry' ),
		),
		'max_value'   => 500,
		'min_value'   => 1,
		'value'       => 55,
	);
	$blog_options['blog-button'] = array(
		'type'        => 'switcher',
		'title'       => __( 'More button', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Enable/Disable read more button in blog listing.', 'cherry' ),
		),
		'value'       => 'true',
	);
	$blog_options['blog-button-text'] = array(
		'type'  => 'text',
		'title' => __( 'More button label', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Specify read more button label text. ', 'cherry' ),
		),
		'value' => __( 'read more', 'cherry' ),
	);

	// Post
	////////////////////////////////////////////////////////////////////////
	$post_single_options['blog-post-featured-image'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Featured Image', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Display featured image on the single post page.', 'cherry' ),
		),
		'value'       => 'true',
	);
	$post_single_options['blog-post-featured-image-size'] = array(
		'type'        => 'select',
		'title'       => __( 'Size of Featured Image', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Set dimensions for single post featured images.', 'cherry' ),
		),
		'value'       => 'thumb-l',
		'options'     => array(
			'thumb-s' => __( 'Small', 'cherry' ),
			'thumb-l' => __( 'Large', 'cherry' ),
		)
	);
	$post_single_options['blog-post-featured-image-align'] = array(
		'type'        => 'select',
		'title'       => __( 'Alignment of Featured Image', 'cherry' ),
		'hint' => array(
			'type' => 'text',
			'content' => __( 'Set alignment for single post featured images.', 'cherry' ),
		),
		'value'       => 'aligncenter',
		'options'     => array(
			'alignnone'   => __( 'None', 'cherry' ),
			'alignleft'   => __( 'Left', 'cherry' ),
			'alignright'  => __( 'Right', 'cherry' ),
			'aligncenter' => __( 'Center', 'cherry' ),
		)
	);
	$post_single_options['blog-post-author-bio'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Author bio', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Enable/disable author bio block. Author bio block is displayed on the post page.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_single_options['blog-related-posts'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Related posts', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Enable/disable related posts block. Related posts block is displayed on the post page.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_single_options['blog-comment-status'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Allow comments', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Enable/disable comments for blog posts. Make sure comments are enabled in Wordpress \'settings->discussion\'. For posts that have already been published you need to enable comments individually in post settings.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_single_options['blog-gallery-shortcode'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Gallery slider', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Replace default Wordpress gallery shortcode with enhanced jQuery carousel.', 'cherry' ),
		),
		'value' => 'true',
	);

	// Meta
	////////////////////////////////////////////////////////////////////////
	$post_meta_options['blog-post-date'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Date', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Show/Hide post publication date.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_meta_options['blog-post-author'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Author', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Show/Hide post author.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_meta_options['blog-post-comments'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Comments', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Show/Hide number of comments.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_meta_options['blog-categories'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Categories', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Show/Hide post categories.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_meta_options['blog-tags'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Tags', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Show/Hide post tags.', 'cherry' ),
		),
		'value' => 'true',
	);

//////////////////////////////////////////////////////////////////////
// Styling options
//////////////////////////////////////////////////////////////////////

	$styling_options = array();
	//background image
	$styling_options['body-background'] = array(
		'type'			=> 'background',
		'title'			=> __('Body background', 'cherry' ),
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Set background for body container. You can specify background image or color, set background repeat, position and attachment. ', 'cherry' ),
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
	// Color scheme options
	//////////////////////////////////////////////////////////////////////

	$color_options = array();
	$color_options['color-primary'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Primary color', 'cherry' ),
		'value' => '#f62e46',
	);
	$color_options['color-secondary'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Secondary color', 'cherry' ),
		'value' => '#333333',
	);
	$color_options['color-success'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Success color', 'cherry' ),
		'value' => '#dff0d8',
	);
	$color_options['color-info'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Info color', 'cherry' ),
		'value' => '#d9edf7',
	);
	$color_options['color-warning'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Warning color', 'cherry' ),
		'value' => '#fcf8e3',
	);
	$color_options['color-danger'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Danger color', 'cherry' ),
		'value' => '#f2dede',
	);
	$color_options['color-gray-variations'] = array(
		'type'  => 'colorpicker',
		'title' => __( 'Primary gray color', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => 'Gray color hues</br>
							<hr>
							gray-darker:           darken(20%)</br>
							gray-dark:             darken(15%)</br>
							gray-light:            lighten(15%)</br>
							gray-lighter:          lighten(20%)</br>'
						),
		'value' => '#555555',
	);



//////////////////////////////////////////////////////////////////////
// Navigation options
//////////////////////////////////////////////////////////////////////

	$navigation_options = array();
	$navigation_options['typography-header-menu'] = array(
		'type'  => 'typography',
		'title' => __('Header Menu Typography', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __('Main header navigation typography settings.', 'cherry' ),
		),
		'value' => array(
			'fonttype'      => 'web',
			'size'          => '14',
			'lineheight'    => '14',
			'color'         => '#474747',
			'family'        => 'Abril Fatface',
			'character'     => 'latin-ext',
			'style'         => '',
			'letterspacing' => '',
			'align'         => 'notdefined',
		)
	);
	$navigation_options['typography-footer-menu'] = array(
		'type'  => 'typography',
		'title' => __('Footer Menu Typography', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __('Main footer navigation typography settings.', 'cherry' ),
		),
		'value' => array(
			'fonttype'      => 'web',
			'size'          => '14',
			'lineheight'    => '14',
			'color'         => '#474747',
			'family'        => 'Abril Fatface',
			'character'     => 'latin-ext',
			'style'         => '',
			'letterspacing' => '',
			'align'         => 'notdefined',
		)
	);


	// Breadcrumbs options
	//////////////////////////////////////////////////////////////////////
	$breadcrumbs_options = array();

	$breadcrumbs_options['breadcrumbs'] = array(
			'type'			=> 'switcher',
			'title'			=> __( 'Breadcrumbs', 'cherry' ),
			'hint'  => array(
				'type'    => 'text',
				'content' => __('Enable/disable breadcrumbs navigation.', 'cherry' ),
			),
			'value'			=> 'true',
			'default_value'	=> 'true'
	);
	$breadcrumbs_options['breadcrumbs-display'] = array(
		'type'			=> 'multicheckbox',
		'title'			=> __( 'Breadcrumbs mobile', 'cherry' ),
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __( 'Enable/disable breadcrumbs on mobile devices.', 'cherry' )
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
		'title' 		=> __( 'Home page breadcrumbs', 'cherry' ),
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __( 'Enable/disable breadcrumbs on home page.', 'cherry' )
		),
		'value'			=> 'false'
	);
	$breadcrumbs_options['breadcrumbs-show-title'] = array(
		'type'			=> 'switcher',
		'title' 		=> __( 'Page title', 'cherry' ),
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __( 'Enable/disable page title in breadcrumbs.', 'cherry' )
		),
		'value'			=> 'true'
	);

	$breadcrumbs_options['breadcrumbs-separator'] = array(
		'type'			=> 'text',
		'title'			=> __( 'Item separator', 'cherry' ),
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __( 'Breadcrumbs separator symbol.', 'cherry' )
		),

		'value'			=> '&#47;',
		'default_value'	=> '&#47;',
		'class'			=> 'width-full'
	);
	$breadcrumbs_options['breadcrumbs-prefix-path'] = array(
		'type'			=> 'text',
		'title'			=> __( 'Breadcrumbs prefix', 'cherry' ),
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __( 'Text displayed before breadcrumbs navigation.', 'cherry' )
		),
		'value'			=> __( 'You are here:', 'cherry' ),
	);

	// Page navigation options
	//////////////////////////////////////////////////////////////////////

	$pagination_option = array();

	$pagination_option['pagination-position'] = array(
		'type'			=> 'select',
		'title' 		=> __( 'Pagination position', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Select where you want to display pagination.', 'cherry' )
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
		'title' 		=> __( 'Prev/next buttons', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Show/hide previous and next buttons in pagination.', 'cherry' )
		),
		'value'			=> 'true'
	);
	$pagination_option['pagination-label'] = array(
		'type'			=> 'text',
		'title'			=> __( 'Pagination label', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Pagination label. Displayed before pagination buttons. Text or HTML can be used.', 'cherry' )
		),
		'value'			=> __( 'Pages:', 'cherry' ),
	);
	$pagination_option['pagination-previous-page'] = array(
		'type'			=> 'text',
		'title'			=> __( 'Prev button label', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Previous button label text. Text or HTML can be used.', 'cherry' )
		),
		'value'			=> '&laquo;',
	);
	$pagination_option['pagination-next-page'] = array(
		'type'			=> 'text',
		'title'			=> __( 'Next button label', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Next button label text. Text or HTML can be used.', 'cherry' )
		),
		'value'			=> '&raquo;',
	);
	$pagination_option['pagination-show-all'] = array(
		'type'			=> 'switcher',
		'title' 		=> __( 'Show all the pages', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'If set to On, then it will show all of the pages instead of a short list of the pages near the current page.', 'cherry' )
		),
		'value'			=> 'false'
	);
	$pagination_option['pagination-end-size'] = array(
		'type'			=> 'stepper',
		'title'			=> __( 'End size', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'How many pages to display either at the top or at the end of the list.', 'cherry' )
		),
		'value'			=> '1',
		'value-step'	=> '1',
		'max-value'		=> '99',
		'min-value'		=> '1'
	);
	$pagination_option['pagination-mid-size'] = array(
		'type'			=> 'stepper',
		'title'			=> __( 'Mid size', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'How many numbers to display to either side of current page, but not including current page.', 'cherry' )
		),
		'value'			=> '2',
		'value-step'	=> '1',
		'max-value'		=> '9999',
		'min-value'		=> '1'
	);
//////////////////////////////////////////////////////////////////////
// Header options
//////////////////////////////////////////////////////////////////////
	$header_options = array();

	$header_options['header-background'] = array(
		'type'			=> 'background',
		'title'			=> __('Header background', 'cherry' ),
		'hint'			=>  array(
				'type'		=> 'text',
				'content'	=>  __( 'Header background settings. You can select background color, upload header background image, set its background position, attachment and repeat.', 'cherry' )
			),
		'return_data_type'	=> 'id',
		'library_type'		=> 'image',
		'value'			=> array(
				'image'	=> '',
				'color'	=> '#ddd',
				'repeat'	=> 'repeat',
				'position'	=> 'left',
				'attachment'=> 'fixed'
			)
	);
	$header_options['header-sticky'] = array(
		'type'			=> 'switcher',
		'title'			=> __( 'Sticky header', 'cherry' ),
		'hint'			=> array(
			'type'		=> 'text',
			'content'	=> __( 'Enable\disable fixed header that sticks to the top.', 'cherry' )
		),
		'value'			=> 'false'
	);
	$header_options['header-sticky-selector'] = array(
		'type'			=> 'select',
		'title'			=> __( 'Sticky selector', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Select the block selector that will be used to build sticky panel. You can use tag name, class name, or id.', 'cherry' )
		),
		'value'			=> $default_selector,
		'options'		=> $sticky_selectors
	);
	// Logo options
	//////////////////////////////////////////////////////////////////////
	$logo_options = array();
	$logo_options['logo-type'] = array(
		'type'			=> 'radio',
		'title'			=> __( 'Logo type', 'cherry' ),
		'hint'			=> array(
			'type'		=> 'text',
			'content'	=> __( 'Select whether you want your main logo to be an image or text. If you select "image", you can choose logo image from the media library in the next option, and if you select "text", your WordPress Site Title will be shown instead.', 'cherry' )
		),
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
		'title'				=> __( 'Logo image', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Click Choose Media button to select logo image from the media library or upload your image.', 'cherry' )
		),
		'value'				=> '',
		'multi-upload'		=> true,
	);
	$logo_options['typography-logo'] = array(
		'type'			=> 'typography',
		'title'				=> __( 'Logo typography', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Configuration settings for text logo. Here you can select logo font family, size, color, etc.', 'cherry' )
		),
		'value'			=> array(
			'fonttype'		=> 'web',
			'size'			=> '60',
			'lineheight'	=> '80',
			'color'			=> '#777777',
			'family'		=> 'Lobster',
			'character'		=> 'latin-ext',
			'style'			=> '',
			'letterspacing' => '',
			'align'			=> 'notdefined'
		)
	);

//////////////////////////////////////////////////////////////////////
// Footer options
//////////////////////////////////////////////////////////////////////

	$footer_options = array();
	$footer_options['footer-background'] = array(
		'type'			=> 'background',
		'title'				=> __( 'Footer background', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Footer background settings. You can select background color, upload footer background image, set its background position, attachment and repeat.', 'cherry' )
		),
		'return_data_type'	=> 'id',
		'library_type'		=> 'image',
		'value'			=> array(
			'image'	=> '',
			'color'	=> '#ddd',
			'repeat'	=> 'repeat',
			'position'	=> 'left',
			'attachment'=> 'fixed'
		)
	);
	$footer_options['typography-footer'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Footer typography', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Typography settings for footer texts.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '14',
			'lineheight'	=> '30',
			'color'			=> '#333333',
			'family'		=> 'Roboto',
			'character'		=> 'latin-ext',
			'style'			=> '',
			'letterspacing' => '',
			'align'			=> 'notdefined'
		)
	);
	$footer_options['logo-footer'] = array(
		'type'				=> 'media',
		'title'				=> __( 'Footer Logo image', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Click Choose Media button to select footer logo image from the media library or upload your image.', 'cherry' )
		),
		'value'				=> '',
		'multi-upload'		=> true,
	);
//////////////////////////////////////////////////////////////////////
// Typography options
//////////////////////////////////////////////////////////////////////

	$typography_options = array();

	$typography_options['typography-body'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Body text', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Main website text typography options.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '14',
			'lineheight'	=> '20',
			'color'			=> '#777777',
			'family'		=> 'Raleway',
			'character'		=> 'latin-ext',
			'style'			=> 'italic',
			'letterspacing' => '',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['color-link'] = array(
		'type'			=> 'colorpicker',
			'title'			=> __( 'Link color', 'cherry' ),
			'hint'      	=> array(
				'type'		=> 'text',
				'content'	=> __( 'Color of links.', 'cherry' )
			),
			'value'			=> '#f62e46'
	);
	$typography_options['color-link-hover'] = array(
		'type'			=> 'colorpicker',
		'title'			=> __( 'Link hover color', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Color of links on hover.', 'cherry' )
		),
		'value'			=> '#333333'
	);
	$typography_options['typography-input-text'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Input text', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Styling text in forms.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'standart',
			'size'			=> '14',
			'lineheight'	=> '20',
			'color'			=> '#333333',
			'family'		=> 'Arial',
			'character'		=> 'latin-ext',
			'style'			=> 'italic',
			'letterspacing' => '',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-breadcrumbs'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Breadcrumbs typography', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Styling text in breadcrumbs.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'standart',
			'size'			=> '14',
			'lineheight'	=> '20',
			'color'			=> '#777777',
			'family'		=> 'Arial',
			'character'		=> 'latin-ext',
			'style'			=> 'italic',
			'letterspacing' => '',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-h1'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Heading 1', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'H1 heading font settings.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '36',
			'lineheight'	=> '40',
			'color'			=> '#333333',
			'family'		=> 'ABeeZee',
			'character'		=> 'latin-ext',
			'style'			=> 'normal',
			'letterspacing' => '',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-h2'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Heading 2', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'H2 heading font settings.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '30',
			'lineheight'	=> '33',
			'color'			=> '#333333',
			'family'		=> 'ABeeZee',
			'character'		=> 'latin-ext',
			'style'			=> 'normal',
			'letterspacing' => '0',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-h3'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Heading 3', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'H3 heading font settings.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '24',
			'lineheight'	=> '26',
			'color'			=> '#333333',
			'family'		=> 'ABeeZee',
			'character'		=> 'latin-ext',
			'style'			=> 'normal',
			'letterspacing' => '0',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-h4'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Heading 4', 'cherry' ),
		'hint'			=> array(
			'type'		=> 'text',
			'content'	=> __( 'H4 heading font settings.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '18',
			'lineheight'	=> '20',
			'color'			=> '#333333',
			'family'		=> 'ABeeZee',
			'character'		=> 'latin-ext',
			'style'			=> 'normal',
			'letterspacing' => '0',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-h5'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Heading 5', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'H5 heading font settings.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '14',
			'lineheight'	=> '16',
			'color'			=> '#333333',
			'family'		=> 'ABeeZee',
			'character'		=> 'latin-ext',
			'style'			=> 'normal',
			'letterspacing' => '0',
			'align'			=> 'notdefined'
		)
	);
	$typography_options['typography-h6'] = array(
		'type'			=> 'typography',
		'title'			=> __( 'Heading 6', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'H6 heading font settings.', 'cherry' )
		),
		'value' => array(
			'fonttype'		=> 'web',
			'size'			=> '12',
			'lineheight'	=> '14',
			'color'			=> '#333333',
			'family'		=> 'ABeeZee',
			'character'		=> 'latin-ext',
			'style'			=> 'normal',
			'letterspacing' => '0',
			'align'			=> 'notdefined'
		)
	);
//////////////////////////////////////////////////////////////////////
// Optimization options
//////////////////////////////////////////////////////////////////////

	$optimization_options = array();

	$optimization_options['concatenate-css'] = array(
		'type'          => 'switcher',
		'title'			=> __( 'Concatenate/minify CSS', 'cherry' ),
		'hint'      	=> array(
			'type'		=> 'text',
			'content'	=> __( 'Select if you want to merge\minify CSS files to performance optimization.', 'cherry' )
		),
		'value'         => 'false',
		'toggle'        => array(
			'true_toggle'  => __( 'Yes', 'cherry' ),
			'false_toggle' => __( 'No', 'cherry' )
		)
	);
	$optimization_options['dynamic-css'] = array(
		'type'			=> 'select',
		'title'			=> 'Dynamic CSS output',
		'hint'			=> array(
			'type'		=> 'text',
			'content'	=> __( 'Output dynamic CSS into separate file or into style tag.', 'cherry' )
		),
		'value'			=> 'tag',
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
	);
	$demo_options['select-demo'] = array(
		'type'			=> 'select',
		'title'			=> __('Select box', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with single option.', 'cherry'),
		),
		'value'			=> 'select-1',
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
	);
	$demo_options['stepper-demo'] = array(
		'type'			=> 'stepper',
		'title'			=> __('Stepper', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'			=> array(
			'type'		=> 'text',
			'content'	=> __('Adds a number input used to define numeric values.', 'cherry'),
		),
		'value'			=> '0',
		'step_value'	=> '1',
		'max-value'		=> '50',
		'min-value'		=> '-50'
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
		'value'			=> 1024
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
		'library_type'		=> ''
	);
	$demo_options['background-demo'] = array(
		'type'				=> 'background',
		'title'			=> __('Background image', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Lets user to add background image from the media library and define its background settings like background repeat, position, attachment, origin.', 'cherry'),
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
	);
	$demo_options['ace-editor-demo'] = array(
		'type'			=> 'ace-editor',
		'title'			=> __('CSS Editor', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Embedded CSS editor with syntax highlighting.', 'cherry'),
		),
		'value'			=> "#header{\n\tmargin: 0 auto;\n}\n#content{\n\tpadding: 0;\n}\n#footer{\n\tbackground-color: #fff;\n}\n.custom-class{\n\tcolor: #0f0f0f;\n}",
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
			'fonttype'		=> 'web',
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
	$demo_options['layout-editor-demo'] = array(
		'type'			=> 'layouteditor',
		'title'			=> __( 'title layout editor', 'cherry' ),
		'label'			=> 'label layout editor',
		'decsription'	=> 'decsription layout editor',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> 'Visual editor based on HTML box model. You can define element margin, padding, size, border. '
		),
		'value'			=> array(
			'position'	=> array(
				'top'		=> '10em',
				'right'		=> '',
				'bottom'	=> '',
				'left'		=> '10%',
			),
			'margin'	=> array(
				'top'		=> '0px',
				'right'		=> '0px',
				'bottom'	=> '0em',
				'left'		=> '0px',
			),
			'border'	=> array(
				'top'		=> '0px',
				'right'		=> '0px',
				'bottom'	=> '0px',
				'left'		=> '0px',
				'style'		=> 'solid',
				'radius'	=> '10px',
				'color'		=> '#ff0000'
			),
			'padding'	=> array(
				'top'		=> '0em',
				'right'		=> '0em',
				'bottom'	=> '0em',
				'left'		=> '0em',
			),
			'container'	=> array(
				'width'		=> '0px',
				'height'	=> '0px',
			),
		),
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
	$demo_options['info-demo'] = array(
		'type'			=> 'info',
		'title'			=> __('Info panel', 'cherry'),
		'decsription'	=> '',
		'value'			=> 'Demo',
	);
	$demo_options['submit-demo'] = array(
		'type'			=> 'submit',
		'value'			=> 'get value'
	);

//////////////////////////////////////////////////////////////////////
// Sections
//////////////////////////////////////////////////////////////////////

	$sections_array = array();

	$sections_array['general-section'] = array(
		'name'         => __( 'General', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-generic',
		'priority'     => 10,
		'options-list' => apply_filters( 'cherry_general_options_list', $general_options ),
	);
	$sections_array['static-area-editor-section'] = array(
		'name'         => __( 'Static areas', 'cherry' ),
		'icon'         => 'dashicons dashicons-menu',
		'priority'     => 20,
		'options-list' => apply_filters( 'cherry_static_area_editor_list', $static_area_editor_options ),
	);
	$sections_array['grid-section'] = array(
		'name'         => __( 'Grid', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 30,
		'options-list' => apply_filters( 'cherry_grid_options_list', $grid_options ),
	);
	$sections_array['blog-section'] = array(
		'name'         => __( 'Blog', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-post',
		'priority'     => 40,
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
		'priority'     => 50,
		'options-list' => apply_filters( 'cherry_styling_options_list', $styling_options ),
	);
	$sections_array['color-subsection'] = array(
		'name'         => __( 'Color scheme', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'styling-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_color_options_list', $color_options ),
	);
	$sections_array['navigation-section'] = array(
		'name'         => __( 'Navigation', 'cherry' ),
		'icon'         => 'dashicons dashicons-menu',
		'priority'     => 60,
		'options-list' => apply_filters( 'cherry_navigation_options_list', $navigation_options ),
	);
	$sections_array['breadcrumbs-subsection'] = array(
		'name'         => __( 'Breadcrumbs', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'navigation-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_breadcrumbs_options_list', $breadcrumbs_options ),
	);
	$sections_array['pagination-section'] = array(
		'name'         => __( 'Pagination', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'navigation-section',
		'priority'     => 2,
		'options-list' => apply_filters( 'cherry_pagination_options_list', $pagination_option ),
	);
	$sections_array['header-section'] = array(
		'name'         => __( 'Header', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 70,
		'options-list' => apply_filters( 'cherry_header_options_list', $header_options ),
	);
	$sections_array['logo-subsection'] = array(
		'name'         => __( 'Logo', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'header-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_logo_options_list', $logo_options ),
	);
	$sections_array['footer-section'] = array(
		'name'         => __( 'Footer', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 80,
		'options-list' => apply_filters( 'cherry_footer_options_list', $footer_options ),
	);
	$sections_array['typography-section'] = array(
		'name'         => __( 'Typography', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-generic',
		'priority'     => 90,
		'options-list' => apply_filters( 'cherry_typography_options_list', $typography_options ),
	);
	$sections_array['optimization-section'] = array(
		'name'         => __( 'Optimization', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-tools',
		'priority'     => 100,
		'options-list' => apply_filters( 'cherry_optimization_options_list', $optimization_options ),
	);
	$sections_array['demo-section'] = array(
		'name'         => __( 'Interface elements (for UI developers)', 'cherry' ),
		'icon'         => 'dashicons dashicons-editor-help',
		'priority'     => 110,
		'options-list' => apply_filters( 'cherry_demo_options_list', $demo_options ),
	);

	return apply_filters( 'cherry_defaults_settings', $sections_array );
}