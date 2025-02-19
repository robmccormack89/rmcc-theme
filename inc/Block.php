<?php

namespace Rmcc;

// this class sets up data like custom classes according to the block's given settings
class Block {

  // ACF Fields
  public $img;

  // Built-in Controls
  public $spacer;
  public $wrapper;
  public $container;
  public $aligner;
  public $bg_class;
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
    $this->spacer = $this->block_spacing($block);
    $this->wrapper = $this->block_wrapper($block);
    $this->container = $this->block_container($block);
    $this->aligner = $this->block_align($block);

    // blocks bg colour / gradient
    $this->bg_class = $this->block_colour_bg($block);

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
    // $data = null;
    $data = [];
    $data['html_wrap_start'] = '<div>';
    $data['html_wrap_end'] = '</div>';

    // img via ACF fields
    if($block['name'] == 'acf/card'){

      if(get_field('img')){

        $data = get_field('img');

        $data['html_wrap_start'] = '<div>';
        $data['html_wrap_end'] = '</div>';

        if(get_field('left')) $data['_left'] = get_field('left');
        if(get_field('top')) $data['_top'] = get_field('top');
        if(get_field('fixed_bg')) $data['_fixed_bg'] = get_field('fixed_bg');
        if(get_field('size')) $data['_size'] = get_field('size');
        if(get_field('width')) $data['_width'] = get_field('width');
        if(get_field('repeat')) $data['_repeat'] = get_field('repeat');

        if($data['url']) {
          $class_string = 'class="rmcc-background-cover"';
          $attrs_string = 'style="background-image: url(' . $data['url'] . ')"';
          $full_string = '<div ' . $class_string . ' ' . $attrs_string . ' >';
          $data['html_wrap_start'] = $full_string;
        }

      }

      // img via native backgroundImage supports
      if(array_key_exists('style', $block)){
        if(array_key_exists('background', $block['style'])){

          $backgroundImage = (array_key_exists('backgroundImage', $block['style']['background'])) ? $block['style']['background']['backgroundImage'] : null;
          $backgroundSize = (array_key_exists('backgroundSize', $block['style']['background'])) ? $block['style']['background']['backgroundSize'] : null;
          $backgroundAttachment = (array_key_exists('backgroundAttachment', $block['style']['background'])) ? $block['style']['background']['backgroundAttachment'] : null;
          $backgroundRepeat = (array_key_exists('backgroundRepeat', $block['style']['background'])) ? $block['style']['background']['backgroundRepeat'] : null;
          $backgroundPosition = (array_key_exists('backgroundPosition', $block['style']['background'])) ? $block['style']['background']['backgroundPosition'] : null;

          $backgroundImageUrl = null;
          $backgroundImageId = null;
          $backgroundImageSrc = null;
          $backgroundImageTitle = null;

          if($backgroundImage){
            if(array_key_exists('url', $backgroundImage)) $backgroundImageUrl = $backgroundImage['url'];
            if(array_key_exists('id', $backgroundImage)) $backgroundImageId = $backgroundImage['id'];
            if(array_key_exists('source', $backgroundImage)) $backgroundImageSrc = $backgroundImage['source'];
            if(array_key_exists('title', $backgroundImage)) $backgroundImageTitle = $backgroundImage['title'];
          }

          if($backgroundImageUrl){
            
            // $class_string = 'class="rmcc-background-cover"';
            // $attrs_string = 'style="background-image: url(' . $backgroundImageUrl . ');"';
            // $full_string = '<div ' . $class_string . ' ' . $attrs_string . ' >';
            // $data['html_wrap_start'] = $full_string;

            $class_start = 'class="';
            $class_end = '"';
            $style_start = 'style="';
            $style_end = '"';

            $size_class = '';
            $size_style = '';
            if($backgroundSize == 'cover') $size_class = 'rmcc-background-cover';
            if($backgroundSize == 'contain') $size_class = 'rmcc-background-contain';
            if($backgroundSize == 'auto') $size_style = 'background-size: auto;';
            if(str_contains($backgroundSize,'px')) $size_style = 'background-size:'.$backgroundSize.';';

            $repeat_class = '';
            $repeat_style = '';
            if($backgroundRepeat == 'no-repeat') $repeat_class = 'rmcc-background-norepeat';
            if($backgroundRepeat == 'repeat') $repeat_style = 'background-repeat: repeat;';

            $attachment_style = '';
            if($backgroundAttachment == 'fixed') $attachment_style = 'background-attachment: fixed;';
            if($backgroundAttachment == 'scroll') $attachment_style = 'background-attachment: scroll;';

            $pos_style = '';
            if($backgroundPosition) $pos_style = 'background-position: '.$backgroundPosition.';';

            $img_style = '';
            if($backgroundImageUrl) $img_style = 'background-image: url('.$backgroundImageUrl.');';

            // print_r($img_style);

            $classy = $class_start . $size_class . ' ' . $repeat_class . $class_end;
            $styley = $style_start . $size_style . ' ' . $repeat_style . ' ' . $attachment_style . ' ' . $pos_style . ' ' . $img_style . $style_end;
            $allo = $classy . ' ' . $styley;
            $data['wrap'] = $allo;
            // print_r($classy);
            // print_r('<hr>');
            // print_r($allo);

            // $rmcc_cover = 'rmcc-background-cover'; // size
            // $rmcc_contain = 'rmcc-background-contain'; // size
            // $rmcc_norepeat = 'rmcc-background-norepeat'; // repeat
            // $rmcc_fixed = 'rmcc-background-fixed'; // attachment

          }

        }
      }

    }

    return $data;
  }

  // returns inline style attrs & class attrs
  public function block_spacing($block) {
    $data = null;
    if(array_key_exists('is_preview', $block)){

      if(!$block['is_preview']) $data = wp_kses_data(get_block_wrapper_attributes());

      // disable spacer on left/right/center align
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