<?php

namespace Rmcc;

class HeroWrap extends Block {

  public $hero_wrap;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hero_wrap = $this->block_hero_wrap($block);
  }

  public function block_hero_wrap($block){
    $classes = ['rmcc-hero-wrap'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}