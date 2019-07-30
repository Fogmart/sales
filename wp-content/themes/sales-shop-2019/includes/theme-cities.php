<?php

function ss_get_cities($city_id = null){
    $args = [
        'post_type' => 'city',
        'post_status' => 'publish',
        'numberposts' => -1,
    ];
    if(isset($city_id)){
        $args['post__in'] = (array)$city_id;
    }

    $posts = get_posts($args);
    wp_reset_postdata();
    return $posts;
}

function ss_get_neighborhoods($city_id = null){
    $items = [];

    foreach(ss_get_cities($city_id) as $city){
        $neighborhood = (array)get_field('neighborhoods', $city->ID);

        array_walk($neighborhood, function(&$value, $key) use($city){
            $value['city_id'] = $city->ID;
            $value = (object)$value;
        });

        $items = array_merge(array_values($neighborhood), $items);
    }
    return $items;
}