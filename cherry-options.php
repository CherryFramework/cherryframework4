<?php

function cherry_defaults_settings() {
	$all_pages     = array();
	$all_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$all_pages[''] = __( 'Select a page:', 'cherry' );

	foreach ( $all_pages_obj as $page ) {
		$all_pages[ $page->ID ] = $page->post_title;
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

	$default_selector = array_keys( $sticky_selectors );
	$default_selector = $default_selector[0];

	//////////////////////////////////////////////////////////////////////
	// General
	//////////////////////////////////////////////////////////////////////
	$general_options = array();
	$general_options['general-favicon'] = array(
		'type'        => 'media',
		'title'       => __( 'Favicon image', 'cherry' ),
		'description' => __( 'Icon image that is displayed in the browser address bar and browser tab heading.', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Max icon size: 32x32 px <br>You can also upload favicon for retina displays. Max retina icon size: 152x152 px', 'cherry' ),
		),
		'value'            => '',
		'display_image'    => true,
		'multi_upload'     => true,
		'return_data_type' => 'url',
		'library_type'     => 'image',
	);
	$general_options['general-maintenance-mode'] = array(
		'type'  => 'switcher',
		'title' => sprintf(
			__( 'Maintenance mode. <a href="%s" target="_blank">Preview</a>', 'cherry' ),
			$maintenance_preview
		),
		'description' => __( 'Enable/disable maintenance mode.', 'cherry' ),
		'hint' => array(
			'type'    => 'text',
			'content' => __( "Logged in administrator gets full access to the site, while regular visitors will\won't be redirected to the page chosen below.", 'cherry' )
		),
		'value' => 'false',
	);
	$general_options['general-maintenance-page'] = array(
		'type'        => 'select',
		'title'       => __( 'Maintenance page', 'cherry' ),
		'description' => __( 'Select page that regular visitors will see if maintenance mode is enabled.', 'cherry' ),
		'value'       => '',
		'class'       => 'width-full',
		'options'     => $all_pages,
	);
	$general_options['general-smoothscroll'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Document smooth scroll', 'cherry' ),
		'description' => __( 'Enable/disable smooth vertical mousewheel scrolling (Chrome browser only).', 'cherry' ),
		'value'       => 'false',
	);
	$general_options['general-user-css'] = array(
		'type'         => 'ace-editor',
		'title'        => __( 'User CSS', 'cherry' ),
		'description'  => __( 'Define custom CSS styling.', 'cherry' ),
		'editor_mode'  => 'css',
		'editor_theme' => 'monokai',
		'value'        => '',
	);

	//////////////////////////////////////////////////////////////////////
	// Grid options
	//////////////////////////////////////////////////////////////////////
	$grid_options = array();
	$grid_options['grid-responsive'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Responsive grid', 'cherry' ),
		'description' => __( 'Enable/disable responsive grid. ', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __('If for any reason you want to disable responsive layout for your site, you are able to turn it off here.', 'cherry' ),
		),
		'value' => 'true',
	);
	$grid_options['grid-container-width'] = array(
		'type'        => 'slider',
		'title'       => __( 'Container width', 'cherry' ),
		'description' => __( 'Width of header/content/footer container in pixels.', 'cherry' ),
		'max_value'   => 1920, // Full HD
		'min_value'   => 970,
		'value'       => 1170,
	);

	// Layouts
	////////////////////////////////////////////////////////////////////////
	$layouts_options['page-layout'] = array(
		'type'        => 'radio',
		'title'       => __( 'Pages', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'You can choose if you want to display sidebars and how you want to display them.', 'cherry' ),
		),
		'value'         => 'content-sidebar',
		'display_input' => false,
		'options'       => array(
			'sidebar-content' => array(
				'label'   => __( 'Left sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-left-sidebar.svg',
			),
			'content-sidebar' => array(
				'label'   => __( 'Right sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-right-sidebar.svg',
			),
			'sidebar-content-sidebar' => array(
				'label'   => __( 'Left and right sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-both-sidebar.svg',
			),
			'sidebar-sidebar-content' => array(
				'label'   => __( 'Two sidebars on the left', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-sameside-left-sidebar.svg',
			),
			'content-sidebar-sidebar' => array(
				'label'   => __( 'Two sidebars on the right', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-sameside-right-sidebar.svg',
			),
			'no-sidebar' => array(
				'label'   => __( 'No sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-fullwidth.svg',
			),
		)
	);
	$layouts_options['single-post-layout'] = array(
		'type'        => 'radio',
		'title'       => __( 'Blog posts', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'You can choose if you want to display sidebars and how you want to display them.', 'cherry' ),
		),
		'value'         => 'content-sidebar',
		'display_input' => false,
		'options'       => array(
			'sidebar-content' => array(
				'label'   => __( 'Left sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-left-sidebar.svg',
			),
			'content-sidebar' => array(
				'label'   => __( 'Right sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-right-sidebar.svg',
			),
			'sidebar-content-sidebar' => array(
				'label'   => __( 'Left and right sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-both-sidebar.svg',
			),
			'sidebar-sidebar-content' => array(
				'label'   => __( 'Two sidebars on the left', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-sameside-left-sidebar.svg',
			),
			'content-sidebar-sidebar' => array(
				'label'   => __( 'Two sidebars on the right', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-sameside-right-sidebar.svg',
			),
			'no-sidebar' => array(
				'label'   => __( 'No sidebar', 'cherry' ),
				'img_src' => PARENT_URI . '/lib/admin/assets/images/svg/page-layout-fullwidth.svg',
			),
		)
	);

//////////////////////////////////////////////////////////////////////
// Blog options
//////////////////////////////////////////////////////////////////////

	$blog_options = array();
	$blog_options['blog-featured-images'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Featured Media', 'cherry' ),
		'description' => __( 'Displays Featured Image, Gallery, Audio, Video in blog posts listing depending on post type.', 'cherry' ),
		'value'       => 'true',
	);
	$blog_options['blog-featured-images-size'] = array(
		'type'        => 'select',
		'title'       => __( 'Featured Image Size', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Set dimensions for post featured images.', 'cherry' ),
		),
		'class'       => 'width-full',
		'description' => __( 'Set dimensions for post featured images.', 'cherry' ),
		'value'       => 'cherry-thumb-l',
		'options'     => array(
			'cherry-thumb-s' => __( 'Small', 'cherry' ),
			'cherry-thumb-l' => __( 'Large', 'cherry' ),
		)
	);
	$blog_options['blog-featured-images-align'] = array(
		'type'        => 'select',
		'title'       => __( 'Featured Image Alignment', 'cherry' ),
		'description' => __( 'Set alignment for post featured images.', 'cherry' ),
		'value'       => 'aligncenter',
		'class'       => 'width-full',
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
		'description' => __( 'Select how you want to display post content in blog listing', 'cherry' ),
		'hint' => array(
			'type'    => 'text',
			'content' => __( 'The following options are available:<br>`full` - display full post content, <br>`part` - display part of the post (you can specify content part length below), <br>`none` - hide post content.', 'cherry' ),
		),
		'value'       => 'part',
		'class'       => 'width-full',
		'options'     => array(
			'none' => __( 'None', 'cherry' ),
			'part' => __( 'Part', 'cherry' ),
			'full' => __( 'Full', 'cherry' ),
		)
	);
	$blog_options['blog-excerpt-length'] = array(
		'type'        => 'slider',
		'title'       => __( 'Content Part length', 'cherry' ),
		'description' => __( 'Specify number of words displayed in blog listing content part. Will not work if post has an excerpt.', 'cherry' ),
		'max_value'   => 500,
		'min_value'   => 1,
		'value'       => 55,
	);
	$blog_options['blog-button'] = array(
		'type'        => 'switcher',
		'title'       => __( 'More button', 'cherry' ),
		'description' => __( 'Enable/Disable read more button in blog listing.', 'cherry' ),
		'value'       => 'true',
	);
	$blog_options['blog-button-text'] = array(
		'type'  => 'text',
		'title' => __( 'More button label', 'cherry' ),
		'description' => __( 'Specify read more button label text. ', 'cherry' ),
		'value' => __( 'read more', 'cherry' ),
	);

	// Post
	////////////////////////////////////////////////////////////////////////
	$post_single_options['blog-post-featured-image'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Featured Image', 'cherry' ),
		'description' => __( 'Display featured image on the single post page.', 'cherry' ),
		'value'       => 'true',
	);
	$post_single_options['blog-post-featured-image-size'] = array(
		'type'        => 'select',
		'title'       => __( 'Size of Featured Image', 'cherry' ),
		'description' => __( 'Set dimensions for single post featured images.', 'cherry' ),
		'value'       => 'cherry-thumb-l',
		'class'       => 'width-full',
		'options'     => array(
			'cherry-thumb-s' => __( 'Small', 'cherry' ),
			'cherry-thumb-l' => __( 'Large', 'cherry' ),
		)
	);
	$post_single_options['blog-post-featured-image-align'] = array(
		'type'        => 'select',
		'title'       => __( 'Alignment of Featured Image', 'cherry' ),
		'description' => __( 'Set alignment for single post featured images.', 'cherry' ),
		'value'       => 'aligncenter',
		'class'       => 'width-full',
		'options'     => array(
			'alignnone'   => __( 'None', 'cherry' ),
			'alignleft'   => __( 'Left', 'cherry' ),
			'alignright'  => __( 'Right', 'cherry' ),
			'aligncenter' => __( 'Center', 'cherry' ),
		)
	);
	$post_single_options['blog-post-navigation'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Navigation', 'cherry' ),
		'description' => __( 'Enable/disable post navigation block.', 'cherry' ),
		'value'       => 'true',
	);
	$post_single_options['blog-post-author-bio'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Author bio', 'cherry' ),
		'description' => __( 'Enable/disable author bio block. Author bio block is displayed on the post page.', 'cherry' ),
		'value'       => 'true',
	);
	$post_single_options['blog-related-posts'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Related posts', 'cherry' ),
		'description' => __( 'Enable/disable related posts block. Related posts block is displayed on the post page.', 'cherry' ),
		'value' => 'true',
	);
	$post_single_options['blog-comment-status'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Allow comments', 'cherry' ),
		'description' => __( 'Enable/disable comments for blog posts.', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Make sure comments are enabled in Wordpress \'settings->discussion\'. For posts that have already been published you need to enable comments individually in post settings.', 'cherry' ),
		),
		'value' => 'true',
	);
	$post_single_options['blog-gallery-shortcode'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Gallery slider', 'cherry' ),
		'description' => __( 'Replace default Wordpress gallery shortcode with enhanced jQuery carousel.', 'cherry' ),
		'value'       => 'true',
	);
	$post_single_options['blog-add-ligthbox'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Lightbox for images in a content', 'cherry' ),
		'description' => __( 'Automatically adds lightbox for images in a post content.', 'cherry' ),
		'value'       => 'true',
	);

	// Meta
	////////////////////////////////////////////////////////////////////////
	$post_meta_options['blog-post-date'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Date', 'cherry' ),
		'description' => __( 'Show/Hide post publication date.', 'cherry' ),
		'value'       => 'true',
	);
	$post_meta_options['blog-post-author'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Author', 'cherry' ),
		'description' => __( 'Show/Hide post author.', 'cherry' ),
		'value'       => 'true',
	);
	$post_meta_options['blog-post-comments'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Comments', 'cherry' ),
		'description' => __( 'Show/Hide number of comments.', 'cherry' ),
		'value'       => 'true',
	);
	$post_meta_options['blog-categories'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Categories', 'cherry' ),
		'description' => __( 'Show/Hide post categories.', 'cherry' ),
		'value'       => 'true',
	);
	$post_meta_options['blog-tags'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Tags', 'cherry' ),
		'description' => __( 'Show/Hide post tags.', 'cherry' ),
		'value'       => 'true',
	);

//////////////////////////////////////////////////////////////////////
// Styling options
//////////////////////////////////////////////////////////////////////
	$styling_options = array();
	//background image
	$styling_options['body-background'] = array(
		'type'			=> 'background',
		'title'			=> __('Body background', 'cherry' ),
		'description'	=> __( 'Set background for body container. ', 'cherry' ),
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('You can specify background image or color, set background repeat, position and attachment. ', 'cherry' ),
		),
		'return_data_type'	=> 'url',
		'library_type'		=> 'image',
		'value'				=> array(
			'image'			=> '',
			'color'			=> '#FFFFFF',
			'repeat'		=> 'repeat',
			'position'		=> 'left',
			'attachment'	=> 'fixed',
			'clip'			=> 'padding-box',
			'size'			=> 'cover',
			'origin'		=> 'padding-box',
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
		'type'        => 'typography',
		'title'       => __( 'Header Menu Typography', 'cherry' ),
		'description' => __( 'Main header navigation typography settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'web',
			'size'          => '14',
			'lineheight'    => '17',
			'color'         => '#474747',
			'family'        => 'Open Sans',
			'character'     => 'latin-ext',
			'style'         => '600',
			'letterspacing' => '',
			'align'         => 'notdefined',
		),
	);
	$navigation_options['typography-footer-menu'] = array(
		'type'        => 'typography',
		'title'       => __( 'Footer Menu Typography', 'cherry' ),
		'description' => __( 'Main footer navigation typography settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'web',
			'size'          => '14',
			'lineheight'    => '17',
			'color'         => '#474747',
			'family'        => 'Open Sans',
			'character'     => 'latin-ext',
			'style'         => '',
			'letterspacing' => '',
			'align'         => 'notdefined',
		),
	);
	$navigation_options['navigation-arrow'] = array(
		'type'          => 'switcher',
		'title'         => __( 'Arrows markup', 'cherry' ),
		'description'   => __( 'Do you want to generate arrow mark-up?', 'cherry' ),
		'value'         => 'true',
		'default_value' => 'true',
	);

	// Breadcrumbs options
	//////////////////////////////////////////////////////////////////////
	$breadcrumbs_options = array();

	$breadcrumbs_options['breadcrumbs'] = array(
		'type'          => 'switcher',
		'title'         => __( 'Breadcrumbs', 'cherry' ),
		'description'   => __( 'Enable/disable breadcrumbs navigation.', 'cherry' ),
		'value'         => 'true',
		'default_value' => 'true',
	);
	$breadcrumbs_options['breadcrumbs-show-title'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Page title', 'cherry' ),
		'description' => __( 'Show / hide current page title in breadcrumb navigation.', 'cherry' ),
		'value'       => 'true',
	);
	$breadcrumbs_options['breadcrumbs-display'] = array(
		'type'        => 'checkbox',
		'title'       => __( 'Breadcrumbs mobile', 'cherry' ),
		'description' => __( 'Enable/disable breadcrumbs on mobile devices.', 'cherry' ),
		'value'       => array( 'tablet', 'mobile' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'Mobile &mdash; Extra small devices, phones (&lt;768px) <br>Tablet &mdash; Small devices, tablets (&lt;991px)', 'cherry' ),
		),
		'options'     => array(
			'mobile' => __( 'Mobile', 'cherry' ),
			'tablet' => __( 'Tablet', 'cherry' ),
		),
	);
	$breadcrumbs_options['breadcrumbs-show-on-front'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Home page breadcrumbs', 'cherry' ),
		'description' => __( 'If option defined in page setting, this global option will not be counted.', 'cherry' ),
		'value'       => 'false',
	);
	$breadcrumbs_options['breadcrumbs-home-title'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Customize a Home page title?', 'cherry' ),
		'value'       => 'true',
		'toggle'      => array(
			'true_toggle'  => __( 'Yes', 'cherry' ),
			'false_toggle' => __( 'No', 'cherry' ),
			'true_slave'   => 'breadcrumbs-home-title-true-slave',
			'false_slave'  => 'breadcrumbs-home-title-false-slave',
		),
	);
	$breadcrumbs_options['breadcrumbs-custom-home-title'] = array(
		'type'        => 'text',
		'title'       => __( 'Home page title', 'cherry' ),
		'description' => __( 'This is a customized title for a Home page.', 'cherry' ),
		'value'       => __( 'Home', 'cherry' ),
		'class'       => 'width-full',
		'master'      => 'breadcrumbs-home-title-true-slave',
	);
	$breadcrumbs_options['breadcrumbs-separator'] = array(
		'type'          => 'text',
		'title'         => __( 'Item separator', 'cherry' ),
		'description'   => __( 'Breadcrumbs separator symbol.', 'cherry' ),
		'value'         => '&#47;',
		'default_value' => '&#47;',
		'class'         => 'width-full',
	);
	$breadcrumbs_options['breadcrumbs-prefix-path'] = array(
		'type'        => 'text',
		'title'       => __( 'Breadcrumbs prefix', 'cherry' ),
		'description' => __( 'Text displayed before breadcrumbs navigation.', 'cherry' ),
		'value'       => __( 'You are here:', 'cherry' ),
	);

	// Page navigation options
	//////////////////////////////////////////////////////////////////////
	$pagination_option = array();

	$pagination_option['pagination-position'] = array(
		'type'        => 'select',
		'title'       => __( 'Pagination position', 'cherry' ),
		'description' => __( 'Select your pagination position.', 'cherry' ),
		'value'       => 'after',
		'options'     => array(
			'after'  => __( 'After posts loop', 'cherry' ),
			'before' => __( 'Before posts loop', 'cherry' ),
			'both'   => __( 'Both', 'cherry' ),
		),
	);
	$pagination_option['pagination-next-previous'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Prev/next buttons', 'cherry' ),
		'description' => __( 'Show/hide previous and next buttons in pagination.', 'cherry' ),
		'value'       => 'true',
	);
	$pagination_option['pagination-label'] = array(
		'type'        => 'text',
		'title'       => __( 'Pagination label', 'cherry' ),
		'description' => __( 'Pagination label. Displayed before pagination buttons. Text or HTML can be used.', 'cherry' ),
		'value'       => __( 'Pages:', 'cherry' ),
	);
	$pagination_option['pagination-previous-page'] = array(
		'type'        => 'text',
		'title'       => __( 'Prev button label', 'cherry' ),
		'description' => __( 'Previous button label text. Text or HTML can be used.', 'cherry' ),
		'value'       => '&laquo;',
	);
	$pagination_option['pagination-next-page'] = array(
		'type'        => 'text',
		'title'       => __( 'Next button label', 'cherry' ),
		'description' => __( 'Next button label text. Text or HTML can be used.', 'cherry' ),
		'value'       => '&raquo;',
	);
	$pagination_option['pagination-show-all'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Show all the pages', 'cherry' ),
		'description' => __( 'If set to On, then it will show all of the pages instead of a short list of the pages near the current page.', 'cherry' ),
		'value'       => 'false',
	);
	$pagination_option['pagination-end-size'] = array(
		'type'        => 'stepper',
		'title'       => __( 'End size', 'cherry' ),
		'description' => __( 'How many pages to display either at the top or at the end of the list.', 'cherry' ),
		'value'       => '1',
		'value-step'  => '1',
		'max-value'   => '99',
		'min-value'   => '1',
	);
	$pagination_option['pagination-mid-size'] = array(
		'type'        => 'stepper',
		'title'       => __( 'Mid size', 'cherry' ),
		'description' => __( 'How many numbers to display to either side of current page, but not including current page.', 'cherry' ),
		'value'       => '2',
		'value-step'  => '1',
		'max-value'   => '9999',
		'min-value'   => '1',
	);
//////////////////////////////////////////////////////////////////////
// Header options
//////////////////////////////////////////////////////////////////////
	$header_options = array();

	$header_options['header-background'] = array(
		'type'  => 'background',
		'title' => __('Background', 'cherry' ),
		'hint'  => array(
				'type'    => 'text',
				'content' => __( 'Header background settings. You can select background color, upload header background image, set its background position, attachment and repeat.', 'cherry' ),
		),
		'return_data_type' => 'id',
		'library_type'     => 'image',
		'description'      => __( 'Header background settings. You can select background color, upload header background image, set its background position, attachment and repeat.', 'cherry' ),
		'return_data_type' => 'id',
		'library_type'     => 'image',
		'value'            => array(
			'image'      => '',
			'color'      => '',
			'repeat'     => 'repeat',
			'position'   => 'left',
			'attachment' => 'fixed',
			'clip'       => 'padding-box',
			'size'       => 'cover',
			'origin'     => 'padding-box',
		),
	);
	$header_options['header-grid-type'] = array(
		'type'          => 'radio',
		'title'         => __( 'Grid type', 'cherry' ),
		'description'   => __( 'Select layout pattern for header website. Wide layout will fit window width. Boxed layout will have fixed width.', 'cherry' ),
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
	$header_options['header-boxed-width'] = array(
		'type'        => 'slider',
		'title'       => __( 'Boxed width', 'cherry' ),
		'description' => __( 'Header width for `boxed` layout. Should not be more than `Grid -> Container width` value.', 'cherry' ),
		'max_value'   => 1920,
		'min_value'   => 970,
		'value'       => 1310,
	);
	$header_options['header-sticky'] = array(
		'type'        => 'switcher',
		'title'       => __( 'Sticky header', 'cherry' ),
		'description' => __( 'Enable\disable fixed header that sticks to the top.', 'cherry' ),
		'value'       => 'false',
	);
	$header_options['header-sticky-selector'] = array(
		'type'        => 'select',
		'title'       => __( 'Sticky selector', 'cherry' ),
		'description' => __( 'Select the block selector that will be used to build sticky panel. You can use tag name, class name, or id.', 'cherry' ),
		'value'       => $default_selector,
		'options'     => $sticky_selectors,
	);
	// Header Logo options
	//////////////////////////////////////////////////////////////////////
	$logo_options = array();
	$logo_options['logo-type'] = array(
		'type'        => 'radio',
		'title'       => __( 'Logo type', 'cherry' ),
		'description' => __( 'Select whether you want your main logo to be an image or text. ', 'cherry' ),
		'hint'        => array(
			'type'    => 'text',
			'content' => __( 'If you select "image", you can choose logo image from the media library in the next option, and if you select "text", your WordPress Site Title will be shown instead.', 'cherry' ),
		),
		'value'         => 'text',
		'default_value' => 'text',
		'class'         => '',
		'display_input' => true,
		'options'       => array(
			'image' => array(
				'label'   => 'Image logo',
				'img_src' => '',
				'slave'   => 'logo-type-image',
			),
			'text' => array(
				'label'   => 'Text logo',
				'img_src' => '',
				'slave'   => 'logo-type-text',
			),
		),
	);
	$logo_options['logo-image-path'] = array(
		'type'         => 'media',
		'title'        => __( 'Logo image', 'cherry' ),
		'description'  => __( 'Click Choose Media button to select logo image from the media library or upload your image.', 'cherry' ),
		'value'        => '',
		'multi-upload' => true,
		'master'       => 'logo-type-image',
	);
	$logo_options['typography-header-logo'] = array(
		'type'        => 'typography',
		'title'       => __( 'Logo typography', 'cherry' ),
		'description' => __( 'Configuration settings for text logo. Here you can select logo font family, size, color, etc.', 'cherry' ),
		'master'      => 'logo-type-text',
		'value'       => array(
			'fonttype'      => 'web',
			'size'          => '30',
			'lineheight'    => '36',
			'color'         => '#444444',
			'family'        => 'Open Sans',
			'character'     => 'latin-ext',
			'style'         => '700',
			'letterspacing' => '',
			'align'         => 'notdefined',
		),
	);

//////////////////////////////////////////////////////////////////////
// Page options
//////////////////////////////////////////////////////////////////////
	$page_options = array();
	$page_options['content-background'] = array(
		'type'  => 'background',
		'title' => __( 'Background', 'cherry' ),
		'hint'  => array(
			'type'    => 'text',
			'content' => __( 'Page background settings. You can select background color, upload footer background image, set its background position, attachment and repeat.', 'cherry' ),
		),
		'description' => __( 'Page background settings. You can select background color, upload footer background image, set its background position, attachment and repeat.', 'cherry' ),
		'return_data_type'	=> 'id',
		'library_type'		=> 'image',
		'value'				=> array(
			'image'			=> '',
			'color'			=> '',
			'repeat'		=> 'repeat',
			'position'		=> 'left',
			'attachment'	=> 'fixed',
			'clip'			=> 'padding-box',
			'size'			=> 'cover',
			'origin'		=> 'padding-box',
		)
	);
	$page_options['content-grid-type'] = array(
		'type'			=> 'radio',
		'title'			=> __( 'Grid type', 'cherry' ),
		'description'	=> __( 'Select layout pattern for main website container. Wide layout will fit window width. Boxed layout will have fixed width and left/right indents. ', 'cherry' ),
		'value'			=> 'boxed',
		'display_input'	=> false,
		'options'		=> array(
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
	$page_options['content-boxed-width'] = array(
		'type'			=> 'slider',
		'title'			=> __( 'Boxed width', 'cherry' ),
		'description'	=> __( 'Main content width for `boxed` layout. Should not be more than `Grid -> Container width` value.', 'cherry' ),
		'max_value'		=> 1920,
		'min_value'		=> 970,
		'value'			=> 1310,
	);
	$page_options['page-featured-images'] = array(
		'type'			=> 'switcher',
		'title'			=> __( 'Featured Images', 'cherry' ),
		'description'	=> __( 'Enable/disable featured images for pages.', 'cherry' ),
		'value'			=> 'false',
	);
	$page_options['page-comments-status'] = array(
		'type'			=> 'switcher',
		'title'			=> __( 'Page comments', 'cherry' ),
		'description'	=> __( "Enable/disable comments for pages by default. For pages that have already been published you need to enable comments individually in page settings.", 'cherry' ),
		'value'			=> 'true',
	);

//////////////////////////////////////////////////////////////////////
// Footer options
//////////////////////////////////////////////////////////////////////
	$footer_options = array();
	$footer_options['footer-background'] = array(
		'type'             => 'background',
		'title'            => __( 'Background', 'cherry' ),
		'description'      => __( 'Footer background settings. You can select background color, upload footer background image, set its background position, attachment and repeat.', 'cherry' ),
		'return_data_type' => 'id',
		'library_type'     => 'image',
		'value'            => array(
			'image'      => '',
			'color'      => '#ddd',
			'repeat'     => 'repeat',
			'position'   => 'left',
			'attachment' => 'fixed',
			'clip'       => 'padding-box',
			'size'       => 'cover',
			'origin'     => 'padding-box',
		),
	);
	$footer_options['typography-footer'] = array(
		'type'        => 'typography',
		'title'       => __( 'Typography', 'cherry' ),
		'description' => __( 'Typography settings for footer text.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'web',
			'size'          => '14',
			'lineheight'    => '30',
			'color'         => '#333333',
			'family'        => 'Roboto',
			'character'     => 'latin-ext',
			'style'         => '',
			'letterspacing' => '',
			'align'         => 'notdefined',
		),
	);
	$footer_options['footer-grid-type'] = array(
		'type'          => 'radio',
		'title'         => __( 'Grid type', 'cherry' ),
		'description'   => __( 'Select layout pattern for footer website. Wide layout will fit window width. Boxed layout will have fixed width.', 'cherry' ),
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
	$footer_options['footer-boxed-width'] = array(
		'type'        => 'slider',
		'title'       => __( 'Boxed width', 'cherry' ),
		'description' => __( 'Footer width for `boxed` layout. Should not be more than `Grid -> Container width` value.', 'cherry' ),
		'max_value'   => 1920,
		'min_value'   => 970,
		'value'       => 1310,
	);
	$footer_options['footer-text'] = array(
		'type'         => 'textarea',
		'title'        => __( 'Footer Info text', 'cherry' ),
		'description'  => __( 'Set custom text for Footer static info.', 'cherry' ),
		'value'        => '',
		'multi-upload' => true,
	);
	// Footer Logo options
	//////////////////////////////////////////////////////////////////////
	$footer_logo_options = array();
	$footer_logo_options['footer-logo-type'] = array(
		'type'          => 'radio',
		'title'         => __( 'Logo type', 'cherry' ),
		'description'   => __( 'Select whether you want your footer logo to be an image or text.', 'cherry' ),
		'value'         => 'text',
		'default_value' => 'text',
		'class'         => '',
		'display_input' => true,
		'options'       => array(
			'image' => array(
				'label'   => 'Image logo',
				'img_src' => '',
				'slave'   => 'footer-logo-type-image',
			),
			'text' => array(
				'label'   => 'Text logo',
				'img_src' => '',
				'slave'   => 'footer-logo-type-text',
			)
		)
	);
	$footer_logo_options['footer-logo-image-path'] = array(
		'type'         => 'media',
		'title'        => __( 'Logo image', 'cherry' ),
		'description'  => __( 'Click Choose Media button to select logo image from the media library or upload your image.', 'cherry' ),
		'value'        => '',
		'multi-upload' => true,
		'master'       => 'footer-logo-type-image',
	);
	$footer_logo_options['typography-footer-logo'] = array(
		'type'        => 'typography',
		'title'       => __( 'Logo typography', 'cherry' ),
		'description' => __( 'Configuration settings for text logo. Here you can select logo font family, size, color, etc.', 'cherry' ),
		'master'      => 'footer-logo-type-text',
		'value'       => array(
			'fonttype'      => 'web',
			'size'          => '20',
			'lineheight'    => '25',
			'color'         => '#444444',
			'family'        => 'Open Sans',
			'character'     => 'latin-ext',
			'style'         => '700',
			'letterspacing' => '',
			'align'         => 'notdefined',
		),
	);
//////////////////////////////////////////////////////////////////////
// Typography options
//////////////////////////////////////////////////////////////////////

	$typography_options = array();

	$typography_options['typography-body'] = array(
		'type'        => 'typography',
		'title'       => __( 'Body text', 'cherry' ),
		'description' => __( 'Main website text typography options.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'web',
			'size'          => '12',
			'lineheight'    => '18',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '',
			'align'         => 'notdefined',
		)
	);
	$typography_options['color-link'] = array(
		'type'        => 'colorpicker',
		'title'       => __( 'Link color', 'cherry' ),
		'description' => __( 'Color of links.', 'cherry' ),
		'value'       => '#f62e46',
	);
	$typography_options['color-link-hover'] = array(
		'type'        => 'colorpicker',
		'title'       => __( 'Link hover color', 'cherry' ),
		'description' => __( 'Color of links on hover.', 'cherry' ),
		'value'       => '#333333',
	);
	$typography_options['typography-input-text'] = array(
		'type'        => 'typography',
		'title'       => __( 'Input text', 'cherry' ),
		'description' => __( 'Styling text in forms.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '12',
			'lineheight'    => '20',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-breadcrumbs'] = array(
		'type'        => 'typography',
		'title'       => __( 'Breadcrumbs typography', 'cherry' ),
		'description' => __( 'Styling text in breadcrumbs.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '12',
			'lineheight'    => '18',
			'color'         => '#777777',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-h1'] = array(
		'type'        => 'typography',
		'title'       => __( 'Heading 1', 'cherry' ),
		'max_value'   => 500,
		'description' => __( 'H1 heading font settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '36',
			'lineheight'    => '40',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-h2'] = array(
		'type'        => 'typography',
		'title'       => __( 'Heading 2', 'cherry' ),
		'max_value'   => 500,
		'description' => __( 'H2 heading font settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '30',
			'lineheight'    => '33',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '0',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-h3'] = array(
		'type'        => 'typography',
		'title'       => __( 'Heading 3', 'cherry' ),
		'max_value'   => 500,
		'description' => __( 'H3 heading font settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '24',
			'lineheight'    => '26',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '0',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-h4'] = array(
		'type'        => 'typography',
		'title'       => __( 'Heading 4', 'cherry' ),
		'max_value'   => 500,
		'description' => __( 'H4 heading font settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '18',
			'lineheight'    => '20',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '0',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-h5'] = array(
		'type'        => 'typography',
		'title'       => __( 'Heading 5', 'cherry' ),
		'max_value'   => 500,
		'description' => __( 'H5 heading font settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '14',
			'lineheight'    => '16',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '0',
			'align'         => 'notdefined',
		)
	);
	$typography_options['typography-h6'] = array(
		'type'        => 'typography',
		'title'       => __( 'Heading 6', 'cherry' ),
		'max_value'   => 500,
		'description' => __( 'H6 heading font settings.', 'cherry' ),
		'value'       => array(
			'fonttype'      => 'standart',
			'size'          => '12',
			'lineheight'    => '14',
			'color'         => '#333333',
			'family'        => 'Arial, Helvetica',
			'character'     => 'latin-ext',
			'style'         => 'regular',
			'letterspacing' => '0',
			'align'         => 'notdefined',
		)
	);
	$typography_options['webfonts'] = array(
		'type'			=> 'webfont',
		'title'			=> __('Webfonts', 'cherry'),
		'label'			=> '',
		'description'	=> __( 'Define custom Font style and Character Sets for selected web font.', 'cherry' ),
		'value'			=> array()
	);
//////////////////////////////////////////////////////////////////////
// Optimization options
//////////////////////////////////////////////////////////////////////

	$optimization_options = array();

	$optimization_options['concatenate-css'] = array(
		'type'          => 'switcher',
		'title'			=> __( 'Concatenate/minify CSS', 'cherry' ),
		'description'	=> __( 'Select if you want to merge\minify CSS files for performance optimization.', 'cherry' ),
		'value'         => 'false',
		'toggle'        => array(
			'true_toggle'  => __( 'Yes', 'cherry' ),
			'false_toggle' => __( 'No', 'cherry' )
		)
	);
	$optimization_options['dynamic-css'] = array(
		'type'			=> 'select',
		'title'			=> 'Dynamic CSS output',
		'description'	=> __( 'Output dynamic CSS into separate file or into style tag.', 'cherry' ),
		'value'			=> 'tag',
		'class'			=> 'width-full',
		'options'		=> array(
			'file'	=> 'Separate file',
			'tag'	=> 'Style tag in HEAD'
		)
	);
//////////////////////////////////////////////////////////////////////
// Cookie Banner
//////////////////////////////////////////////////////////////////////
	$cookie_banner = array();

	$cookie_banner['cookie-banner-visibility'] = array(
		'type'  => 'switcher',
		'title' => __( 'Display Cookie Banner?', 'cherry' ),
		'value'  => 'false',
		'toggle' => array(
			'true_toggle'  => __( 'Yes', 'cherry' ),
			'false_toggle' => __( 'No', 'cherry' ),
		)
	);
	$cookie_banner['cookie-banner-text'] = array(
		'type'        => 'textarea',
		'title'       => __( 'Message', 'cherry' ),
		'description' => __( 'Enter the cookie banner message.', 'cherry' ),
		'value'       => __( 'We use cookies to ensure you get the best experience on our website.', 'cherry' ),
	);

//////////////////////////////////////////////////////////////////////
// Demo options
//////////////////////////////////////////////////////////////////////
	$demo_options = array();

	$demo_options['text-demo'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input', 'cherry'),
		'label'			=> '',
		'description'	=> '',
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
		'description'	=> '',
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
		'description'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with single option.', 'cherry'),
		),
		'value'			=> 'select-1',
		'class'			=> '',
		'options'		=> array(
			'select-1'	=> 'select 1',
			'select-2'	=> 'select 2',
			'select-3'	=> 'select 3'
		)
	);
	$demo_options['filterselect-demo'] = array(
		'type'			=> 'select',
		'title'			=> __('Filtered select', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with filter option.', 'cherry'),
		),
		'value'			=> 'select-2',
		'class'			=> 'cherry-filter-select',
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
		'type'			=> 'select',
		'title'			=> __('Multi-select box', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with multiple select capability.', 'cherry'),
		),
		'multiple'		=> true,
		'value'			=> array('select-1','select-2'),
		'class'			=> 'cherry-multi-select',
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
	$demo_options['multiselect-demo-1'] = array(
		'type'			=> 'select',
		'title'			=> __('Multi-select box', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with multiple select capability.', 'cherry'),
		),
		'multiple'		=> true,
		'value'			=> array('select-1','select-2'),
		'class'			=> 'cherry-multi-select',
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
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular HTML checkbox.', 'cherry'),
		),
		'value'			=> array( 'checkbox-1' ),
		'options'		=> array(
			'checkbox-1'	=> 'checkbox value 1',
			'checkbox-2'	=> 'checkbox value 2',
		)
	);
	$demo_options['switcher-demo'] = array(
		'type'			=> 'switcher',
		'title'			=> __('Switcher', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'description'	=> __('Analogue of the regular HTML radio buttons. ', 'cherry'),
		'value'			=> 'true',
	);
	$demo_options['switcher-custom-toogle-demo'] = array(
		'type'			=> 'switcher',
		'title'			=> __('Switcher (alternative)', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'description'	=> __('Alternative switcher with custom labels.', 'cherry'),
		'value'			=> 'true',
		'toggle'		=> array(
			'true_toggle'	=> __( 'Enabled', 'cherry' ),
			'false_toggle'	=> __( 'Disabled', 'cherry' ),
			'true_slave'	=> 'switcher-custom-toogle-demo-true-slave',
			'false_slave'	=> 'switcher-custom-toogle-demo-false-slave'
		),
	);
	$demo_options['stepper-demo'] = array(
		'type'			=> 'stepper',
		'title'			=> __('Stepper', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'description'	=> __('Adds a number input used to define numeric values.', 'cherry'),
		'value'			=> '0',
		'step_value'	=> '1',
		'max_value'		=> '50',
		'min_value'		=> '-50',
		'master'		=> 'switcher-custom-toogle-demo-true-slave'
	);
	$demo_options['slider-demo'] = array(
		'type'			=> 'slider',
		'title'			=> __('Slider', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'description'	=> __('Draggable slider with stepper. Used to define some numeric value.', 'cherry'),
		'max_value'		=> 1920,
		'min_value'		=> 980,
		'value'			=> 1024
	);
	$demo_options['range-slider-demo'] = array(
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
			'left_value'	=> 30,
			'right_value'	=> 50,
		)
	);
	$demo_options['radio-demo'] = array(
		'type'			=> 'radio',
		'title'			=> __('Radio buttons', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'description'	=> __('Adds radio buttons group. Lets user select one option from the list.', 'cherry'),
		'value'			=> 'radio-2',
		'class'			=> '',
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
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry'),
		),
		'description'	=> __('Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry'),
		'value'			=> 'radio-1',
		'class'			=> '',
		'options'		=> array(
			'radio-1' => array(
				'label' => 'radio image 1',
				'img_src' => PARENT_URI.'/screenshot.png',
				'slave'	=> 'radio-image-demo-checkbox-2'
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
	$demo_options['colorpicker-demo'] = array(
		'type'			=> 'colorpicker',
		'title'			=> __('Colorpicker', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'			=> array(
			'type'		=> 'text',
			'content'	=> __('Adds a color picker.', 'cherry'),
		),
		'value'			=> '#ff0000',
	);
	$demo_options['image-demo'] = array(
		'type'				=> 'media',
		'title'			=> __('Media library element', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Allows user to add content from Wordpress media library.', 'cherry'),
		),
		'value'				=> '',
		'multi_upload'		=> true,
		'library_type'		=> ''
	);
	$demo_options['background-demo'] = array(
		'type'			=> 'background',
		'title'			=> __('Background image', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Allows user to add background image from the media library and define its background settings like background repeat, position, attachment, origin.', 'cherry'),
		),
		'multi_upload'		=> true,
		'library_type'		=> 'image',
		'value'				=> array(
			'image'			=> '',
			'color'			=> '#ff0000',
			'repeat'		=> 'repeat',
			'position'		=> 'left',
			'attachment'	=> 'fixed',
			'clip'			=> 'padding-box',
			'size'			=> 'cover',
			'origin'		=> 'padding-box',
		)
	);

	$demo_options['typography-demo'] = array(
		'type'			=> 'typography',
		'title'			=> __('Typography', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'max_value '	=> 500,
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Provides typography configuration options such as Google Font family name, font size, line height, style, letter spacing, characters sets, text align and color. Below options you can see font preview.', 'cherry'),
		),
		'max_value '	=> 500,
		'value'			=> array(
			'fonttype'		=> 'web',
			'family'		=> 'Abril Fatface',
			'character'		=> 'latin-ext',
			'style'			=> 'italic',
			'size'			=> '20',
			'lineheight'	=> '20',
			'letterspacing' => '0',
			'align'			=> 'notdefined',
			'color'			=> '#222222',
		)
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
	$demo_options['layout-editor-demo'] = array(
		'type'			=> 'layouteditor',
		'title'			=> __( 'title layout editor', 'cherry' ),
		'label'			=> 'label layout editor',
		'description'	=> __( 'description layout editor', 'cherry' ),
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
		'description'	=> '',
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
	$demo_options['webfont-demo'] = array(
		'type'			=> 'webfont',
		'title'			=> __('Webfont', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'value'			=> array()
	);
	$demo_options['editordemo'] = array(
		'type'			=> 'editor',
		'title'			=> __('WYSIWYG editor', 'cherry'),
		'label'			=> '',
		'decsription'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Adds an input section with WYSIWYG editor. Behaves as Wordpress post or page editing area.', 'cherry'),
		),
		'value'			=> 'Lorem ipsum',
	);

//////////////////////////////////////////////////////////////////////
// Test options
//////////////////////////////////////////////////////////////////////
	$test_options = array();

	$test_options['switcher-test'] = array(
		'type'			=> 'switcher',
		'title'			=> __('Switcher', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'description'	=> __('Analogue of the regular HTML radio buttons. ', 'cherry'),
		'value'			=> 'true',
		'toggle'		=> array(
			'true_toggle'	=> __( 'Enabled', 'cherry' ),
			'false_toggle'	=> __( 'Disabled', 'cherry' ),
			'true_slave'	=> 'switcher-test-true-slave',
			'false_slave'	=> 'switcher-test-false-slave'
		),
	);

	$test_options['text-test'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'switcher-test-true-slave'
	);
	$test_options['textarea-test'] = array(
		'type'			=> 'textarea',
		'title'			=> __('Textarea input', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Multiline text input field ( 16 rows x 20 cols ).', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'switcher-test-true-slave'
	);
	$test_options['select-test'] = array(
		'type'			=> 'select',
		'title'			=> __('Select box', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with single option.', 'cherry'),
		),
		'value'			=> 'select-1',
		'class'			=> '',
		'options'		=> array(
			'select-1'	=> 'select 1',
			'select-2'	=> 'select 2',
			'select-3'	=> 'select 3'
		),
		'master'			=> 'switcher-test-true-slave'
	);
	$test_options['filterselect-test'] = array(
		'type'			=> 'select',
		'title'			=> __('Filtered select', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'      	=>  array(
			'type'		=> 'text',
			'content'	=> __('Select box with filter option.', 'cherry'),
		),
		'value'			=> 'select-2',
		'class'			=> 'cherry-filter-select',
		'options'		=> array(
			'select-1'	=> 'select 1',
			'select-2'	=> 'select 2',
			'select-3'	=> 'select 3',
			'select-4'	=> 'select 4',
			'select-5'	=> 'select 5',
			'select-6'	=> 'select 6',
			'select-7'	=> 'select 2',
			'select-8'	=> 'select 8'
		),
		'master'			=> 'switcher-test-true-slave'
	);
	$test_options['radio-image-test'] = array(
		'type'			=> 'radio',
		'title'			=> __('Radio buttons (image)', 'cherry'),
		'label'			=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry'),
		),
		'description'	=> __('Adds image based radio buttons group. Behaves as HTML radio buttons.', 'cherry'),
		'value'			=> 'radio-1',
		'class'			=> '',
		'options'		=> array(
			'radio-1' => array(
				'label'		=> 'radio image 1',
				'img_src'	=> PARENT_URI.'/screenshot.png',
				'slave'		=> 'radio-image-test-radio-1'
			),
			'radio-2' => array(
				'label'		=> 'radio image 2',
				'img_src'	=> PARENT_URI.'/screenshot.png',
				'slave'		=> 'radio-image-test-radio-2'
			),
			'radio-3' => array(
				'label'		=> 'radio image 3',
				'img_src'	=> PARENT_URI.'/screenshot.png',
				'slave'		=> 'radio-image-test-radio-3'
			),
		),
		'master'			=> 'switcher-test-true-slave'
	);
	$test_options['text-test-radio-1'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input 1', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'switcher-test-true-slave, radio-image-test-radio-1'
	);
	$test_options['text-test-radio-2'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input 2', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'switcher-test-true-slave, radio-image-test-radio-2'
	);
	$test_options['text-test-radio-3'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input 3', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'switcher-test-true-slave, radio-image-test-radio-3'
	);

	$test_options['checkbox-text'] = array(
		'type'			=> 'checkbox',
		'title'			=> __('Checkbox', 'cherry'),
		'label'			=> __('Checkbox label', 'cherry'),
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular HTML checkbox.', 'cherry'),
		),
		'value'			=> array( 'checkbox-1' ),
		'options'		=> array(
			'checkbox-1'	=> 'checkbox value 1',
			'checkbox-2'	=> array(
				'label'		=> 'checkbox value 2',
				'slave'		=> 'checkbox-text-checkbox-2'
			),
			'checkbox-3'	=> array(
				'label'		=> 'checkbox value 3',
				'slave'		=> 'checkbox-text-checkbox-3'
			),
		),
	);
	$test_options['text-test-checkbox-1'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input 1', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
	);
	$test_options['text-test-checkbox-2'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input 2', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'checkbox-text-checkbox-2'
	);
	$test_options['text-test-checkbox-3'] = array(
		'type'			=> 'text',
		'title'			=> __('Text input 3', 'cherry'),
		'label'			=> '',
		'description'	=> '',
		'hint'			=>  array(
			'type'		=> 'text',
			'content'	=> __('Regular single line text input field.', 'cherry'),
		),
		'value'			=> 'value',
		'master'			=> 'checkbox-text-checkbox-3'
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
	$sections_array['grid-section'] = array(
		'name'         => __( 'Grid', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 30,
		'options-list' => apply_filters( 'cherry_grid_options_list', $grid_options ),
	);
	$sections_array['layouts-subsection'] = array(
		'name'         => __( 'Layouts', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'grid-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_layouts_options_list', $layouts_options ),
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
	$sections_array['page-section'] = array(
		'name'         => __( 'Page', 'cherry' ),
		'icon'         => 'dashicons dashicons-text',
		'priority'     => 80,
		'options-list' => apply_filters( 'cherry_page_options_list', $page_options ),
	);
	$sections_array['footer-section'] = array(
		'name'         => __( 'Footer', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-appearance',
		'priority'     => 90,
		'options-list' => apply_filters( 'cherry_footer_options_list', $footer_options ),
	);
	$sections_array['footer-logo-subsection'] = array(
		'name'         => __( 'Logo', 'cherry' ),
		'icon'         => 'dashicons dashicons-arrow-right',
		'parent'       => 'footer-section',
		'priority'     => 1,
		'options-list' => apply_filters( 'cherry_footer_logo_options_list', $footer_logo_options ),
	);
	$sections_array['typography-section'] = array(
		'name'         => __( 'Typography', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-generic',
		'priority'     => 100,
		'options-list' => apply_filters( 'cherry_typography_options_list', $typography_options ),
	);
	$sections_array['optimization-section'] = array(
		'name'         => __( 'Optimization', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-tools',
		'priority'     => 110,
		'options-list' => apply_filters( 'cherry_optimization_options_list', $optimization_options ),
	);
	$sections_array['cookie-banner-section'] = array(
		'name'         => __( 'Cookie Banner', 'cherry' ),
		'icon'         => 'dashicons dashicons-admin-tools',
		'priority'     => 120,
		'options-list' => apply_filters( 'cherry_cookie_banner_options_list', $cookie_banner ),
	);
	$sections_array['demo-section'] = array(
		'name'         => __( 'Interface elements (for UI developers)', 'cherry' ),
		'icon'         => 'dashicons dashicons-editor-help',
		'priority'     => 999,
		'options-list' => apply_filters( 'cherry_demo_options_list', $demo_options ),
	);

	return apply_filters( 'cherry_defaults_settings', $sections_array );
}
