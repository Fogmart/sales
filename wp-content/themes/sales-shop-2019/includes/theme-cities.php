<?php

function ss_get_cities(){
    $args = [
        'post_type' => 'city',
        'post_status' => 'publish',
        'numberposts' => -1
    ];
    $posts = get_posts($args);
    wp_reset_postdata();
    return $posts;
}


function ss_get_neighborhoods(){
    $items = [];

    foreach(ss_get_cities() as $city){
        $neighborhood = (array)get_field('neighborhoods', $city->ID);

        array_walk($neighborhood, function(&$value, $key) use($city){
            $value['city_id'] = $city->ID;
            $value = (object)$value;
        });

        $items = array_merge(array_values($neighborhood), $items);
    }
    return $items;
}