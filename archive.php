<?php
/**
 * The template for displaying general archive pages
 *
 * @package Loadingdock_Theme
 */

// sets the template hierarchy
$templates = array( 'archive.twig', 'index.twig' );
 
// sets the main context
$context = Timber::context();

// set the title variables & reset the template hierarchy for more specificity  
$context['title'] = 'Archive';
if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
} elseif ( is_tax('status') ) {
	$context['title'] = single_term_title( 'Status: ', false );;
  array_unshift( $templates, 'archive-live_draws.twig' );
}

if (is_post_type_archive( 'entry_lists' )) {
  $file = get_field('pdf_upload');
  $context['pdf_upload_url'] = $file['url'];
}

// get the pagination
$context['pagination'] = Timber::get_pagination();
$context['paged'] = $paged;

// get the posts variable for looping in our templates. the posts is from the main query
$context['posts'] = new Timber\PostQuery();

// render the twig templates with the context
Timber::render( $templates, $context );