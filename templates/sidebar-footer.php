<?php
/**
 * The Sidebar located in the footer of the site.
 *
 * @package Cherry Framework
 */
?>
	<!-- Subsidiary column -->
	<?php do_action( 'cherry_sidebar_footer_before' ); ?>

	<div <?php cherry_attr( 'sidebar', 'subsidiary' ); ?>>

		<?php do_action( 'cherry_sidebar_footer_start' ); ?>

			<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>

				<?php dynamic_sidebar( 'sidebar-footer' ); ?>

			<?php else : ?>

				<?php do_action( 'cherry_sidebar_footer_empty' ); ?>

		<?php endif; ?>

		<?php do_action( 'cherry_sidebar_footer_end' ); ?>

	</div>

	<?php do_action( 'cherry_sidebar_footer_after' ); ?>