<?php
/**
 * Functions for working with CSS text
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2014, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

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
