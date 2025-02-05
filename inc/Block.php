<?php

namespace Rmcc;

// this class sets up data like custom classes according to the block's given settings
class Block {

  // ACF Fields
  public $img;

  // Built-in Controls
  public $spacingAttrs;
  public $wrapper;
  public $container;
  public $align;
  public $colour_bg;
  public $fullheight;
  public $fullheight_img;
  public $align_text;
  public $align_content;
  public $align_content_pos;

  public function __construct($block) {

    /*
    Built-in
    Controls
    */

    // block spacing, margin & wrapping (related to aligner)
    $this->spacingAttrs = $this->block_spacing($block);
    $this->wrapper = $this->block_wrapper($block);
    $this->container = $this->block_container($block);
    $this->align = $this->block_align($block);

    // blocks bg colour / gradient
    $this->colour_bg = $this->block_colour_bg($block);

    // blocks fullHeight
    $this->fullheight = $this->block_fullheight($block);
    $this->fullheight_img = $this->block_fullheight_img($block);

    // blocks text alignment
    $this->align_text = $this->block_align_text($block);

    // blocks content alignment (positioning)
    $this->align_content = $this->block_align_content($block);
    $this->align_content_pos = $this->block_align_content_pos($block);

    /*
    ACF
    Fields
    */

    $this->img = $this->block_fields_img($block);

  }

  // returns image object
  public function block_fields_img($block){
    $data = null;
    if($block['name'] == 'acf/card'){
      if(get_field('img')){
        $data = get_field('img');
        if(get_field('left')) $data['left'] = get_field('left');
        if(get_field('top')) $data['top'] = get_field('top');
        if(get_field('fixed_bg')) $data['fixed_bg'] = get_field('fixed_bg');
        if(get_field('size')) $data['_size'] = get_field('size');
        if(get_field('width')) $data['_width'] = get_field('width');
        if(get_field('repeat')) $data['repeat'] = get_field('repeat');
      }
    }
    return $data;
  }

  // returns inline style attrs & class attrs
  public function block_spacing($block) {
    $data = null;
    if(array_key_exists('is_preview', $block)){

      if(!$block['is_preview']) $data = wp_kses_data(get_block_wrapper_attributes());

      // disable spacingAttrs on left/right/center align
      if( $block['align'] == 'left' || $block['align'] == 'right' || $block['align'] == 'center') $data = null;

    }
    return $data;
  }

  // returns class
  public function block_wrapper($block) {
    $data = 'rmcc-block';
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'wide' || $block['align'] == 'full') $data = 'rmcc-block rmcc-container-break';
      }
    }
    return $data;
  }

  // returns class
  public function block_container($block) {
    $data = 'rmcc-no-container';
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'full') $data = 'rmcc-container rmcc-container-expand rmcc-padding-remove-horizontal';
        if($block['align'] == 'wide') $data = 'rmcc-container rmcc-container-xlarge';
      }
    }
    return $data;
  }

  // returns inline style attrs
  public function block_align($block) {
    $data = null;
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'right') $data = 'style="padding-right:0;margin-right:0;margin-left:25%"';
        if($block['align'] == 'left') $data = 'style="padding-left:0;margin-left:0;margin-right:25%"';
        if($block['align'] == 'center') $data = 'style="padding-left:0;padding-right:0;margin-left:12.5%;margin-right:12.5%"';
      }
    }
    return $data;
  }

  // returns class
  public function block_colour_bg($block){
    $data = 'rmcc-background-muted';
    if((array_key_exists('backgroundColor', $block)) || (array_key_exists('gradient', $block))) $data = 'rmcc-background-blank';
    if((array_key_exists('style', $block))){
      if((array_key_exists('color', $block['style']))){
        if( (array_key_exists('background', $block['style']['color'])) || (array_key_exists('gradient', $block['style']['color'])) ){
          $data = 'rmcc-background-blank';
        }
      }
    }
    return $data;
  }

  // returns class
  public function block_align_content($block){
    $data = null;

    // non-matrix
    if(array_key_exists('alignContent', $block)){
      $pos = ($block['alignContent'] == 'center') ? 'middle' : $block['alignContent'];
      if($block['alignContent'] == 'center' || $block['alignContent'] == 'top' || $block['alignContent'] == 'bottom') $data = 'rmcc-flex rmcc-flex-' . $pos;
    }

    return $data;
  }

  // returns class
  public function block_align_content_pos($block){
    $data = null;

    if(array_key_exists('alignContent', $block)){

      // matrix: top
      if($block['alignContent'] == 'top right') $data = 'rmcc-position-top-right';
      if($block['alignContent'] == 'top center') $data = 'rmcc-position-top-center';
      if($block['alignContent'] == 'top left') $data = 'rmcc-position-top-left';
    
      // matrix: center
      if($block['alignContent'] == 'center right') $data = 'rmcc-position-center-right';
      if($block['alignContent'] == 'center center') $data = 'rmcc-position-center';
      if($block['alignContent'] == 'center left') $data = 'rmcc-position-center-left';
    
      // matrix: bottom
      if($block['alignContent'] == 'bottom right') $data = 'rmcc-position-bottom-right';
      if($block['alignContent'] == 'bottom center') $data = 'rmcc-position-bottom-center';
      if($block['alignContent'] == 'bottom left') $data = 'rmcc-position-bottom-left';

    }

    return $data;
  }

  // returns class
  public function block_fullheight($block) {
    $data = 'rmcc-no-height';
    if(array_key_exists('fullHeight', $block)){
      if($block['fullHeight']) $data = 'rmcc-height-viewport';
    }
    return $data;
  }

  // returns class
  public function block_fullheight_img($block) {
    $data = 'cover-img';
    if(array_key_exists('fullHeight', $block)){
      if($block['fullHeight']) $data = 'cover-img home-cover-img';
    }
    return $data;
  }

  // returns something...
  public function block_align_text($block) {
    $data = null;
    if(array_key_exists('alignText', $block)) $data = $block['alignText'];
    return $data;
  }

}