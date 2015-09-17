<?php
/**
 * The template for displaying theme header.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php wp_head(); ?>
</head>
<body <?php cherry_attr( 'body' ); ?>>

	<?php do_action( 'cherry_body_start' ); ?>

	<div id="site-wrapper" class="hfeed site">

		<?php do_action( 'cherry_header_before' ); ?>

		<?php do_action( 'cherry_header' ); ?>

		<?php do_action( 'cherry_header_after' ); ?>