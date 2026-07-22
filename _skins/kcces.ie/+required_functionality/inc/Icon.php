<?php

namespace Rmcc;

class Icon extends Block {

  public $icon;
  public $colour;
  public $wrap;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->icon = $this->block_icon($block);
    $this->colour = $this->block_colour($block);
    $this->wrap = $this->block_wrap($block);
  }

  public function block_get_fields(){
    $fields  = [];

    if(get_field('icon')) $fields['icon'] = get_field('icon');

    return $fields;
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
    $styles = 'style="' . esc_attr(implode(';', $styles)) . '"';
    return $styles;
  }

  public function block_icon($block){
    $styles = [];

    // icon ratio (using line-height control)
    $styles['ratio'] = 2;
    if(array_key_exists('style', $block)) {
      if(array_key_exists('typography', $block['style'])) {
        if(array_key_exists('lineHeight', $block['style']['typography'])) {
          $styles['ratio'] = $block['style']['typography']['lineHeight'];
        }
      }
    }

    // icon slug (using icon custom field)
    $styles['icon'] = 'question';
    if(!empty($this->block_get_fields()['icon'])) $styles['icon'] = $this->block_get_fields()['icon'];

    // better html outputting of styles (as arrays)
    $styles = array_map(function($value, $key) {
      return $key.':'.$value;
    }, array_values($styles), array_keys($styles));
    $styles = 'rmcc-icon="' . esc_attr(implode(';', $styles)) . '"';
    return $styles;
  }

  public function block_wrap($block){
    $classes = [];

    if(array_key_exists('className', $block)) $classes[] = $block['className'];

    $html = 'class="' . esc_attr(implode(' ', $classes)) . '"';
    return $html;
  }

}