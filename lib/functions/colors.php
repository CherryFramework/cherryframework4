<?php
/**
 * Functions for working with CSS colors
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Make passed color darken
 *
 * @since  4.0.0
 *
 * @param  string  $color  HEX or RGB(A) color value
 * @param  float   $darken darken percent (0-100)
 * @return string          processed color
 */
function cherry_colors_darken( $color, $darken = 0 ) {

	if ( ! $color ) {
		return false;
	}

	$prepared_data = cherry_prepare_color_mod( $color, $darken );

	if ( ! $prepared_data || ! is_array( $prepared_data ) ) {
		return false;
	}

	$r       = $prepared_data['r'];
	$g       = $prepared_data['g'];
	$b       = $prepared_data['b'];
	$a       = $prepared_data['a'];
	$percent = $prepared_data['percent'];

	// Calc darken vals
	$r = round( $r - 255*$percent, 0 );
	$g = round( $g - 255*$percent, 0 );
	$b = round( $b - 255*$percent, 0 );

	$r = $r < 0 ? 0 : $r;
	$g = $g < 0 ? 0 : $g;
	$b = $b < 0 ? 0 : $b;

	if ( false !== $a ) {
		return sprintf( 'rgba(%s,%s,%s,%s)', $r, $g, $b, $a );
	} else {
		return sprintf( 'rgb(%s,%s,%s)', $r, $g, $b );
	}

}

/**
 * Make passed color lighten
 *
 * @since  4.0.0
 *
 * @param  string  $color   HEX or RGB(A) color value
 * @param  float   $lighten lighten percent (0-100)
 * @return string           processed color
 */
function cherry_colors_lighten( $color, $lighten = 0 ) {

	if ( ! $color ) {
		return false;
	}

	$prepared_data = cherry_prepare_color_mod( $color, $lighten );

	if ( ! $prepared_data || ! is_array( $prepared_data ) ) {
		return false;
	}

	$r       = $prepared_data['r'];
	$g       = $prepared_data['g'];
	$b       = $prepared_data['b'];
	$a       = $prepared_data['a'];
	$percent = $prepared_data['percent'];

	// Calc lighten vals
	$r = round( $r + 255*$percent, 0 );
	$g = round( $g + 255*$percent, 0 );
	$b = round( $b + 255*$percent, 0 );

	$r = $r > 255 ? 255 : $r;
	$g = $g > 255 ? 255 : $g;
	$b = $b > 255 ? 255 : $b;

	if ( false !== $a ) {
		return sprintf( 'rgba(%s,%s,%s,%s)', $r, $g, $b, $a );
	} else {
		return sprintf( 'rgb(%s,%s,%s)', $r, $g, $b );
	}

}

/**
 * Select contast color for passed from 2 proposed.
 * 1st proposed color must be light - it will selected if passed color is dark,
 * 2nd selected if passed is light, so it must be darken
 *
 * @since  4.0.0
 *
 * @param  string $color     color to get contrast for
 * @param  string $if_dark   return this if we had dark color
 * @param  string $if_light  return this if we had light color
 * @return string
 */
function cherry_contrast_color( $color, $if_dark = '#ffffff', $if_light = '#000000' ) {

	if ( ! $color ) {
		return false;
	}

	$prepared_data = cherry_prepare_color_mod( $color, 100 );

	if ( ! $prepared_data || ! is_array( $prepared_data ) ) {
		return false;
	}

	$r = $prepared_data['r'];
	$g = $prepared_data['g'];
	$b = $prepared_data['b'];

	$luminance = 0.299 * $r + 0.587 * $g + 0.114 * $b;

	if ( $luminance >= 127 ) {
		return $if_light;
	} else {
		return $if_dark;
	}
}

/**
 * Prepare color to modify.
 * Bring passed color and change percent to array
 * with R, G, B color values, opacity (if provided)
 * and change percentage
 *
 * @since  4.0.0
 *
 * @param  string  $color   HEX or RGB(A) color value
 * @param  float   $percent modify percent (0-100)
 * @return array            prepared color and modify percent
 */
function cherry_prepare_color_mod( $color, $percent = 0 ) {

	$is_rgba = ( false !== strpos( $color, 'rgba' ) ) ? true : false;
	$is_rgb  = ( false !== strpos( $color, 'rgb' ) && false === $is_rgba ) ? true : false;
	$is_hex  = ( false === $is_rgba && false === $is_rgb ) ? true : false;

	$percent = round( (double)$percent / 100, 4 );

	if ( $is_hex && '#' == $color[0] ) {
		$color = substr( $color, 1 );
	}

	// prepare hex color
	if ( $is_hex && strlen( $color ) == 6 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( $is_hex && strlen( $color ) == 3 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} elseif ( $is_hex ) {
		return false;
	}

	if ( $is_hex ) {
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
	}

	$color = str_replace( ' ', '', $color );

	// prepare RGBA
	if ( $is_rgba ) {
		preg_match( '/rgba\((.*)\)/', $color, $matches );
		if ( ! is_array( $matches ) || empty( $matches[1] ) ) {
			return false;
		}
		list( $r, $g, $b, $a ) = explode( ',', $matches[1] );
	}

	// prepare RGB
	if ( $is_rgb ) {
		preg_match( '/rgb\((.*)\)/', $color, $matches );
		if ( ! is_array( $matches ) || empty( $matches[1] ) ) {
			return false;
		}
		list( $r, $g, $b ) = explode( ',', $matches[1] );
	}

	$result = array(
		'r'       => $r,
		'g'       => $g,
		'b'       => $b,
		'a'       => isset( $a ) ? $a : false,
		'percent' => $percent,
	);

	return $result;
}