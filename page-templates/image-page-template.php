<?php
/**
 * Template Name: Image Header Page Template
 *
 * @package Cautious_Octo_Fiesta
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('image-page.twig', $context);