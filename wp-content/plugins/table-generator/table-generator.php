<?php

/*
Plugin Name: Table Generator
Plugin URI: https://wpgurus.net/table-generator/
Description: Create pricing comparison tables with just a few clicks.
Version: 1.3.0
Author: WPGurus
Author URI: https://wpgurus.net/
License: GPL2
Text Domain: wptg-plugin
Domain Path: /languages/
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'inc/class-wptg-table-generator.php';

function wptg_run_table_generator() {
	$plugin_instance = new WPTG_Table_Generator('1.3.0');
	register_activation_hook( __FILE__, array($plugin_instance, 'initialize') );
	register_uninstall_hook( __FILE__, array('WPTG_Table_Generator', 'rollback') );
}

wptg_run_table_generator();

function wptg_get_table($id)
{
	$db = WPTG_DB_Table::get_instance();
	$table = $db->get($id);
	return $table['tvalues'];
}

function wptg_load_plugin_textdomain() {
	load_plugin_textdomain( 'wptg-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wptg_load_plugin_textdomain' );