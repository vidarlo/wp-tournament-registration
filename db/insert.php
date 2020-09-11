<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* stores the form data (no params) */
function wptournreg_insert_data() {
	
	require_once WP_TOURNREG_DATABASE_PATH . 'escape.php';
	require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
	$scheme = wptournreg_get_field_list();
	
	global $wpdb;
	$data = [];
	$fields = [];
	
	foreach( $_POST as $field => $value ) {
		
		if ( $field == 'id' || $field == 'time' || $field == 'cc' || $field == 'touched'|| $field == 'ip' ) { continue; }
		
		if ( array_key_exists( $field, $scheme ) ) {
				
			if ( preg_match( '/char|string|text/i', $scheme[ $field ] ) ) {
				
				$prepared = "'" . wptournreg_escape( $value ) . "'";
			}
			else if ( preg_match( '/bool|int\(1\)/i', $scheme[ $field ] ) ) {
				
				$prepared = 1;
			}
			else if ( preg_match( '/int\(/i', $scheme[ $field ] ) ) {
				
				$val = wptournreg_escape( $value );
				$prepared = (  preg_match( '/\d+/', $val ) ) ? intval( $val ) : 'NULL';
			}
			else {
				
				$prepared = wptournreg_escape( $value );
			}
			
			array_push( $fields, $field );
		    array_push( $data, $prepared );
		}
	}
	
	$fields[] = 'time';
	$data[] = time();
	$fields[] = 'ip';
	$data[] = "'" . $_SERVER[ 'REMOTE_ADDR' ] . "'";
	
	return $wpdb->query( 'INSERT INTO ' . WP_TOURNREG_DATA_TABLE . '(' . implode( ', ', $fields ) . ') VALUES (' . implode( ', ', $data ) . ');' );
}