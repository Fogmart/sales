<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5d428e05e0368',
        'title' => __('Sidebar in the buyer\'s dashboard'),
        'fields' => array(
            array(
                'key' => 'field_5d428f4434da8',
                'label' => __('Enable sidebar'),
                'name' => 'enable_sidebar',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    0 => __('off'),
                    1 => __('on'),
                ),
                'allow_null' => 0,
                'default_value' => 0,
                'layout' => 'horizontal',
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_5d428fd334da9',
                'label' => __('Headline'),
                'name' => 'headline_sidebar',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5d428f4434da8',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5d42902834daa',
                'label' => __('Body'),
                'name' => 'body_sidebar',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5d428f4434da8',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_template',
                    'operator' => '==',
                    'value' => 'account-page-template.php',
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
        ),
        'active' => true,
        'description' => '',
    ));

endif;
