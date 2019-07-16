<?php

//header menu
function ss_menu_header()
{
    $menu_list = '';
    $menu_option_key = 'header-menu';
    global $ss_theme_option;
    $menu_list = '';
    $menu_id = $ss_theme_option[$menu_option_key];

    if ($menu_id) {
        $menu = wp_get_nav_menu_object($menu_id);
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<div class="menu"><div class="container"><ul class="menu__content">';
        foreach ((array) $menu_items as $key => $menu_item) {
            $menu_list .= '<li class="menu__item"><a href="' . $menu_item->url . '" class="menu__link">' . $menu_item->title . '</a></li>';
        }
        $menu_list .= '</ul></div>';
        $menu_list .= do_shortcode('[wcs_switcher classes="currency_mobile"]');
        $menu_list .= '</div>';
    }
    return $menu_list;
}

//Footer menus
function ss_menu_footer_column($menu_option_key)
{
    global $ss_theme_option;
    $menu_list = '';
    $menu_id = $ss_theme_option[$menu_option_key];

    if ($menu_id) {
        $menu = wp_get_nav_menu_object($menu_id);
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<div class="footer__title">' . $menu->name . '</div>';
        $menu_list = '<div class="footer__block"><h4 class="footer__item__title">' . $menu->name . '</h4>';
        $menu_list .= '<ul class="footer__menu">';
        foreach ((array) $menu_items as $key => $menu_item) {
            $menu_list .= '<li class="footer__item"><a href="' . $menu_item->url . '" class="footer__link">' . $menu_item->title . '</a></li>';
        }
        $menu_list .= '</ul>';
        $menu_list .= '</div>';
    }
    return $menu_list;
}

function ss_menu_footer_first()
{
    return ss_menu_footer_column('footer-menu-first');
}
function ss_menu_footer_second()
{
    return ss_menu_footer_column('footer-menu-second');
}
function ss_menu_footer_third()
{
    return ss_menu_footer_column('footer-menu-third');
}
//footer menus end
