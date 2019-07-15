<?php

//scripts
function MP_frontend_scripts(){
    wp_register_style('MP_cloned', MP_STYLES . '/cloned-styles.min.css', array(), false, 'all');
}
add_action( 'wp_enqueue_scripts', 'MP_frontend_scripts');

//render switcher shortcode
function MP_render_shortcode()
{   
    wp_enqueue_style('MP_cloned');
    return ModelPriceTable::getCode();
}
add_shortcode('model_price_table', 'MP_render_shortcode');