<?php /* Template Name: Profile Page Template */
$user = ss_get_user();

if ($user) {
    if ($user->is_seller) {
        get_template_part('parts/profile', 'seller');
    } else if ($user->is_customer) {
        get_template_part('parts/profile', 'customer');
    } else {
        ss_return_home();
    }
} else {
    ss_return_home();
}
