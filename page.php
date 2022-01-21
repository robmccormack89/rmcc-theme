<?php
/**
 * The default template for displaying all pages
 *
 * @package Rmcc_Theme
 */

// get the main context
$context = Timber::context();
$post = new Timber\Post();
$context['post'] = $post;

Timber::render(array('page-' . $context['post']->post_name . '.twig', 'page.twig', 'single.twig'), $context);