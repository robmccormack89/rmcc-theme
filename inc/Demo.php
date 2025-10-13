<?php

namespace Rmcc;

class Demo extends Block {

  public $demo;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->demo = $this->block_demo($block);
  }

  public function block_demo($block){
    $classes = ['rmcc-demo', 'rmcc-text-center', 'rmcc-margin-remove'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

  public function block_card($block) {
    $classes = ['rmcc-flex', 'flexoo'];
    $styles = [];

    // if custom className, remove rmcc-card-body (padding) class, & replace with custom className
    // allow for removal/custom internal padding
    if(array_key_exists('className', $block)) {
      $classes = ['rmcc-flex'];
      $classes[] = esc_html($block['className']);
    }

    // backgrounds classes
    $bg_class = 'rmcc-background-muted';
    if((array_key_exists('backgroundColor', $block)) || (array_key_exists('gradient', $block))) $bg_class = 'rmcc-background-blank';
    if((array_key_exists('style', $block))){
      if((array_key_exists('color', $block['style']))){
        if( (array_key_exists('background', $block['style']['color'])) || (array_key_exists('gradient', $block['style']['color'])) ){
          $bg_class = 'rmcc-background-blank';
        }
      }
    }
    $classes[] = $bg_class;

    // heights classes
    $height_class = 'rmcc-no-height';
    if(array_key_exists('fullHeight', $block)){
      if($block['fullHeight']) $height_class = 'rmcc-height-viewport';
    } 
    $classes[] = $height_class;

    // heights styles
    if((array_key_exists('style', $block))){
      if((array_key_exists('dimensions', $block['style']))){
        if((array_key_exists('minHeight', $block['style']['dimensions']))){
          if(!empty($block['style']['dimensions']['minHeight'])){
            $styles[] = 'height: ' . $block['style']['dimensions']['minHeight'];
            $styles[] = 'min-height: ' . $block['style']['dimensions']['minHeight'];
          }
        }
      }
    } 

    // alignContent top|middle|bottom
    if((array_key_exists('align_content', $block))){
      if((array_key_exists('supports', $block))){
        if((array_key_exists('alignContent', $block['supports']))){
          if($block['supports']['alignContent']){
            if(!($block['supports']['alignContent'] === 'matrix')){
              $flex_classes = 'rmcc-flex rmcc-flex-' . $block['align_content'];
              if($block['align_content'] == 'center') $flex_classes = 'rmcc-flex rmcc-flex-middle';
              $classes[] = $flex_classes;
            }
          }
        }
      }
    }

    // finally....
    $html = 'class="' . implode(' ', $classes) . '" style="' . implode(';', $styles) . '"';
    return $html;
  }

}