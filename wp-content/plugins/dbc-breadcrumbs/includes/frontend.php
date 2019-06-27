<?php
function dbc_render_shortcode(){
    $items = dbc_get_items();
    
    $t_container = dbc_container_template();
    $t_one = dbc_one_template();
    $t_last = dbc_last_template();

    return dbc_render($t_container, $t_one, $t_last, $items);
}
add_shortcode('dbc_breadcrumbs', 'dbc_render_shortcode');