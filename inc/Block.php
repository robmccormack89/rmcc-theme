<?php

namespace Rmcc;

class Block {

  public $spacingAttrs;

  public $wrapper;
  public $container;
  public $align;
  
  public $fullheight;
  public $fullheight_class;
  public $fullheight_img_class;

  public $align_text;

  public $align_content;
  public $align_content_pos;

  public function __construct($block) {

    $this->spacingAttrs = wp_kses_data(get_block_wrapper_attributes());

    // block wrapping (_block.twig only)
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
    
        // align_break
        $this->wrapper = ($block['align'] == 'wide' || $block['align'] == 'full') ? 'rmcc-block rmcc-container-break' : 'rmcc-block';
      
        // align_container
        $this->container = 'rmcc-no-container';
        if($block['align'] == 'left' || $block['align'] == 'center' || $block['align'] == 'right') $this->container = 'rmcc-container rmcc-container-small';
        if($block['align'] == 'full') $this->container = 'rmcc-container rmcc-container-expand rmcc-padding-remove-horizontal';
        if($block['align'] == 'wide') $this->container = 'rmcc-container rmcc-container-xlarge';
      
        // align_style
        $this->align = null;
        if($block['align'] == 'right') $this->align = 'style="padding-right:0;margin-right:0;"';
        if($block['align'] == 'left') $this->align = 'style="padding-left:0;margin-left:0;"';
      
      }
    }

    // blocks requiring fullHeight
    if(array_key_exists('fullHeight', $block)){
      $this->fullheight = $block['fullHeight'];
      $this->fullheight_class = ($this->fullheight) ? 'rmcc-height-viewport': '';
      $this->fullheight_img_class = $this->fullheight ? 'cover-img home-cover-img' : 'cover-img';
    }

    // blocks requiring text alignment
    if(array_key_exists('alignText', $block)) $this->align_text = $block['alignText'];

    // blocks requiring content alignment (positioning)
    if(array_key_exists('alignContent', $block)){

      $this->align_content = '';
      $this->align_content_pos = '';
    
      // non-matrix
      $pos = ($block['alignContent'] == 'center') ? 'middle' : $block['alignContent'];
      if($block['alignContent'] == 'center' || $block['alignContent'] == 'top' || $block['alignContent'] == 'bottom') $this->align_content = 'rmcc-flex rmcc-flex-' . $pos;
    
      // matrix: top
      if($block['alignContent'] == 'top right') $this->align_content_pos = 'rmcc-position-top-right';
      if($block['alignContent'] == 'top center') $this->align_content_pos = 'rmcc-position-top-center';
      if($block['alignContent'] == 'top left') $this->align_content_pos = 'rmcc-position-top-left';
    
      // matrix: center
      if($block['alignContent'] == 'center right') $this->align_content_pos = 'rmcc-position-center-right';
      if($block['alignContent'] == 'center center') $this->align_content_pos = 'rmcc-position-center';
      if($block['alignContent'] == 'center left') $this->align_content_pos = 'rmcc-position-center-left';
    
      // matrix: bottom
      if($block['alignContent'] == 'bottom right') $this->align_content_pos = 'rmcc-position-bottom-right';
      if($block['alignContent'] == 'bottom center') $this->align_content_pos = 'rmcc-position-bottom-center';
      if($block['alignContent'] == 'bottom left') $this->align_content_pos = 'rmcc-position-bottom-left';
      
    }

  }

}