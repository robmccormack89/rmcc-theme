<?php

namespace Rmcc;

class HeroTop extends Block {

  public $hero_top;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->hero_top = $this->block_hero_top($block);
  }

  public function block_get_fields(){
    $fields  = [];

    if(get_field('gallery')) $fields['gallery'] = get_field('gallery');

    return $fields;
  }

  public function block_hero_top($block){
    $classes = ['rmcc-hero-top'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}