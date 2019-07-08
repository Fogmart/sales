<?php
define('SS_INC', get_template_directory() . '/includes');
define('SS_JS', get_template_directory_uri() . '/assets/js');
define('SS_CSS', get_template_directory_uri() . '/assets/css');
define('SS_POST_TYPES', SS_INC . '/post_types');
define('SS_CUSTOM_FIELDS', SS_INC . '/custom_fields');
define('SS_CLASSES', SS_INC . '/classes');
define('SS_WOOCOMMERCE', SS_INC . '/woocommerce');

//theme options
require_once(SS_INC . '/redux-theme-config.php');

//menus
require_once(SS_INC . '/menu/register.php');
require_once(SS_INC . '/menu/render.php');

//custom functinal
require_once(SS_INC . '/theme-functional.php');
require_once(SS_INC . '/theme-banners.php');
require_once(SS_INC . '/theme-extends.php');

//woocommerce
require_once(SS_WOOCOMMERCE . '/theme-product.php');

//post types, post type fields, classes include
ss_autoload_scripts([SS_POST_TYPES, SS_CUSTOM_FIELDS,]);


//scripts, styles
add_action('wp_enqueue_scripts', 'ss_theme_assets');
function ss_theme_assets()
{
    wp_register_script('ss_script', SS_JS . '/scripts.min.js');
    wp_register_style('ss_style', SS_CSS . '/main.min.css');

    wp_enqueue_script('ss_script');
    wp_enqueue_style('ss_style');
}
