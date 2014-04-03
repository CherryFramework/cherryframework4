<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Cherry Framework
 */
?>
	<!-- Secondary column -->
	<?php do_action( 'cherry_sidebar_main_before' ); ?>

	<div <?php cherry_attr( 'sidebar', 'secondary' ); ?>>

		<?php do_action( 'cherry_sidebar_main_start' ); ?>

			<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>

				<?php dynamic_sidebar( 'sidebar-main' ); ?>

			<?php else : ?>

				<?php do_action( 'cherry_sidebar_main_empty' ); ?>

		<?php endif; ?>

		<?php do_action( 'cherry_sidebar_main_end' ); ?>

	</div>

	<?php do_action( 'cherry_sidebar_main_after' ); ?>