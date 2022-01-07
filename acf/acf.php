<?php

/**
 * ACF Options Pages
 *
 * @package Loadingdock_Theme
 */

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' 	=> 'Theme Settings',
    'menu_title'	=> 'Theme Settings',
    'menu_slug' 	=> 'theme-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));
};

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_61d6edf96bd2e',
	'title' => 'Contact Block',
	'fields' => array(
		array(
			'key' => 'field_61d6ee22d9feb',
			'label' => 'Heading',
			'name' => 'heading',
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
			'key' => 'field_61d6ee47d9fec',
			'label' => 'Address',
			'name' => 'address',
			'type' => 'textarea',
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
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'br',
		),
		array(
			'key' => 'field_61d6ee82d9fee',
			'label' => 'Openhours',
			'name' => 'openhours',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Mon - Fri, 10am - 9pm
Sat & Sun, 11am - 5pm',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'br',
		),
		array(
			'key' => 'field_61d6eef1d9ff2',
			'label' => 'Add button?',
			'name' => 'if_button',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'no' => 'No',
				'yes' => 'Yes',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'no',
			'layout' => 'horizontal',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_61d6eeafd9ff0',
			'label' => 'Button text',
			'name' => 'button_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d6eef1d9ff2',
						'operator' => '==',
						'value' => 'yes',
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
			'key' => 'field_61d6eed4d9ff1',
			'label' => 'Button link',
			'name' => 'button_link',
			'type' => 'page_link',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d6eef1d9ff2',
						'operator' => '==',
						'value' => 'yes',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'page',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'allow_archives' => 0,
			'multiple' => 0,
		),
		array(
			'key' => 'field_61d6f23c2068b',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/contact-section',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_61d76f01959d2',
	'title' => 'Cover Block',
	'fields' => array(
		array(
			'key' => 'field_61d76f01c14b7',
			'label' => 'Background image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_61d76f01c08f9',
			'label' => 'Heading',
			'name' => 'heading',
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
			'key' => 'field_61d76f01c0ce3',
			'label' => 'Message',
			'name' => 'message',
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
			'key' => 'field_61d76f6fc44cb',
			'label' => 'Custom button?',
			'name' => 'if_button',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'no' => 'No',
				'yes' => 'Yes',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'no',
			'layout' => 'horizontal',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_61d76f01c10ee',
			'label' => 'Custom button text',
			'name' => 'button_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d76f6fc44cb',
						'operator' => '==',
						'value' => 'yes',
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
			'key' => 'field_61d76f99c44cc',
			'label' => 'Custom button link',
			'name' => 'button_link',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d76f6fc44cb',
						'operator' => '==',
						'value' => 'yes',
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
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/cover-section',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_61d86002e3d53',
	'title' => 'Cover Left Block',
	'fields' => array(
		array(
			'key' => 'field_61d8600358ddf',
			'label' => 'Background image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_61d86003591dd',
			'label' => 'Heading',
			'name' => 'cover_title',
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
			'key' => 'field_61d8600359613',
			'label' => 'Message',
			'name' => 'cover_desc',
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
			'key' => 'field_61d8616c198fc',
			'label' => 'Address',
			'name' => 'cover_address',
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
			'key' => 'field_61d86179198fd',
			'label' => 'Phone',
			'name' => 'cover_phone',
			'type' => 'number',
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
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_61d86197198fe',
			'label' => 'Email',
			'name' => 'cover_email',
			'type' => 'email',
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
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/cover-left-section',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_61d7565707266',
	'title' => 'CTA Block',
	'fields' => array(
		array(
			'key' => 'field_61d756573afe1',
			'label' => 'Background Colour',
			'name' => 'cta_colour',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'enable_opacity' => 0,
			'return_format' => 'string',
		),
		array(
			'key' => 'field_61d7565739326',
			'label' => 'Heading',
			'name' => 'cta_heading',
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
			'key' => 'field_61d7565739f02',
			'label' => 'Message',
			'name' => 'cta_message',
			'type' => 'textarea',
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
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'br',
		),
		array(
			'key' => 'field_61d756573a44e',
			'label' => 'Custom button?',
			'name' => 'cta_if_button',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'no' => 'No',
				'yes' => 'Yes',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'no',
			'layout' => 'horizontal',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_61d756573a6b4',
			'label' => 'Button text',
			'name' => 'cta_button_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d756573a44e',
						'operator' => '==',
						'value' => 'yes',
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
			'key' => 'field_61d756573aaa0',
			'label' => 'Button link',
			'name' => 'cta_button_link',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d756573a44e',
						'operator' => '==',
						'value' => 'yes',
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
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/cta-section',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_61d7029f3506a',
	'title' => 'Featured Content Item Block',
	'fields' => array(
		array(
			'key' => 'field_61d70387240ad',
			'label' => 'Select featured content item',
			'name' => 'select_featured_item',
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
				0 => 'post',
				1 => 'page',
				2 => 'product',
				3 => 'winners',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_61d706143a453',
			'label' => 'Custom heading',
			'name' => 'heading',
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
			'key' => 'field_61d7062e3a455',
			'label' => 'Custom message',
			'name' => 'message',
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
			'key' => 'field_61d706263a454',
			'label' => 'Custom button text',
			'name' => 'custom_button_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_61d70387240ad',
						'operator' => '!=empty',
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
			'key' => 'field_61d70b0a1ff42',
			'label' => 'Custom image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/featured-content',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_61d86695e8f44',
	'title' => 'Featured Gallery',
	'fields' => array(
		array(
			'key' => 'field_61d86696a3e82',
			'label' => 'Heading',
			'name' => 'heading',
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
			'key' => 'field_61d86696a42a3',
			'label' => 'Message',
			'name' => 'message',
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
			'key' => 'field_61d8671f9e0e3',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_61d867329e0e4',
			'label' => 'Gallery',
			'name' => 'gallery',
			'type' => 'gallery',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'insert' => 'append',
			'library' => 'all',
			'min' => '',
			'max' => '',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/featured-gallery',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_61d741c282ad7',
	'title' => 'Featured Pages Block',
	'fields' => array(
		array(
			'key' => 'field_61d741c2b5996',
			'label' => 'Featured items',
			'name' => 'featureds_items',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_61d7426a0bbed',
			'min' => 0,
			'max' => 6,
			'layout' => 'block',
			'button_label' => 'Add featured item',
			'sub_fields' => array(
				array(
					'key' => 'field_61d7426a0bbed',
					'label' => 'Select featured item',
					'name' => 'select_featured_item',
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
						0 => 'page',
					),
					'taxonomy' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
				array(
					'key' => 'field_61d741c2b65b0',
					'label' => 'Custom text',
					'name' => 'text',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_61d741c2b5996',
								'operator' => '!=empty',
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
					'key' => 'field_61d741c2b6aaa',
					'label' => 'Custom image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_61d742e20bbee',
					'label' => 'Custom link',
					'name' => 'link',
					'type' => 'url',
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
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/featured-pages',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

acf_add_local_field_group(array(
	'key' => 'group_60d37f3ba214d',
	'title' => 'Testimonials',
	'fields' => array(
		array(
			'key' => 'field_60d37f52d3310',
			'label' => 'Testimonial Rating',
			'name' => 'testimonial_rating',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 5,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 1,
			'max' => 5,
			'step' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'testimonials',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
));

acf_add_local_field_group(array(
	'key' => 'group_61d6feddd992e',
	'title' => 'Youtube popup Block',
	'fields' => array(
		array(
			'key' => 'field_61d6fede37cca',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_61d6ff16b532a',
			'label' => 'Youtube embed url',
			'name' => 'youtube_embed_url',
			'type' => 'url',
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
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/youtube-popup',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
));

endif;


/**
 * ACF Block Functions
 *
 * @package Dream_Winners
 */

add_action( 'acf/init', 'acf_blocks_init' );
function acf_blocks_init() {
  
  if ( ! function_exists( 'acf_register_block' ) ) {
    return;
  }

  acf_register_block( array(
    'name'            => 'featured_pages',
    'title'           => 'Featured Pages',
    'description'     => 'Featured Pages',
    'render_callback' => 'featured_pages_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'featured', 'pages' ),
  ));
  acf_register_block( array(
    'name'            => 'featured_content',
    'title'           => 'Featured Content',
    'description'     => 'Featured Content',
    'render_callback' => 'featured_content_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'featured', 'content' ),
  ));
  acf_register_block( array(
    'name'            => 'featured_gallery',
    'title'           => 'Featured gallery',
    'description'     => 'Featured gallery',
    'render_callback' => 'featured_gallery_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'featured', 'content' ),
  ));
  acf_register_block( array(
    'name'            => 'testimonials',
    'title'           => 'Testimonials',
    'description'     => 'Testimonials',
    'render_callback' => 'testimonials_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'testimonials', 'rating' ),
  ));
  acf_register_block( array(
    'name'            => 'contact_section',
    'title'           => 'Contact section',
    'description'     => 'Contact section',
    'render_callback' => 'contact_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'contact', 'section' ),
  ));
  acf_register_block( array(
    'name'            => 'blog_posts',
    'title'           => 'Blog posts',
    'description'     => 'Blog posts',
    'render_callback' => 'blog_posts_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'blog', 'posts' ),
  ));
  acf_register_block( array(
    'name'            => 'youtube_popup',
    'title'           => 'Youtube popup',
    'description'     => 'Youtube popup',
    'render_callback' => 'youtube_popup_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'youtube', 'popup' ),
  ));
  acf_register_block( array(
    'name'            => 'cta_section',
    'title'           => 'CTA section',
    'description'     => 'CTA section',
    'render_callback' => 'cta_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'cta', 'section' ),
  ));
  acf_register_block( array(
    'name'            => 'cover_section',
    'title'           => 'Cover section',
    'description'     => 'Cover section',
    'render_callback' => 'cover_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'cover', 'section' ),
  ));
  acf_register_block( array(
    'name'            => 'cover_left_section',
    'title'           => 'Cover left section',
    'description'     => 'Cover left section',
    'render_callback' => 'cover_left_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'cover', 'section' ),
  ));
}

function cover_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'cover-section.twig', $context );
}
function cover_left_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'cover-left-section.twig', $context );
}
function cta_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'cta-section.twig', $context );
}
function featured_pages_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  if($context['fields']['featureds_items']){
    $selected_items = $context['fields']['featureds_items'];
    $items_ids = array_column($context['fields']['featureds_items'], 'select_featured_item');
    $selected_posts = Timber::get_posts($items_ids);
    $context['posts'] = $selected_posts;
  }
  Timber::render( 'featured-page-blocks.twig', $context );
}
function featured_content_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  if($context['fields']['select_featured_item']){
    $selected_post_id = $context['fields']['select_featured_item'];
    $selected_post = Timber::get_post($selected_post_id);
    $context['post'] = $selected_post;
  }
  Timber::render( 'featured-item.twig', $context );
}
function featured_gallery_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'featured-gallery.twig', $context );
}
function testimonials_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $testimonials_post_args = array(
    'post_type'             => 'testimonials',
    'post_status'           => 'publish',
    'posts_per_page'        => '6',
  );
  $context['testimonials'] = Timber::get_posts($testimonials_post_args);
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  remove_filter( 'the_content', 'wpautop' );
  Timber::render( 'testimonials-rating.twig', $context );
}
function contact_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'contact-section.twig', $context );
}
function blog_posts_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  $args = array(
   'post_type'             => 'post',
   'post_status'           => 'publish',
   'posts_per_page'        => '1',
  );
  $context['latest_posts_one'] = Timber::get_posts($args);
  $args = array(
   'post_type'             => 'post',
   'post_status'           => 'publish',
   'posts_per_page'        => '3',
   'offset' => '1',
  );
  $context['latest_posts_three'] = Timber::get_posts($args);
  Timber::render( 'blog-posts.twig', $context );
}
function youtube_popup_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'video-section.twig', $context );
}

function acf_blocks_editor_scripts() {
  
  wp_enqueue_style(
    'nunito-font',
    'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap'
  );
  
  // theme base css
  wp_enqueue_style(
    'loadingdock-theme',
    get_template_directory_uri() . '/assets/css/base.css'
  );
  
  // theme stylesheet
  wp_enqueue_style(
    'loadingdock-theme-styles', get_stylesheet_uri()
  );

}
add_action( 'enqueue_block_editor_assets', 'acf_blocks_editor_scripts' );