<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5d2ebb3610bd3',
        'title' => __('Additional Information'),
        'fields' => array(
            array(
                'key' => 'field_5d2ebc43852fc',
                'label' =>  __('Mobile'),
                'name' => 'mobile',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
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
                'key' => 'field_5d2ebcd2852fd',
                'label' =>  __('Date of Birth'),
                'name' => 'date_of_birth',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'm/d/Y',
                'return_format' => 'm/d/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_5d2ebd48852fe',
                'label' =>  __('Gender'),
                'name' => 'gender',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'male' => 'Male',
                    'female' => 'Female',
                ),
                'default_value' => array(
                ),
                'allow_null' => 1,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
            array(
                'key' => 'field_5d2ebe8c852ff',
                'label' =>  __('City'),
                'name' => 'city',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'city',
                ),
                'taxonomy' => '',
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_5d2ec34a19148',
                'label' =>  __('Neighborhood'),
                'name' => 'neighborhood',
                'type' => 'select',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5d2ebe8c852ff',
                            'operator' => '!=empty',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ),
            array(
                'key' => 'field_5d2ec39519149',
                'label' =>  __('Address'),
                'name' => 'address',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
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
        ),
        'location' => array(
            array(
                array(
                    'param' => 'user_role',
                    'operator' => '==',
                    'value' => 'customer',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;
