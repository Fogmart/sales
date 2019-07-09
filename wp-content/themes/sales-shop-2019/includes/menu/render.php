<?php

function ss_menu_header(){
    $out = '<div class="menu">
        <div class="container">
            <ul class="menu__content">
                <li class="menu__item"><a href="#!" class="menu__link">local</a></li>
                <li class="menu__item"><a href="#!" class="menu__link">shopping</a></li>
                <li class="menu__item"><a href="#!" class="menu__link">gateways</a></li>
            </ul>
        </div>';
    $out .= do_shortcode('[wcs_switcher classes="currency_mobile"]');
    $out .= '</div>';
    return $out;
}

function ss_menu_footer(){
    $out = '';
}