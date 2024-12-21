<?php
/**
*
* The main blog template file
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

// set some context vars.
// set title & desc to start, in case anything goes wrong.
// we will modify these within conditionals below for diffrent contexts etc...
$context['title'] = _x( 'Error: Page not found', '404/Error pages', 'rmcc-theme' );
$context['description'] = _x( 'Sorry, there has been an error locating a resource for your query. Try finding what you want using the search form below.', '404/Error pages', 'rmcc-theme' );

/*
Set
The
Contextual
Stuff
with
Conditionals
*/

// is main blog posts page, basically
if(is_home()) {

  array_unshift($templates, 'archive.twig'); // front_page or not. static front_page's will go thru the singular.php route instead

  // firstly we use the post object itself (the page) to set title & description
  $context['title'] = get_the_title($context['post']->id);
  $context['description'] = $context['post']->post_excerpt ?: false;

  // reset the title & description from site if blog is on the front page
  if(is_front_page()) {

    $context['title'] = get_bloginfo('name');
    $context['description'] = get_bloginfo('description');
  }

}

/*
Set
An
Archive
Object
So
We
Have
it
like
a
post
object
*/

// create the archive object, and fill it. i think this is good practice as it matches singular context format like post.title as archive.title
$context['archive'] = (object) [

  "posts" => $context['posts'],

  "title" => (is_paged()) ? $context['title'] . ' - Page ' . get_query_var('paged') : $context['title'],
  "description" => $context['description'],

  "thumbnail" => [
    "src" => false,
    "alt" => false,
    "caption" => false
  ]

];

/*
finally
we
render
templates
and
context
*/

Theme::render($templates, $context);