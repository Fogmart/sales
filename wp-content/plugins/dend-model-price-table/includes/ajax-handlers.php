<?php
add_action('wp_ajax_nopriv_mp_settings', 'mp_settings_handler');
add_action('wp_ajax_mp_settings', 'mp_settings_handler');

function mp_settings_handler(){
    check_ajax_referer( 'mp_cs');

    $out['message'] = __('Saved');
    $data = $_POST['data'];

    ModelPriceTable::setCode($data['code']);

    if(!is_array($data)){
        $out['message'] = __('Not saved');
        return wp_send_json_error($out);
    }

    return wp_send_json_success($out);
}
