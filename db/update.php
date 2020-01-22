<?php

/* updates from editor (param1 = id) */
function wptournreg_update_data( ) {
	
	global $wpdb;

	require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
	$scheme = wptournreg_get_field_list();
		
	$values = [];
	foreach( $scheme as $field => $type ) {
		
		if ( $field == 'id' || $field == 'time' ) {
		}
		else if ( preg_match( '/bool|int\(1\)/i', $type ) ) {
			
			$values[ $field ] = ( isset( $_POST[ $field ] ) ) ? 1 : 0;
		}
		else if ( preg_match( '/int\(/i', $type ) ) {
			
			$values[ $field ] = ( !empty( $_POST[ $field ] ) ) ? $_POST[ $field ] : 'NULL';
		}
		else if ( array_key_exists( $field, $_POST ) ) {
			
			$values[ $field ] =  "'" . $wpdb->_real_escape( $_POST[ $field ] ) . "'";				
		}
	}
	
	$update = [];
	foreach( $values as $field => $value ) {
		$update[] = "$field = $value";
	}
	
	/* $wpdb->update and friends canm't set NULL values */
	return $wpdb->query( 'UPDATE ' . WP_TOURNREG_DATA_TABLE . ' SET ' . implode( ', ', $update ) . ' WHERE id = ' . $_POST[ 'id' ] . ';' );
}