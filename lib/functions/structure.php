<?php
// Header structure.
add_action( 'cherry_header_before', 'cherry_header_wrap', 999 );
add_action( 'cherry_header_after',  'cherry_header_wrap', 0 );
add_action( 'cherry_header',        'cherry_header_logo', 1 );
add_action( 'cherry_header',        'cherry_header_nav',  9 );

// Footer structure.
add_action( 'cherry_footer_before', 'cherry_footer_wrap', 999 );
add_action( 'cherry_footer_after',  'cherry_footer_wrap', 0 );
add_action( 'cherry_footer',        'cherry_footer_info', 1 );

/**
 * Output Header Wrap.
 *
 * @since 4.0.0
 */
function cherry_header_wrap() {
	$output = "";
	if ( !did_action( 'cherry_header') ) {
		$output .= "<header " . cherry_get_attr( 'header' ) . ">\n";
			$output .= "<div class='container'>\n";
	} else {
			$output .= "</div>\n";
		$output .= "</header>\n";
	}

	echo $output;
}

/**
 * Output Header Logo.
 *
 * @since 4.0.0
 */
function cherry_header_logo() {
	$output = "<!-- Branding -->\n";
	$output .= "<div class='site-branding'>\n";
		$output .= cherry_get_site_title();
		$output .= cherry_get_site_description();
	$output .= "</div>\n";

	echo $output;
}

/**
 * Output Header Menu.
 *
 * @since 4.0.0
 */
function cherry_header_nav() {
	if ( has_nav_menu( 'header' ) ) {
		echo "<!-- Navigation -->\n";

		// http://codex.wordpress.org/Function_Reference/wp_nav_menu
		$args = array(
					'theme_location' => 'header',
					'container'      => '',
					'menu_class'     => 'sf-menu',
					'items_wrap'     => '<nav ' . cherry_get_attr( 'menu', 'navigation' ) . '><ul id="%s" class="%s">%s</ul></nav>',
				);
		wp_nav_menu( apply_filters( 'cherry_header_nav_args', $args ) );
	}
}

/**
 * Output Footer Wrap.
 *
 * @since 4.0.0
 */
function cherry_footer_wrap() {
	if ( !did_action( 'cherry_footer') ) {
		$output = "<footer " . cherry_get_attr( 'footer' ) . ">\n";
			$output .= "<div class='container'>\n";
	} else {
			$output = "</div>\n";
		$output .= "</footer>\n";
	}

	echo $output;
}

/**
 * Output Footer Info.
 *
 * @since 4.0.0
 */
function cherry_footer_info() {
	$output = "<div class='site-info'>";
	$output .= sprintf(
					__( 'Copyright &copy; %1$s %2$s. Powered by %3$s and %4$s.', 'cherry' ),
					date_i18n( 'Y' ), cherry_get_site_link(), cherry_get_wp_link(), cherry_get_theme_link()
				);
	$output .= "</div>";

	echo $output;
}