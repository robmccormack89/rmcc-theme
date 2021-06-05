<?php
/**
 * Template Name: Contact Page Template
 *
 * @package Cautious_Octo_Fiesta
 */

$context = Timber::context();
$post = Timber::query_post();
$context['post'] = $post;

$context['contact_page_text'] = get_field('contact_page_text', 'option');

Timber::render(  'contact.twig' , $context );