<?php

//header menu
function ss_menu_header()
{
    $menu_list = '';
    $menu_name = 'header_menu';
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<div class="menu"><div class="container"><ul class="menu__content">';
        foreach ((array) $menu_items as $key => $menu_item) {
            $menu_list .= '<li class="menu__item"><a href="'.$menu_item->url.'" class="menu__link">'.$menu_item->title.'</a></li>';
        }
        $menu_list .= '</ul></div>';
        $menu_list .= do_shortcode('[wcs_switcher classes="currency_mobile"]');
        $menu_list .= '</div>';
    }
    return $menu_list;
}

//Footer menus
function ss_menu_footer_column($column)
{
    $menu_list = '';
    $menu_name = 'footer_' . $column . '_column';
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
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
    return ss_menu_footer_column('first');
}
function ss_menu_footer_second()
{
    return ss_menu_footer_column('second');
}
function ss_menu_footer_third()
{
    return ss_menu_footer_column('third');
}
//footer menus end
