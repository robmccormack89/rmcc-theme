<?php

namespace Rmcc;

class HeroBottom extends Block {

  public $hero_bottom;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hero_bottom = $this->block_hero_bottom($block);
  }

  public function block_hero_bottom($block){
    $classes = ['rmcc-hero-bottom'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}