<?php

/**
 * Grouped data for current user
 */
function ss_get_user()
{
    $user = wp_get_current_user();
    //user is logged in
    if ($user->exists()) {
        $user->is_seller = in_array('seller', (array) $user->roles);
        $user->is_customer = in_array('customer', (array) $user->roles);
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
