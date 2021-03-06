<?php
/**
 * Template Name: Wide Template
 *
 * @package Urban_Carnival_Theme
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render(  'wide.twig' , $context );