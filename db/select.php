<?php

/* stores the form data 
 * param1 = tournament_id
 */
function wptournreg_select_tournament( $tournament_id ) {
	
	global $wpdb;

	return $wpdb->get_results('SELECT * FROM ' . WP_TOURNREG_DATA_TABLE . " WHERE tournament_id = '" . $tournament_id . "';" );
}