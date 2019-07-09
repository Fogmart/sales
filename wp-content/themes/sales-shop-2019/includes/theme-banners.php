<?php
/**
 * General method for banners rendering
 */
function ss_banner($banner_id, $page_width_style){
    set_query_var('ss_banner_id', $banner_id);
    get_template_part('parts/banner', $page_width_style);
    remove_query_arg('ss_banner_id');
}

/**
 * Render one of three page with banner
 */
function ss_banner_one($banner_id){
    ss_banner($banner_id, 'one');
}

/**
 * Render two of three page with banner
 */
function ss_banner_two($banner_id){
    ss_banner($banner_id, 'two');
}

/**
 * Render full page with banner
 */
function ss_banner_full($banner_id){
    ss_banner($banner_id, 'three');
}