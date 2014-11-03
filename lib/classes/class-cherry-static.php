<?php

class Cherry_Static {

	public function __construct() {}

	/**
	 * Prints HTML with Header Logo.
	 *
	 * @since 4.0.0
	 */
	public static function logo( $options ) {

		if ( cherry_get_site_title() || cherry_get_site_description() ) {

			printf( '<div class="site-branding %1$s">%2$s %3$s</div>',
				esc_attr( $options['class'] ),
				cherry_get_site_title(),
				cherry_get_site_description()
			);

		}
	}

	/**
	 * Prints HTML with Primary Menu.
	 *
	 * @since 4.0.0
	 */
	public static function mainmenu() {
		cherry_get_menu_template( 'primary' );
	}

	/**
	 * Prints HTML with Search Form.
	 *
	 * @since 4.0.0
	 */
	public static function searchform() {
		get_search_form( true );
	}

}
new Cherry_Static;