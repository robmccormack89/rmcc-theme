<?php

namespace Rmcc;

class Copyright extends Block {

  public $copyright;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->copyright = $this->block_copyright($block);
  }

  public function block_copyright($block){
    $classes = ['rmcc-copyright', 'rmcc-text-center', 'rmcc-text-small', 'rmcc-margin-remove'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}