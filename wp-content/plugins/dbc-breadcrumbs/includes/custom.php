<?php
//render items to code
function dbc_render($container, $one, $last, $items){
    $last_item = array_pop($items);
    $items_r = '';

    //all items, except last
    foreach($items as $item){
        $item_one__r = str_replace('@name', $item['name'], $one);
        $item_one__r = str_replace('@link', $item['link'], $item_one__r);
        $items_r .= $item_one__r;
    }

    //last item
    $item_one__r = str_replace('@name', $last_item['name'], $last);
    $item_one__r = str_replace('@link', $last_item['link'], $item_one__r);
    $items_r .= $item_one__r;

    return str_replace('@loop', $items_r, $container);
}

//construct item
function dbc_item($name, $link = null){
    return compact('name', 'link');
}

//get breadcrumbs items
function dbc_get_items(){
    $object = get_queried_object();
    $items[] = dbc_item(_('Home'), get_home_url());    

    if(is_single()){
        $category = is_product() ? wp_get_post_terms($object->ID, 'product_cat') : get_the_category();
        $term = array_shift($category);
        if($term){
            $items[] = dbc_item($term->name, get_term_link($term->term_id));
        }
    }

    $current = isset($object->name) ? $object->name : $object->post_title;
    $items[] = dbc_item($current);

    return $items;
}