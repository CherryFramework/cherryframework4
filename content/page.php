<?php //var_dump('page.php');
/**
 * The template for displaying page content
 *
 * @package Cherry Framework
 */
?>

<!-- Page entry view -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_page() ) : // If viewing a single page. ?>

		<!-- Entry header -->
		<header class="entry-header">
			<h1 class="entry-title"><?php single_post_title(); ?></h1>
		</header>

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
		<?php edit_post_link( __( 'Edit', 'cherry' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

	<?php else : // If not viewing a single page. ?>

		<!-- Entry header -->
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>

		<!-- Entry summary -->
		<div class="entry-summary">
			<?php if ( has_excerpt() || is_search() ) {
				the_excerpt();
			} else {
				the_content();
			} ?>
		</div>

	<?php endif; ?>

</article>