<?php
register_post_type('city', array(
    'labels' => array(
        'name' => __('Cities'),
        'singular_name' => __('City'),
    ),
    'public' => true,
    'has_archive' => false,
    'rewrite' => true,
    'query_var' => true,
));


