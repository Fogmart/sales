<?php

/**
 * Get max and min prices of loop
 */
function ss_get_loop_prices()
{
    global $wpdb;

    // var_dump(WC()->query->get_main_query());
    if ($main_query = WC()->query->get_main_query()) {
        $args       = $main_query->query_vars;
        $tax_query  = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms'    => array($args['term']),
                'field'    => 'slug',
            );
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query  = new WP_Tax_Query($tax_query);
        $search     = WC_Query::get_main_search_query_sql();

        $meta_query_sql   = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql    = $tax_query->get_sql($wpdb->posts, 'ID');
        $search_query_sql = $search ? ' AND ' . $search : '';

        $sql = "
        SELECT min( min_price ) as min_price, MAX( max_price ) as max_price
        FROM {$wpdb->wc_product_meta_lookup}
        WHERE product_id IN (
            SELECT ID FROM {$wpdb->posts}
            " . $tax_query_sql['join'] . $meta_query_sql['join'] . "
            WHERE {$wpdb->posts}.post_type IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product')))) . "')
            AND {$wpdb->posts}.post_status = 'publish'
            " . $tax_query_sql['where'] . $meta_query_sql['where'] . $search_query_sql . '
        )';

        $sql = apply_filters('woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql);

        return $wpdb->get_row($sql);
    }
}

function ss_get_users_by_params($city_id, $neighborhoods)
{
    $meta_args = array(
        'relation' => 'AND',
    );

    if (!empty($city_id)) {
        $meta_args[] = array(
            'key'     => 'city',
            'value'   => $city_id,
            'compare' => '='
        );

        if (!empty($neighborhoods)) {
            $meta_args[] = array(
                'key'     => 'neighborhood',
                'value'   => $neighborhoods,
                'compare' => 'IN'
            );
        }
    }

    $args = array(
        'fields' => 'ids',
        'role' => 'seller',
        'meta_query' => $meta_args,
    );

    $user_query = new WP_User_Query($args);
    $rez = $user_query->get_results();

    wp_reset_query();
    return $rez;
}

//filters on page loading
function ss_filter_product_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_product_category() || is_shop()) {
        $city_id = filter_input(INPUT_GET, 'city_id');

        $neighborhoods = filter_input(INPUT_GET, 'neighborhood');
        if ($neighborhoods) {
            $neighborhoods =  explode(',', urldecode($neighborhoods));
        }

        $from_price = filter_input(INPUT_GET, 'min_price');
        $to_price = filter_input(INPUT_GET, 'max_price');
        $keywords = filter_input(INPUT_GET, 'q');

        //category

        $sellers = ss_get_users_by_params($city_id, $neighborhoods); //results by city and neighborhoods

        $meta_args = array(
            array(
                'key' => 'seller',
                'value' => $sellers,
                'compare' => 'IN',
            )
        );

        $meta_query_args = array(
            'meta_query' => $meta_args,
        );
        $query->set('meta_query', $meta_query_args);
    }
}
add_action('pre_get_posts', 'ss_filter_product_query');
