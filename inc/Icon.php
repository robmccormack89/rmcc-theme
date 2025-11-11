<?php

namespace Rmcc;

class Icon extends Block {

  public $icon;
  public $colour;
  public $outer;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->icon = $this->block_icon($block);
    $this->colour = $this->block_colour($block);
    $this->outer = $this->block_outer($block);
  }

  public function block_colour($block){
    $styles = [];

    if(array_key_exists('textColor', $block)) {
      $styles['color'] = 'var(--wp--preset--color--' . $block['textColor']  . ') !important';
    } else {
      if(array_key_exists('style', $block)){
        if(array_key_exists('elements', $block['style'])){
          if(array_key_exists('link', $block['style']['elements'])){
            if(array_key_exists('color', $block['style']['elements']['link'])){
              if(array_key_exists('text', $block['style']['elements']['link']['color'])){
                $styles['color'] = $block['style']['elements']['link']['color']['text'];
              }
            }
          }
        }
      }
    }

    // better html outputting of styles (as arrays)
    $styles = array_map(function($value, $key) {
      return $key.':'.$value;
    }, array_values($styles), array_keys($styles));
    $styles = 'style="' . implode(';', $styles) . '"';
    return $styles;
  }

  public function block_icon($block){
    $styles = [];
    $styles['ratio'] = 2;
    if(array_key_exists('style', $block)) {
      if(array_key_exists('typography', $block['style'])) {
        if(array_key_exists('lineHeight', $block['style']['typography'])) {
          $styles['ratio'] = $block['style']['typography']['lineHeight'];
        }
      }
    }

    $styles['icon'] = 'user';
    if(array_key_exists('data', $block)) {
      if(array_key_exists('icon_slug', $block['data'])) {
        $styles['icon'] = $block['data']['icon_slug'];
      }
    }

    // better html outputting of styles (as arrays)
    $styles = array_map(function($value, $key) {
      return $key.':'.$value;
    }, array_values($styles), array_keys($styles));
    $styles = 'rmcc-icon="' . implode(';', $styles) . '"';
    return $styles;
  }

  public function block_outer($block){
    $classes = [];

    if(array_key_exists('className', $block)) {
      $classes = ['rmcc-icon-block'];
      $classes[] = esc_html($block['className']);
    }

    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}