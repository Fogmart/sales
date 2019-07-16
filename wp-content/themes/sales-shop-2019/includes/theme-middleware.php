<?php
function ss_get_current_page_slug(){

    //defineing current page slug
    $current_page_slug = $_SERVER['REDIRECT_URL'];
    if(substr($current_page_slug, -1) == '/') {
        $current_page_slug = substr($current_page_slug, 0, -1);
    }
    return $current_page_slug;
}

/**
 * - Hook handler -
 * Redirect user to homepage if is logged in and requested page in restriction list
 */
function user_logged_in_redirect()
{
    $restrict_on_login = [
        SS_LOGIN_PAGE, SS_REG_PAGE
    ];

    $current_page_slug = ss_get_current_page_slug();
    if (is_user_logged_in() && in_array($current_page_slug, $restrict_on_login)) {
        ss_return_home();
    }
}

/**
 * - Hook handler -
 * Redirect user to homepage if is not logged in and requested page in restriction list
 */
function user_not_logged_in_redirect()
{
    $restrict_on_login = [
        SS_PROFILE_PAGE,
        SS_ORDERS_PAGE,
        SS_ACCOUNT_PAGE,
    ];

    $current_page_slug = ss_get_current_page_slug();
    if (!is_user_logged_in() && in_array($current_page_slug, $restrict_on_login)) {
        ss_return_login();
    }
}

if(SS_ENABLE_MIDDLEWARE){
    add_action('init', 'user_logged_in_redirect');
    add_action('init', 'user_not_logged_in_redirect');
}
