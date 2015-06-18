<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */
?>

<!-- 404 page view -->
<section class="error-404 not-found">
	<div class="row">
		<div class="error-404-num col-md-6 col-sm-6 col-xs-12">
			<?php echo apply_filters( 'cherry_404_page_num', 404 ); ?>
		</div>
		<div class="error-404-body col-md-6 col-sm-6 col-xs-12">
			<!-- Page header -->
			<header class="page-header">
				<h2 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'cherry' ); ?></h2>
			</header>
			<!-- Page content -->
			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or use search.', 'cherry' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</section>