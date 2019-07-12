<?php
//login form
function ss_login_form_handler()
{
    $data = (object)$_POST;

    $creds = array(
        'user_login'    => $data->login,
        'user_password' => $data->password,
        'remember'      => $data->remember
    );
    $user = wp_signon( $creds, is_ssl() );
 
    return is_wp_error( $user ) ? ss_return_back() : ss_return_home();
}
add_action('admin_post_nopriv_login_form', 'ss_login_form_handler');
add_action('admin_post_login_form', 'ss_login_form_handler');
