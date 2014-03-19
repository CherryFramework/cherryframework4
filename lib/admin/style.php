<?php

add_action( 'admin_enqueue_scripts', 'cherry_register_admin_style', 0);

function cherry_register_admin_style(){
	wp_register_style( 'interface-bilder', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/css/interface-bilder.css' ), false, '1.0');
}