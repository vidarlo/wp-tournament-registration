<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* stores the form data (no params) */
function wptournreg_escape( $value ) {
	
	global $wpdb;
	
	return $wpdb->_real_escape( trim( $value ) );
}