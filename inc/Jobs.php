<?php

namespace Rmcc;

class Jobs extends Block {

  public $jobs;

  public function __construct($block) {
    parent::__construct($block); // inherit construc of parent class
    $this->jobs = $this->block_jobs($block);
  }

  public function block_get_fields(){
    $fields  = [];
    return $fields;
  }

  public function block_jobs($block){
    $classes = ['rmcc-jobs'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}