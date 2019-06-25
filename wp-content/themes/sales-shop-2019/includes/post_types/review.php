<?php
register_post_type('review', array(
    'labels' => array(
        'name' => __('Reviews'),
        'singular_name' => __('Review'),
    ),
    'public' => true,
    'has_archive' => false,
    'rewrite' => true,
    'query_var' => true,
));



