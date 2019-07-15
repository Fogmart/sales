<?php
//Seller role
add_role(
    'seller',
    __('Seller'),
    array(
        'read'         => true,
        'edit_posts'   => false,
        'delete_posts' => false,
    )
);

//Customer role
add_role(
    'customer',
    __('Customer'),
    array(
        'read'         => true,
        'edit_posts'   => false,
        'delete_posts' => false,
    )
);