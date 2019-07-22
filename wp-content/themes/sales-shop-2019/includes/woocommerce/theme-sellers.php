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

function ss_get_seller_info($seller_id, $load_more_info = false)
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

        $reviews = get_posts($args);
        foreach ($reviews as $key => $review) {
            $count = $count + 1;
            $value = get_field("rating", $review->ID);
            $reviews[$key]->rating = $value;
            $reviews[$key]->customer = null;
            $rating = $rating + $value;

            if ($load_more_info) {
                $time = human_time_diff(strtotime($review->post_date), current_time( 'timestamp' )) . ' ' . __( 'ago' );
                $reviews[$key]->human_time_diff = $time;
                $user_id = get_field("customer", $review->ID);
                if (!empty($user_id)) {
                    $reviews[$key]->customer = get_user_by('id', $user_id);
                    $reviews[$key]->customer->name = $reviews[$key]->customer->first_name . ' ' . $reviews[$key]->customer->last_name;
                }
            }
        }

        $rated_rating = $count > 0 ? $rating / $count : 0;
        
        $seller = new stdClass();
        
        $seller->id = $seller_obj->ID;
        $seller->name = $seller_obj->first_name . ' ' . $seller_obj->last_name;

        $seller->reviews = $reviews;
        $seller->rating = round($rated_rating, 2);
        $seller->rating_real = $rated_rating;
        $seller->reviews_count = $count;
        $seller->user = $seller_obj;
    }
    return $seller;
}