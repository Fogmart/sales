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
    'menu_icon' => 'dashicons-images-alt2'
));
//Hide wp editor from Banners
remove_post_type_support( 'banner', 'editor');

