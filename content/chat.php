<!-- Post entry view -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

		<!-- Entry header -->
		<header class="entry-header">
			<h1 class="entry-title"><?php single_post_title(); ?></h1>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php cherry_posted_on(); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if ( has_excerpt() ) : // If the post has an excerpt. ?>

			<!-- Entry summary -->
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>

		<?php endif; ?>

		<!-- Entry content -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'cherry' ),
					'after'  => '</div>',
				) );
			?>
		</div>

		<!-- Entry footer -->
		<footer class="entry-meta">
			<?php
				/* translators: used between list items, there is a space after the comma */
				$category_list = get_the_category_list( __( ', ', 'cherry' ) );

				/* translators: used between list items, there is a space after the comma */
				$tag_list = get_the_tag_list( '', __( ', ', 'cherry' ) );

				if ( ! cherry_categorized_blog() ) {
					// This blog only has 1 category so we just need to worry about tags in the meta text
					if ( '' != $tag_list ) {
						$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cherry' );
					} else {
						$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cherry' );
					}

				} else {
					// But this blog has loads of categories so we should probably display them here
					if ( '' != $tag_list ) {
						$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cherry' );
					} else {
						$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cherry' );
					}

				} // end check for categories on this blog

				printf(
					$meta_text,
					$category_list,
					$tag_list,
					get_permalink()
				);
			?>

			<?php edit_post_link( __( 'Edit', 'cherry' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>

	<?php else : // If not viewing a single post. ?>

		<!-- Entry header -->
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php cherry_posted_on(); ?>
				</div>
			<?php endif; ?>
		</header>

		<!-- Entry summary -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

	<?php endif; ?>

</article>