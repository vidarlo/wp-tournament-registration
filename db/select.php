<?php

/* stores the form data 
 * param1 = tournament_id
 */
function wptournreg_select_tournament( $tournament_id ) {
	
	global $wpdb;

	$tourn = $wpdb->_real_escape( $tournament_id );
	return $wpdb->get_results('SELECT * FROM ' . WP_TOURNREG_DATA_TABLE . " WHERE tournament_id = '" . $tourn . "';" );
}