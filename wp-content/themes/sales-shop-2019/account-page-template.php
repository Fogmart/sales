<?php /* Template Name: Account Page Template */
$user = ss_get_user();
if ($user) {
    if ($user->is_seller) {
        get_template_part('parts/account', 'seller');
    } else if ($user->is_customer) {
        get_template_part('parts/account', 'customer');
    } else {
        ss_return_home();
    }
} else {
    ss_return_home();
}
