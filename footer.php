<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Cherry Framework
 */
?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<?php dynamic_sidebar( 'footer' ); ?>
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'cherry' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'cherry' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'cherry' ), 'Cherry Framework', '<a href="http://www.cherryframework.com" rel="designer">Cherry Team</a>' ); ?>
				</div><!-- .site-info -->
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>