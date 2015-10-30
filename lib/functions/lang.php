<?php
/**
 * Internationalization and translation functions.
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
 * Gets the parent theme textdomain. This allows the framework to recognize the proper textdomain of the
 * parent theme.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @global object $cherry
 * @return string $cherry->textdomain The textdomain of the theme.
 */
function cherry_get_parent_textdomain() {
	global $cherry;

	// If the global textdomain isn't set, define it. Plugin/theme authors may also define a custom textdomain.
	if ( empty( $cherry->parent_textdomain ) ) {

		$theme      = wp_get_theme( get_template() );
		$textdomain = $theme->get( 'TextDomain' ) ? $theme->get( 'TextDomain' ) : get_template();

		$cherry->parent_textdomain = sanitize_key( apply_filters( 'cherry_parent_textdomain', $textdomain ) );
	}

	// Return the expected textdomain of the parent theme.
	return $cherry->parent_textdomain;
}

/**
 * Gets the child theme textdomain. This allows the framework to recognize the proper textdomain of the
 * child theme.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 * @global object $cherry
 * @return string $cherry->child_theme_textdomain The textdomain of the child theme.
 */
function cherry_get_child_textdomain() {
	global $cherry;

	// If a child theme isn't active, return an empty string.
	if ( ! is_child_theme() ) {
		return '';
	}

	// If the global textdomain isn't set, define it. Plugin/theme authors may also define a custom textdomain.
	if ( empty( $cherry->child_textdomain ) ) {

		$theme      = wp_get_theme();
		$textdomain = $theme->get( 'TextDomain' ) ? $theme->get( 'TextDomain' ) : get_stylesheet();

		$cherry->child_textdomain = sanitize_key( apply_filters( 'cherry_child_textdomain', $textdomain ) );
	}

	// Return the expected textdomain of the child theme.
	return $cherry->child_textdomain;
}
