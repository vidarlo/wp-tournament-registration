<?php

function wptournreg_load_tablesort() {
	
	wp_register_script(
		'wptournregtablesorter', // $handle
		WP_TOURNREG_TBSORTJS_URL, // $url
		array( 'jquery' ), // $deps
		'2.31.2', // $ver
		true // $in_footer
	);
	
	wp_register_script(
		'wptournreg', // $handle
		WP_TOURNREG_JS_URL, // $url
		array( 'wptournregtablesorter' ), // $deps
		null, // $ver
		true // $in_footer
	);
		
	wp_register_style(
		'wptournregtablesorter', // $handle
		WP_TOURNREG_TBSORTCSS_URL, // $url
		array(), // $deps
		'2.31.2', // $ver
		false // $in_footer
	);
}

/* add  scripts and styles */  
add_action( 'wp_enqueue_scripts', 'wptournreg_load_tablesort', 9999 );
