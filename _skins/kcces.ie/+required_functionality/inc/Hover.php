<?php

namespace Rmcc;

class Hover extends Block {

  public $hover;
  public $classes;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hover = $this->block_hover($block);
    $this->classes = $this->block_hover_class($block);
  }

  public function block_get_fields(){
    $fields  = [];

    if(get_field('front_image')) $fields['front_image'] = get_field('front_image');
    if(get_field('back_image')) $fields['back_image'] = get_field('back_image');

    return $fields;
  }

  public function block_hover($block){
    $classes = ['rmcc-hover-block'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

  public function block_hover_class($block){
    $classes = [];

    // use custom classes to control the overlay colours
    if(array_key_exists('className', $block)) $classes[] = $block['className'];
    
    return $classes;
  }

}