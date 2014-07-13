<?php

add_action( 'admin_enqueue_scripts', 'cherry_register_admin_scripts', 0);
add_action( 'admin_enqueue_scripts', 'cherry_enqueue_admin_scripts', 0);

function cherry_register_admin_scripts(){
	wp_register_script( 'cherry-select2', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/js/select2.js' ), array( 'jquery' ), '1.0', true );
	wp_register_script( 'interface-bilder', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/js/interface-bilder.js' ), array( 'jquery' ), '1.0', true );
	wp_register_script( 'cherry-admin-interface', esc_url( trailingslashit( CHERRY_URI ) . 'admin/assets/js/cherry-admin-interface.js' ), array( 'jquery' ), '1.0', true );
}

function cherry_enqueue_admin_scripts(){
	wp_enqueue_script( 'cherry-select2' );
	wp_enqueue_script( 'cherry-admin-interface' );
}