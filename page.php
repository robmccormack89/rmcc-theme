<?php
/**
 * The default template for displaying all pages
 *
 * @package Cautious_Octo_Fiesta
 */

// get the main context
$context = Timber::context();

if (is_cart()) : // if is cart page
  $context['post'] = Timber::query_post();
  Timber::render('basket.twig', $context);
elseif (is_checkout()) : // if is checkout page
  $context['post'] = Timber::query_post();
  Timber::render('checkout.twig', $context);
elseif (is_account_page()) : // if is my-account page/s
  $context['post'] = Timber::query_post();
  Timber::render('account.twig', $context);
else : // else all other pages
  $context['post'] = new Timber\Post();
  Timber::render(array('page-' . $context['post']->post_name . '.twig', 'page.twig'), $context);
endif;