<?php
/**
 * The default template for displaying all pages
 *
 * @package Serchek_Theme
 */

// get the main context
$context = Timber::context();
$post = new Timber\Post();
$context['post'] = $post;

if ( post_password_required( $post->ID ) ) {
  Timber::render( 'page-password.twig', $context );
} else {
  Timber::render(array('page-' . $context['post']->post_name . '.twig', 'page.twig'), $context);
}