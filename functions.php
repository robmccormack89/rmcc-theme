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
    // site preloader
    array(
      'name'               => 'Site Animated Preloader by RMcC', // The plugin name.
			'slug'               => 'site-preloader-animated-plugin', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/inc/lib/plugins/site-preloader-animated-plugin-master.zip', // The plugin source.
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
add_action('tgmpa_register', 'serchek_theme_register_required_plugins');

if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

new Rmcc\SerchekTheme;