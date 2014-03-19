<?php get_header( cherry_template_base() ); ?>

<div id="content" class="site-content">
	<div class="container">
		<div class="row">

			<!-- Primary column -->
			<div id="primary" class="content-area <?php cherry_content_class(); ?>">
				<main id="main" class="site-main" role="main">
					<h2><strong>col-lg </strong></h2>
						<div class="row">
							<div class="col-lg-2"><div class="innerWrap">lg2</div></div>
							<div class="col-lg-4"><div class="innerWrap">lg4</div></div>
							<div class="col-lg-2"><div class="innerWrap">lg2</div></div>
							<div class="col-lg-4"><div class="innerWrap">lg4</div></div>
						</div>
					<h2><strong>col-md </strong></h2>
						<div class="row">
							<div class="col-md-4"><div class="innerWrap">md4</div></div>
							<div class="col-md-4"><div class="innerWrap">md4</div></div>
							<div class="col-md-4"><div class="innerWrap">md4</div></div>
						</div>
					<h2><strong>col-sm</strong></h2>
						<div class="row">
							<div class="col-sm-4"><div class="innerWrap">sm4</div></div>
							<div class="col-sm-8"><div class="innerWrap">sm8</div></div>
						</div>
					<h2><strong>col-xs</strong></h2>
						<div class="row">
							<div class="col-xs-8"><div class="innerWrap">xs8</div></div>
							<div class="col-xs-4"><div class="innerWrap">xs4</div></div>
						</div>
					<h2><strong>col-lg col-md</strong></h2>
						<div class="row">
							<div class="col-lg-3 col-md-2"><div class="innerWrap">lg3 md2</div></div>
							<div class="col-lg-3 col-md-4"><div class="innerWrap">lg3 md4</div></div>
							<div class="col-lg-3 col-md-1"><div class="innerWrap">lg3 md1</div></div>
							<div class="col-lg-3 col-md-5"><div class="innerWrap">lg3 md5</div></div>
						</div>
					<h2><strong>col-md col-sm</strong></h2>
						<div class="row">
							<div class="col-md-4 col-sm-2"><div class="innerWrap">md4 sm2</div></div>
							<div class="col-md-4 col-sm-7"><div class="innerWrap">md4 sm7</div></div>
							<div class="col-md-4 col-sm-3"><div class="innerWrap">md4 sm3</div></div>
						</div>
					<h2><strong>col-md col-sm col-xs</strong></h2>
						<div class="row">
							<div class="col-md-3 col-sm-2 col-xs-6"><div class="innerWrap">md3 sm2 xs6</div></div>
							<div class="col-md-3 col-sm-4 col-xs-2"><div class="innerWrap">md3 sm4 xs2</div></div>
							<div class="col-md-3 col-sm-2 col-xs-2"><div class="innerWrap">md3 sm2 xs2</div></div>
							<div class="col-md-3 col-sm-4 col-xs-2"><div class="innerWrap">md3 sm4 xs2</div></div>
						</div>
					<h2><strong>col-sm col-sm-offset</strong></h2>
						<div class="row">
							<div class="col-sm-2 col-sm-offset-2"><div class="innerWrap">sm2-offset2</div></div>
							<div class="col-sm-4 col-sm-offset-2"><div class="innerWrap">sm4-offset2</div></div>
							<div class="col-sm-2"><div class="innerWrap">sm2</div></div>
						</div>
					<h2><strong>Nesting columns col-sm</strong></h2>
						<div class="row">
							<div class="col-sm-4">
								<div class="innerWrap">
									<div class="row">
										<div class="col-sm-6"><div class="innerWrapSub">sm6</div></div>
										<div class="col-sm-6"><div class="innerWrapSub">sm6</div></div>
									</div>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="innerWrap">
									<div class="row">
										<div class="col-sm-4"><div class="innerWrapSub">sm4</div></div>
										<div class="col-sm-4"><div class="innerWrapSub">sm4</div></div>
										<div class="col-sm-4"><div class="innerWrapSub">sm4</div></div>
									</div>
								</div>
							</div>
						</div>
				</main>
			</div>

			<?php if ( cherry_display_sidebar() ) {
				include cherry_sidebar_path();
			} ?>

		</div>
	</div>
</div>

<?php get_footer( cherry_template_base() ); ?>