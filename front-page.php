<?php
/**
* The front page template (when backend settings for front page display are set to static or latest posts)
* @package Urban_Carnival_Theme
*/

// get the context
$context = Timber::context();

// get the post object (singular)
$post = Timber::query_post();
$context['post'] = $post;

// get the posts object (archive)
$context['posts'] = new Timber\PostQuery();

// get & set the title. if is blog & home, use site.title, else post.title 
if ( is_home() && is_front_page() ) {
	$context['title'] =  get_bloginfo( 'name' );
} else {
	$context['title'] =  get_the_title( $post->ID );
};

// render the context with template
Timber::render( array('front-page.twig'), $context );