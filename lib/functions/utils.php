<?php
/**
 * Utils Functions
 * Enqueue util scripts, CSS util functions
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

// Load Cherry Framework scripts.
add_action( 'wp_enqueue_scripts', 'cherry_enqueue_utility_scripts' );

/**
 * Enqueue utility scripts
 * @since  4.0.0
 */
function cherry_enqueue_utility_scripts() {
	global $is_chrome;

	$cherry_url = trailingslashit( CHERRY_URI );

	if ( 'false' != cherry_get_option( 'general-smoothscroll' ) ) {
		wp_register_script(
			'jquery-easing',
			esc_url( $cherry_url . 'assets/js/jquery.easing.1.3.min.js' ),
			array( 'jquery' ),
			'3.1.0',
			true
		);
		wp_register_script(
			'jquery-smoothscroll',
			esc_url( $cherry_url . 'assets/js/jquery.smoothscroll.js' ),
			array( 'jquery', 'jquery-easing' ),
			'3.0.6',
			true
		);

		if ( !wp_is_mobile() && $is_chrome ){
			wp_enqueue_script( 'jquery-smoothscroll' );
		}
	}

	if ( 'false' != cherry_get_option( 'header-sticky' ) ) {
		wp_enqueue_script(
			'cherry-stick-up',
			esc_url( $cherry_url . 'assets/js/jquery.cherry.stickup.min.js' ),
			array( 'jquery' ),
			'1.0.0',
			true
		);
	}

	if ( 'false' != cherry_get_option( 'cookie-banner-visibility' )
		&& !( isset( $_COOKIE['cherry_cookie_banner'] ) && '1' == $_COOKIE['cherry_cookie_banner'] )
		) {
		wp_enqueue_script(
			'cherry-cookie-banner',
			esc_url( $cherry_url . 'assets/js/jquery.cherry.cookie.banner.js' ),
			array( 'jquery' ),
			CHERRY_VERSION,
			true
		);
		wp_localize_script(
			'cherry-cookie-banner', 'cookie_banner_args', array(
				'name'    => 'cherry_cookie_banner',
				'value'   => '1',
				'options' => array(
					'expires' => YEAR_IN_SECONDS,
					'path'    => ( defined( 'COOKIEPATH' ) ? COOKIEPATH : '/' ),
					'domain'  => ( defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '' ),
				),
			)
		);
	}

}

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

/**
 * Get background CSS by bg data from options and selector
 * If passed multiplie images - returns retina ready CSS
 *
 * @since  4.0.0
 *
 * @param  string $selector CSS selector to apply bg for
 * @param  array  $data     data-array from options
 * @return string
 */
function cherry_get_background_css( $selector, $data ) {

	if ( ! $selector ) {
		return;
	}

	if ( ! is_array( $data ) ) {
		return;
	}

	if ( empty( $data['image'] ) && empty( $data['color'] ) ) {
		return;
	}

	$standard_bg = cherry_prepare_background( $data );

	if ( empty( $data['image'] ) ) {
		$standard_bg .= 'background-image:none;';
		return $selector . '{' . $standard_bg . '}';
	}

	$images = explode( ',', $data['image'] );

	$property_format = "%s {background-image: url(%s);%s}";

	if ( 1 == count( $images ) && wp_attachment_is_image( $images[0] ) ) {

		$img    = wp_get_attachment_image_src( $images[0], 'full' );
		$result = sprintf( $property_format, $selector, $img[0], $standard_bg );

		return $result;
	}

	$img1x    = null;
	$img2x    = null;
	$width1x  = 0;
	$count    = 2;

	for ( $i = 0; $i < $count; $i++ ) {

		if ( ( !isset($images[$i]) ) || ( ! wp_attachment_is_image( $images[$i] ) ) ) {
			continue;
		}

		$img = wp_get_attachment_image_src( $images[$i], 'full' );

		if ( ! is_array( $img ) ) {
			continue;
		}

		$img_url    = $img[0];
		$img_width  = intval( $img[1] );

		if ( null == $img1x ) {
			$img1x   = $img_url;
			$img2x   = $img_url;
			$width1x = $img_width;
		} elseif ( $img_width > $width1x ) {
			$img2x = $img_url;
		} else {
			$img1x = $img_url;
		}

	}

	$bg1 = sprintf( $property_format, $selector, $img1x, $standard_bg );
	$bg2 = sprintf( $property_format, $selector, $img2x, '' );
	$result = $bg1 . ' @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {' . $bg2 . '}';

	return $result;

}

/**
 * Sanitizes a hex color. Always adds hash to color
 * use sanitize_hex_color if exist
 *
 * @since  4.0.0
 *
 * @param  string  $color  maybe HEX color
 * @return string|null     sanitized color
 */
function cherry_sanitize_hex_color( $color ) {

	$color = ltrim( $color, '#' );
	$color = '#' . $color;

	if ( '' === $color ) {
		return '';
	}

	if ( function_exists( 'sanitize_hex_color' ) ) {
		return sanitize_hex_color( $color );
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

/**
 * Implode background properties array into CSS string
 *
 * @since  4.0.0
 *
 * @param  array  $data  BG data array
 * @return string
 */
function cherry_prepare_background( $data ) {
	if ( ! is_array( $data ) ) {
		return;
	}

	unset( $data['image'] );

	$result = '';
	$format = 'background-%s:%s;';

	foreach ( $data as $prop => $value ) {

		if ( ! $value ) {
			continue;
		}

		switch ( $prop ) {
			case 'color':
				$value = cherry_sanitize_hex_color( $value );
				break;

			case 'position':
				$value = str_replace( '-', ' ', $value );
				break;
		}

		$result .= sprintf( $format, $prop, $value );
	}

	return $result;
}

/**
 * Implode typography data array from options into CSS string
 *
 * @since  4.0.0
 *
 * @param  array  $data  typography parameters array from options
 * @param  array  $mod   optional parameter - pass function name and arg to modify values inside typography array
 * @return string        font, letter-spacing, text-align, color CSS properties string
 */
function cherry_get_typography_css( $data, $mod = array() ) {

	if ( ! is_array( $data ) || empty( $data ) ) {
		return;
	}

	$defaults = array(
		'family'        => '',
		'style'         => '',
		'color'         => '',
		'size'          => '',
		'lineheight'    => '',
		'letterspacing' => '',
		'align'         => ''
	);

	$data = wp_parse_args( $data, $defaults );

	$result = array();

	if ( '' !== $data['letterspacing'] ) {
		$units = '0' != $data['letterspacing'] ? 'px' : '';
		$result[] = 'letter-spacing:' . $data['letterspacing'] . $units;
	}

	if ( 'notdefined' != $data['align'] ) {
		$result[] = 'text-align:' . $data['align'];
	}

	if ( '' != $data['color'] ) {
		$color = cherry_sanitize_hex_color( $data['color'] );

		if ( 1 < count( $mod ) && ( in_array( $mod[0], array( 'cherry_colors_lighten', 'cherry_colors_darken' ) ) ) ) {
			$color = $mod[0]( $color, $mod[1] );
		}

		$result[] = 'color:' . $color;
	}

	$ext_families = ! empty( $data['category'] ) ? ', ' . $data['category'] : ', sans-serif';

	$font_style  = false;
	$font_weight = false;
	$font_size   = $data['size'] . 'px';
	$line_height = $data['lineheight'] . 'px';
	$font_family = "'" . $data['family'] . "'" . $ext_families;

	preg_match( '/^(\d*)(\w*)/i', $data['style'], $matches );

	if ( is_array( $matches ) ) {
		$font_style  = ( 'regular' != $matches[2] ) ? $matches[2] : false;
		$font_weight = $matches[1];
	}

	$font = array(
		$font_style,
		$font_weight,
		$font_size . '/' . $line_height,
		$font_family
	);

	$font = implode( ' ', array_filter( $font ) );

	$result[] = 'font:' . ltrim($font);

	$result = implode( ';', $result ) . ';';

	return $result;
}

/**
 * Get box model CSS from layout editor option
 *
 * @since  4.0.0
 *
 * @param  array  $data  layout parameters array from options
 * @param  array  $mod   optional parameter - pass function name and arg to modify values inside layout array
 * @return string        indents, border etc.
 */
function cherry_get_box_model_css( $data, $mod = array() ) {

	if ( ! is_array( $data ) || empty( $data ) ) {
		return;
	}

	$defaults = array(
		'position'  => array(),
		'margin'    => array(),
		'border'    => array(),
		'padding'   => array(),
		'container' => array()
	);

	$box_defaults = array(
		'top'    => '',
		'right'  => '',
		'bottom' => '',
		'left'   => ''
	);

	$data = wp_parse_args( $data, $defaults );

	$result = '';

	// Prepare postion
	$data['position'] = array_filter( $data['position'] );
	if ( ! empty( $data['position'] ) ) {

		$data['position'] = array_intersect_key( $data['position'], $box_defaults );

		$parser_data = array(
			'prefix'  => '',
			'allowed' => $box_defaults
		);

		array_walk( $data['position'], 'cherry_prepare_box_item', $parser_data );

		$result .= implode( ';', array_filter( $data['position'] ) ) . ';';

	}

	// Prepare indents
	$result .= cherry_prepare_css_indents( $data['margin'], 'margin' );
	$result .= cherry_prepare_css_indents( $data['padding'], 'padding' );

	// Prepare borders
	if ( ! empty( $data['border'] ) ) {

		$border_style  = ! empty( $data['border']['style'] ) ? $data['border']['style'] : '';
		$border_color  = ! empty( $data['border']['color'] ) ? $data['border']['color'] : '';
		$border_radius = ! empty( $data['border']['radius'] ) ? $data['border']['radius'] : '';

		if ( '' != $border_radius ) {
			$result .= 'border-radius:' . $border_radius . ';';
		}

		$border_format = 'border-%1$s:%2$s %3$s %4$s;';

		foreach ( $data['border'] as $property => $value ) {

			if ( ! array_key_exists( $property, $box_defaults ) ) {
				continue;
			}

			if ( empty( $value ) ) {
				continue;
			}

			$result .= sprintf(
				$border_format,
				$property, $value, $border_style, $border_color
			);

		}

	}

	// Prepare dimensions
	if ( ! empty( $data['container']['width'] ) ) {
		$result .= 'width:' . $data['container']['width'] . ';';
	}
	if ( ! empty( $data['container']['height'] ) ) {
		$result .= 'height:' . $data['container']['height'] . ';';
	}

	return $result;
}

/**
 * Service function to grab CSS indents from data array into string
 *
 * @since  4.0.0
 *
 * @param  array        $data      data array
 * @param  CSS property $property  CSS property
 * @return string
 */
function cherry_prepare_css_indents( $data, $property ) {

	if ( empty( $data ) ) {
		return;
	}

	$box_defaults = array(
		'top'    => '',
		'right'  => '',
		'bottom' => '',
		'left'   => ''
	);

	$data = array_intersect_key( $data, $box_defaults );
	$data = array_filter( $data );

	if ( 4 == count( $data ) ) {
		$result = $property . ':' . implode( ' ', $data ) . ';';
		return $result;
	}

	$parser_data = array(
		'prefix'  => $property,
		'allowed' => $box_defaults
	);

	array_walk( $data, 'cherry_prepare_box_item', $parser_data );

	$result = implode( ';', array_filter( $data ) ) . ';';

	return $result;
}

/**
 * Service callback function for
 *
 * @since  4.0.0
 *
 * @param  string  $item  position value
 * @param  string  $key   position key
 * @param  array   $data  array of allowed positions and property prefix
 * @return bool
 */
function cherry_prepare_box_item( &$item, $key, $data ) {

	if ( ! array_key_exists( $key, $data['allowed'] ) ) {
		$item = false;
		return;
	}

	if ( empty( $item ) ) {
		$item = false;
		return;
	}

	$prefix = '';

	if ( ! empty( $data['prefix'] ) ) {
		$prefix = $data['prefix'] . '-';
	}

	$item = $prefix . $key . ':' . $item;

}

/**
 * Make float size
 *
 * @since  4.0.0
 *
 * @param
 * @param
 * @return
 */
function cherry_typography_size( $size, $operation = ' ', $func = 'round', $percent) {

	if ( ! $size ) {
		return false;
	}

	switch( $operation ) {
		case 'multiple':
			$size = (double)$size * (double)$percent;
		case 'addition':
			$size = (double)$size + (double)$percent;
	}

	switch( $func ) {
		case 'floor':
			$size = floor($size);
		case 'ceil':
			$size = ceil($size);
		case 'round':
			$size = round($size);
		case 'abs':
			$size = abs($size);
	}

	return $size;
}

function cherry_empty_value( $value, $rule) {

	if ('' == $value or 'notdefined' == $value) {
		return;
	}

	echo $rule . ": " . $value;

	if ( is_numeric( $value ) ) {
		echo "px; ";
	} else {
		echo"; ";
	}

}

/**
 * Set element emphasis
 *
 * @since  4.0.0
 *
 * @param  string $parent   parent selector
 * @param  string $color    color
 * @param  string $property to define
 */
function cherry_element_emphasis( $parent, $color, $property ) {

	$result  = $parent . ' {' . $property . ':' . $color . ';}';
	$result .= $parent . ':hover {' . $property . ':' . cherry_colors_darken( $color, 10 ) . ';}';

	return $result;
}

/**
 * Return width value for container.
 *
 * @since  4.0.0
 *
 * @param  int $container_width A container width value.
 * @param  int $element_width   Some-block (parent-block for container) width value.
 * @return int
 */
function cherry_container_width_compare( $container_width, $element_width ) {
	return ( $container_width > $element_width ) ? $element_width : $container_width;
}

/**
 * Retirieve CSS-rule only when site non-responsive.
 *
 * @since  4.0.0
 *
 * @param  string $style CSS-rule.
 * @return string
 */
function cherry_non_responsive_style( $style ) {
	return ( 'false' == cherry_get_option( 'grid-responsive' ) ) ? $style : '';
}

/**
 * Open `@media` rule.
 *
 * @since  4.0.0
 *
 * @param  string $function Media function
 * @return string
 */
function cherry_media_queries_open( $function ) {
	return ( 'true' == cherry_get_option( 'grid-responsive' ) ) ? '@media ( ' . $function . ' ) {' : '';
}

/**
 * Close `@media` rule.
 *
 * @since  4.0.0
 *
 * @return string
 */
function cherry_media_queries_close() {
	return ( 'true' == cherry_get_option( 'grid-responsive' ) ) ? '}' : '';
}