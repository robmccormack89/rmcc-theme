<?php

global $configs;

if(!$configs['enable_acf']) return;

if(!function_exists('is_plugin_active')) include_once ABSPATH . 'wp-admin/includes/plugin.php';

// Check if another plugin or theme has bundled ACF
if(defined('MY_ACF_PATH')) return;

// Check if ACF PRO is active & Abort all bundling, ACF PRO plugin takes priority
if(is_plugin_active('advanced-custom-fields-pro/acf.php')) return;

// Define path and URL to the ACF plugin.
define('MY_ACF_PATH', get_stylesheet_directory() . '/inc/acf/');
define('MY_ACF_URL', get_stylesheet_directory_uri() . '/inc/acf/');

// Include the ACF plugin.
include_once(MY_ACF_PATH . 'acf.php');

// Customize the URL setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url($url) {
  return MY_ACF_URL;
}

// Check if the ACF free plugin is activated
if(is_plugin_active('advanced-custom-fields/acf.php')){
  // Free plugin activated, show notice
  add_action('admin_notices', function() {
    ?>
    <div class="updated" style="border-left: 4px solid #ffba00;">
      <p>The ACF plugin cannot be activated at the same time as Third-Party Product and has been deactivated. Please keep ACF installed to allow you to use ACF functionality.</p>
    </div>
    <?php
  },99);
  // Disable ACF free plugin
  deactivate_plugins('advanced-custom-fields/acf.php');
}

// Check if ACF free is installed, then hide ACF admin menu item & Updates menu
if($configs['hide_acf_menus'] && (!file_exists(WP_PLUGIN_DIR . '/advanced-custom-fields/acf.php'))) {
  add_filter('acf/settings/show_admin', '__return_false');
  add_filter('acf/settings/show_updates', '__return_false', 100);
}

function local_json_save_point( $path ) {
  return get_stylesheet_directory() . '/inc/acf-json';
}
add_filter('acf/settings/save_json', 'local_json_save_point');

function local_json_load_point( $paths ) {
  unset($paths[0]); // Remove the original path (optional).
  $paths[] = get_stylesheet_directory() . '/inc/acf-json'; // Append the new path
  return $paths;    
}
add_filter( 'acf/settings/load_json', 'local_json_load_point' );

// blocks
if(class_exists('ACF')) new Rmcc\Blocks;