<?php
//settings save admin
add_action('wp_ajax_nopriv_wcs_settings', 'wcs_settings_handler');
add_action('wp_ajax_wcs_settings', 'wcs_settings_handler');

function wcs_settings_handler(){
    check_ajax_referer( 'wcs_cs');

    $out['message'] = __('Saved');
    $data = $_POST['data'];

    if(!is_array($data)){
        $out['message'] = __('Not saved');
        return wp_send_json_error($out);
    }

    WCS_Settings::getInstance()->setSettings($data);

    return wp_send_json_success($out);
}

//change currency frontend
add_action('wp_ajax_nopriv_wcs_change', 'change_currency_handler');
add_action('wp_ajax_wcs_change', 'change_currency_handler');

function change_currency_handler(){
    check_ajax_referer( 'wcs_cc');

    $data = $_POST['data'];
    $new_currency = $data['newCurrency'];

    WCS_Settings::getInstance()->setSystemCurrency($new_currency);

    return wp_send_json_success();
}
