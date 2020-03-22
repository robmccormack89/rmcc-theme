<?php
/**
 * The main template file
 *
 * @package Sixstar_Theme
 */

$context = Timber::get_context();

$context['posts'] = Timber::get_posts();
$post = new TimberPost();
if ( is_home() && is_front_page() ) {
	$context['title'] =  get_bloginfo( 'name' );
} else {
	$context['title'] =  get_the_title( $post->ID );
};
$context['pagination'] = Timber::get_pagination();
$context['paged'] = $paged;



$templates = array( 'index.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}
Timber::render( $templates, $context );