<?php
/**
 * Plugin Name: DEND - Woo Currency Switcher
 * Description: Woocomerce Currency tool. Extends functional. Add, Delete, Manage Woocomerce Curencies. 
 * Author:      <a href="https://t.me/dendrofen">Dendrofen</a>
 * Version:     1.0
 */


//создаем необходимые константы
define('WCS_PLUGIN', dirname(__FILE__));
define('WCS_INC', WCS_PLUGIN . '/includes');

require_once(WCS_INC.'/admin-page.php'); //скрипты для админки
require_once(WCS_INC.'/frontend.php'); //регистрация фронтенда
