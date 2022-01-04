<?php
/**
 * Serchek Theme functions and definitions
 *
 * @package Serchek_Theme
 */
 
// stuff to say we need timber activated!! see TGM Plugin activation library for php
require_once get_template_directory() . '/inc/lib/class-tgm-plugin-activation.php';

// register the required plugins(Timber) see TGM Plugin activation library for php
function serchek_theme_register_required_plugins() {
	$plugins = array(
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
add_action('tgmpa_register', 'serchek_theme_register_required_plugins');

if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

new Rmcc\SerchekTheme;

// this should be temporary until Tom is ready to start on othe pages
add_action('template_redirect','redirect_all_pages_to_home');
function redirect_all_pages_to_home() {
  if ( !is_front_page() && !is_user_logged_in()  ) {
    wp_redirect( get_home_url() );
    exit;
  }
}