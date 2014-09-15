<?php if ( has_nav_menu( 'secondary' ) ) : // Check if there's a menu assigned to the 'secondary' location. ?>

	<!-- Secondary navigation -->
	<nav <?php cherry_attr( 'menu', 'secondary' ); ?>>

		<?php wp_nav_menu( array(
			'theme_location' => 'secondary',
			'container'      => '',
			'menu_id'        => 'menu-secondary-items',
			'menu_class'     => 'menu-items',
			'fallback_cb'    => '',
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'          => 1,
		) ); ?>

	</nav>

<?php endif; // End check for menu. ?>