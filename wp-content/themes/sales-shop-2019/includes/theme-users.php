<?php

/**
 * Grouped data for current user
 */
function ss_get_user()
{
    $user = wp_get_current_user();
    //user is logged in
    if ($user->exists()) {
        $is_seller = get_user_meta($user->ID, 'is_seller');
        $user->is_seller = $is_seller;
        $user->is_customer = !$is_seller;
    }
    return $user->exists() ? $user : null;
}

/**
 * Stub function 
 */
function ss_is_customer($return)
{
    return $return;
}

/**
 * * Stub function 
 */
function ss_is_seller($return)
{
    return $return;
}
