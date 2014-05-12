<?php get_header( cherry_template_base() ); ?>
<?php require_once( PARENT_DIR .'/lib/classes/class-scss-compiler.php' ); ?>
<div id="content" class="site-content">
	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php include cherry_template_path(); ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div>
</div><!-- #content -->

<?php get_footer( cherry_template_base() ); ?>