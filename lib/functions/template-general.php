<?php
/**
 * General template functions. These functions are for use throughout the theme's various template files.
 * Their main purpose is to handle many of the template tags that are currently lacking in core WordPress.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Outputs the link back to the site.
 *
 * @since  4.0.0
 *
 * @return void
 */
function cherry_site_link() {
	/**
	 * Filter the displayed the link to the site.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_site_link', cherry_get_site_link() );
}

/**
 * Returns a link back to the site.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_site_link() {

	if ( $title = get_bloginfo( 'name' ) ) {
		return sprintf( '<a class="site-link" href="%s" rel="home">%s</a>', esc_url( home_url() ), $title );
	}

}

/**
 * Displays a link to WordPress.org.
 *
 * @since  4.0.0
 *
 * @return void
 */
function cherry_wp_link() {
	/**
	 * Filter the displayed the link to the WordPress.org.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_wp_link', cherry_get_wp_link() );
}

/**
 * Returns a link to WordPress.org.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_wp_link() {
	return sprintf( '<a class="wp-link" href="http://wordpress.org/" rel="nofollow">%s</a>', 'WordPress' );
}

/**
 * Displays a link to the parent theme URI.
 *
 * @since  4.0.0
 *
 * @return void
 */
function cherry_theme_link() {
	/**
	 * Filter the displayed the link to the parent theme URI.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_theme_link', cherry_get_theme_link() );
}

/**
 * Returns a link to the parent theme URI.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_theme_link() {
	$theme = wp_get_theme( get_template() );
	$uri   = $theme->get( 'ThemeURI' );
	$name  = $theme->display( 'Name', false, true );
	$title = sprintf( __( '%s WordPress Theme', 'cherry' ), $name );

	return sprintf( '<a class="theme-link" href="%s" title="%s" rel="nofollow">%s</a>', esc_url( $uri ), esc_attr( $title ), $name );
}

/**
 * Outputs the site logo.
 *
 * @since  4.0.0
 *
 * @return void
 */
function cherry_site_logo() {
	/**
	 * Filter the displayed the site title.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_site_logo', cherry_get_site_title() );
}

/**
 * Returns the linked site logo wrapped in an '<h1>' tag.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_site_logo() {

	$type         = cherry_get_option( 'logo-type', 'text' );
	$logo_img_ids = cherry_get_option( 'logo-image-path', false );

	if ( 'image' == $type && false != $logo_img_ids ) {

		$images = explode( ',', $logo_img_ids );

		if ( count( $images ) > 1 ) {
			$logo_content = cherry_get_retina_logo( $images );
		} else {

			$img = wp_get_attachment_url( $images[0] );

			$logo_image_format = apply_filters(
				'cherry_logo_image_format',
				'<a href="%1$s" rel="home"><img src="%2$s" alt="%3$s"></a>'
			);

			$logo_content = sprintf( $logo_image_format, home_url(), esc_url( $img ), get_bloginfo( 'title' ) );
		}

	} else {
		$logo_content = cherry_get_site_link();
	}

	$tag = is_front_page() ? 'h1' : 'h2';

	$logo = sprintf( '<%3$s class="%1$s">%2$s</%3$s>', 'site-title', $logo_content, $tag );

	return apply_filters( 'cherry_get_site_logo', $logo );
}

/**
 * Get image logo with retina ready img tag
 *
 * @since  4.0.0
 *
 * @param  array  $images  logo images array - default and 2x for retina
 * @return string          logo html markup
 */
function cherry_get_retina_logo( $images ) {

	$img1x    = null;
	$img2x    = null;
	$width1x  = 0;
	$height1x = 0;

	$count    = 2;

	for ( $i = 0; $i < $count; $i++ ) {

		$img = wp_get_attachment_image_src( $images[$i], 'full' );

		if ( ! is_array( $img ) ) {
			$count++;
			continue;
		}

		$img_url    = $img[0];
		$img_width  = intval( $img[1] );
		$img_height = intval( $img[2] );

		if ( null == $img1x ) {

			$img1x    = $img_url;
			$img2x    = $img_url;
			$width1x  = $img_width;
			$height1x = $img_height;

		} elseif ( $img_width > $width1x ) {

			$img2x = $img_url;

		} else {

			$img1x    = $img_url;
			$width1x  = $img_width;
			$height1x = $img_height;
		}

	}

	$logo_format = apply_filters(
		'cherry_retina_logo_image_format',
		'<a href="%1$s" rel="home"><img src="%2$s" alt="%4$s" srcset="%3$s 2x" width="%5$s" height="%6$s"></a>'
	);

	$logo_content = sprintf(
		$logo_format,
		home_url(), esc_url( $img1x ), esc_url( $img2x ), get_bloginfo( 'title' ), $width1x, $height1x
	);

	return $logo_content;

}

/**
 * Outputs the site description.
 *
 * @since  4.0.0
 * @return void
 */
function cherry_site_description() {
	/**
	 * Filter the displayed the site description.
	 *
	 * @since 4.0.0
	 */
	echo apply_filters( 'cherry_site_description', cherry_get_site_description() );
}

/**
 * Returns the site description wrapped in an '<div>' tag.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_get_site_description() {

	if ( $desc = get_bloginfo( 'description' ) ) {
		$desc = sprintf( '<div class="%s">%s</div>', 'site-description', $desc );
	}

	return apply_filters( 'cherry_get_site_description', $desc );
}