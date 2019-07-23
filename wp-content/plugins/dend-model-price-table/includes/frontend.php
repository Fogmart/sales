<?php

//scripts
function MP_frontend_scripts()
{
    wp_register_style('MP_cloned', MP_STYLES . '/cloned-styles.min.css', array(), false, 'all');
    wp_register_script('MP_cloned_script', MP_SCRIPTS . '/cloned.js');
}
add_action('wp_enqueue_scripts', 'MP_frontend_scripts');

//render switcher shortcode
function MP_render_shortcode($atts)
{
    $attr = shortcode_atts([
        'table' => ''
    ], $atts);

    wp_enqueue_style('MP_cloned');
    wp_enqueue_script('MP_cloned_script');
    
    $table_key = ModelPriceTable::getTableKey(urlencode($attr['table']));
    return ModelPriceTable::getCode($table_key) ?: '';
}
add_shortcode('model_price_table', 'MP_render_shortcode');
