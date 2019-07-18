<?php

function ss_get_seller_profile_link($seller_id){
    return SS_PROFILE_PAGE.'/'.$seller_id;
}

function ss_get_seller_city($seller_id)
{
    $city = new stdClass();
    $city_id = get_field('city', 'user_' . $seller_id);
    if ($city_id) {
        $city->id = $city_id;
        $city->name = get_the_title($city->id);
        $city->country = get_field('country', 'user_' . $seller_id);
    }
    return $city;
}

function ss_get_seller_info($seller_id)
{
    $seller = null;
    $seller_obj = get_user_by('id', $seller_id); //user obj
    $rating = 0;
    $count = 0;
    
    if ($seller_obj && in_array('seller', (array) $seller_obj->roles)) {
        
        $args = array('posts_per_page'=>-1,
            'post_type'=> 'review',
            'meta_key' => 'seller',
            'meta_query' => array(
                'key'     => 'seller',
                'value'   => $seller_id,
                'compare' => '=',
            ),
        );       
        $new_wp_query = new WP_Query($args);

        while ($new_wp_query->have_posts()) : 
            $new_wp_query->the_post(); 
            $count = $count + 1;
            $ID = get_the_ID();
            $value = get_field( "rating", $ID );
            $rating = $rating + $value;        
        endwhile; 

        wp_reset_postdata();

        $rated_rating = $rating / $count;
        
        $seller = new stdClass();
        
        $seller->id = $seller_obj->ID;
        $seller->name = $seller_obj->first_name . ' ' . $seller_obj->last_name;

        $seller->rating = round($rated_rating, 2); 
        $seller->rating_real = $rated_rating;
        $seller->reviews_count = $count;
    }
    return $seller;
}