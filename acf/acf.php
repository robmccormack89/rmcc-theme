<?php

/**
 * ACF Options Pages
 *
 * @package Loadingdock_Theme
 */

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' 	=> 'Theme Settings',
    'menu_title'	=> 'Theme Settings',
    'menu_slug' 	=> 'theme-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));
};

/**
 * ACF Block Functions
 *
 * @package Dream_Winners
 */

add_action( 'acf/init', 'acf_blocks_init' );
function acf_blocks_init() {
  
  if ( ! function_exists( 'acf_register_block' ) ) {
    return;
  }

  acf_register_block( array(
    'name'            => 'featured_pages',
    'title'           => 'Featured Pages',
    'description'     => 'Featured Pages',
    'render_callback' => 'featured_pages_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'featured', 'pages' ),
  ));
  acf_register_block( array(
    'name'            => 'featured_content',
    'title'           => 'Featured Content',
    'description'     => 'Featured Content',
    'render_callback' => 'featured_content_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'featured', 'content' ),
  ));
  acf_register_block( array(
    'name'            => 'featured_gallery',
    'title'           => 'Featured gallery',
    'description'     => 'Featured gallery',
    'render_callback' => 'featured_gallery_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'featured', 'content' ),
  ));
  acf_register_block( array(
    'name'            => 'testimonials',
    'title'           => 'Testimonials',
    'description'     => 'Testimonials',
    'render_callback' => 'testimonials_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'testimonials', 'rating' ),
  ));
  acf_register_block( array(
    'name'            => 'contact_section',
    'title'           => 'Contact section',
    'description'     => 'Contact section',
    'render_callback' => 'contact_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'contact', 'section' ),
  ));
  acf_register_block( array(
    'name'            => 'blog_posts',
    'title'           => 'Blog posts',
    'description'     => 'Blog posts',
    'render_callback' => 'blog_posts_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'blog', 'posts' ),
  ));
  acf_register_block( array(
    'name'            => 'youtube_popup',
    'title'           => 'Youtube popup',
    'description'     => 'Youtube popup',
    'render_callback' => 'youtube_popup_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'youtube', 'popup' ),
  ));
  acf_register_block( array(
    'name'            => 'cta_section',
    'title'           => 'CTA section',
    'description'     => 'CTA section',
    'render_callback' => 'cta_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'cta', 'section' ),
  ));
  acf_register_block( array(
    'name'            => 'cover_section',
    'title'           => 'Cover section',
    'description'     => 'Cover section',
    'render_callback' => 'cover_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'cover', 'section' ),
  ));
  acf_register_block( array(
    'name'            => 'cover_left_section',
    'title'           => 'Cover left section',
    'description'     => 'Cover left section',
    'render_callback' => 'cover_left_section_render_callback',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'cover', 'section' ),
  ));
}

function cover_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'cover-section.twig', $context );
}
function cover_left_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'cover-left-section.twig', $context );
}
function cta_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'cta-section.twig', $context );
}
function featured_pages_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  if($context['fields']['featureds_items']){
    $selected_items = $context['fields']['featureds_items'];
    $items_ids = array_column($context['fields']['featureds_items'], 'select_featured_item');
    $selected_posts = Timber::get_posts($items_ids);
    $context['posts'] = $selected_posts;
  }
  Timber::render( 'featured-page-blocks.twig', $context );
}
function featured_content_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  if($context['fields']['select_featured_item']){
    $selected_post_id = $context['fields']['select_featured_item'];
    $selected_post = Timber::get_post($selected_post_id);
    $context['post'] = $selected_post;
  }
  Timber::render( 'featured-item.twig', $context );
}
function featured_gallery_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'featured-gallery.twig', $context );
}
function testimonials_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $testimonials_post_args = array(
    'post_type'             => 'testimonials',
    'post_status'           => 'publish',
    'posts_per_page'        => '6',
  );
  $context['testimonials'] = Timber::get_posts($testimonials_post_args);
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  remove_filter( 'the_content', 'wpautop' );
  Timber::render( 'testimonials-rating.twig', $context );
}
function contact_section_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'contact-section.twig', $context );
}
function blog_posts_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  $args = array(
   'post_type'             => 'post',
   'post_status'           => 'publish',
   'posts_per_page'        => '1',
  );
  $context['latest_posts_one'] = Timber::get_posts($args);
  $args = array(
   'post_type'             => 'post',
   'post_status'           => 'publish',
   'posts_per_page'        => '3',
   'offset' => '1',
  );
  $context['latest_posts_three'] = Timber::get_posts($args);
  Timber::render( 'blog-posts.twig', $context );
}
function youtube_popup_render_callback( $block, $content = '', $is_preview = false ) {
  $context = Timber::context();
  $context['block'] = $block;
  $context['fields'] = get_fields();
  $context['is_preview'] = $is_preview;
  Timber::render( 'video-section.twig', $context );
}

function acf_blocks_editor_scripts() {
  
  wp_enqueue_style(
    'nunito-font',
    'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap'
  );
  
  // theme base css
  wp_enqueue_style(
    'loadingdock-theme',
    get_template_directory_uri() . '/assets/css/base.css'
  );
  
  // theme stylesheet
  wp_enqueue_style(
    'loadingdock-theme-styles', get_stylesheet_uri()
  );

}
add_action( 'enqueue_block_editor_assets', 'acf_blocks_editor_scripts' );