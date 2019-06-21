<?php

//ригестрируем шорт код для вывода плагина
function sld_render_shortcode()
{
    include(SLD_PLUGIN . '/parts/main.php');
}
add_shortcode('sld_spec_list', 'sld_render_shortcode');

//регестрируем скрипты и стили для фронтенда
add_action('admin_init', 'sld_register_assets');
add_action('init', 'sld_register_assets');
function sld_register_assets()
{
    wp_enqueue_script('sld_read_file_script', plugins_url('/assets/js/readFile.js', __DIR__), array('jquery'), false);
    wp_enqueue_script('sld_index_script', plugins_url('/assets/js/index.js', __DIR__), array('sld_read_file_script'), false);
}
