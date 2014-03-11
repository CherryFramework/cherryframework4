<?php get_header( cherry_template_base() ); ?>

<div id="content" class="site-content">
	<div class="container">
		<div class="row">

			<!-- Primary column -->
			<div id="primary" class="content-area col-sm-8">
				<main id="main" class="site-main" role="main">
					<?php include cherry_template_path(); ?>
				</main>
			</div>

			<?php get_sidebar( cherry_template_base() ); ?>

		</div>
	</div>
</div>

<?php get_footer( cherry_template_base() ); ?>