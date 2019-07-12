<?php
/**
 * Plugin Name: DEND - Price Model Table
 * Description: Create and view price tables linked with model. 
 * Author:      <a href="https://t.me/dendrofen">Dendrofen</a>
 * Version:     0.1
 */

//create necessary constants
define('MP_PLUGIN', dirname(__FILE__));
define('MP_PLUGIN_URL', plugin_dir_url(__FILE__));

define('MP_INC', MP_PLUGIN . '/includes');
define('MP_PARTS', MP_PLUGIN . '/parts');
define('MP_CLASSES', MP_INC . '/classes');

define('MP_STYLES', MP_PLUGIN_URL . '/assets/css');
define('MP_SCRIPTS', MP_PLUGIN_URL . '/assets/js');;

require_once(MP_CLASSES.'/table.php');

require_once(MP_INC.'/admin-page.php'); //admin page scripts
require_once(MP_INC.'/frontend.php'); //front end page scripts
require_once(MP_INC.'/ajax-handlers.php'); //ajax handlers
