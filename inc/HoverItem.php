<?php

namespace Rmcc;

class HoverItem extends Block {

  public $hover_item;
  public $classes;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hover_item = $this->block_hover_item($block);
    $this->classes = $this->block_hover_class($block);
  }

  public function block_hover_item($block){
    $classes = ['rmcc-hover-item'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

  public function block_hover_class($block){
    $classes = [];

    // if custom className, remove rmcc-card-body (padding) class, & replace with custom className
    // allow for removal/custom internal padding
    if(array_key_exists('className', $block)) {
      $classes[] = esc_html($block['className']);
    }
    
    return $classes;
  }

}