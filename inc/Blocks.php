<?php

namespace Rmcc;
use Timber\Timber;
use Timber\Post;
use Timber\PostQuery;

array_unshift(
  Timber::$dirname,
  'views/blocks',
);

class Blocks {

  public function __construct() {
    add_action('init', array($this, 'register_acf_blocks'));
    add_action('enqueue_block_assets', array($this, 'acf_blocks_editor_scripts')); // use 'enqueue_block_editor_assets' for backend-only
  }

  function register_acf_blocks() {
    register_block_type(__DIR__ . '/blocks/hellooo/block.json');
  }

  public function acf_blocks_editor_scripts() {

    // gutenberg editor styles
    if(is_admin()){
      // base
      wp_enqueue_style(
        'base-theme',
        get_template_directory_uri() . '/assets/css/base.css'
      );
      wp_enqueue_script(
        'base-theme',
        get_template_directory_uri() . '/assets/js/base.js',
        '',
        '',
        false
      );
      // theme stylesheet (theme)
      wp_enqueue_style(
        'base-theme-styles', get_stylesheet_uri()
      );
      wp_enqueue_style(
        'admin-editor-theme',
        get_template_directory_uri() . '/assets/css/admin-editor.css'
      );
    }
    
    // swiper (frontend only)
    if(!is_admin()){
      wp_enqueue_style(
        'swiper',
        // get_template_directory_uri() . '/assets/css/lib/swiper-bundle.min.css'
        'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css'
      );
      wp_enqueue_script(
        'swiper-js',
        // get_template_directory_uri() . '/assets/js/lib/swiper-bundle.min.js',
        'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
        '',
        '1.0.0',
        false
      );
      wp_enqueue_style(
        'frontend-editor-theme',
        get_template_directory_uri() . '/assets/css/frontend.css'
      );
    }

  }

}