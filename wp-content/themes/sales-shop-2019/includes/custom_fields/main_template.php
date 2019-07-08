<?php
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_5d234ed48a856',
        'title' => 'Main template fields',
        'fields' => array(
            array(
                'key' => 'field_5d234fc5b9212',
                'label' => 'Banners',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 1,
            ),
            array(
                'key' => 'field_5d234edcb920e',
                'label' => 'Banner Top',
                'name' => 'banner_top',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'banner',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_5d234f90b9210',
                'label' => 'Banner Middle Left',
                'name' => 'banner_middle_left',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '66',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'banner',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_5d234fb6b9211',
                'label' => 'Banner Middle Right',
                'name' => 'banner_middle_right',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'banner',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_5d234f44b920f',
                'label' => 'Banner Bottom',
                'name' => 'banner_bottom',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'banner',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_template',
                    'operator' => '==',
                    'value' => 'main-page-template.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'the_content',
            1 => 'excerpt',
            2 => 'discussion',
            3 => 'comments',
            4 => 'format',
            5 => 'page_attributes',
            6 => 'featured_image',
            7 => 'categories',
            8 => 'tags',
        ),
        'active' => true,
        'description' => '',
    ));

endif;
