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

    if(is_singular('post') || is_page()){
      if(has_block('acf/rmcc-jobs')){
        if(!is_admin()){

          // rmcc jobs feed js
          wp_enqueue_script(
            'rmcc-theme-jobs',
            get_template_directory_uri() . '/public/js/jobs-feed.js',
            '',
            '',
            false
          );

          if(is_page('some-page')) {

          } else {

            // rmcc jobs feed init js
            wp_enqueue_script(
              'rmcc-theme-jobs-init',
              get_template_directory_uri() . '/public/js/jobs.js',
              '',
              '',
              false
            );

          }

        }
      }
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
    register_block_type(__DIR__ . '/blocks/jobs/block.json');
  }

}