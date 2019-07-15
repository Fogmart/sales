<?php

//register menus
add_action('after_setup_theme', function () {
    register_nav_menus([
        'header_menu' => __('Header menu'),
        'footer_first_column' => __('First column footer'),
        'footer_second_column' => __('Second column footer'),
        'footer_third_column' => __('Third column footer'),
    ]);
});
