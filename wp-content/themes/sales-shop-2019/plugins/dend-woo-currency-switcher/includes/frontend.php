<?php

//scripts
function wcs_frontend_scripts(){
    wp_register_script('wcs_frontend', WCS_SCRIPTS . '/frontend.js', false);
    wp_localize_script( 'wcs_frontend', 'wcsData', array( 
        'wcs_cc' => wp_create_nonce("wcs_cc"), 
    ) );
}
add_action( 'wp_enqueue_scripts', 'wcs_frontend_scripts');

//render switcher shortcode
function wcs_render_shortcode()
{   
    wp_enqueue_script('wcs_frontend');
    $plugin_core = WCS_Settings::getInstance();
    return $plugin_core->renderWidget();
}
add_shortcode('wcs_switcher', 'wcs_render_shortcode');
