<?php
/**
 * Theme functions & bits
 *
 * @package Urban_Carnival_Theme
 */

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