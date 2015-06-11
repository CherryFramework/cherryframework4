<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */
?>

<!-- 404 page view -->
<section class="error-404 not-found">

	<!-- Page header -->
	<header class="page-header">
		<h2 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'cherry' ); ?></h2>
	</header>

	<!-- Page content -->
	<div class="page-content">
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or use search.', 'cherry' ); ?></p>

		<?php get_search_form(); ?>

		<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

		<?php if ( cherry_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>

		<!-- Widget categories -->
		<div class="widget widget_categories">
			<h2 class="widget-title"><?php _e( 'Most Used Categories', 'cherry' ); ?></h2>
			<ul>
			<?php
				wp_list_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				) );
			?>
			</ul>
		</div>
		<?php endif; ?>

		<?php
			/* translators: %1$s: smiley */
			$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'cherry' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
		?>

		<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

	</div>
</section>