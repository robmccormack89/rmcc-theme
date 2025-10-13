<?php
/**
 *
 * Template Name: Blank Template
 * Template Post Type: post, page
 *
 * @package Rmcc_Theme
 *
 */

namespace Rmcc;

/*
Set 
The
Base
Stuff
Same
As
404
*/

// set templates variable as an array. set as base.twig to start,
// in case anything goes wrong (wp wants display some template, but our conditionals below dont cover it).
// we will modify this within conditionals below for diffrent contexts etc...
$templates = array('base.twig');

// set the context
$context = Theme::context();

/*
Set
The
Contextual
Stuff
with
Conditionals
*/

// set some context vars
$context['post'] = Theme::get_post(); // the singlular post object
$context['post']->the_excerpt = $context['post']->post_excerpt ?: false; // set post.the_excerpt instead

// if not a privated post (privated posts will appear as 404s due to configs above)
if (get_post_status($context['post']->ID) != 'private') {

  // good housekeeping. we will still use post.title & post.post_excerpt in actual templates
  $context['title'] = $context['post']->title;
  $context['description'] = $context['post']->post_excerpt ?: false;

  // twig templates for singles                        
  array_unshift(
    $templates,
    'single-' . $context['post']->ID . '.twig',
    'single-' . $context['post']->slug . '.twig',
    'single-' . $context['post']->post_type . '.twig',
    $context['post']->slug . '.twig',
    'single.twig'
  );

  // add the custom template/s to the start of the templates array
  array_unshift($templates, 'blank-' . $context['post']->post_type . '.twig', 'blank.twig', );

  // add new template for password protected singulars (does not work on static front_pages)
  if (post_password_required($context['post'])) array_unshift($templates, 'single_protected.twig');

}

/*
finally
we
render
templates
and
context
*/

// & render the template with the context
Theme::render($templates, $context);