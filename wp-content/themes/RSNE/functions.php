<?php

function blocks_init() {
	wp_enqueue_script('main-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
	wp_enqueue_style('main_styles', get_theme_file_uri('/build/style-index.css'));
	wp_enqueue_style('extra_styles', get_theme_file_uri('/build/style-index-rtl.css'));
	register_block_type( __DIR__ . "/build/header" );

	wp_localize_script('main-js', 'rsneData', array(
		'root_url' => get_site_url(),
		'nonce' => wp_create_nonce('wp_rest')
	));
	
}
add_action( 'init', 'blocks_init' );