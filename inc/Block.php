<?php

namespace Rmcc;

// this class sets up data like custom classes according to the block's given settings
class Block {

  // Built-in Controls
  public $spacer;
  public $wrap_class;
  public $container_class;
  public $align_style;
  public $bg_class;
  public $fullheight_class;
  public $fullheight_img;
  public $align_text;
  public $align_content;
  public $align_content_pos;

  public $img;
  public $preview;

  public function __construct($block) {

    /*
    Built-in
    Controls
    */

    // block spacing, margin & wrapping (related to aligner)
    $this->spacer = $this->block_spacing($block);
    $this->wrap_class = $this->block_wrapper($block);
    $this->container_class = $this->block_container($block);
    $this->align_style = $this->block_align($block);

    // blocks bg colour / gradient
    $this->bg_class = $this->block_colour_bg($block);

    // blocks fullHeight
    $this->fullheight_class = $this->block_fullheight($block);
    $this->fullheight_img = $this->block_fullheight_img($block);

    // blocks text alignment
    $this->align_text = $this->block_align_text($block);

    // blocks content alignment (positioning)
    $this->align_content = $this->block_align_content($block);
    $this->align_content_pos = $this->block_align_content_pos($block);

    // blocks backgroundImage
    $this->img = $this->block_img($block);

    //
    $this->preview = $this->block_preview_wrapper($block);

  }

  public function block_preview_wrapper($block){
    $data = [];
    $data['wrapper'] = '';

    if(array_key_exists('backgroundColor', $block)) $data['wrapper'] = 'style="background-color: var(--wp--preset--color--' . $block['backgroundColor']  . ') !important;"';
    if(array_key_exists('gradient', $block)) $data['wrapper'] = 'style="background: var(--wp--preset--gradient--' . $block['gradient'] . ') !important;"';
    if(array_key_exists('style', $block)){
      if(array_key_exists('color', $block['style'])){
        if(array_key_exists('background', $block['style']['color'])) $data['wrapper'] = 'style="background-color: ' . $block['style']['color']['background'] . ';"';
        if(array_key_exists('gradient', $block['style']['color'])) $data['wrapper'] = 'style="background: ' . $block['style']['color']['gradient'] . ';"';
      }
    }

    return $data;
  }

  // returns image object
  public function block_img($block){
    // $data = null;
    $data = [];
    $data['wrapper'] = '';

    // img via ACF fields
    if($block['name'] == 'acf/card'){

      // img via native backgroundImage (with relevant supports)
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

            // background size
            $size_class = '';
            $size_style = '';
            if($backgroundSize == 'cover') $size_class = 'rmcc-background-cover ';
            if($backgroundSize == 'contain') $size_class = 'rmcc-background-contain ';
            if($backgroundSize == 'auto') $size_style = 'background-size:auto;';
            if(str_contains($backgroundSize,'px')) $size_style = 'background-size:'.$backgroundSize.';';

            // background repeat
            $repeat_class = '';
            $repeat_style = '';
            if($backgroundRepeat == 'no-repeat') $repeat_class = 'rmcc-background-norepeat ';
            if($backgroundRepeat == 'repeat') $repeat_style = 'background-repeat:repeat;';

            // background attachment
            $attachment_class = '';
            $attachment_style = '';
            if($backgroundAttachment == 'fixed') $attachment_class = 'rmcc-background-fixed ';
            if($backgroundAttachment == 'fixed') $attachment_style = 'background-attachment:fixed;';
            if($backgroundAttachment == 'scroll') $attachment_style = 'background-attachment:scroll;';

            // background position
            $pos_style = '';
            if($backgroundPosition) $pos_style = 'background-position:'.$backgroundPosition.';';

            // background image
            $img_style = '';
            if($backgroundImageUrl) $img_style = 'background-image: url('.$backgroundImageUrl.');';

            $classes = $class_start . $size_class . '' . $repeat_class . '' . $attachment_class . '' .$class_end;
            $styles = $style_start . $size_style . '' . $repeat_style . '' . $attachment_style . '' . $pos_style . '' . $img_style . $style_end;
            $wrap = $classes . ' ' . $styles;
            $data['wrapper'] = $wrap;

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
    if(array_key_exists('className', $block)) $data = $data . ' ' . esc_html($block['className']);;
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