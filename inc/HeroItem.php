<?php

namespace Rmcc;

class HeroItem extends Block {

  public $hero_item;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hero_item = $this->block_hero_item($block);
  }

  public function block_hero_item($block){
    $classes = ['rmcc-hero-item'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}