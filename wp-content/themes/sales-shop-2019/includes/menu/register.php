<?php

//register menus
add_action('after_setup_theme', function () {
    register_nav_menus([
        'system_menu' => __('Do not remove'),
    ]);
});
