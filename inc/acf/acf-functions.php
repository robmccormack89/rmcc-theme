<?php
/**
* ACF Functions
* @package Cautious_Octo_Fiesta
*/

function editor_settings( $settings ) {
  global $post_type;
  
  if ( $post_type == 'slide' ) {
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

// add local php field groups from acf - the json for these groups is saved into main site directory for reimporting and editing the fields
if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array(
  	'key' => 'group_5e8de4fdbcea9',
  	'title' => 'Entry List Group',
  	'fields' => array(
  		array(
  			'key' => 'field_5e8de529c1f06',
  			'label' => 'PDF Upload',
  			'name' => 'pdf_upload',
  			'type' => 'file',
  			'instructions' => 'Upload your Entry List PDF',
  			'required' => 1,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'return_format' => 'array',
  			'library' => 'all',
  			'min_size' => '',
  			'max_size' => '',
  			'mime_types' => '',
  		),
  		array(
  			'key' => 'field_5e8de56e8657d',
  			'label' => 'Draw Date',
  			'name' => 'draw_date',
  			'type' => 'text',
  			'instructions' => 'Enter the date the competition was drawn on',
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
  	),
  	'location' => array(
  		array(
  			array(
  				'param' => 'post_type',
  				'operator' => '==',
  				'value' => 'entry_lists',
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

  acf_add_local_field_group(array(
  	'key' => 'group_5e8dfddec654c',
  	'title' => 'Live Draw Group',
  	'fields' => array(
  		array(
  			'key' => 'field_5e8dfe94a5dae',
  			'label' => 'Live Draw Link',
  			'name' => 'live_draw_link',
  			'type' => 'wysiwyg',
  			'instructions' => '',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '',
  			'tabs' => 'text',
  			'media_upload' => 0,
  			'toolbar' => 'full',
  			'delay' => 0,
  		),
  	),
  	'location' => array(
  		array(
  			array(
  				'param' => 'post_type',
  				'operator' => '==',
  				'value' => 'live_draws',
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

  acf_add_local_field_group(array(
  	'key' => 'group_5fc3ebf0d7bb9',
  	'title' => 'Site Settings',
  	'fields' => array(
  		array(
  			'key' => 'field_5fc3ecc02877c',
  			'label' => 'General Settings',
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
  			'placement' => 'top',
  			'endpoint' => 0,
  		),
  		array(
  			'key' => 'field_60425edbc8b65',
  			'label' => 'Company Phone Number',
  			'name' => 'company_phone_number',
  			'type' => 'text',
  			'instructions' => 'Enter the Business Phone number; to be used in navigation, contact page links etc.',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '+01 234 5678',
  			'placeholder' => '',
  			'prepend' => '',
  			'append' => '',
  			'maxlength' => '',
  		),
  		array(
  			'key' => 'field_60425efdc8b66',
  			'label' => 'Facebook Link',
  			'name' => 'facebook_link',
  			'type' => 'url',
  			'instructions' => 'Enter the URL to the business\' Facebook page; to be used in navigation etc.',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '#',
  			'placeholder' => '',
  		),
  		array(
  			'key' => 'field_604645c5b4f3c',
  			'label' => 'Instagram Link',
  			'name' => 'insta_link',
  			'type' => 'url',
  			'instructions' => 'Enter the URL to the business\' Instagram page; to be used in navigation etc.',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '#',
  			'placeholder' => '',
  		),
  		array(
  			'key' => 'field_60425f1ec8b67',
  			'label' => 'Display email',
  			'name' => 'display_email',
  			'type' => 'email',
  			'instructions' => 'Enter the email for the business; to be used in navigation, contact page links etc.',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => 'info@masseyfergusontractors.ie',
  			'placeholder' => '',
  			'prepend' => '',
  			'append' => '',
  		),
  		array(
  			'key' => 'field_60425e52c8b64',
  			'label' => 'Above Footer Text',
  			'name' => 'above_footer_text',
  			'type' => 'text',
  			'instructions' => 'Enter the text you want to appear in the section which appears above the footer (muted grey section). This section is used across several templates.',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => 'Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.',
  			'placeholder' => '',
  			'prepend' => '',
  			'append' => '',
  			'maxlength' => '',
  		),
  	),
  	'location' => array(
  		array(
  			array(
  				'param' => 'options_page',
  				'operator' => '==',
  				'value' => 'site-settings',
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