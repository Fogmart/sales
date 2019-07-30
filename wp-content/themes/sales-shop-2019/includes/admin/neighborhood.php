<?php

function acf_admin_enqueue($hook)
{
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : false;
    if ($user_id === false) {
        return;
    }
    //$post_id = get_the_ID(); // Get current post id
    //$type = get_post_type(); // Check current post type
    //$types = array('seller'); // Allowed post types

    // if( !in_array( $type, $types ) )
    //     return; // Only applies to post types in array

    wp_enqueue_script('neighborhoods', get_stylesheet_directory_uri() . '/assets/js/autopopulates.js');


    wp_localize_script(
        'neighborhoods',
        'pa_vars',
        array(
            'pa_nonce' => wp_create_nonce('pa_nonce'), // Create nonce which we later will use to verify AJAX request
            'current_neighborhood' => get_field('neighborhood', 'user_' . $user_id) // Get current neighborhood
        )
    );
}

add_action('admin_enqueue_scripts', 'acf_admin_enqueue');


if (WP_DEBUG && WP_DEBUG_DISPLAY && (defined('DOING_AJAX') && DOING_AJAX)) {
    @ini_set('display_errors', 1);
}
// Return neighborhoods by city
function neighborhoods_by_city()
{
    // Verify nonce
    if (!isset($_POST['pa_nonce']) || !wp_verify_nonce($_POST['pa_nonce'], 'pa_nonce'))
        die('Permission denied');

    // Get city var
    $selected_city = $_POST['city'];

    // Get neighborhoods
    $neighborhoods_data = get_field('neighborhoods', 'post_' . $selected_city);
    $neighborhoods = array();
    if (!empty($neighborhoods_data)) {
        foreach ($neighborhoods_data as $row) {
            $neighborhoods[] = $row['name'];
        }
    }

    return wp_send_json($neighborhoods);
}

add_action('wp_ajax_neighborhood_of_cities', 'neighborhoods_by_city');
add_action('wp_ajax_nopriv_neighborhood_of_cities', 'neighborhoods_by_city');
