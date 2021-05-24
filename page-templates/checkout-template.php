<?php
/**
 * Template Name: Checkout Template
 *
 * @package Cautious_Octo_Fiesta
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;
Timber::render(  'checkout.twig' , $context );