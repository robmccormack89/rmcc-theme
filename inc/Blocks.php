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
    // filter what html tags & attrs are allowed in wp content / wp kses post
    add_action('init', array($this, 'allowed_html_tags_attrs'), 10);

    // block stuff
    add_action('block_categories_all', array($this, 'register_blocks_categories'));
    add_action('enqueue_block_assets', array($this, 'register_blocks_scripts'));
    add_action('init', array($this, 'register_blocks'));
  }

  // filter what html tags & attrs are allowed in wp content / wp kses post
  public function allowed_html_tags_attrs() {
    global $allowedposttags;
    $allowed_atts = array(
      'align' => array(),
      'class' => array(),
      'type' => array(),
      'id' => array(),
      'dir' => array(),
      'lang' => array(),
      'style' => array(),
      'xml:lang' => array(),
      'src' => array(),
      'alt' => array(),
      'href' => array(),
      'rel' => array(),
      'rev' => array(),
      'target' => array(),
      'novalidate' => array(),
      'type' => array(),
      'value' => array(),
      'name' => array(),
      'tabindex' => array(),
      'action' => array(),
      'method' => array(),
      'for' => array(),
      'width' => array(),
      'height' => array(),
      'data' => array(),
      'title' => array(),
      'fuck' => array(),
      'rmcc-accordion' => array(),
      'rmcc-icon' => array(),
      'rmcc-slider' => array(),
      'rmcc-grid' => array(),
      'rmcc-form' => array(),
      'rmcc-modal' => array(),
      'rmcc-toggle' => array(),
      'hidden' => array(),
      'role' => array(),
      'aria-live' => array(),
      'aria-atomic' => array(),
      'data-status' => array(),
      'data-template' => array(),
      'aria-required' => array(),
      'aria-invalid' => array(),
      'aria-describedby' => array(),
      'data-name' => array(),
      'size' => array(),
      'role' => array(),
      'aria-hidden' => array(),
      'focusable' => array(),
      'role' => array(),
      'viewBox' => array(),
      'fill' => array(),
      'd' => array(),
      'uk-slider-parallax' => array(),
      'data-nanogallery2' => array(),
    );
    $allowedposttags['form'] = $allowed_atts;
    $allowedposttags['button'] = $allowed_atts;
    $allowedposttags['cite'] = $allowed_atts;
    $allowedposttags['svg'] = $allowed_atts;
    $allowedposttags['path'] = $allowed_atts;
    $allowedposttags['label'] = $allowed_atts;
    $allowedposttags['input'] = $allowed_atts;
    $allowedposttags['textarea'] = $allowed_atts;
    $allowedposttags['iframe'] = $allowed_atts;
    $allowedposttags['script'] = $allowed_atts;
    $allowedposttags['style'] = $allowed_atts;
    $allowedposttags['strong'] = $allowed_atts;
    $allowedposttags['small'] = $allowed_atts;
    $allowedposttags['table'] = $allowed_atts;
    $allowedposttags['span'] = $allowed_atts;
    $allowedposttags['abbr'] = $allowed_atts;
    $allowedposttags['code'] = $allowed_atts;
    $allowedposttags['pre'] = $allowed_atts;
    $allowedposttags['div'] = $allowed_atts;
    $allowedposttags['img'] = $allowed_atts;
    $allowedposttags['h1'] = $allowed_atts;
    $allowedposttags['h2'] = $allowed_atts;
    $allowedposttags['h3'] = $allowed_atts;
    $allowedposttags['h4'] = $allowed_atts;
    $allowedposttags['h5'] = $allowed_atts;
    $allowedposttags['h6'] = $allowed_atts;
    $allowedposttags['ol'] = $allowed_atts;
    $allowedposttags['ul'] = $allowed_atts;
    $allowedposttags['li'] = $allowed_atts;
    $allowedposttags['em'] = $allowed_atts;
    $allowedposttags['hr'] = $allowed_atts;
    $allowedposttags['br'] = $allowed_atts;
    $allowedposttags['tr'] = $allowed_atts;
    $allowedposttags['td'] = $allowed_atts;
    $allowedposttags['p'] = $allowed_atts;
    $allowedposttags['a'] = $allowed_atts;
    $allowedposttags['b'] = $allowed_atts;
    $allowedposttags['i'] = $allowed_atts;
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

    // frontend only
    if(!is_admin()){}

    // backend (gutenberg editor)
    if(is_admin()){

      // rmcc (uikit) css
      wp_enqueue_style(
        'rmcc-theme',
        get_template_directory_uri() . '/public/css/rmcc.min.css'
      );
      // rmcc (uikit) js
      wp_enqueue_script(
        'rmcc-theme',
        get_template_directory_uri() . '/public/js/rmcc.min.js',
        '',
        '',
        false
      );

      // theme stylesheet (style.css)
      wp_enqueue_style(
        'rmcc-theme-style',
        get_stylesheet_uri()
      );
      
    }

  }
  public function register_blocks() {
    register_block_type(__DIR__ . '/blocks/block/block.json');
    register_block_type(__DIR__ . '/blocks/copyright/block.json');
  }

}