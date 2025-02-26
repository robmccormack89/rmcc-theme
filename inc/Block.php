<?php

namespace Rmcc;

// this class sets up data like custom classes according to the block's given settings
class Block {

  public $outer;
  public $container;
  public $img;
  public $block_wrapper_attributes;
  public $inner;
  public $position;

  public $preview;

  public function __construct($block) {

    $this->outer = $this->block_outer($block);
    $this->container = $this->block_container($block);
    $this->img = $this->block_img($block);
    $this->block_wrapper_attributes = $this->block_wrapper_attributes($block);
    $this->inner = $this->block_inner($block);
    $this->position = $this->block_position($block);

    $this->preview = $this->block_preview($block);

  }

  public function block_outer($block) {
    $data = [];
    $data['wrap'] = '';
    $data['classes'] = null;

    $classes = ['rmcc-block'];
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'wide' || $block['align'] == 'full') $classes[] = 'rmcc-container-break';
      }
    }

    $data['classes'] = $classes;
    $data['wrap'] = 'class="' . implode(' ', $classes) . '"';

    return $data;
  }
  public function block_container($block) {
    $data = [];
    $classes = [];
    $style = null;
    $data['wrap'] = '';

    // container classes (align full/wide)
    $classes[] = 'rmcc-no-container';
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'full') $classes = ['rmcc-container', 'rmcc-container-expand', 'rmcc-padding-remove-horizontal'];
        if($block['align'] == 'wide') $classes = ['rmcc-container', 'rmcc-container-xlarge'];
      }
    }

    // custom className
    if(array_key_exists('className', $block)) $classes[] = esc_html($block['className']);

    // align style inline (left/right/center)
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'right') $style = 'style="padding-right:0;margin-right:0;margin-left:25%"';
        if($block['align'] == 'left') $style = 'style="padding-left:0;margin-left:0;margin-right:25%"';
        if($block['align'] == 'center') $style = 'style="padding-left:0;padding-right:0;margin-left:12.5%;margin-right:12.5%"';
      }
    }

    $data['classes'] = implode(' ', $classes);
    $data['wrap'] = 'class="' . $data['classes'] . '"';
    if($style) $data['style'] = $style;
    if($style) $data['wrap'] = $data['wrap'] . ' ' . $data['style'];
    return $data;
  }
  public function block_img($block) {
    
    $data = [];
    $_classes = [];
    $_styles = [];
    $data['wrap'] = '';

    if($block['name'] == 'acf/card'){
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

            // background size
            if($backgroundSize == 'cover') $_classes[] = 'rmcc-background-cover';
            if($backgroundSize == 'contain') $_classes[] = 'rmcc-background-contain';
            if($backgroundSize == 'auto') $_styles['background-size'] = 'auto;';
            if(str_contains($backgroundSize,'px')) $_styles['background-size'] = $backgroundSize;

            // background repeat
            if($backgroundRepeat == 'no-repeat') $_classes[] = 'rmcc-background-norepeat';
            if($backgroundRepeat == 'repeat') $_styles['background-repeat'] = 'repeat';

            // background attachment
            if($backgroundAttachment == 'fixed') $_classes[] = 'rmcc-background-fixed';
            if($backgroundAttachment == 'fixed') $_styles['background-attachment'] = 'fixed';
            if($backgroundAttachment == 'scroll') $_styles['background-attachment'] = 'scroll';

            // background position
            if($backgroundPosition) $_styles['background-position'] = $backgroundPosition;

            // background image
            if($backgroundImageUrl) $_styles['background-image'] = 'url('.$backgroundImageUrl.')';

            // for background images WITH borders, we need to add the radius to the img wrap, when imgs are set
            if(array_key_exists('border', $block['style'])){
              if(array_key_exists('radius', $block['style']['border'])){
                $_styles['border-radius'] = $block['style']['border']['radius'];
              }
            }

          }

        }
      }
    }

    // better output of classes and styles
    $classes = 'class="' . implode(' ', $_classes) . '"';
    $styles = array_map(function($value, $key) {
      return $key.':'.$value;
    }, array_values($_styles), array_keys($_styles));
    $styles = 'style="' . implode(';', $styles) . '"';

    // combine classes & styles into wrap
    $data['wrap'] = $classes . ' ' . $styles;

    return $data;
  }
  public function block_wrapper_attributes($block) {
    $data = null;
    if(array_key_exists('is_preview', $block)){
      if(!$block['is_preview']) $data = wp_kses_data(get_block_wrapper_attributes());
    }
    return $data;
  }
  public function block_inner($block) {

    $data = [];
    $data['wrap'] = '';
    $classes = ['rmcc-card','rmcc-card-body'];
    $styles = [];

    // backgrounds
    $bg_class = 'rmcc-background-muted';
    if((array_key_exists('backgroundColor', $block)) || (array_key_exists('gradient', $block))) $bg_class = 'rmcc-background-blank';
    if((array_key_exists('style', $block))){
      if((array_key_exists('color', $block['style']))){
        if( (array_key_exists('background', $block['style']['color'])) || (array_key_exists('gradient', $block['style']['color'])) ){
          $bg_class = 'rmcc-background-blank';
        }
      }
    }

    // heights styles
    if((array_key_exists('style', $block))){
      if((array_key_exists('dimensions', $block['style']))){
        if((array_key_exists('minHeight', $block['style']['dimensions']))){
          $styles[] = 'min-height: ' . $block['style']['dimensions']['minHeight'];
        }
      }
    }

    // heights classes
    $height_class = 'rmcc-no-height';
    if(array_key_exists('fullHeight', $block)){
      if($block['fullHeight']) $height_class = 'rmcc-height-viewport';
    }  

    $classes[] = $bg_class;
    $classes[] = $height_class;

    // alignContent top|middle|bottom
    if((array_key_exists('align_content', $block))){
      $align_content = 'rmcc-width-1-1 rmcc-inline';
      $_align_content = ($block['align_content'] == 'center') ? 'rmcc-width-1-1 rmcc-flex rmcc-flex-middle' : 'rmcc-width-1-1 rmcc-flex rmcc-flex-' . $block['align_content'];
      if($block['align_content'] == 'center' || $block['align_content'] == 'top' || $block['align_content'] == 'bottom') $align_content = $_align_content;
      $classes[] = $align_content;
    }

    // finally....
    $data['wrap'] = 'class="' . implode(' ', $classes) . '" style="' . implode(';', $styles) . '"';
    
    // and return!
    return $data;

  }
  public function block_position($block) {
    $data = [];
    $data['wrap'] = '';
    $classes = [];

    $align_content_pos = 'rmcc-position-none';
    if((array_key_exists('align_content', $block))){
      if(!($block['align_content'] == 'center' || $block['align_content'] == 'top' || $block['align_content'] == 'bottom')){

        if($block['align_content'] == 'top right') $align_content_pos = 'rmcc-position-top-right';
        if($block['align_content'] == 'top center') $align_content_pos = 'rmcc-position-top-center';
        if($block['align_content'] == 'top left') $align_content_pos = 'rmcc-position-top-left';

        if($block['align_content'] == 'center right') $align_content_pos = 'rmcc-position-center-right';
        if($block['align_content'] == 'center center') $align_content_pos = 'rmcc-position-center';
        if($block['align_content'] == 'center left') $align_content_pos = 'rmcc-position-center-left';

        if($block['align_content'] == 'bottom right') $align_content_pos = 'rmcc-position-bottom-right';
        if($block['align_content'] == 'bottom center') $align_content_pos = 'rmcc-position-bottom-center';
        if($block['align_content'] == 'bottom left') $align_content_pos = 'rmcc-position-bottom-left';
      }
    }
    $classes[] = $align_content_pos;

    $data['wrap'] = 'class="' . implode(' ', $classes) . '"';
    
    // and return!
    return $data;
  }

  public function block_preview($block){
    $data = [];
    $data['wrap'] = '';
    if(array_key_exists('backgroundColor', $block)) $data['wrap'] = 'style="background-color: var(--wp--preset--color--' . $block['backgroundColor']  . ') !important;"';
    if(array_key_exists('gradient', $block)) $data['wrap'] = 'style="background: var(--wp--preset--gradient--' . $block['gradient'] . ') !important;"';
    if(array_key_exists('style', $block)){
      if(array_key_exists('color', $block['style'])){
        if(array_key_exists('background', $block['style']['color'])) $data['wrap'] = 'style="background-color: ' . $block['style']['color']['background'] . ';"';
        if(array_key_exists('gradient', $block['style']['color'])) $data['wrap'] = 'style="background: ' . $block['style']['color']['gradient'] . ';"';
      }
    }
    return $data;
  }


  // public function __block_img($block) {
  //   $data = [];
  //   $data['wrap'] = '';
  //   if($block['name'] == 'acf/card'){

  //     // img via native backgroundImage (with relevant supports)
  //     if(array_key_exists('style', $block)){
  //       if(array_key_exists('background', $block['style'])){

  //         $backgroundImage = (array_key_exists('backgroundImage', $block['style']['background'])) ? $block['style']['background']['backgroundImage'] : null;
  //         $backgroundSize = (array_key_exists('backgroundSize', $block['style']['background'])) ? $block['style']['background']['backgroundSize'] : null;
  //         $backgroundAttachment = (array_key_exists('backgroundAttachment', $block['style']['background'])) ? $block['style']['background']['backgroundAttachment'] : null;
  //         $backgroundRepeat = (array_key_exists('backgroundRepeat', $block['style']['background'])) ? $block['style']['background']['backgroundRepeat'] : null;
  //         $backgroundPosition = (array_key_exists('backgroundPosition', $block['style']['background'])) ? $block['style']['background']['backgroundPosition'] : null;

  //         $backgroundImageUrl = null;
  //         $backgroundImageId = null;
  //         $backgroundImageSrc = null;
  //         $backgroundImageTitle = null;

  //         if($backgroundImage){
  //           if(array_key_exists('url', $backgroundImage)) $backgroundImageUrl = $backgroundImage['url'];
  //           if(array_key_exists('id', $backgroundImage)) $backgroundImageId = $backgroundImage['id'];
  //           if(array_key_exists('source', $backgroundImage)) $backgroundImageSrc = $backgroundImage['source'];
  //           if(array_key_exists('title', $backgroundImage)) $backgroundImageTitle = $backgroundImage['title'];
  //         }

  //         if($backgroundImageUrl){
            
  //           // $class_string = 'class="rmcc-background-cover"';
  //           // $attrs_string = 'style="background-image: url(' . $backgroundImageUrl . ');"';
  //           // $full_string = '<div ' . $class_string . ' ' . $attrs_string . ' >';
  //           // $data['html_wrap_start'] = $full_string;

  //           $class_start = 'class="';
  //           $class_end = '"';
  //           $style_start = 'style="';
  //           $style_end = '"';

  //           // background size
  //           $size_class = '';
  //           $size_style = '';
  //           if($backgroundSize == 'cover') $size_class = 'rmcc-background-cover ';
  //           if($backgroundSize == 'contain') $size_class = 'rmcc-background-contain ';
  //           if($backgroundSize == 'auto') $size_style = 'background-size:auto;';
  //           if(str_contains($backgroundSize,'px')) $size_style = 'background-size:'.$backgroundSize.';';

  //           // background repeat
  //           $repeat_class = '';
  //           $repeat_style = '';
  //           if($backgroundRepeat == 'no-repeat') $repeat_class = 'rmcc-background-norepeat ';
  //           if($backgroundRepeat == 'repeat') $repeat_style = 'background-repeat:repeat;';

  //           // background attachment
  //           $attachment_class = '';
  //           $attachment_style = '';
  //           if($backgroundAttachment == 'fixed') $attachment_class = 'rmcc-background-fixed ';
  //           if($backgroundAttachment == 'fixed') $attachment_style = 'background-attachment:fixed;';
  //           if($backgroundAttachment == 'scroll') $attachment_style = 'background-attachment:scroll;';

  //           // background position
  //           $pos_style = '';
  //           if($backgroundPosition) $pos_style = 'background-position:'.$backgroundPosition.';';

  //           // background image
  //           $img_style = '';
  //           if($backgroundImageUrl) $img_style = 'background-image: url('.$backgroundImageUrl.');';

  //           $classes = $class_start . $size_class . '' . $repeat_class . '' . $attachment_class . '' .$class_end;
  //           $styles = $style_start . $size_style . '' . $repeat_style . '' . $attachment_style . '' . $pos_style . '' . $img_style . $style_end;
  //           $wrap = $classes . ' ' . $styles;
  //           $data['wrap'] = $wrap;

  //         }

  //       }
  //     }

  //   }
  //   return $data;
  // }


  // public function block_wrapper($block) {
  //   $data = 'rmcc-block';
  //   if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
  //     if(!$block['is_preview']){
  //       if($block['align'] == 'wide' || $block['align'] == 'full') $data = 'rmcc-block rmcc-container-break';
  //     }
  //   }
  //   return $data;
  // }
  // public function _block_container($block) {
  //   $data = 'rmcc-no-container';
  //   if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
  //     if(!$block['is_preview']){
  //       if($block['align'] == 'full') $data = 'rmcc-container rmcc-container-expand rmcc-padding-remove-horizontal';
  //       if($block['align'] == 'wide') $data = 'rmcc-container rmcc-container-xlarge';
  //     }
  //   }
  //   if(array_key_exists('className', $block)) $data = $data . ' ' . esc_html($block['className']);
  //   return $data;
  // }
  // public function block_align($block) {
  //   $data = null;
  //   if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
  //     if(!$block['is_preview']){
  //       if($block['align'] == 'right') $data = 'style="padding-right:0;margin-right:0;margin-left:25%"';
  //       if($block['align'] == 'left') $data = 'style="padding-left:0;margin-left:0;margin-right:25%"';
  //       if($block['align'] == 'center') $data = 'style="padding-left:0;padding-right:0;margin-left:12.5%;margin-right:12.5%"';
  //     }
  //   }
  //   return $data;
  // }
  // public function _block_img($block){
  //   // $data = null;
  //   $data = [];
  //   $data['wrapper'] = '';

  //   // img via ACF fields
  //   if($block['name'] == 'acf/card'){

  //     // img via native backgroundImage (with relevant supports)
  //     if(array_key_exists('style', $block)){
  //       if(array_key_exists('background', $block['style'])){

  //         $backgroundImage = (array_key_exists('backgroundImage', $block['style']['background'])) ? $block['style']['background']['backgroundImage'] : null;
  //         $backgroundSize = (array_key_exists('backgroundSize', $block['style']['background'])) ? $block['style']['background']['backgroundSize'] : null;
  //         $backgroundAttachment = (array_key_exists('backgroundAttachment', $block['style']['background'])) ? $block['style']['background']['backgroundAttachment'] : null;
  //         $backgroundRepeat = (array_key_exists('backgroundRepeat', $block['style']['background'])) ? $block['style']['background']['backgroundRepeat'] : null;
  //         $backgroundPosition = (array_key_exists('backgroundPosition', $block['style']['background'])) ? $block['style']['background']['backgroundPosition'] : null;

  //         $backgroundImageUrl = null;
  //         $backgroundImageId = null;
  //         $backgroundImageSrc = null;
  //         $backgroundImageTitle = null;

  //         if($backgroundImage){
  //           if(array_key_exists('url', $backgroundImage)) $backgroundImageUrl = $backgroundImage['url'];
  //           if(array_key_exists('id', $backgroundImage)) $backgroundImageId = $backgroundImage['id'];
  //           if(array_key_exists('source', $backgroundImage)) $backgroundImageSrc = $backgroundImage['source'];
  //           if(array_key_exists('title', $backgroundImage)) $backgroundImageTitle = $backgroundImage['title'];
  //         }

  //         if($backgroundImageUrl){
            
  //           // $class_string = 'class="rmcc-background-cover"';
  //           // $attrs_string = 'style="background-image: url(' . $backgroundImageUrl . ');"';
  //           // $full_string = '<div ' . $class_string . ' ' . $attrs_string . ' >';
  //           // $data['html_wrap_start'] = $full_string;

  //           $class_start = 'class="';
  //           $class_end = '"';
  //           $style_start = 'style="';
  //           $style_end = '"';

  //           // background size
  //           $size_class = '';
  //           $size_style = '';
  //           if($backgroundSize == 'cover') $size_class = 'rmcc-background-cover ';
  //           if($backgroundSize == 'contain') $size_class = 'rmcc-background-contain ';
  //           if($backgroundSize == 'auto') $size_style = 'background-size:auto;';
  //           if(str_contains($backgroundSize,'px')) $size_style = 'background-size:'.$backgroundSize.';';

  //           // background repeat
  //           $repeat_class = '';
  //           $repeat_style = '';
  //           if($backgroundRepeat == 'no-repeat') $repeat_class = 'rmcc-background-norepeat ';
  //           if($backgroundRepeat == 'repeat') $repeat_style = 'background-repeat:repeat;';

  //           // background attachment
  //           $attachment_class = '';
  //           $attachment_style = '';
  //           if($backgroundAttachment == 'fixed') $attachment_class = 'rmcc-background-fixed ';
  //           if($backgroundAttachment == 'fixed') $attachment_style = 'background-attachment:fixed;';
  //           if($backgroundAttachment == 'scroll') $attachment_style = 'background-attachment:scroll;';

  //           // background position
  //           $pos_style = '';
  //           if($backgroundPosition) $pos_style = 'background-position:'.$backgroundPosition.';';

  //           // background image
  //           $img_style = '';
  //           if($backgroundImageUrl) $img_style = 'background-image: url('.$backgroundImageUrl.');';

  //           $classes = $class_start . $size_class . '' . $repeat_class . '' . $attachment_class . '' .$class_end;
  //           $styles = $style_start . $size_style . '' . $repeat_style . '' . $attachment_style . '' . $pos_style . '' . $img_style . $style_end;
  //           $wrap = $classes . ' ' . $styles;
  //           $data['wrapper'] = $wrap;

  //         }

  //       }
  //     }

  //   }

  //   return $data;
  // }
  // public function block_spacing($block) {
  //   $data = null;
  //   if(array_key_exists('is_preview', $block)){

  //     if(!$block['is_preview']) $data = wp_kses_data(get_block_wrapper_attributes());

  //     // disable spacer on left/right/center align
  //     // if( $block['align'] == 'left' || $block['align'] == 'right' || $block['align'] == 'center') $data = null;

  //   }
  //   return $data;
  // }
  // public function block_content($block){
  //   $data = [];
  //   $data['wrapper'] = '';

  //   $class_start = 'class="';
  //   $class_end = '"';
  //   $classes = ['rmcc-card','rmcc-card-body'];

  //   $style_start = 'style="';
  //   $style_end = '"';
  //   $styles = [];

  //   // backgrounds
  //   $bg_class = 'rmcc-background-muted';
  //   if((array_key_exists('backgroundColor', $block)) || (array_key_exists('gradient', $block))) $bg_class = 'rmcc-background-blank';
  //   if((array_key_exists('style', $block))){
  //     if((array_key_exists('color', $block['style']))){
  //       if( (array_key_exists('background', $block['style']['color'])) || (array_key_exists('gradient', $block['style']['color'])) ){
  //         $bg_class = 'rmcc-background-blank';
  //       }
  //     }
  //   }

  //   // heights styles
  //   if((array_key_exists('style', $block))){
  //     if((array_key_exists('dimensions', $block['style']))){
  //       if((array_key_exists('minHeight', $block['style']['dimensions']))){
  //         $styles[] = 'min-height: ' . $block['style']['dimensions']['minHeight'] . ';';
  //       }
  //     }
  //   }

  //   // heights classes
  //   $fullheight_class = 'rmcc-no-height';
  //   if(array_key_exists('fullHeight', $block)){
  //     if($block['fullHeight']) $fullheight_class = 'rmcc-height-viewport';
  //   }

  //   // print_r($fullheight_class);  

  //   $classes[] = $bg_class;
  //   $classes[] = $fullheight_class;

  //   // finally....
  //   $data['wrapper'] = 'class="' . implode(' ', $classes) . '" style="' . implode(' ', $styles) . '"';

  //   // print_r($data['wrapper']);  

  //   return $data;
  // }

  // returns class
  // public function block_align_content($block){
  //   $data = null;

  //   // non-matrix
  //   if(array_key_exists('alignContent', $block)){
  //     $pos = ($block['alignContent'] == 'center') ? 'middle' : $block['alignContent'];
  //     if($block['alignContent'] == 'center' || $block['alignContent'] == 'top' || $block['alignContent'] == 'bottom') $data = 'rmcc-flex rmcc-flex-' . $pos;
  //   }

  //   return $data;
  // }
  // public function block_align_content_pos($block){
  //   $data = null;

  //   if(array_key_exists('alignContent', $block)){

  //     // matrix: top
  //     if($block['alignContent'] == 'top right') $data = 'rmcc-position-top-right';
  //     if($block['alignContent'] == 'top center') $data = 'rmcc-position-top-center';
  //     if($block['alignContent'] == 'top left') $data = 'rmcc-position-top-left';
    
  //     // matrix: center
  //     if($block['alignContent'] == 'center right') $data = 'rmcc-position-center-right';
  //     if($block['alignContent'] == 'center center') $data = 'rmcc-position-center';
  //     if($block['alignContent'] == 'center left') $data = 'rmcc-position-center-left';
    
  //     // matrix: bottom
  //     if($block['alignContent'] == 'bottom right') $data = 'rmcc-position-bottom-right';
  //     if($block['alignContent'] == 'bottom center') $data = 'rmcc-position-bottom-center';
  //     if($block['alignContent'] == 'bottom left') $data = 'rmcc-position-bottom-left';

  //   }

  //   return $data;
  // }
  // public function block_fullheight_img($block) {
  //   $data = 'cover-img';
  //   if(array_key_exists('fullHeight', $block)){
  //     if($block['fullHeight']) $data = 'cover-img home-cover-img';
  //   }
  //   return $data;
  // }
  // public function block_align_text($block) {
  //   $data = null;
  //   if(array_key_exists('alignText', $block)) $data = $block['alignText'];
  //   return $data;
  // }

}