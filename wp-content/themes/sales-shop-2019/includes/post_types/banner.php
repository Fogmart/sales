<?php
register_post_type('banner', array(
    'labels' => array(
        'name' => __('Banners'),
        'singular_name' => __('Banner'),
    ),
    'public' => true,
    'has_archive' => false,
    'rewrite' => true,
    'query_var' => true,
));
