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

//Contact form theme asset tag start
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
//Contact form theme asset tag end


//Disable plugin update notification
add_filter('site_transient_update_plugins', 'remove_update_notification');
function remove_update_notification($value)
{
    //woocommerce gallery extending with videos
    unset($value->response["woocommerce-embed-videos-to-product-image-gallery/woocommerce-embed-videos-product-image-gallery.php"]);
    return $value;
}

//API KEYS
function my_acf_init()
{
    acf_update_setting('google_api_key', GOOGLE_API_KEY);
}
add_action('acf/init', 'my_acf_init');


//CHECKOUT PAGE CUSTOM URL
function ss_custom_checkout_url($url)
{

    // Force SSL if needed
    $scheme = (is_ssl() || 'yes' === get_option('woocommerce_force_ssl_checkout')) ? 'https' : 'http';
    $url = site_url(SS_CHECKOUT_PAGE, $scheme);

    return $url;
}
add_filter('woocommerce_get_checkout_url', 'ss_custom_checkout_url', 10, 2);


//CART PAGE CUSTOM URL
function ss_custom_cart_url($url)
{

    // Force SSL if needed
    $scheme = (is_ssl() || 'yes' === get_option('woocommerce_force_ssl_checkout')) ? 'https' : 'http';
    $url = site_url(SS_CART_PAGE, $scheme);

    return $url;
}
add_filter('woocommerce_get_cart_url', 'ss_custom_cart_url', 10, 2);
