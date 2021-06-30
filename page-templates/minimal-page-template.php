<?php
/**
 * Template Name: Minimal Header Template
 *
 * @package Dream_Winners
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('minimal-page.twig', $context);