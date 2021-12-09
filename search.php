<?php
/**
 * The search
 *
 * @package Serchek_Theme
 */

 $context = Timber::context();
 $context['posts'] = new Timber\PostQuery();
 
 $context['title'] = 'Search results for ' . get_search_query();
 
 $context['pagination'] = Timber::get_pagination();
 $context['paged'] = $paged;
 
 Timber::render( array( 'search.twig', 'archive.twig', 'index.twig' ), $context );