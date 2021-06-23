<?php
/**
* The front page template (when backend settings for front page display are set to static or latest posts)
*
* @package Cautious_Octo_Fiesta
*/

/**
 * ADD WOOCOMMERCE BODY CLASS TO FRONT PAGE
 * makes ajax add to cart buttons on homepage work with loader effect
 *
**/
add_filter('body_class', function($classes){
	$stack = $classes;
	array_push($stack, 'woocommerce');
	return $stack;
});

// get the context
$context = Timber::context();

// get the post object (singular)
$post = new TimberPost();
$context['post'] = $post;

// get the posts object (archive)
// $context['posts'] = new Timber\PostQuery();

// get & set the title. if is blog & home, use site.title, else post.title 
if (is_home() && is_front_page()) {
	$context['title'] =  get_bloginfo( 'name' );
} else {
	$context['title'] =  get_the_title($post->id);
};

// latest competitions args
$args = array(
 'post_type'             => 'product',
 'post_status'           => 'publish',
 'posts_per_page'        => '5',
);
$context['latest_competitions'] = new Timber\PostQuery($args);

// latest competition winners args
$args = array(
 'post_type'             => 'winners',
 'post_status'           => 'publish',
 'posts_per_page'        => '8',
);
$context['winners'] = new Timber\PostQuery($args);

// render the context with template
Timber::render(array('front-page.twig'), $context);