<?php
define('SS_INC', get_template_directory() . '/includes');
define('SS_JS', get_template_directory_uri().'/assets/js');
define('SS_CSS', get_template_directory_uri().'/assets/css');
define('SS_POST_TYPES', SS_INC . '/post_types');
define('SS_POST_TYPE_FIELDS', SS_INC . '/post_type_fields');
define('SS_CLASSES', SS_INC . '/classes');

//theme options
require_once(SS_INC . '/redux-theme-config.php');

//menus
require_once(SS_INC . '/menu.php');

//post types, post type fields, classes include
$except = array('.', '..');
$to_include = array(
    SS_POST_TYPES,
    SS_POST_TYPE_FIELDS,
);

foreach ($to_include as $one) {
    $files = scandir($one);
    foreach ($files as $item) {
        if (!in_array($item, $except)) {
            require_once($one . '/' . $item);
        }
    }
}

add_action('wp_enqueue_scripts', 'ss_theme_assets');
function ss_theme_assets(){
    wp_register_script('ss_script', SS_JS.'/scripts.min.js');
    wp_register_style('ss_style', SS_CSS.'/main.min.css');

    wp_enqueue_script('ss_script');
    wp_enqueue_style('ss_style');
}