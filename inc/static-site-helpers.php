<?php
/**
 * Remove stuff from the & clean up. useful for doing wget commands on wp site to generate static version
 * wget --reject-regex "(.*)\?(.*)" -m -p -E -k -np -P dreamwinners_static/ http://dreamwinners.ie/
 *
 * @package Cautious_Octo_Fiesta
 */

function wpse33072_wp_head() {
  remove_action( 'wp_head', 'feed_links', 2 );
  remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'wp_head', 'wpse33072_wp_head', 1 );

function remove_query_strings() {
 if(!is_admin()) {
   add_filter('script_loader_src', 'remove_query_strings_split', 15);
   add_filter('style_loader_src', 'remove_query_strings_split', 15);
 }
}
function remove_query_strings_split($src){
   $output = preg_split("/(&ver|\?ver)/", $src);
   return $output[0];
}
add_action('init', 'remove_query_strings');
 
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');
add_filter( 'rest_enabled', '__return_false' );
add_filter( 'rest_jsonp_enabled', '__return_false' );
add_filter('xmlrpc_enabled', '__return_false');
add_filter( 'embed_oembed_discover', '__return_false' );
add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
add_filter('xmlrpc_methods', function () { 
  return []; 
}, PHP_INT_MAX);
add_filter('wp_headers', function($headers, $wp_query){
  if (array_key_exists('X-Pingback', $headers)) {
    unset($headers['X-Pingback']);
  }
  return $headers;
}, 11, 2);
add_filter('bloginfo_url', function($output, $property){
  error_log("====property=" . $property);
  return ($property == 'pingback_url') ? null : $output;
}, 11, 2);

remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wlwmanifest_link');

remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

add_action('wp', function(){
  remove_action('wp_head', 'rsd_link');
}, 11);

function disable_embeds_tiny_mce_plugin($plugins) {
  return array_diff($plugins, array('wpembed'));
}
function disable_embeds_rewrites($rules) {
  foreach($rules as $rule => $rewrite) {
      if(false !== strpos($rewrite, 'embed=true')) {
          unset($rules[$rule]);
      }
  }
  return $rules;
}