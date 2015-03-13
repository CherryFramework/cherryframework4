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

$body_typography = $cherry_css_vars['typography-body-text'] ;

?>

body {
	color: <?php echo cherry_esc_value( $body_typography, 'color' ); ?>;
}

.cherry-btn-primary {
	background-color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
	color: <?php echo cherry_contrast_color( cherry_esc_value( $cherry_css_vars, 'color-primary' ) ); ?>;
	border: 2px solid <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-btn-primary:hover {
	background-color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-secondary' ); ?>;
	border: 2px solid <?php echo cherry_esc_value( $cherry_css_vars, 'color-secondary' ); ?>;
}
.cherry-btn-link{
	color: <?php echo cherry_contrast_color( cherry_esc_value( $cherry_css_vars, 'color-primary' ) ); ?>;
}
.cherry-btn-link:hover {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-secondary' ); ?>;
}
.cherry-btn-primary-light {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
	border: 2px solid <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-btn-primary-light:hover {
	background-color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-btn-gray {
	border: 2px solid <?php echo cherry_colors_lighten( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 54); ?>;
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-secondary' ); ?>;
}
.cherry-btn-gray:hover {
	background-color: <?php echo cherry_colors_lighten( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 54); ?>;
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-secondary' ); ?>;
}

.cherry-list-numbered-circle > li, .cherry-list-numbered-slash > li, .cherry-list-icons > li {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}

.cherry-list-numbered-circle > li::before {
	background-color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-list-numbered-circle > li:hover::before {
	background-color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}
.cherry-list-numbered-circle > li:hover {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}


.cherry-list-simple > li {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-list-simple > li::before {
	color: <?php echo cherry_colors_lighten( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 53.2); ?>;
}
.cherry-list-simple > li:hover {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}
.cherry-list-simple > li:hover::before {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}


.cherry-list-numbered-slash > li::before {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-list-numbered-slash > li:hover {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-list-numbered-slash > li:hover::before {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}


.cherry-list-icons > li {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}
.cherry-list-icons > li:hover {
	color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-list-icons > li i {
	color: <?php echo cherry_colors_lighten( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 53.2); ?>;
}
.cherry-list-icons > li:hover i {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}

.cherry-hr-primary{
	background-color: <?php echo cherry_esc_value( $cherry_css_vars, 'color-primary' ); ?>;
}
.cherry-hr-gray-lighter{
	background-color: <?php echo cherry_colors_lighten( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 53.2); ?>;
}
.cherry-hr-gray-dark{
	background-color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}





.help-block {
	color: <?php echo cherry_colors_lighten( cherry_esc_value( $body_typography, 'color' ), 20); ?>;
}
legend {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 20); ?>;
}
.cherry-highlight-grey {
	color: <?php echo cherry_colors_darken( cherry_esc_value( $cherry_css_vars, 'color-gray-variations' ), 13.2); ?>;
}
output {
	<?php echo cherry_esc_value( $cherry_css_vars, 'color-gray-variations' );?>
}