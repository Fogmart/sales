<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5d2ed5b6737f9',
	'title' => 'Review setting',
	'fields' => array(
		array(
			'key' => 'field_5d2ed5bb1e7ed',
			'label' => 'Rating',
			'name' => 'rating',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 0,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 0,
			'max' => 5,
			'step' => 1,
		),
		array(
			'key' => 'field_5d2ed77cc3371',
			'label' => 'Customer',
			'name' => 'customer',
			'type' => 'user',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => array(
				0 => 'customer',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
		),
		array(
			'key' => 'field_5d2edab544771',
			'label' => 'Seller',
			'name' => 'seller',
			'type' => 'user',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => array(
				0 => 'seller',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'array',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'review',
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