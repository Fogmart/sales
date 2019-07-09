<?php
//Woocommerce support for theme
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
    add_theme_support('woocommerce');
}

//Contact form unwrap with span
add_filter('wpcf7_form_elements', function ($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});

//Contact form theme asset tag
add_action('wpcf7_init', 'ss_contact_asset_tag');
function ss_contact_asset_tag()
{
    wpcf7_add_form_tag('ss_asset', 'ss_contact_asset_handler');
}

function ss_contact_asset_handler($tag)
{
    $path_index = array_search('path', $tag->options);
    return ss_asset($tag->values[$path_index]);
}
