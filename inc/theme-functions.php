<?php
/**
 * Theme functions & bits
 *
 * @package Urban_Carnival_Theme
 */
 
// check if is blog or post
function is_blog () {
  return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}
 
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
  $labels = nk_get_cpt_labels('Competition','Competitions');
  $args['labels'] = $labels;
  return $args;
}
add_filter( 'woocommerce_register_post_type_product', 'nk_custom_post_type_label_woo' );

function ecs_add_post_state( $post_states, $post ) {
 
 if( get_post_meta($post->ID,'_wp_page_template',true) == 'page-templates/contact-template.php' ) {
		$post_states[] = 'Contact page';
	};

	return $post_states;
}
add_filter( 'display_post_states', 'ecs_add_post_state', 10, 2 );

// change the seperator for yoast's breadcrumb
function filter_wpseo_breadcrumb_separator($this_options_breadcrumbs_sep) {
  return '<i class="fas fa-angle-right fa-sm"></i>';
};
add_filter('wpseo_breadcrumb_separator', 'filter_wpseo_breadcrumb_separator', 10, 1);