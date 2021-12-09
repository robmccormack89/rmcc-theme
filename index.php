<?php
/**
 * The main index template file, functions at the main archive
 *
 * @package Serchek_Theme
 */

// get the main context
$context = Timber::context();

// get the posts from the main query
$context['posts'] = new Timber\PostQuery();

// get the singular post object from within the loop, for setting the title below
$post = new Timber\Post();

// set the title for blog page etc
if ( is_home() && is_front_page() ) {
	$context['title'] =  get_bloginfo( 'name' );
} else {
	$context['title'] =  get_the_title( $post->ID );
};

// get the pagination
$context['pagination'] = Timber::get_pagination();
$context['paged'] = $paged;

// templates to render
$templates = array( 'blog.twig' );

// render templates & context
Timber::render( $templates, $context );