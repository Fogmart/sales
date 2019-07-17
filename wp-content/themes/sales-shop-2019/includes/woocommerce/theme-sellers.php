<?php

function ss_get_seller_profile_link($seller_id){
    return SS_PROFILE_PAGE.'/'.$seller_id;
}

function ss_get_seller_info($seller_id)
{
    $seller = new stdClass();
    $seller_obj = get_user_by('id', $seller_id); //user obj
    $rating = 0;
    $count = 0;
    
    if ($seller_obj) {
        
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

        $rated_rating = $rating / $count;
        
        $seller->rating = round($rated_rating, 2); 
        $seller->reviews_count = $count;
    }
    return $seller;
}