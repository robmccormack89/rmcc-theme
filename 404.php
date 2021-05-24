<?php
/**
 * The 404 template
 *
 * @package Cautious_Octo_Fiesta
 */

// get the main context
$context = Timber::context();
// set the title variable
$context['title'] =  'Page not found';
// render the template in 404.twig with the above context
Timber::render( '404.twig', $context );