<?php

namespace Rmcc;

class HoverWrap extends Block {

  public $hover_wrap;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hover_wrap = $this->block_hover_wrap($block);
  }

  public function block_hover_wrap($block){
    $classes = ['rmcc-hover-wrap'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}