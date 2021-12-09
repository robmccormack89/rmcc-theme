<?php
/**
 * Template Name: Minimal Header Template
 *
 * @package Serchek_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render('minimal-page.twig', $context);