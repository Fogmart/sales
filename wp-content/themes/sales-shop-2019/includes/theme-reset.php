<?php

if (wp_doing_ajax()) {
    add_action('wp_ajax_nopriv_account_exist', 'ss_account_exist_handler');
    add_action('wp_ajax_account_exist', 'ss_account_exist_handler');

    function ss_account_exist_handler()
    {
        $nonce = filter_input(INPUT_POST, '_wpnonce');
        if (wp_verify_nonce($nonce)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $found = get_user_by('email', $email);
            
            $responce_data = [
                'token' => get_password_reset_key($found),
                'user_login' => $found->user_login
            ];
            $found ? wp_send_json_success($responce_data) : '';
        }
        wp_send_json_error();
    }

    add_action('wp_ajax_nopriv_reset', 'ss_reset_handler');
    add_action('wp_ajax_reset', 'ss_reset_handler');

    function ss_reset_handler()
    {
        $error = null;
        $nonce = filter_input(INPUT_POST, '_wpnonce');
        if (wp_verify_nonce($nonce)) {
            
            $user_login = filter_input(INPUT_POST, 'user_login', FILTER_SANITIZE_EMAIL);
            $reset_token = filter_input(INPUT_POST, 'reset_key');
            $password = filter_input(INPUT_POST, 'password');
            $password_conf = filter_input(INPUT_POST, 'password_confirm');

            $user = check_password_reset_key($reset_token, $user_login);

            if(!is_wp_error($user) && strcmp($password, $password_conf) === 0){
                $req_data = [
                    'email' => $user->user_email,
                    'password' => $password
                ];
                $req_action_name = 'ss_reset_password';

                $request_id = wp_create_user_request($user->user_email, $req_action_name, $req_data);
                if(!is_wp_error(request_id)){
                    $send_res = wp_send_user_request($request_id);
                    if(!is_wp_error($send_res)){
                        wp_send_json_success();
                    }else{
                        $error = $send_res;
                    }
                }else{
                    $error = $request_id;
                }
            }else{
                $error = $user;
            }
        }
        wp_send_json_error($error);
    }
}

add_action('ss_reset_password', 'ss_reset_password_handler');
function ss_reset_password_handler($req_data){
    $user = get_user_by('email', $req_data['email']);
    if(!is_wp_error($user)){
        $password = $req_data['password'];
        wp_set_password($password, $user->ID);
    }
}
