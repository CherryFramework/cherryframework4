<?php

add_action( 'admin_enqueue_scripts', 'cherry_register_admin_scripts', 0);

function cherry_register_admin_scripts(){
	wp_register_script( 'interface-bilder', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/js/interface-bilder.js' ), array( 'jquery' ), '1.0', true );
}