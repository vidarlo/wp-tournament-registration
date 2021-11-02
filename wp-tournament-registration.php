<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
 
/*
* Plugin Name:         WP Pinball Tournament Registration
* Plugin URI:          https://github.com/vidarlo/wp-tournament-registration
* Version:             1.2.0
* Requires at least:   5.3
* Requires PHP:        7.0
* Author:              Ingram Braun / Vidar Løkken
* Author URI:          https://ingram-braun.net/
* License:             GPL v2 or later
* License URI:         https://www.gnu.org/licenses/gpl-2.0.html
* Description:         Simple tournament registration form for Pinball
* Text Domain:         wp-pinball-tournament-registration
* Domain Path:         /languages
*/

/* VERSIONS */
define( "WP_TOURNREG_DB_VER", 4 );
define( "WP_TOURNREG_PLUGIN_VER", '1.2.0' );
define( "WP_TOURNREG_TBSORT_VER", '1.0' );

/* PATHES */
define( "WP_TOURNREG_PLUGIN_PATH", plugin_dir_path( __FILE__ ) );
define( "WP_TOURNREG_ASSETS_PATH", WP_TOURNREG_PLUGIN_PATH . 'assets' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_DATABASE_PATH", WP_TOURNREG_PLUGIN_PATH . 'db' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_HTML_PATH", WP_TOURNREG_PLUGIN_PATH . 'html' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_HTTP_PATH", WP_TOURNREG_PLUGIN_PATH . 'http' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_INSTALL_PATH", WP_TOURNREG_PLUGIN_PATH . 'install' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_LOCALIZATION_PATH", WP_TOURNREG_PLUGIN_PATH . 'languages' . DIRECTORY_SEPARATOR );
define( "WP_TOURNREG_SHORTCODE_PATH", WP_TOURNREG_PLUGIN_PATH . 'shortcodes' . DIRECTORY_SEPARATOR );

/* URLs */
define( "WP_TOURNREG_ACTION_URL", esc_url( admin_url('admin-post.php') ) );
define( "WP_TOURNREG_CSS_URL", plugins_url( 'assets/wptournreg.css', __FILE__ ) );
define( "WP_TOURNREG_JS_URL", plugins_url( 'assets/wptournreg.js', __FILE__ ) );
define( "WP_TOURNREG_TBSORTJS_URL", plugins_url( 'assets/jquery.tablesorter/js/jquery.tablesorter.min.js', __FILE__ ) );
define( "WP_TOURNREG_TBSORTCSS_URL", plugins_url( 'assets/jquery.tablesorter/css/theme.default.min.css', __FILE__ ) );

/* TABLE NAME */
global $wpdb;
define("WP_TOURNREG_DATA_TABLE", $wpdb->prefix . 'wptournreg_participants' );

/* ACTIVATION */
require_once WP_TOURNREG_INSTALL_PATH . 'install.php';
require_once WP_TOURNREG_INSTALL_PATH . 'uninstall.php';
require_once WP_TOURNREG_INSTALL_PATH . 'upgrade.php';
register_activation_hook( __FILE__, 'wptournreg_install' );
register_uninstall_hook( __FILE__, 'wptournreg_uninstall' );
add_action('plugins_loaded', 'wptournreg_upgrade');

/* LOCALIZATION */
function wptournreg_load_textdomain() {
	
	load_plugin_textdomain( 'wp-tournament-registration', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'wptournreg_load_textdomain' );

/* Suppress caching for rapidly changing lists */
require_once WP_TOURNREG_HTTP_PATH. 'cache.php';



/* SHORTCODES */
require_once WP_TOURNREG_SHORTCODE_PATH . 'edit.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'field.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'form.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'list.php';
require_once WP_TOURNREG_SHORTCODE_PATH . 'export.php';

require_once WP_TOURNREG_ASSETS_PATH . 'tablesort.php';
require_once WP_TOURNREG_ASSETS_PATH . 'load.php';

