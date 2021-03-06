<?php
/**
 * Template Name: Full Width Template
 *
 * @package Urban_Carnival_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render(  'full.twig' , $context );