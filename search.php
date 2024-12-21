<?php
/**
*
* The search
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
$context['title'] = _x( 'Error: Page not found', '404/Error pages', 'basic-theme' );
$context['description'] = _x( 'Sorry, there has been an error locating a resource for your query. Try finding what you want using the search form below.', '404/Error pages', 'basic-theme' );

/*
Set
The
Contextual
Stuff
with
Conditionals
*/

if(is_search()){
  
  $context['configs']['blog_filters'] = false;

  // set templates & vars
  array_unshift($templates, 'search.twig', 'archive.twig');
  $context['title'] = _x( 'Search results', 'Search: results', 'basic-theme' );
  $context['description'] = _x( 'You have searched for:', 'Search: results', 'basic-theme' ) . ' "' . get_search_query() . '"';

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