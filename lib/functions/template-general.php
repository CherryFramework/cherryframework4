<?php
/**
 * General template functions. These functions are for use throughout the theme's various template files.
 * Their main purpose is to handle many of the template tags that are currently lacking in core WordPress.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Outputs the link back to the site.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @param  string $class optional CSS class added to site-link
 * @return string
 */
function cherry_get_site_link( $class = 'site-link' ) {

	$class = esc_attr( $class );
	if ( ! $class ) {
		$class = 'site-link';
	}

	$title = get_bloginfo( 'name' );
	if ( !$title ) {
		return false;
	}
	return sprintf( '<a class="%s" href="%s" rel="home">%s</a>', $class, esc_url( home_url( '/' ) ), $title );
}

/**
 * Displays a link to WordPress.org.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return string
 */
function cherry_get_wp_link() {
	return sprintf(
		'<a class="wp-link" href="%s" rel="nofollow">%s</a>',
		__( 'http://wordpress.org/', 'cherry' ), 'WordPress'
	);
}

/**
 * Displays a link to the parent theme URI.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
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
 * Get link HTML by page slug
 *
 * @since 4.0.0
 *
 * @param string $slug page slug
 */
function cherry_get_link_by_slug( $slug = null ) {

	if ( ! $slug || ! is_string( $slug ) ) {
		return;
	}

	$page = get_page_by_path( $slug );

	if ( ! $page ) {
		return;
	}

	$format = '<a href="%s">%s</a>';
	$result = sprintf( $format, get_permalink( $page->ID ), $page->post_title );

	return $result;

}

/**
 * Outputs the site logo.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
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

			$logo_content = sprintf( $logo_image_format, home_url( '/' ), esc_url( $img ), get_bloginfo( 'title' ) );
		}

	} else {
		$logo_content = cherry_get_site_link();
	}

	$tag = is_front_page() ? 'h1' : 'h2';

	$logo = $logo_content ? sprintf( '<%3$s class="%1$s">%2$s</%3$s>', 'site-title', $logo_content, $tag ) : '';

	return apply_filters( 'cherry_get_site_logo', $logo );
}

/**
 * Returns the linked site footer logo
 *
 * @since  4.0.0
 * @return string
 */
function cherry_get_footer_logo() {

	$logo_img = cherry_get_option( 'logo-footer', false );

	if ( ! $logo_img ) {
		return;
	}

	$images = explode( ',', $logo_img );

	if ( count( $images ) > 1 ) {
		$logo_content = cherry_get_retina_logo( $images );
	} else {
		$img = wp_get_attachment_url( $images[0] );
		$logo_image_format = '<a href="%1$s" rel="home"><img src="%2$s" alt="%3$s"></a>';
		$logo_content = sprintf( $logo_image_format, home_url( '/' ), esc_url( $img ), get_bloginfo( 'title' ) );
	}

	return sprintf( '<div class="cherry-footer-logo">%s</div>', $logo_content );

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

		if ( ! wp_attachment_is_image( $images[$i] ) ) {
			continue;
		}

		$img = wp_get_attachment_image_src( $images[$i], 'full' );

		if ( ! is_array( $img ) ) {
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
		home_url( '/' ), esc_url( $img1x ), esc_url( $img2x ), get_bloginfo( 'title' ), $width1x, $height1x
	);

	return $logo_content;

}

/**
 * Outputs the site description.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
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
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return string
 */
function cherry_get_site_description() {

	if ( $desc = get_bloginfo( 'description' ) ) {
		$desc = sprintf( '<div class="%s">%s</div>', 'site-description', $desc );
	}

	return apply_filters( 'cherry_get_site_description', $desc );
}

/**
 * Get favicons from theme options
 *
 * @since 4.0.0
 */
function cherry_get_favicon_tags() {

	$result = apply_filters( 'cherry_pre_get_favicon_tags', false );

	if ( false != $result ) {
		return $result;
	}

	$favicons = cherry_get_option( 'general-favicon' );

	$default_format = '<link type="%1$s" href="%3$s" rel="%2$s">';
	$device_format  = '<link href="%3$s" sizes="%2$sx%2$s" rel="%1$s">';

	if ( ! $favicons ) {
		return false;
	}

	$icons = array(
		array(
			'type'  => 'image/x-icon',
			'rel'   => 'shortcut icon',
			'sizes' => false
		)
	);

	$favicons = explode( ',', $favicons );
	$count    = count( $favicons );

	if ( 1 <= $count ) {
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 57
		);
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 72
		);
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 114
		);
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 144
		);
	}

	$icon1x  = null;
	$icon2x  = null;
	$width1x = 0;
	$width2x = 0;
	$count   = ( 2 > $count ) ? $count : 2;

	for ( $i = 0; $i < $count; $i++ ) {

		if ( ! wp_attachment_is_image( $favicons[$i] ) ) {
			continue;
		}

		$type = get_post_mime_type( $favicons[$i] );

		if ( 'image/x-icon' == $type ) {
			$icon1x = $icon2x = wp_get_attachment_url( $favicons[$i] );
			break;
		}

		$icon = wp_get_attachment_image_src( $favicons[$i] );

		if ( ! is_array( $icon ) ) {
			continue;
		}

		$icon_url   = $icon[0];
		$icon_width = intval( $icon[1] );

		if ( null == $icon1x ) {

			$icon1x  = $icon_url;
			$icon2x  = $icon_url;
			$width1x = $icon_width;
			$width2x = $icon_width;

		} elseif ( $icon_width > $width1x ) {

			$icon2x  = $icon_url;
			$width2x = $icon_width;

		} else {

			$icon1x  = $icon_url;
			$width1x = $icon_width;
		}

	}

	$result = '';

	foreach ( $icons as $icon_data ) {

		if ( ! $icon_data['sizes'] ) {
			$result .= sprintf( $default_format, $icon_data['type'], $icon_data['rel'], $icon1x );
			continue;
		}

		$result .= sprintf( $device_format, $icon_data['rel'], $icon_data['sizes'], $icon2x );

	}

	return $result;

}

/**
 * Print favicons tags
 *
 * @since 4.0.0
 */
function cherry_favicon_tags() {
	echo cherry_get_favicon_tags();
}