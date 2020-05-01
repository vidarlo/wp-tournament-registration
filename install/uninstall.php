<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Delete table on uninstall. */

function wptournreg_uninstall() {
	
	global $wpdb;
	$table_name = WP_TOURNREG_DATA_TABLE;
	
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	
}