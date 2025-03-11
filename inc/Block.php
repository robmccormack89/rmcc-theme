<?php

namespace Rmcc;

// this class sets up data like custom classes according to the block's given settings
class Block {

  public $outer;
  public $container;
  public $background;
  public $block_wrapper_attributes;
  public $inner;
  public $inline;
  public $position;
  public $preview;

  public function __construct($block) {
    $this->outer = $this->block_outer($block);
    $this->container = $this->block_container($block);
    $this->background = $this->block_background($block);
    $this->block_wrapper_attributes = $this->block_wrapper_attributes($block);
    $this->inner = $this->block_inner($block);
    $this->inline = $this->block_inline($block);
    $this->position = $this->block_position($block);
    $this->preview = $this->block_preview($block);
  }

  public function block_outer($block) {
    $data = [];
    $data['wrap'] = '';

    $classes = ['rmcc-block'];
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'wide' || $block['align'] == 'full' || $block['align'] == 'right' || $block['align'] == 'left' || $block['align'] == 'center') $classes[] = 'rmcc-container-break';
      }
    }

    $data['wrap'] = 'class="' . implode(' ', $classes) . '"';
    return $data;
  }
  public function block_container($block) {
    $data = [];
    $classes = [];
    $style = false;
    $data['wrap'] = '';

    // container classes (align full/wide)
    $classes[] = 'rmcc-no-container';
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'full') $classes = ['rmcc-container', 'rmcc-container-expand', 'rmcc-padding-remove-horizontal'];
        if($block['align'] == 'wide') $classes = ['rmcc-container'];
      }
    }

    // align style inline (left/right/center)
    if(array_key_exists('align', $block) && array_key_exists('is_preview', $block)){
      if(!$block['is_preview']){
        if($block['align'] == 'right') $style = 'style="padding-right:0;margin-right:0;margin-left:50%"';
        if($block['align'] == 'left') $style = 'style="padding-left:0;margin-left:0;margin-right:50%"';
        if($block['align'] == 'center') $style = 'style="padding-left:0;padding-right:0;margin-left:25%;margin-right:25%"';
      }
    }

    $classes = implode(' ', $classes);
    $data['wrap'] = 'class="' . $classes . '"';
    if($style) $data['wrap'] = $data['wrap'] . ' ' . $style;
    return $data;
  }
  public function block_background($block) {
    $data = [];
    $_classes = [];
    $_styles = [];
    $data['wrap'] = '';

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

    // better output of classes and styles
    $classes = 'class="' . implode(' ', $_classes) . '"';
    $styles = array_map(function($value, $key) {
      return $key.':'.$value;
    }, array_values($_styles), array_keys($_styles));
    $styles = 'style="' . implode(';', $styles) . '"';

    $data['wrap'] = $classes . ' ' . $styles;
    return $data;
  }
  public function block_wrapper_attributes($block) {
    $data = null;
    if(array_key_exists('is_preview', $block)){

      if(!$block['is_preview']) $data = wp_kses_data(get_block_wrapper_attributes());

      // remove custom className from get_block_wrapper_attributes (we will put it back in in inner)
      if(array_key_exists('className', $block)) {
        $_className = esc_html($block['className']);
        if($data && str_contains($data, $_className))$data = str_replace(' '.$_className, '', $data);
      }

    }
    return $data;
  }
  public function block_inner($block) {
    $data = [];
    $classes = ['rmcc-flex','rmcc-card-body'];
    $styles = [];
    $data['wrap'] = '';

    // if custom className, remove rmcc-card-body (padding) class, & replace with custom className
    // allow for removal/custom internal padding
    if(array_key_exists('className', $block)) {
      $classes = ['rmcc-flex'];
      $classes[] = esc_html($block['className']);
    }

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
          $styles[] = 'height: ' . $block['style']['dimensions']['minHeight'];
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
    $align_content = '';
    if((array_key_exists('align_content', $block))){
      if((array_key_exists('supports', $block))){
        if((array_key_exists('alignContent', $block['supports']))){
          if($block['supports']['alignContent']){
            if($block['supports']['alignContent'] === 'matrix'){
              // print_r('nope');
            } else {
              $_align_content = ($block['align_content'] == 'center') ? 'rmcc-flex rmcc-flex-middle' : 'rmcc-flex rmcc-flex-' . $block['align_content'];
              if($block['align_content'] == 'center' || $block['align_content'] == 'top' || $block['align_content'] == 'bottom') $align_content = $_align_content;
              $classes[] = $align_content;
            }
          }
        }
      }
    }

    // finally....
    $data['wrap'] = 'class="' . implode(' ', $classes) . '" style="' . implode(';', $styles) . '"';
    
    // and return!
    return $data;

  }
  public function block_inline($block) {
    $data = [];
    $data['wrap'] = '';
    $classes = [];

    if((array_key_exists('align_content', $block))){
      if((array_key_exists('supports', $block))){
        if((array_key_exists('alignContent', $block['supports']))){
          if($block['supports']['alignContent']){
            if($block['supports']['alignContent'] === 'matrix'){
              $classes = ['rmcc-width-1-1','rmcc-inline'];
            } else {
              $classes = ['rmcc-width-1-1'];
            }
          }
        }
      }
    }

    // finally....
    $data['wrap'] = 'class="' . implode(' ', $classes) . '"';
    
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

        if($block['align_content'] == 'none') $align_content_pos = 'rmcc-position-none';
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

}