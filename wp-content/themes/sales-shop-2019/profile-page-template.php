<?php /* Template Name: Profile Page Template */
get_header();

$user = ss_get_user();

if ($user->exists()) {
    if ($user->is_seller) {
        get_template_part('parts/profile', 'seller');
    } else {
        get_template_part('parts/profile', 'customer');
    }
} else {
    echo __('Please login first');
}

get_footer();
?>