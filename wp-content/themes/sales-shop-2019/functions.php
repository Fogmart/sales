<?php
define('SS_INC', get_template_directory() . '/includes');
define('SS_POST_TYPES', SS_INC . '/post_types');
define('SS_POST_TYPE_FIELDS', SS_INC . '/post_type_fields');
define('SS_CLASSES', SS_INC . '/classes');


//theme options
require_once(dirname(__FILE__) . '/redux-theme-config.php');

//menus
require_once(SS_INC . '/menu.php');


//post types, post type fields, classes include
$except = array('.', '..');
$to_include = array(
    SS_POST_TYPES,
    SS_POST_TYPE_FIELDS,
    SS_CLASSES
);

foreach ($to_include as $one) {
    $files = scandir($one);
    foreach ($files as $item) {
        if (!in_array($item, $except)) {
            require_once($one . '/' . $item);
        }
    }
}
