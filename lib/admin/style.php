<?php

add_action( 'admin_enqueue_scripts', 'cherry_register_admin_style', 0);
add_action( 'admin_enqueue_scripts', 'cherry_enqueue_admin_style', 0);

function cherry_register_admin_style(){
	wp_register_style( 'cherry-select2', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/css/cherry-select2.css' ), false, '1.0');
	wp_register_style( 'interface-bilder', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/css/interface-bilder.css' ), false, '1.0');
	wp_register_style( 'cherry-admin-interface', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/css/cherry-admin-interface.css' ), false, '1.0');
}

function cherry_enqueue_admin_style(){
	wp_enqueue_style( 'cherry-select2' );
	wp_enqueue_style( 'cherry-admin-interface' );

}