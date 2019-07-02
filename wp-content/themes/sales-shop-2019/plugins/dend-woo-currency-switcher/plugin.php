<?php
/**
 * Plugin Name: DEND - Woo Currency Switcher
 * Description: Woocomerce Currency tool. Extends functional. Add, Delete, Manage Woocomerce Curencies. 
 * Author:      <a href="https://t.me/dendrofen">Dendrofen</a>
 * Version:     1.0
 */


//create necessary constants
define('WCS_PLUGIN', dirname(__FILE__));
define('WCS_PLUGIN_URL', SS_PLUGINS_URL . '/' . basename(__DIR__) . '/'); //plugin_dir_url(__FILE__));

define('WCS_INC', WCS_PLUGIN . '/includes');
define('WCS_PARTS', WCS_PLUGIN . '/parts');

define('WCS_STYLES', WCS_PLUGIN_URL . '/assets/css');
define('WCS_SCRIPTS', WCS_PLUGIN_URL . '/assets/js');

require_once(WCS_INC.'/general.php'); //general settings
require_once(WCS_INC.'/admin-page.php'); //admin page scripts
require_once(WCS_INC.'/frontend.php'); //front end page scripts
require_once(WCS_INC.'/ajax-handlers.php'); //ajax handlers
require_once(WCS_INC.'/redefiners.php'); //ajax handlers

register_activation_hook( __FILE__, array( 'WCS_Settings', 'install' ) );
register_deactivation_hook( __FILE__, array( 'WCS_Settings', 'uninstall' ) );
