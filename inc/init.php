<?php
/**
 * Sets up custom filters and actions for the theme. This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 */

// Register custom image sizes.
if ( current_theme_supports( 'post-thumbnails' ) ) {
	add_action( 'init', 'cherry_register_image_sizes' );
}

// Setup of certain features for a 'page' post type.
add_action( 'init', 'cherry_page_support' );

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
add_filter( 'cherry_attr_sidebar', 'cherry_sidebar_main_class', 10, 2 );

// Registers custom image sizes for the theme.
function cherry_register_image_sizes() {

	// Sets the 'post-thumbnail' size.
	set_post_thumbnail_size( 200, 150, true );

	// Adds the 'slider-post-thumbnail' image size.
	add_image_size( 'slider-post-thumbnail', 1025, 500, true );
}

// Setup of certain features for a 'page' post type.
function cherry_page_support() {

	// Enable support for excerpts.
	add_post_type_support( 'page', 'excerpt' );

	// Disable support for thumbnails.
	remove_post_type_support( 'page', 'thumbnail' );
}

// Registers nav menu locations.
function cherry_register_menus() {
	register_nav_menu( 'header', __( 'Header Menu', 'cherry' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'cherry' ) );
}

// Registers sidebars.
function cherry_register_sidebars() {

	cherry_register_sidebar(
		array(
			'id'          => 'sidebar-main',
			'name'        => __( 'Main Sidebar', 'cherry' ),
			'description' => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'cherry' )
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
	echo "<div class='row'>\n";
}
function cherry_sidebar_footer_wrap_close() {
	echo "</div>\n";
}

/**
 * Define which templates/pages exclude the sidebar.
 *
 * @since 4.0.0
 *
 * @return boolean Display or not the sidebar?
 */
function cherry_display_sidebar( $id ) {
	global $wp_registered_sidebars;

	if ( array_key_exists( $id, $wp_registered_sidebars ) !== TRUE ) {
		__return_false();
	}

	$sidebars = array(
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
				'templates/template-fullwidth.php',
			)
		),
		'sidebar-footer' => new Cherry_Sidebar(
			array(
				'is_404',
			)
		),
	);

	return apply_filters( 'cherry_display_sidebar', $sidebars[ $id ]->display, $id );
}

/**
 * Output classes for Primary column.
 *
 * @since 4.0.0
 *
 * @return string Classes name
 */
function cherry_content_class() {
	if ( cherry_display_sidebar( 'sidebar-main' ) ) {
		$class = 'col-sm-8';
	} else {
		$class = 'col-sm-12';
	}
	return apply_filters( 'cherry_content_class', $class );
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