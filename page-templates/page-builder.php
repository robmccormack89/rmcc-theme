<?php
/**
 * Template Name: Page Builder Template
 * Template Post Type: post, page
 *
 * @package Rmcc_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('page-builder-page.twig', $context);