<?php
/**
 * The default template for displaying all single posts
 *
 * @package Serchek_Theme
 */

// get the main context
$context = Timber::context();

// get the singular post object
$timber_post = Timber::get_post();

// set the post object variable
$context['post'] = $timber_post;

Timber::render( array( 'post-' . $timber_post->ID . '.twig', 'post-' . $timber_post->post_type . '.twig', 'post-' . $timber_post->slug . '.twig', 'post.twig', 'single.twig' ), $context );