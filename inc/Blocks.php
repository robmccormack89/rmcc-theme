<?php

namespace Rmcc;
use Timber\Timber;

array_unshift(
  Timber::$dirname,
  'views/blocks',
);

// this class sets things up for our creation of blocks, as a whole, before we have moved onto doing anything for the individual blocks.
class Blocks {

  public function __construct() {
    // block stuff
    add_action('block_categories_all', array($this, 'register_blocks_categories'));
    add_action('enqueue_block_assets', array($this, 'register_blocks_scripts'));
    add_action('init', array($this, 'register_blocks'));
  }

  // block stuff
  public function register_blocks_categories($categories) {
    $categories[] = array(
      'slug'  => 'rmcc',
      'title' => 'RMcC'
    );
    return $categories;
  }
  public function register_blocks_scripts() {

    // backend (gutenberg editor)
    if(is_admin()){

      // rmcc theme main css (uikit/build)
      wp_enqueue_style(
        'rmcc-theme',
        get_template_directory_uri() . '/public/css/rmcc.min.css'
      );
      // rmcc theme main js (uikit/build)
      wp_enqueue_script(
        'rmcc-theme',
        get_template_directory_uri() . '/public/js/rmcc.min.js',
        '',
        '',
        false
      );
      // rmcc icons (uikit) js
      wp_enqueue_script(
        'rmcc-theme-icons',
        get_template_directory_uri() . '/public/js/rmcc-icons.min.js',
        '',
        '',
        false
      );

      // rmcc theme stylesheet (style.css)
      wp_enqueue_style(
        'rmcc-theme-style',
        get_stylesheet_uri()
      );
      
    } else {

      // frontend only

    }

  }
  public function register_blocks() {
    register_block_type(__DIR__ . '/blocks/block/block.json');
    register_block_type(__DIR__ . '/blocks/demo/block.json');

    register_block_type(__DIR__ . '/blocks/icon/block.json');

    register_block_type(__DIR__ . '/blocks/hero-wrap/block.json');
    register_block_type(__DIR__ . '/blocks/hero-top/block.json');
    register_block_type(__DIR__ . '/blocks/hero-bottom/block.json');
    register_block_type(__DIR__ . '/blocks/hero-item/block.json');

    register_block_type(__DIR__ . '/blocks/hover/block.json');
  }

}