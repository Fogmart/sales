<?php
define('SS_PLUGINS', get_template_directory() . '/plugins');
define('SS_PLUGINS_URL', get_stylesheet_directory_uri() . '/plugins');
define('SS_INC', get_template_directory() . '/includes');
define('SS_POST_TYPES', SS_INC . '/post_types');
define('SS_POST_TYPE_FIELDS', SS_INC . '/post_type_fields');
define('SS_CLASSES', SS_INC . '/classes');

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

//require plugins
$theme_plugins = array(
    SS_PLUGINS.'/advanced-custom-fields-pro/acf.php',
    SS_PLUGINS.'/ACF-auto-generated-value-master/acf-auto_generated_value.php',
    //SS_PLUGINS.'/ajax-search-for-woocommerce/ajax-search-for-woocommerce.php',
    SS_PLUGINS.'/classic-editor/classic-editor.php',
    SS_PLUGINS.'/contact-form-7/wp-contact-form-7.php',
    SS_PLUGINS.'/dbc-breadcrumbs/plugin.php',
    SS_PLUGINS.'/dend-woo-currency-switcher/plugin.php',
    SS_PLUGINS.'/mailchimp-for-wp/mailchimp-for-wp.php',
    SS_PLUGINS.'/redux-framework/redux-framework.php',
    SS_INC . '/redux-theme-config.php',
    SS_PLUGINS.'/woocommerce/woocommerce.php',
    SS_PLUGINS.'/wp-super-cache/wp-cache.php',
);

foreach ($theme_plugins as $plugin) {
    require_once($plugin);
}