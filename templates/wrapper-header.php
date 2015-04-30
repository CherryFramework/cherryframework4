<?php
	cherry_static_area( 'header-top' );
	cherry_static_area( 'header-bottom' );

	if ( is_front_page() ) {
		cherry_static_area( 'showcase-area' );
	}
?>