<?php
/**
* Woo functions
*
* @package Cautious_Octo_Fiesta
*/

/**
 * Remove stuff from the document & clean up in Wordpress. Useful for doing wget commands on a WP site to generate static version
 * Example wget command: wget --reject-regex "(.*)\?(.*)" -m -p -E -k -np -P static/ https://dreamwinners.ie/
 * See https://www.gnu.org/software/wget/ for more
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

/**
 * WOOCOMMERCE CUSTOMIZE CPT LABELS: SINGULAR & PLURAL
 * we set it here to Competition/Competitions
 *
**/
  
function nk_get_cpt_labels($single,$plural){
   $arr = array(
    'name' => $plural,
    'singular_name' => $single,
    'menu_name' => $plural,
    'add_new' => 'Add '.$single,
    'add_new_item' => 'Add New '.$single,
    'edit' => 'Edit',
    'edit_item' => 'Edit '.$single,
    'new_item' => 'New '.$single,
    'view' => 'View '.$plural,
    'view_item' => 'View '.$single,
    'search_items' => 'Search '.$plural,
    'not_found' => 'No '.$plural.' Found',
    'not_found_in_trash' => 'No '.$plural.' Found in Trash',
    'parent' => 'Parent '.$single
 );
   return $arr;
}
// change the post type labels for the Competition cpt
function nk_custom_post_type_label_woo( $args ){
  $labels = nk_get_cpt_labels(
    _x( 'Competition', 'Products label: Singular', 'cautious-octo-fiesta' ), 
    _x( 'Competitions', 'Products label: Plural', 'cautious-octo-fiesta' )
  );
  $args['labels'] = $labels;
  return $args;
}
add_filter('woocommerce_register_post_type_product', 'nk_custom_post_type_label_woo');

/**
 * REMOVE WOO SCRIPTS & STYLES SELECTIVELY
 * can use this to override woo frontend scripts like add-to-cart.min.js
 * also use this to remove default woo styles for various bits
 * see assets/scss/woo for custom woo build as part of base.css
 *
**/
  
function theme_woo_script_styles() {
  remove_action('wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
  wp_dequeue_style( 'woocommerce_frontend_styles' );
  wp_dequeue_style( 'woocommerce-general');
  wp_dequeue_style( 'woocommerce-layout' );
  wp_dequeue_style( 'woocommerce-smallscreen' );
  wp_dequeue_style( 'woocommerce_fancybox_styles' );
  wp_dequeue_style( 'woocommerce_chosen_styles' );
  wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
  wp_dequeue_script( 'selectWoo' );
  wp_deregister_script( 'selectWoo' );
  wp_dequeue_script( 'select2' );
  wp_deregister_script( 'select2' );
}
add_action('wp_enqueue_scripts', 'theme_woo_script_styles', 99);

/**
 * Single Product Custom Parts
 * did this so as to move some stuff around on single product design
 *
**/

function single_title(){
  echo the_title('<h1 class="product_title entry-title uk-h2">', '</h1>');
}
add_action('single_title', 'single_title');

function single_price(){
  global $product;
  echo '<p class="';
  echo esc_attr(apply_filters( 'woocommerce_product_price_class', 'price'));
  echo '">';
  echo $product->get_price_html();
  echo '</p>';
}
add_action('single_price', 'single_price');

function single_excerpt(){
  global $post;
  $short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);
  if (!$short_description) {
  	return;
  }
  echo '<div class="woocommerce-product-details__short-description">';
  echo $short_description;
  echo '</div>';
}
add_action('single_excerpt', 'single_excerpt');

function single_sales_flash(){
  global $post, $product;

  if ( $product->is_on_sale() ) :
    echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html_x( 'Sale!', 'Onsale label', 'cautious-octo-fiesta' ) . '</span>', $post, $product );
  endif;
}
add_action('single_sales_flash', 'single_sales_flash');

/**
 * WOO ACTIONS: ADD/REMOVE DEFAULTS
 *
**/

// archives
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10); // unnecessary in any context
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10); // unnecessary in any context
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10); // replaced by theme pagination

// tease
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10); // unnecessary in any context
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5); // unnecessary in any context
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10); // replaced with custom thumb markup
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10); // replaced with custom title markup
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5); // just removed for now. not displaying ratings in teases

// single
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10); // just removed for now. not displaying ratings on singles
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5); // replaced in twig with single_title
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10); // replaced in twig with single_price
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20); // replaced in twig with single_excerpt

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10); // replaced in twig with single_sales_flash
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20); // replaced in twig with custom gallery markup (lightgallery)
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15); // replaced with custom upsells markup
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20); // replaced with custom relateds markup

// general filters
add_filter( 'wc_product_sku_enabled', '__return_false' ); // remove skus globally
add_filter( 'woocommerce_redirect_single_search_result', '__return_false'); // stop redirecting search when only one result