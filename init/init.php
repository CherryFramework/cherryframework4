<?php
/**
 * Sets up custom confguration for the theme. This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 */
add_action( 'after_setup_theme', 'cherry_theme_config', 20 );

/**
 * Load necessary config parts
 *
 * @since 4.0.0
 */
function cherry_theme_config() {

	$config_statements = array(
		'thumbnails',
		'post-type-support',
		'menus',
		'sidebars',
		'display-sidebars',
		'static-areas',
		'statics'
	);

	// get from child theme disabled config statements array
	$disabled_statements = apply_filters( 'cherry_disable_config_statements', array() );

	$config_statements = array_diff( $config_statements, $disabled_statements );

	foreach ( $config_statements as $statement ) {
		cherry_require( PARENT_CONFIG_DIR . "$statement.php" );
	}

}

// Added class for Footer Sidebar widgets.
add_filter( 'cherry_sidebar_args', 'cherry_footer_sidebar_class' );

// Added wrap for Footer Sidebar widgets.
add_action( 'cherry_sidebar_footer_start', 'cherry_sidebar_footer_wrap_open' );
add_action( 'cherry_sidebar_footer_end', 'cherry_sidebar_footer_wrap_close' );

// Output classes for Secondary column.
// add_filter( 'cherry_attr_sidebar', 'cherry_sidebar_main_class', 10, 2 );

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