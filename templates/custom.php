<?php
  
/**
*
* Template Name: Custom Template
* Template Post Type: post, page
*
* @package Rmcc_Theme
*
*/

// namespace stuff
namespace Rmcc;
use Timber\Post;

global $theme_config;

 // set the contexts
$context = Theme::context();
$context['post'] = new Post();

// templates variable as an array (using the $post stuff)
$templates = array(
  'single-' . $context['post']->post_type . '.twig', 
  'single.twig'
);

// if acf_local_json & acf_template_settings are enabled, then add the custom template/s to the start of the templates array
if($theme_config['acf_local_json'] && $theme_config['acf_template_settings']){
  array_unshift($templates, 'custom-' . $context['post']->post_type . '.twig', 'custom.twig',);
}

// and render
Theme::render($templates, $context);