<?php
/**
 * The template for making woocommerce work with timber/twig. sets the templates & context for woo's archive & singular views
 * https://docs.woocommerce.com/document/conditional-tags/ for more conditional tags
 *
 * @package Cautious_Octo_Fiesta
 */

// make sure timber is activated first
if ( ! class_exists( 'Timber' ) ) {
  echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
  return;
}

// get the main context
$context = Timber::context();

// if is the single product page
if (is_singular('product')) {
  
  $context['post'] = Timber::get_post();
  $product = wc_get_product( $context['post']->ID );
  $context['product'] = $product;
  
  // get singular gallery attachments
  $context['attachment_ids'] = $product->get_gallery_image_ids();
  
  wp_reset_postdata();
  
  Timber::render( 'product.twig', $context );
  
} 

// if is any woocommerce archive
if (is_shop()) {
  
  // get the main posts object via the standard wp archive query & assign as variable 'products'
  $posts = Timber::get_posts();
  $context['products'] = $posts;
  $context['title'] = _x('Our Competitions', 'Shop Title', 'cautious-octo-fiesta');
  $context['products_grid_columns'] = wc_get_loop_prop('columns');
  $context['pagination'] = Timber::get_pagination();
  $context['paged'] = $paged;
  
  // if is any general taxonomy archive
  if (is_tax()) {
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $context['term_slug'] = $queried_object->slug;
    $context['term_id'] = $term_id;
    $context['title'] = single_term_title('', false);
  };
  
  // if is specifically a product category archive
  if (is_product_category()) {
    $context['category'] = get_term( $term_id, 'product_cat' );
    $thumbnail_id = get_term_meta( $term_id, 'thumbnail_id', true );
    $context['cat_featured_img'] = wp_get_attachment_url( $thumbnail_id );
    $context['cat_featured_alt'] = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', TRUE);
  };

  Timber::render('shop.twig', $context);
}