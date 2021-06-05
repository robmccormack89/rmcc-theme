<?php
/**
* Theme functions & bits
*
* @package Cautious_Octo_Fiesta
*/
 
function set_posts_per_page_for_entry_lists( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'entry_lists' ) ) {
    $query->set( 'posts_per_page', '6' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_entry_lists' );
 
function set_posts_per_page_for_winners( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'winners' ) ) {
    $query->set( 'posts_per_page', '8' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_winners' );
 
function dates_to_days($date) {
  $date1 = new DateTime('now');
  $date2 = new DateTime($date);
  $days  = $date2->diff($date1)->format('%a');
  return $days;
}

function times_to_hours($date) {
  $date1 = new DateTime('now');
  $date2 = new DateTime($date);
  $days  = $date2->diff($date1)->format('%h');
  return $days;
}
 
// check if is blog or post
function is_blog () {
  return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

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