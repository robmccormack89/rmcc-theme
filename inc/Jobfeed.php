<?php

namespace Rmcc;

class Jobfeed extends Block {

  public $jobfeed;

  public function __construct($block) {
    parent::__construct($block); // inherit construtc of parent class
    $this->jobfeed = $this->block_jobfeed($block);
  }

  public function block_jobfeed($block){
    $classes = ['rmcc-jobfeed', 'rmcc-text-small', 'rmcc-margin-remove'];
    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }

}