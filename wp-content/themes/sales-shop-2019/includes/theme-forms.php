<?php

/**Try to sign in user, and return WP_User if success, else WP_Error */
function ss_login_user($login, $password, $remember = false)
{
    $creds = array(
        'user_login'    => $login,
        'user_password' => $password,
        'remember'      => $remember
    );
    $user = wp_signon($creds, is_ssl());

    return $user;
}

function ss_register_user($full_name, $email, $password, $terms, $newsletter)
{
    $user_id = false;
    $user = false;
    if ($terms) {
        $user_id = wp_create_user($full_name, $password, $email);
    }
    if (!is_wp_error($user_id)) {
        $user = ss_login_user($email, $password);
        if (!is_wp_error($user)) {
            $user->set_role('customer');

            if ($newsletter) {
                //do some subscribtion functional
            }
        }
    }

    return $user !== false && !is_wp_error($user);
}
//login form
function ss_login_form_handler()
{
    $retrieved_nonce = $_POST['_wpnonce'];
    if (empty($_POST) || !wp_verify_nonce($retrieved_nonce, 'ss_login_form')) {
        exit(wp_generate_uuid4());
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');
    $remember = filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_STRING) == 'on';

    $user = ss_login_user($email, $password, $remember);

    is_wp_error($user) ? ss_return_back() : ss_return_home();
}
add_action('admin_post_nopriv_login_form', 'ss_login_form_handler');
add_action('admin_post_login_form', 'ss_login_form_handler');

//register form
function ss_register_form_handler()
{
    $retrieved_nonce = $_POST['_wpnonce'];
    if (empty($_POST) || !wp_verify_nonce($retrieved_nonce, 'ss_register_form')) {
        exit(wp_generate_uuid4());
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password');
    $terms = filter_input(INPUT_POST, 'terms', FILTER_SANITIZE_STRING) == 'on';
    $newsletter = filter_input(INPUT_POST, 'newsletter', FILTER_SANITIZE_STRING) == 'on';

    if (ss_register_user($full_name, $email, $password, $terms, $newsletter)) {
        ss_return_home();
    } else {
        ss_return_back();
    }
}
add_action('admin_post_nopriv_register_form', 'ss_register_form_handler');
add_action('admin_post_register_form', 'ss_register_form_handler');

//Account details form
function ss_account_details_form_handler()
{
    $user = wp_get_current_user();
    // Verify nonce
    if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'ss_account_details_form') ||
        !$user->exists()
    ) {
        return ss_return_back();
    }

    $data = $_POST;
    $user_data = [];

    if (
        !empty($data['current_pass']) &&
        !empty($data['user_pass']) &&
        !empty($data['confirm_pass']) &&
        $data['user_pass'] !== $data['confirm_pass']
    ) {
        return ss_return_back();
    } else {
        if (
            !empty($data['current_pass']) &&
            !empty($data['user_pass']) &&
            !empty($data['confirm_pass']) &&
            $data['user_pass'] === $data['confirm_pass']
        ) {
            if (wp_check_password($data['current_pass'], $user->user_pass, $user->ID)) {
                $user_data['user_pass'] = filter_input(INPUT_POST, 'user_pass');
            } else {
                return ss_return_back();
            }
        }
    }

    $available_fields = [
        'first_name',
        'last_name',
        'user_email'
    ];
    foreach ($available_fields as $field) {
        if (isset($data[$field])) {
            if ($field === 'user_email') {
                $user_data[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);
            } else {
                $user_data[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
            }
        }
    }

    if (!empty($user_data)) {
        $user_data['ID'] = $user->ID;
        wp_update_user($user_data);
    }

    $available_acf_fields = [
        'mobile',
        'date_of_birth',
        'gender',
        'address',
        //'city',
        'neighborhood'
    ];
    foreach ($available_acf_fields as $field) {
        if (isset($data[$field])) {
            update_field($field, filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING), 'user_' . $user->ID);
        }
    }

    return ss_return_back();
}
add_action('admin_post_nopriv_account_details_form', 'ss_account_details_form_handler');
add_action('admin_post_account_details_form', 'ss_account_details_form_handler');

//Account details form
function ss_review_add_form_handler()
{
    $user = wp_get_current_user();
    // Verify nonce
    if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'ss_review_add_form') ||
        !$user->exists() ||
        !in_array('customer', (array) $user->roles)
    ) {
        return ss_return_back();
    }

    $seller_id = filter_input(INPUT_POST, 'review_add_id', FILTER_SANITIZE_NUMBER_INT);
    $star = filter_input(INPUT_POST, 'star', FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    if (empty($seller_id) || $seller_id == $user->ID || empty($comment)) {
        return ss_return_back();
    }

    $seller = get_user_by('id', $seller_id);
    if (!$seller->exists() || !in_array('seller', (array) $seller->roles)) {
        return ss_return_back();
    }

    if (empty($star)) {
        $star = 1;
    }

    $post_data = array(
        'post_title'   => 'Review for the seller ' . $seller->ID,
        'post_content' => $comment,
        'post_status'  => 'publish',
        'post_author'  => $user->ID,
        'post_type'    => 'review'
    );

    $post_id = wp_insert_post($post_data);

    update_field('seller', $seller->ID, $post_id);
    update_field('customer', $user->ID, $post_id);
    update_field('rating', $star, $post_id);

    return ss_return_back();
}
add_action('admin_post_nopriv_review_add_form', 'ss_review_add_form_handler');
add_action('admin_post_review_add_form', 'ss_review_add_form_handler');

//Quantity order form
function ss_quantity_order_form_handler()
{
    $user = wp_get_current_user();
    // Verify nonce
    if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'ss_quantity_order_form') ||
        !$user->exists()
    ) {
        wp_die('verify error');
    }

    $key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

    if (empty($key) || empty($quantity) || $quantity < 1) {
        wp_die('error input');
    }

    WC()->cart->set_quantity($key, $quantity);

    wp_die('ok');
}
add_action('wp_ajax_quantity_order_form', 'ss_quantity_order_form_handler');
add_action('wp_ajax_nopriv_quantity_order_form', 'ss_quantity_order_form_handler');

function ss_apply_discount_handler()
{
    $retrieved_nonce = $_POST['_wpnonce'];
    if (empty($_POST) || !wp_verify_nonce($retrieved_nonce, 'ss_discount')) {
        exit(wp_generate_uuid4());
    }

    $code = filter_input(INPUT_POST, 'code');

    if ($code) {
        if ( null === WC()->session ) {
            $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
            WC()->session = new $session_class();
            WC()->session->init();
        }

        WC()->session->set('coupon_code', $code);
    }

    ss_return_back();
}
add_action('admin_post_nopriv_apply_discount', 'ss_apply_discount_handler');
add_action('admin_post_apply_discount', 'ss_apply_discount_handler');
