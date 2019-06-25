<?php
register_post_type('seller', array(
    'labels' => array(
        'name' => __('Sellers'),
        'singular_name' => __('Seller'),
    ),
    'public' => true,
    'has_archive' => false,
    'rewrite' => true,
    'query_var' => true,
));


