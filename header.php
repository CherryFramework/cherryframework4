<?php
/**
 * The template for displaying theme header.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Cherry Framework
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'cherry_body_start' ); ?>
	<div id="site_wrapper" class="hfeed site">

		<?php
			do_action( 'cherry_header_before' );
			do_action( 'cherry_header' );
			do_action( 'cherry_header_after' );
		?>