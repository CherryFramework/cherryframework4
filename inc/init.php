<?php
/**
 * Sets up custom filters and actions for the theme. This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 */

// Register custom image sizes.
if ( current_theme_supports( 'post-thumbnails' ) ) {
	add_action( 'init', 'cherry_register_image_sizes' );
}

// Add extra support for post types.
add_action( 'init', 'cherry_add_post_type_support' );
add_action( 'init', 'cherry_remove_post_type_support' );

// Register custom menus.
add_action( 'init', 'cherry_register_menus' );

// Register sidebars.
add_action( 'widgets_init', 'cherry_register_sidebars' );

// Added class for Footer Sidebar widgets.
add_filter( 'cherry_sidebar_args', 'cherry_footer_sidebar_class' );

// Added wrap for Footer Sidebar widgets.
add_action( 'cherry_sidebar_footer_start', 'cherry_sidebar_footer_wrap_open' );
add_action( 'cherry_sidebar_footer_end', 'cherry_sidebar_footer_wrap_close' );

// Output classes for Secondary column.
// add_filter( 'cherry_attr_sidebar', 'cherry_sidebar_main_class', 10, 2 );

// Registers custom image sizes for the theme.
function cherry_register_image_sizes() {

	// Sets the 'post-thumbnail' size.
	set_post_thumbnail_size( 200, 150, true );

	// Adds the 'slider-post-thumbnail' image size.
	add_image_size( 'slider-post-thumbnail', 1025, 500, true );
}

function cherry_add_post_type_support() {

	// Enable support for excerpts.
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * Filters the array with post types that supported `cherry-layouts`.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	$post_types = apply_filters( 'cherry_layouts_add_post_type_support', array( 'post', 'page' ) );

	// For each available post type, create a meta box on its edit page.
	foreach ( $post_types as $type ) {
		add_post_type_support( $type, 'cherry-layouts' );
	}

	/**
	 * Filters the array with post types that supported `cherry-grid-type`.
	 *
	 * @since 4.0.0
	 * @var   array
	 */
	$post_types = apply_filters( 'cherry_grid_type_add_post_type_support', array( 'post', 'page' ) );

	// For each available post type, create a meta box on its edit page.
	foreach ( $post_types as $type ) {
		add_post_type_support( $type, 'cherry-grid-type' );
	}
}

function cherry_remove_post_type_support() {

	// Disable support for thumbnails.
	remove_post_type_support( 'page', 'thumbnail' );
}

// Registers nav menu locations.
function cherry_register_menus() {
	register_nav_menu( 'primary',   __( 'Primary Menu', 'cherry' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'cherry' ) );
}

// Registers sidebars.
function cherry_register_sidebars() {

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-main',
			'name'        => __( 'Main Sidebar', 'cherry' ),
			'description' => __( 'This is the main sidebar if you are using a two or three column site layout option.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-secondary',
			'name'        => __( 'Secondary Sidebar', 'cherry' ),
			'description' => __( 'This is the secondary sidebar if you are using a three column site layout option.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-header',
			'name'        => __( 'Header Sidebar', 'cherry' ),
			'description' => __( 'A sidebar located in the header of the site.', 'cherry' )
		)
	);

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-footer',
			'name'        => __( 'Footer Sidebar', 'cherry' ),
			'description' => __( 'A sidebar located in the footer of the site.', 'cherry' )
		)
	);
}

// Added class for Footer Sidebar widgets.
function cherry_footer_sidebar_class( $args ) {
	if ( 'sidebar-footer' === $args['id'] ) {
		$args['before_widget'] = preg_replace( '/class="/', "class=\"col-sm-3 ", $args['before_widget'], 1 );
	}

	return $args;
}

// Added wrap for Footer Sidebar widgets
function cherry_sidebar_footer_wrap_open() {
	echo "<div class='container'><div class='row'>";
}
function cherry_sidebar_footer_wrap_close() {
	echo "</div></div>";
}

/**
 * Define which templates/pages exclude the sidebar.
 *
 *  @since 4.0.0
 * @param  string $id Sidebar ID.
 * @return bool       Display or not the sidebar?
 */
function cherry_display_sidebar( $id ) {
	global $wp_registered_sidebars;

	if ( array_key_exists( $id, $wp_registered_sidebars ) !== TRUE ) {
		return false;
	}

	$sidebars = apply_filters( 'cherry_display_sidebar_args', array(
		'sidebar-main' => new Cherry_Sidebar(
			/**
			 * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags).
			 * Any of these conditional tags that return true won't show the sidebar.
			 *
			 * If you only wanted to exclude page from displaying the sidebar, you'll need to pass
			 * an additional argument through the array, namely the page id, the slug, or the title.
			 * To do this you need to pass the conditional and argument together as an array.
			 * The following would exclude a page with id of 36, page with slug 'page-slug' and page with title 'Page Title':
			 *
			 *      array(
			 *      	array('is_page', array(36, 'page-slug', 'Page Title'))
			 *      ),
			 */
			array(
				'is_404',
				'is_front_page',
			),
			/**
			 * Page template checks (via is_page_template()).
			 * Any of these page templates that return true won't show the sidebar.
			 */
			array(
				// 'templates/my-template-name.php',
			)
		),
		'sidebar-secondary' => new Cherry_Sidebar(
			array(
				'is_404',
				'is_front_page',
			)
		),
		'sidebar-footer' => new Cherry_Sidebar(
			array(
				'is_404',
			)
		),
	) );

	if ( !isset( $sidebars[ $id ] ) ) {
		return true;
	}

	return apply_filters( 'cherry_display_sidebar', $sidebars[ $id ]->display, $id );
}

/**
 * Output classes for Secondary column.
 *
 * @since 4.0.0
 *
 * @return string Classes name
 */
function cherry_sidebar_main_class( $attr, $context ) {
	if ( 'secondary' === $context ) {
		$attr['class'] .= ' ' . apply_filters( 'cherry_sidebar_main_class', 'col-sm-4' );
	}

	return $attr;
}