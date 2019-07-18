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

        return $user;
    }

    return null;
}

/**
 * Return relative link to user page
 */
function ss_get_user_page_url($user_id)
{
    return SS_ACCOUNT_PAGE . '/' . $user_id;
}
