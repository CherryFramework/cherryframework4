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
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Display the link back to the site.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return void
 */
function cherry_site_link() {
	echo cherry_get_site_link();
}

/**
 * Retrieve the link back to the site.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @since  4.0.5  Add a filter `cherry_site_link_format`.
 * @param  string $class optional CSS class added to site-link
 * @return string
 */
function cherry_get_site_link( $class = 'site-link' ) {
	$title = get_bloginfo( 'name' );

	if ( ! $title ) {
		return false;
	}

	$class = esc_attr( $class );

	if ( ! $class ) {
		$class = 'site-link';
	}

	/**
	 * Filter the link format to the site.
	 *
	 * @since 4.0.5
	 * @param string $format Link format.
	 * @param string $class  CSS-class.
	 * @param string $url    Link URL.
	 * @param string $title  Site title.
	 */
	$format = apply_filters( 'cherry_site_link_format',
		'<a class="%s" href="%s" rel="home">%s</a>',
		$class,
		esc_url( home_url( '/' ) ),
		$title
	);

	return sprintf( $format, $class, esc_url( home_url( '/' ) ), $title );
}

/**
 * Display a link to WordPress.org.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return void
 */
function cherry_wp_link() {
	echo cherry_get_wp_link();
}

/**
 * Return a link to WordPress.org.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @since  4.0.5  Add a filter `cherry_wp_link_format`.
 * @return string
 */
function cherry_get_wp_link() {
	/**
	 * Filter a link format to the WordPress.org.
	 *
	 * @since 4.0.5
	 * @param string $format Link format.
	 * @param string $url    Link URL.
	 * @param string $text   Link text.
	 */
	$format = apply_filters( 'cherry_wp_link_format',
		'<a class="wp-link" href="%s" rel="nofollow">%s</a>',
		esc_url( __( 'https://wordpress.org/', 'cherry' ) ),
		esc_html__( 'WordPress', 'cherry' )
	);

	return sprintf( $format,
		esc_url( __( 'https://wordpress.org/', 'cherry' ) ),
		esc_html__( 'WordPress', 'cherry' )
	);
}

/**
 * Display a link to the parent theme URI.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return void
 */
function cherry_theme_link() {
	echo cherry_get_theme_link();
}

/**
 * Return a link to the parent theme URI.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @since  4.0.5  Add a filter `cherry_theme_link_format`.
 * @return string
 */
function cherry_get_theme_link() {
	$allowed = array( 'abbr' => array( 'title' => true ), 'acronym' => array( 'title' => true ), 'code' => true, 'em' => true, 'strong' => true );

	$theme = wp_get_theme( get_template() );
	$uri   = $theme->get( 'ThemeURI' );
	$name  = wp_kses( $theme->display( 'Name' ), $allowed );
	$title = sprintf( __( '%s WordPress Theme', 'cherry' ), $name );

	/**
	 * Filter a link format to the parent theme URI.
	 *
	 * @since 4.0.5
	 * @param string $format Link format.
	 * @param string $url    Link URL.
	 * @param string $title  Title attribute.
	 * @param string $name   Link text
	 */
	$format = apply_filters( 'cherry_theme_link_format',
		'<a class="theme-link" href="%s" title="%s" rel="nofollow">%s</a>',
		esc_url( $uri ),
		esc_attr( $title ),
		$name
	);

	return sprintf( $format, esc_url( $uri ), esc_attr( $title ), $name );
}

/**
 * Retrieve a link HTML by page slug.
 *
 * @since 4.0.0
 * @since 4.0.5  Add a filter `cherry_get_link_by_slug_format`.
 * @param string $slug Page slug.
 */
function cherry_get_link_by_slug( $slug = null ) {

	if ( ! $slug || ! is_string( $slug ) ) {
		return;
	}

	$page = get_page_by_path( $slug );

	if ( ! $page ) {
		return;
	}

	$url   = get_permalink( $page->ID );
	$title = $page->post_title;

	/**
	 * Filter the link format to the parent theme URI.
	 *
	 * @since 4.0.5
	 * @param string $format Link format.
	 * @param string $url    Link URL.
	 * @param string $title  Link text.
	 */
	$format = apply_filters( 'cherry_get_link_by_slug_format',
		'<a href="%s">%s</a>',
		esc_url( $url ),
		esc_html( $title )
	);

	return sprintf( $format, esc_url( $url ), esc_html( $title ) );
}

/**
 * Display the site logo.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return void
 */
function cherry_site_logo() {
	echo cherry_get_site_title();
}

/**
 * Retrieve the linked site logo wrapped in a HTML-tag.
 *
 * @since  4.0.0
 * @return string
 */
function cherry_get_site_logo( $location = 'header' ) {
	$logo_class = array();

	switch ( $location ) {
		case 'header':
			$type         = cherry_get_option( 'logo-type', 'text' );
			$logo_img_ids = cherry_get_option( 'logo-image-path', false );
			$tag          = is_front_page() ? 'h1' : 'h2';
			$logo_class[] = 'site-title';
			$logo_class[] = $type . '-logo';
			$link_class   = '';
			break;

		case 'footer':
			$type         = cherry_get_option( 'footer-logo-type', 'text' );
			$logo_img_ids = cherry_get_option( 'footer-logo-image-path', false );
			$tag          = 'div';
			$logo_class[] = 'cherry-footer-logo';
			$logo_class[] = $type . '-logo';
			$link_class   = 'footer-logo-link';
			break;

		default:
			$tag          = 'div';
			$logo_class[] = $location . '-logo';
			$link_class   = '';
			break;
	}

	/**
	 * Filter a CSS-classes for logo.
	 *
	 * @since 4.0.0
	 * @param array  $logo_class Set of CSS-classes.
	 * @param string $location   Logo location.
	 */
	$logo_class = apply_filters( 'cherry_logo_classes', $logo_class, $location );
	$logo_class = array_unique( $logo_class );
	$logo_class = array_map( 'sanitize_html_class', $logo_class );

	if ( 'image' == $type && false != $logo_img_ids ) {

		$images = explode( ',', $logo_img_ids );

		if ( count( $images ) > 1 ) {
			$logo_content = cherry_get_retina_logo( $images );
		} else {

			$img = wp_get_attachment_url( $images[0] );

			/**
			 * Filter a format for image logo.
			 *
			 * @since 4.0.0
			 * @param array  $format   Logo format (image).
			 * @param string $location Logo location.
			 */
			$logo_image_format = apply_filters(
				'cherry_logo_image_format',
				'<a href="%1$s" rel="home"><img src="%2$s" alt="%3$s"></a>',
				$location
			);

			$logo_content = sprintf( $logo_image_format, home_url( '/' ), esc_url( $img ), get_bloginfo( 'title' ) );
		}

	} else {
		$logo_content = cherry_get_site_link( $link_class );
	}

	$logo = $logo_content ? sprintf( '<%3$s class="%1$s">%2$s</%3$s>', join( ' ', $logo_class ), $logo_content, $tag ) : '';

	/**
	 * Filter the linked site logo wrapped in a HTML-tag.
	 *
	 * @since 4.0.0
	 * @param string $logo     HTML-formatted logo.
	 * @param string $location Logo location.
	 */
	return apply_filters( 'cherry_get_site_logo', $logo, $location );
}

/**
 * Retrieve a image logo with retina ready `<img>` tag.
 *
 * @since  4.0.0
 * @param  array  $images Logo images array - default and 2x for retina.
 * @return string         Logo HTML-markup.
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

	/**
	 * Filter the HTML-markup for image logo.
	 *
	 * @since 4.0.0
	 * @param string $logo_format Logo format.
	 */
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
 * Display the site description.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @return void
 */
function cherry_site_description() {
	echo cherry_get_site_description();
}

/**
 * Return the site description wrapped in an '<div>' tag.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @since  4.0.5 Add a filter `cherry_site_description_format`.
 * @return string
 */
function cherry_get_site_description() {
	$desc = get_bloginfo( 'description' );

	if ( ! empty( $desc ) ) {

		/**
		 * Filter the site description format.
		 *
		 * @since 4.0.5
		 * @param string $format Format.
		 * @param string $class  CSS-class.
		 * @param string $desc   Text.
		 */
		$format = apply_filters( 'cherry_site_description_format',
			'<div class="%s">%s</div>',
			'site-description',
			$desc
		);

		$desc = sprintf( '<div class="%s">%s</div>', 'site-description', $desc );
	}

	/**
	 * Filter the site description.
	 *
	 * @since 4.0.5
	 * @param string $desc Description.
	 */
	return apply_filters( 'cherry_get_site_description', $desc );
}

/**
 * Get favicons from theme options.
 *
 * @since  4.0.0
 * @return string
 */
function cherry_get_favicon_tags() {
	/**
	 * Filter the favicons before it is retrieved.
	 *
	 * @since 4.0.0
	 * @param bool|mixed $result Value to return instead of the favicon.
	 *                           Default false to skip it.
	 */
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
			'sizes' => false,
		),
	);

	$favicons = explode( ',', $favicons );
	$count    = count( $favicons );

	if ( 1 <= $count ) {
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 57,
		);
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 72,
		);
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 114,
		);
		$icons[] = array(
			'type'  => false,
			'rel'   => 'apple-touch-icon-precomposed',
			'sizes' => 144,
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
 * Display a favicons tags.
 *
 * @since 4.0.0
 */
function cherry_favicon_tags() {
	echo cherry_get_favicon_tags();
}
