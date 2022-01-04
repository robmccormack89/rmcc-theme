<?php
/**
 * Template Name: Narrow Template
 * Template Post Type: post, page
 *
 * @package Loadingdock_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('narrow-'.$post->post_type.'.twig', $context);