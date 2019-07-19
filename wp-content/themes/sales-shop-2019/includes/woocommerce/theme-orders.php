<?php

function ss_get_user_orders($paginate_page = 1, $paginate_count = -1, $status = [])
{
    if (empty($status)) {
        $status = array_keys(wc_get_order_statuses());
    }

    if (!is_array($status)) {
        return null;
    }

    $orders = get_posts([
        'numberposts' => $paginate_count,
        'paged' => $paginate_page,
        'meta_key' => '_customer_user',
        'meta_value' => get_current_user_id(),
        'post_type' => wc_get_order_types(),
        'post_status' => $status,
    ]);

    return $orders;
}
