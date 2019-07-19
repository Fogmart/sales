<?php
if (wp_doing_ajax()) {
    add_action('wp_ajax_nopriv_mp_settings', 'mp_settings_handler');
    add_action('wp_ajax_mp_settings', 'mp_settings_handler');

    function mp_settings_handler()
    {
        check_ajax_referer('mp_cs');

        $out['message'] = __('Saved');
        $data = $_POST['data'];

        if (!is_array($data)) {
            $out['message'] = __('Not saved');
            return wp_send_json_error($out);
        }

        $name = sanitize_title($data['name']);
        ModelPriceTable::setCode($name, $data['code']);

        return wp_send_json_success($out);
    }

    add_action('wp_ajax_nopriv_mp_settings_del', 'mp_settings_del_handler');
    add_action('wp_ajax_mp_settings_del', 'mp_settings_del_handler');

    function mp_settings_del_handler()
    {
        check_ajax_referer('mp_cs');

        $out['message'] = __('Saved');
        $data = $_POST['data'];

        if (!is_array($data)) {
            $out['message'] = __('Not saved');
            return wp_send_json_error($out);
        }

        $name = sanitize_title($data['name']);
        ModelPriceTable::deleteTable($name);

        return wp_send_json_success($out);
    }
}
