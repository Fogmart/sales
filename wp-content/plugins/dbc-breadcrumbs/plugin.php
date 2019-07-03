<?php
/**
 * Plugin Name: DEND - Breadcrumbs displayer
 * Description: WordPress tool. Extends functional. Display breadcrumbs everywhere with shortcode. 
 * Author:      <a href="https://t.me/dendrofen">Dendrofen</a>
 * Version:     2.0
 */

//Plugin paths
define('DBC_PLUGIN', dirname(__FILE__));

define('DBC_INC', DBC_PLUGIN . '/includes');
define('DBC_PARTS', DBC_PLUGIN . '/parts');

require_once(DBC_INC.'/templates.php');
require_once(DBC_INC.'/custom.php');
require_once(DBC_INC.'/frontend.php');