<?php
/**
 *
 * The template for displaying general archive pages.
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
$context['title'] = _x('Error: Page not found', '404/Error pages', 'rmcc-theme');
$context['description'] = _x('Sorry, there has been an error locating a resource for your query. Try finding what you want using the search form below.', '404/Error pages', 'rmcc-theme');

/*
Set
The
Contextual
Stuff
with
Conditionals
*/

// author archives
if (is_author()) {

  // set templates & vars
  array_unshift($templates, 'author.twig', 'archive.twig');
  if (isset($wp_query->query_vars['author'])) {
    $author = Theme::get_user($wp_query->query_vars['author']);
    $context['author'] = $author;
    $context['title'] = _x('Author: ', 'Archives', 'rmcc-theme') . $author->name();
    $context['description'] = get_the_archive_description();
  }

}

// date archives (D)
elseif (is_day()) {

  // set templates & vars
  array_unshift($templates, 'day.twig', 'archive.twig');
  $context['title'] = _x('Day: ', 'Archives', 'rmcc-theme') . get_the_date('l dS \o\f F Y');
  $context['description'] = get_the_archive_description();

}

// date archives (M)
elseif (is_month()) {

  // set templates & vars
  array_unshift($templates, 'month.twig', 'archive.twig');
  $context['title'] = _x('Month: ', 'Archives', 'rmcc-theme') . get_the_date('F Y');
  $context['description'] = get_the_archive_description();

}

// date archives (Y)
elseif (is_year()) {

  // set templates & vars
  array_unshift($templates, 'year.twig', 'archive.twig');
  $context['title'] = _x('Year: ', 'Archives', 'rmcc-theme') . get_the_date('Y');
  $context['description'] = get_the_archive_description();

}

// tag archives
elseif (is_tag()) {

  // set templates & vars
  array_unshift($templates, 'archive_' . get_query_var('tag') . '.twig', 'tag.twig', 'archive.twig');
  $context['title'] = _x('Tag: ', 'Archives', 'rmcc-theme') . single_tag_title('', false);
  $context['description'] = get_the_archive_description();

}

// category archives
elseif (is_category()) {

  // set templates & vars
  array_unshift($templates, 'archive_' . get_query_var('cat') . '.twig', 'category.twig', 'archive.twig');
  $context['title'] = single_cat_title('', false);
  $context['description'] = get_the_archive_description();

}

// custom taxonomy archives
elseif (is_tax()) {

  // set templates & vars
  array_unshift($templates, 'custom_taxonomy.twig', 'archive.twig');
  $context['title'] = single_term_title('', false);
  $context['description'] = get_the_archive_description();

}

// custom post_type archives
elseif (is_post_type_archive()) {

  // set templates & vars
  array_unshift($templates, 'archive_' . get_post_type() . '.twig', 'custom_post_type.twig', 'archive.twig');
  $context['title'] = post_type_archive_title('', false);
  $context['description'] = get_the_archive_description();

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