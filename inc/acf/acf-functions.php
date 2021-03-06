<?php
/**
* ACF Functions
* @package Urban_Carnival_Theme
*/

function editor_settings( $settings ) {
  global $post_type;
  
  if ( $post_type == 'slide' ) {
    $settings[ 'tinymce' ] = false;
  };
  
  if ( $post_type == 'mega_menu' ) {
    $settings[ 'tinymce' ] = false;
  };
  
  return $settings;
}
add_filter( 'wp_editor_settings', 'editor_settings' );

/* add options page in backend via acf */;
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'site-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
};

// if( function_exists('acf_add_local_field_group') ):
// 
// acf_add_local_field_group(array(
// 	'key' => 'group_5fc51ff79687a',
// 	'title' => 'Home Banner Slides Fields',
// 	'fields' => array(
// 		array(
// 			'key' => 'field_5fc52020bdb94',
// 			'label' => 'Home Banner Slide Subtitle',
// 			'name' => 'home_banner_slide_subtitle',
// 			'type' => 'text',
// 			'instructions' => '',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'default_value' => '',
// 			'placeholder' => 'Add the subtitle for the Banner Slide',
// 			'prepend' => '',
// 			'append' => '',
// 			'maxlength' => '',
// 		),
// 		array(
// 			'key' => 'field_5fc52053bdb95',
// 			'label' => 'Home Banner Slide Button Text',
// 			'name' => 'home_banner_slide_button_text',
// 			'type' => 'text',
// 			'instructions' => '',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'default_value' => '',
// 			'placeholder' => 'Add the text for the button in the Banner Slide',
// 			'prepend' => '',
// 			'append' => '',
// 			'maxlength' => '',
// 		),
// 		array(
// 			'key' => 'field_5fc52079bdb96',
// 			'label' => 'Home Banner Slide Button Link',
// 			'name' => 'home_banner_slide_button_link',
// 			'type' => 'url',
// 			'instructions' => '',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'default_value' => '',
// 			'placeholder' => 'Add the URL for the Banner Slide button',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'post_type',
// 				'operator' => '==',
// 				'value' => 'slide',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'top',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
// 
// acf_add_local_field_group(array(
// 	'key' => 'group_60412cb05f9c9',
// 	'title' => 'Product Series Fields',
// 	'fields' => array(
// 		array(
// 			'key' => 'field_60412cddbdefd',
// 			'label' => 'Series Thumbnail',
// 			'name' => 'series_thumbnail',
// 			'type' => 'image',
// 			'instructions' => 'Upload the thumbnail image for Series/Model. Recommended to upload image with dimensions of 215px by 150px	(jpg or png)',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'return_format' => 'array',
// 			'preview_size' => 'medium',
// 			'library' => 'all',
// 			'min_width' => '',
// 			'min_height' => '',
// 			'min_size' => '',
// 			'max_width' => 1000,
// 			'max_height' => 1000,
// 			'max_size' => 2,
// 			'mime_types' => '.jpg, .png',
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'taxonomy',
// 				'operator' => '==',
// 				'value' => 'product_series',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'top',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
// 
// acf_add_local_field_group(array(
// 	'key' => 'group_5fc3ebf0d7bb9',
// 	'title' => 'Site Settings',
// 	'fields' => array(
// 		array(
// 			'key' => 'field_5fc3ec1c28779',
// 			'label' => 'Homepage Settings',
// 			'name' => '',
// 			'type' => 'tab',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'placement' => 'top',
// 			'endpoint' => 0,
// 		),
// 		array(
// 			'key' => 'field_5fc3ec732877b',
// 			'label' => 'Homepage Featured Products',
// 			'name' => 'homepage_product_selection',
// 			'type' => 'post_object',
// 			'instructions' => 'Pick the featured products to display on the homepage',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'post_type' => array(
// 				0 => 'product',
// 			),
// 			'taxonomy' => '',
// 			'allow_null' => 0,
// 			'multiple' => 1,
// 			'return_format' => 'id',
// 			'ui' => 1,
// 		),
// 		array(
// 			'key' => 'field_5fc41a5c8995f',
// 			'label' => 'Homepage Product Category Section Title',
// 			'name' => 'homepage_product_category_section_title',
// 			'type' => 'text',
// 			'instructions' => 'Enter a title to go to the top of the homepage product category section',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'default_value' => 'Shop by Category',
// 			'placeholder' => '',
// 			'prepend' => '',
// 			'append' => '',
// 			'maxlength' => '',
// 		),
// 		array(
// 			'key' => 'field_5fc3ed22adf5d',
// 			'label' => 'Homepage Product Category Selection',
// 			'name' => 'homepage_product_category_selection',
// 			'type' => 'taxonomy',
// 			'instructions' => 'Pick the product categories to show on the Homepage',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'taxonomy' => 'product_cat',
// 			'field_type' => 'multi_select',
// 			'allow_null' => 0,
// 			'add_term' => 0,
// 			'save_terms' => 0,
// 			'load_terms' => 0,
// 			'return_format' => 'id',
// 			'multiple' => 0,
// 		),
// 		array(
// 			'key' => 'field_5fc418ec337fa',
// 			'label' => 'Homepage Product Category Columns',
// 			'name' => 'homepage_product_category_columns',
// 			'type' => 'select',
// 			'instructions' => '',
// 			'required' => 1,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'choices' => array(
// 				3 => '3',
// 				4 => '4',
// 				5 => '5',
// 				6 => '6',
// 			),
// 			'default_value' => 3,
// 			'allow_null' => 0,
// 			'multiple' => 0,
// 			'ui' => 0,
// 			'return_format' => 'value',
// 			'ajax' => 0,
// 			'placeholder' => '',
// 		),
// 		array(
// 			'key' => 'field_5fc3ecc02877c',
// 			'label' => 'General Settings',
// 			'name' => '',
// 			'type' => 'tab',
// 			'instructions' => '',
// 			'required' => 0,
// 			'conditional_logic' => 0,
// 			'wrapper' => array(
// 				'width' => '',
// 				'class' => '',
// 				'id' => '',
// 			),
// 			'placement' => 'top',
// 			'endpoint' => 0,
// 		),
// 	),
// 	'location' => array(
// 		array(
// 			array(
// 				'param' => 'options_page',
// 				'operator' => '==',
// 				'value' => 'site-settings',
// 			),
// 		),
// 	),
// 	'menu_order' => 0,
// 	'position' => 'normal',
// 	'style' => 'default',
// 	'label_placement' => 'top',
// 	'instruction_placement' => 'label',
// 	'hide_on_screen' => '',
// 	'active' => true,
// 	'description' => '',
// ));
// 
// endif;