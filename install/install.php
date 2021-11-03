<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* https://codex.wordpress.org/Creating_Tables_with_Plugins */


function wptournreg_install() {
	global $wpdb;

	add_option( 'wptournreg_db_version', WP_TOURNREG_DB_VER );
	$table_name = WP_TOURNREG_DATA_TABLE;
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		tournament_id varchar(32) NOT NULL,
		time int(64) DEFAULT 0 NOT NULL,
		lastname tinytext DEFAULT '' NOT NULL,
		firstname tinytext DEFAULT '' NOT NULL,
		email tinytext NOT NULL,
		tag varchar(3) DEFAULT '' NOT NULL,
		phone varchar(64) DEFAULT '' NOT NULL,
		ifpanumber mediumint(9) DEFAULT NULL,
		place tinytext DEFAULT '' NOT NULL,
		day1 bool DEFAULT FALSE NOT NULL,
		day2 bool DEFAULT FALSE NOT NULL,
		day3 bool DEFAULT FALSE NOT NULL,
		approved bool DEFAULT FALSE NOT NULL,
		protected bool DEFAULT FALSE NOT NULL,
		paid bool DEFAULT FALSE NOT NULL,
		ip varchar(32) NOT NULL,
		hash varchar(32) DEFAULT NULL,
		UNIQUE (hash),
		PRIMARY KEY (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}