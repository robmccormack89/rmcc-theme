<?php
/**
 * Loadingdock Theme functions and definitions
 *
 * @package Loadingdock_Theme
 */
 
// stuff to say we need timber activated!! see TGM Plugin activation library for php
require_once get_template_directory() . '/inc/lib/class-tgm-plugin-activation.php';

// register the required plugins(Timber) see TGM Plugin activation library for php
function loadingdock_theme_register_required_plugins() {
	$plugins = array(
    // acf pro
    array(
      'name'               => 'Advanced Custom Fields PRO', // The plugin name.
			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/inc/lib/plugins/advanced-custom-fields-pro.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
    // loco translate
    array(
      'name' => 'Loco Translate',
			'slug' => 'loco-translate',
			'required' => false
		),
	);
	$config  = array(
		'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu' => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug' => 'themes.php', // Parent menu slug.
		'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices' => true, // Show admin notices or not.
		'dismissable' => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false, // Automatically activate plugins after installation or not.
		'message' => '' // Message to output right before the plugins table.
	);
	tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'loadingdock_theme_register_required_plugins');

if ( class_exists( 'ACF' ) ) {
  if( function_exists('acf_add_options_page') ) {
    // the options pages
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
    	'key' => 'group_61d4a24beaa13',
    	'title' => 'Homepage text content',
    	'fields' => array(
    		array(
    			'key' => 'field_61d4a25f1684e',
    			'label' => 'How to modify text on the homepage & elsewhere (translations)',
    			'name' => '',
    			'type' => 'message',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'message' => '<a href="https://loadingdock.ie/wp-admin/admin.php?path=themes%2Floadingdock-theme%2Flanguages%2Fen_GB.po&bundle=loadingdock-theme&domain=loadingdock-theme&page=loco-theme&action=file-edit" target="_blank">Click here</a> to start modifying text strings in your theme via Loco Translate.',
    			'new_lines' => 'wpautop',
    			'esc_html' => 0,
    		),
    	),
    	'location' => array(
    		array(
    			array(
    				'param' => 'options_page',
    				'operator' => '==',
    				'value' => 'theme-settings',
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
    	'show_in_rest' => 0,
    ));
    acf_add_local_field_group(array(
    	'key' => 'group_61d4699ed1bf9',
    	'title' => 'Homepage imagery',
    	'fields' => array(
    		array(
    			'key' => 'field_61d469f4cb4c1',
    			'label' => 'Homepage Cover',
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
    			'endpoint' => 0,
    		),
    		array(
    			'key' => 'field_61d46a8097684',
    			'label' => 'Homepage Cover image',
    			'name' => 'homepage_cover_image',
    			'type' => 'image',
    			'instructions' => 'Select/upload the image for the Homepage Cover. This will overwrite the default image. This can itself be overwritten by setting a Featured Image to the Homepage.',
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
    			'key' => 'field_61d46a2c3ea4f',
    			'label' => 'Homepage Slider',
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
    			'endpoint' => 0,
    		),
    		array(
    			'key' => 'field_61d46afc8aefa',
    			'label' => 'Homepage Slider images',
    			'name' => 'homepage_slider_images',
    			'type' => 'gallery',
    			'instructions' => 'Select/upload the images for the Homepage Slider(beneath the cover). These will overwrite the default slider images.',
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
    		array(
    			'key' => 'field_61d47bfada649',
    			'label' => 'Homepage Gallery',
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
    			'endpoint' => 0,
    		),
    		array(
    			'key' => 'field_61d47c02da64a',
    			'label' => 'Homepage Gallery images',
    			'name' => 'homepage_gallery_images',
    			'type' => 'gallery',
    			'instructions' => 'Select/upload the images for the Homepage Gallery(beside the slider). These will overwrite the default gallery images.',
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
    		array(
    			'key' => 'field_61d46a3a3ea50',
    			'label' => 'Homepage Contact Section',
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
    			'endpoint' => 0,
    		),
    		array(
    			'key' => 'field_61d46bc883187',
    			'label' => 'Homepage Contact Section image',
    			'name' => 'homepage_contact_section_image',
    			'type' => 'image',
    			'instructions' => 'Select/upload the image for the Homepage Contact Section(above the footer). This will overwrite the default image.',
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
    				'param' => 'options_page',
    				'operator' => '==',
    				'value' => 'theme-settings',
    			),
    		),
    	),
    	'menu_order' => 1,
    	'position' => 'normal',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => true,
    	'description' => '',
    	'show_in_rest' => 0,
    ));
  endif;
};

if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

new Rmcc\LoadingdockTheme;

// this should be temporary until Tom is ready to start on other pages
add_action('template_redirect','redirect_all_pages_to_home');
function redirect_all_pages_to_home() {
  if ( !is_front_page() && !is_user_logged_in()  ) {
    wp_redirect( get_home_url() );
    exit;
  }
}