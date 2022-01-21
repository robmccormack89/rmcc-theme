<?php
/**
 * Template Name: Wide Template
 * Template Post Type: post, page
 *
 * @package Rmcc_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('wide-'.$post->post_type.'.twig', $context);