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
