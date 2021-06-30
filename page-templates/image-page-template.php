<?php
/**
 * Template Name: Image Header Template
 *
 * @package Dream_Winners
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('image-page.twig', $context);