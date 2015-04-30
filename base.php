<?php cherry_get_header(); ?>

<div <?php cherry_attr( 'content' ); ?>>

	<?php cherry_get_content(); ?>

	<?php cherry_get_sidebar( 'main' ); ?>
	<?php cherry_get_sidebar( 'secondary' ); ?>

</div>

<?php cherry_get_footer(); ?>