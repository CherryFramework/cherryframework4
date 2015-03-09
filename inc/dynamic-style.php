<?php
/**
 * Dynamic CSS template
 *
 * @package    Cherry_Framework
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

$cherry_css_vars = cherry_get_css_varaibles();

?>
a {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
a:hover {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-primary' ), 20 ); ?>;
}