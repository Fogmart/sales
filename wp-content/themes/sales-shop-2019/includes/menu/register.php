<?php

//register menus
add_action('after_setup_theme', function () {
    register_nav_menus([
        'header_menu' => __('Header menu'),
        'footer_menu' => __('Footer menu'),
    ]);
});
