<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Cherry Framework
 */
?>
	<!-- Secondary column -->
	<div id="secondary" class="widget-area <?php cherry_sidebar_class(); ?>" role="complementary">
		<?php if ( ! dynamic_sidebar( 'main-sidebar' ) ) : ?>

			<!-- Search widget -->
			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<!-- Archives widget -->
			<aside id="archives" class="widget widget_archives">
				<h1 class="widget-title"><?php _e( 'Archives', 'cherry' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<!-- Meta widget -->
			<aside id="meta" class="widget widget_meta">
				<h1 class="widget-title"><?php _e( 'Meta', 'cherry' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div>
