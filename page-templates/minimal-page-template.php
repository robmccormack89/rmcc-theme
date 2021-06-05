<?php
/**
 * Template Name: Minimal Header Page Template
 *
 * @package Cautious_Octo_Fiesta
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('minimal-page.twig', $context);