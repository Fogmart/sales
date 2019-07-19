<?php

// Adding a new rule
function ss_rewrite_rules($rules)
{
    $my_rule = ['profile/(\d+)/?' => 'index.php?pagename=profile&seller_id=$matches[1]'];

    return array_merge($my_rule, $rules);
}

add_filter('rewrite_rules_array', 'ss_rewrite_rules');

// Adding the var so that WP recognizes it
function ss_query_vars($vars)
{
    $vars[] = 'seller_id';

    return $vars;
}

add_filter('query_vars', 'ss_query_vars');

// Remember to flush_rules() when adding rules
function ss_flush_rules()
{
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

add_filter('init', 'ss_flush_rules');
