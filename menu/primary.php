<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<!-- Primary navigation -->
	<nav <?php cherry_attr( 'menu', 'primary' ); ?>>

		<?php wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => '',
			'menu_id'        => 'menu-primary-items',
			'menu_class'     => 'menu-items simple-menu',
			'fallback_cb'    => '',
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		) ); ?>

	</nav>

<?php endif; // End check for menu. ?>