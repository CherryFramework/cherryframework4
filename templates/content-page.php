<?php
/**
 * The template for displaying page content in page.php
 *
 * @package Cherry Framework
 */
?>

<!-- Page entry view -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Entry header -->
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
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
</article>