<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Cherry Framework
 */
?>
		<footer id="footer" class="site-footer" role="contentinfo">
			<div class="container">

				<?php dynamic_sidebar( 'footer' ); ?>

				<!-- Site info -->
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'cherry' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'cherry' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'cherry' ), 'Cherry Framework', '<a href="http://www.cherryframework.com" rel="designer">Cherry Team</a>' ); ?>
				</div>
			</div>
		</footer>

	</div>

<?php wp_footer(); ?>

</body>
</html>