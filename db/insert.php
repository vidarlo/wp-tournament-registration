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
		
		/*`no need for HTML in any field */
		$value = ( strip_tags( $value ) );
		
		if ( array_key_exists( $field, $scheme ) ) {
				
			if ( $field == 'email' ) {

				$prepared = "'" . wptournreg_escape( sanitize_email( $value ) ) . "'";
			}
			else if ( $field == 'message' ) {
				
				$prepared = "'" . wptournreg_escape( sanitize_textarea_field( $value ) ) . "'";
			}
			else if ( preg_match( '/char|string|text/i', $scheme[ $field ] ) ) {
				
				$prepared = "'" . wptournreg_escape( sanitize_text_field( $value ) ) . "'";
			}
			else if ( preg_match( '/bool|int\(1\)/i', $scheme[ $field ] ) ) {
				
				$prepared = 1;
			}
			else if ( preg_match( '/int\(/i', $scheme[ $field ] ) ) {
				
				$val = sanitize_text_field( $value );
				$prepared = (  preg_match( '/\d+/', $val ) ) ? intval( $val ) : 'NULL';
			}
			else {
				
				$prepared = "'" . wptournreg_escape( sanitize_text_field( $value ) ) . "'";
				trigger_error( 'Unknown field type ' . $scheme[ $field ] , E_USER_NOTICE );
			}
			
			$fields[] = $field;
			$data[] = $prepared;
		}
	}
	
	$fields[] = 'time';
	$data[] = time();
	$fields[] = 'ip';
	$data[] = "'" . $_SERVER[ 'REMOTE_ADDR' ] . "'";
	
	return $wpdb->query( 'INSERT INTO ' . WP_TOURNREG_DATA_TABLE . '(' . implode( ', ', $fields ) . ') VALUES (' . implode( ', ', $data ) . ');' );
}