<?php
/**
 * The 404 template
 *
 * @package Loadingdock_Theme
 */

// get the main context
$context = Timber::context();
// render the template in 404.twig with the above context
Timber::render( '404.twig', $context );