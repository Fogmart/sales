<?php
define('SS_INC', get_template_directory() . '/includes');
define('SS_JS', get_template_directory_uri() . '/assets/js');
define('SS_CSS', get_template_directory_uri() . '/assets/css');
define('SS_POST_TYPES', SS_INC . '/post_types');
define('SS_CUSTOM_FIELDS', SS_INC . '/custom_fields');
define('SS_CLASSES', SS_INC . '/classes');
define('SS_WOOCOMMERCE', SS_INC . '/woocommerce');

//web options
define('SS_REG_PAGE', '/register');
define('SS_LOGIN_PAGE', '/login');
define('SS_RESET_PAGE', '/reset');
define('SS_PROFILE_PAGE', '/profile');
define('SS_ORDERS_PAGE', '/orders');
define('SS_VOUCHERS_PAGE', '/vouchers');
define('SS_CART_PAGE', '/cart');
define('SS_CHECKOUT_PAGE', '/checkout');
define('SS_ACCOUNT_PAGE', '/account');

//settings
define('SS_ENABLE_MIDDLEWARE', false);
define('GOOGLE_API_KEY', 'xxx');

$post_form_action = 'action="' . esc_url(admin_url('admin-post.php')) . '" method="POST"';
define('SS_FORM_POST', $post_form_action);

//menus
require_once(SS_INC . '/menu/register.php');
require_once(SS_INC . '/menu/render.php');

//custom functional
require_once(SS_INC . '/theme-middleware.php');
require_once(SS_INC . '/admin/neighborhood.php');
require_once(SS_INC . '/theme-roles.php');
require_once(SS_INC . '/theme-functional.php');
require_once(SS_INC . '/theme-banners.php');
require_once(SS_INC . '/theme-extends.php');
require_once(SS_INC . '/theme-forms.php');
require_once(SS_INC . '/theme-users.php');

//woocommerce
require_once(SS_WOOCOMMERCE . '/theme-sellers.php');
require_once(SS_WOOCOMMERCE . '/theme-product.php');
require_once(SS_WOOCOMMERCE . '/theme-ajax.php');
require_once(SS_WOOCOMMERCE . '/theme-orders.php');
require_once(SS_WOOCOMMERCE . '/price-change-rates.php'); //change price due to exchange rates

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

    if (is_product()) {
        wp_register_script('ss_product', SS_JS . '/product.js');
        wp_localize_script('ss_product', 'pData', array(
            'nonce' => wp_create_nonce('nonce_' . get_the_ID()),
        ));
        wp_enqueue_script('ss_product');
    }
}

add_action('pre_get_posts', 'tt_woocommerce_archive');
function tt_woocommerce_archive($query)
{
    if (!is_admin() && $query->is_main_query() && is_product_category()) {
        global $ss_theme_option;
        $query->set('posts_per_page', $ss_theme_option["category-pagination-amount"]);
    }
}
