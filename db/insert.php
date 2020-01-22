<?php

/* stores the form data (no params) */
function wptournreg_insert_data() {
	
	require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
	$scheme = wptournreg_get_field_list();
	
	global $wpdb;
	$data = [];
	$fields = [];
	
	foreach( $_POST as $field => $value ) {
		
		if ( $field == 'id' || $field == 'time' ) { continue; }
		
		if ( array_key_exists( $field, $scheme ) ) {
				
			if ( preg_match( '/char|string|text/i', $scheme[ $field ] ) ) {
				
				$prepared = "'" . $wpdb->_real_escape( $value ) . "'";
			}
			else if ( preg_match( '/bool|int\(1\)/i', $scheme[ $field ] ) ) {
				
				$prepared = 'TRUE';
			}
			else if ( preg_match( '/int\(/i', $scheme[ $field ] ) ) {
				
				$prepared = ( is_int( $value ) ) ? $value : 'NULL'
				;
			}
			else {
				
				$prepared = $wpdb->_real_escape( $value );
			}
			
			array_push( $fields, $field );
		    array_push( $data, $prepared );
		}
	}
	
	array_push( $fields, 'time' );
	array_push( $data, time() );
	
	$wpdb->query( 'INSERT INTO ' . WP_TOURNREG_DATA_TABLE . '(' . implode( ', ', $fields ) . ') VALUES (' . implode( ', ', $data ) . ');' );
}