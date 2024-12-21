<?php
/**
 * The search
 *
 * @package Rmcc_Theme
 */
 
// namespace stuff
namespace Rmcc;
use Timber\PostQuery;

global $snippets;

// templates variable as an array
$templates = array('search.twig', 'archive.twig');

$context = Theme::context();
$context['posts'] = new PostQuery();

$context['title'] = $snippets['search_results_title_text'] . ' ' . get_search_query();

Theme::render($templates, $context);