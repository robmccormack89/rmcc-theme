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

// author archives
if (is_author()) {

  // disable blog filters on author archives
  // $context['configs']['blog_filters'] = false;

  // set templates
  array_unshift($templates, 'author.twig', 'archive.twig');

  // set vars
  if (isset($wp_query->query_vars['author'])) {
  	$author = Theme::get_user( $wp_query->query_vars['author'] );
  	$context['author'] = $author;
  	$context['title'] = _x('Author: ', 'Archives', 'basic-theme') . $author->name();
    $context['description'] = get_the_archive_description();
  }

}

// date archives (D)
elseif (is_day()) {

  // disable blog filters on date archives
  $context['configs']['blog_filters'] = false;

  // set templates
  array_unshift($templates, 'day.twig', 'archive.twig');

  // set vars
	$context['title'] = _x('Day: ', 'Archives', 'basic-theme') . get_the_date('l dS \o\f F Y');
  $context['description'] = get_the_archive_description();

}

// date archives (M)
elseif (is_month()) {

  // disable blog filters on date archives
  $context['configs']['blog_filters'] = false;

  // set templates
  array_unshift($templates, 'month.twig', 'archive.twig');

  // set vars
	$context['title'] = _x('Month: ', 'Archives', 'basic-theme') . get_the_date('F Y');
  $context['description'] = get_the_archive_description();
  
}

// date archives (Y)
elseif (is_year()) {

  // disable blog filters on date archives
  $context['configs']['blog_filters'] = false;

  // set templates
  array_unshift($templates, 'year.twig', 'archive.twig');

  // set vars
	$context['title'] = _x('Year: ', 'Archives', 'basic-theme') . get_the_date('Y');
  $context['description'] = get_the_archive_description();

}

// tag archives
elseif (is_tag()) {

  // set templates
  array_unshift($templates, 'archive_' . get_query_var('tag') . '.twig', 'tag.twig', 'archive.twig');

  // set vars
  $context['title'] = _x('Tag: ', 'Archives', 'basic-theme') . single_tag_title('', false);
  $context['description'] = get_the_archive_description();

}

// category archives
elseif (is_category()) {

  // set templates
  array_unshift($templates, 'archive_' . get_query_var('cat') . '.twig', 'category.twig', 'archive.twig');

  // set vars
  $context['title'] = single_cat_title('', false);
  $context['description'] = get_the_archive_description();

}

// custom taxonomy archives
elseif(is_tax()){

  // disable blog filters on custom taxonomy archives
  $context['configs']['blog_filters'] = false;

  // set templates
  array_unshift($templates, 'custom_taxonomy.twig', 'archive.twig');

  // set vars
  $context['title'] = single_term_title('', false);
  $context['description'] = get_the_archive_description();

}

// custom post_type archives
elseif (is_post_type_archive()) {

  // disable blog filters on post_type archives.
  // can reset the blog filters settings here if adding in filters for other taxonomies on a custom type etc. Clever?!
  $context['configs']['blog_filters'] = false;

  // set templates
	array_unshift($templates, 'archive_' . get_post_type() . '.twig', 'custom_post_type.twig', 'archive.twig');

  // set vars
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

// & render the templates with the context
Theme::render($templates, $context);
