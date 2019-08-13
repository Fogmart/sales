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
    'menu_icon' => 'dashicons-location-alt'
));

add_filter( 'enter_title_here', 'filter_function_name_city', 10, 2 );
function filter_function_name_city( $text, $post ){
    if ( $post->post_type === 'city' ) {
        $text = __('City name');
    }

    return $text;
}
