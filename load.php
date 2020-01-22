<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
 
/* also read https://codex.wordpress.org/Writing_a_Plugin */
 
/*
 
Plugin Name: WP Tournament Registration
 
Description: Simple tournament registration form
 
*/

/* PATHES */

define( "WP_TOURNREG_ASSETS_PATH", plugin_dir_path( __FILE__ ) . 'assets' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_DATABASE_PATH", plugin_dir_path( __FILE__ ) . 'db' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_INSTALL_PATH", plugin_dir_path( __FILE__ ) . 'install' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_LOCALIZATION_PATH", plugin_dir_path( __FILE__ ) . 'languages' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_SHORTCODE_PATH", plugin_dir_path( __FILE__ ) . 'shortcodes' . DIRECTORY_SEPARATOR );

/* URLs */
define( "WP_TOURNREG_JS_URL", plugins_url( 'assets/wptournreg.js', __FILE__ ) );
define( "WP_TOURNREG_TBSORTJS_URL", plugins_url( 'assets/tablesorter-master/js/jquery.tablesorter.js', __FILE__ ) );
define( "WP_TOURNREG_TBSORTCSS_URL", plugins_url( 'assets/tablesorter-master/css/theme.default.css', __FILE__ ) );

/* TABLE NAME */
global $wpdb;
define("WP_TOURNREG_DATA_TABLE", $wpdb->prefix . 'wptournreg_participants' );

/* ACTIVATION */

require_once WP_TOURNREG_INSTALL_PATH . 'install.php';

$wptournreg_db_version = 1;

add_option( 'wptournreg_db_version', $wptournreg_db_version );
register_activation_hook( __FILE__, 'wptournreg_install' );

/* SHORTCODES */

require_once WP_TOURNREG_SHORTCODE_PATH . 'field.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'form.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'list.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'txt.php';

require_once WP_TOURNREG_ASSETS_PATH . 'tablesort.php';

