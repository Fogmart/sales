<?php
add_filter('woocommerce_currency', 'wcs_redefine_currency', 10, 2);

//update currency to selected from plugin widget
function wcs_redefine_currency( $currency ) {
    $wcs_settings = WCS_Settings::getInstance();
    return $wcs_settings->getSystemCurrency();
}