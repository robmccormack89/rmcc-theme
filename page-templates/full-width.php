<?php
/**
 * Template Name: Full Width Template
 * Template Post Type: post, page
 *
 * @package Serchek_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('full-width-'.$post->post_type.'.twig', $context);