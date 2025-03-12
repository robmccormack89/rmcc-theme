<?php

namespace Rmcc;

// this class sets up data like custom classes according to the block's given settings
class Block {

  public $break;
  public $container;
  public $background;
  public $block_wrapper_attributes;
  public $card;
  public $content;
  public $preview;

  public function __construct($block) {
    $this->break = $this->block_break($block);
    $this->container = $this->block_container($block);
    $this->background = $this->block_background($block);
    $this->block_wrapper_attributes = $this->block_wrapper_attributes($block);
    $this->card = $this->block_card($block);
    $this->content = [];
    $this->content['wrap'] = $this->block_content_wrap($block);
    $this->content['position'] = $this->block_content_position($block);
    $this->preview = $this->block_preview($block);
  }

  public function block_break($block) {
    $classes = ['rmcc-block'];
    if($block['align'] == 'wide' || $block['align'] == 'full' || $block['align'] == 'right' || $block['align'] == 'left' || $block['align'] == 'center') $classes[] = 'rmcc-container-break';

    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }
  public function block_container($block) {
    $classes = ['rmcc-no-container'];
    $style = null;

    if(array_key_exists('align', $block)){

      // container classes (align full/wide)
      if($block['align'] == 'full') $classes = ['rmcc-container', 'rmcc-container-expand', 'rmcc-padding-remove-horizontal'];
      if($block['align'] == 'wide') $classes = ['rmcc-container'];

      // align style inline (left/right/center)
      if($block['align'] == 'right') $style = 'style="padding-right:0;margin-right:0;margin-left:50%"';
      if($block['align'] == 'left') $style = 'style="padding-left:0;margin-left:0;margin-right:50%"';
      if($block['align'] == 'center') $style = 'style="padding-left:0;padding-right:0;margin-left:25%;margin-right:25%"';

    }

    $classes = implode(' ', $classes);
    $html = 'class="' . $classes . '"';
    if($style) $html = $html . ' ' . $style;
    return $html;
  }
  public function block_background($block) {
    $classes = [];
    $styles = [];

    // set the background classes & styles according to block background settings
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
          if($backgroundSize == 'cover') $classes[] = 'rmcc-background-cover';
          if($backgroundSize == 'contain') $classes[] = 'rmcc-background-contain';
          if($backgroundSize == 'auto') $styles['background-size'] = 'auto;';
          if(str_contains($backgroundSize,'px')) $styles['background-size'] = $backgroundSize;

          // background repeat
          if($backgroundRepeat == 'no-repeat') $classes[] = 'rmcc-background-norepeat';
          if($backgroundRepeat == 'repeat') $styles['background-repeat'] = 'repeat';

          // background attachment
          if($backgroundAttachment == 'fixed') $classes[] = 'rmcc-background-fixed';
          if($backgroundAttachment == 'fixed') $styles['background-attachment'] = 'fixed';
          if($backgroundAttachment == 'scroll') $styles['background-attachment'] = 'scroll';

          // background position
          if($backgroundPosition) $styles['background-position'] = $backgroundPosition;

          // background image
          if($backgroundImageUrl) $styles['background-image'] = 'url('.$backgroundImageUrl.')';

          // for background images WITH borders, we need to add the radius to the img wrap, when imgs are set
          if(array_key_exists('border', $block['style'])){
            if(array_key_exists('radius', $block['style']['border'])){
              $styles['border-radius'] = $block['style']['border']['radius'];
            }
          }

        }
      }
    }

    // better html outputting of classes & styles (as arrays)
    $classes = 'class="' . implode(' ', $classes) . '"';
    $styles = array_map(function($value, $key) {
      return $key.':'.$value;
    }, array_values($styles), array_keys($styles));
    $styles = 'style="' . implode(';', $styles) . '"';
    $html = $classes . ' ' . $styles;

    return $html;
  }
  public function block_wrapper_attributes($block) {
    $html = wp_kses_data(get_block_wrapper_attributes());

    // remove custom className from get_block_wrapper_attributes (we will put it back in in inner)
    if(array_key_exists('className', $block)) {
      $className = esc_html($block['className']);
      if($html && str_contains($html, $className)) $html = str_replace(' '.$className, '', $html);
    }

    return $html;
  }
  public function block_card($block) {
    $classes = ['rmcc-flex','rmcc-card-body'];
    $styles = [];

    // if custom className, remove rmcc-card-body (padding) class, & replace with custom className
    // allow for removal/custom internal padding
    if(array_key_exists('className', $block)) {
      $classes = ['rmcc-flex'];
      $classes[] = esc_html($block['className']);
    }

    // backgrounds classes
    $bg_class = 'rmcc-background-muted';
    if((array_key_exists('backgroundColor', $block)) || (array_key_exists('gradient', $block))) $bg_class = 'rmcc-background-blank';
    if((array_key_exists('style', $block))){
      if((array_key_exists('color', $block['style']))){
        if( (array_key_exists('background', $block['style']['color'])) || (array_key_exists('gradient', $block['style']['color'])) ){
          $bg_class = 'rmcc-background-blank';
        }
      }
    }
    $classes[] = $bg_class;

    // heights classes
    $height_class = 'rmcc-no-height';
    if(array_key_exists('fullHeight', $block)){
      if($block['fullHeight']) $height_class = 'rmcc-height-viewport';
    } 
    $classes[] = $height_class;

    // heights styles
    if((array_key_exists('style', $block))){
      if((array_key_exists('dimensions', $block['style']))){
        if((array_key_exists('minHeight', $block['style']['dimensions']))){
          $styles[] = 'height: ' . $block['style']['dimensions']['minHeight'];
          $styles[] = 'min-height: ' . $block['style']['dimensions']['minHeight'];
        }
      }
    } 

    // alignContent top|middle|bottom
    if((array_key_exists('align_content', $block))){
      if((array_key_exists('supports', $block))){
        if((array_key_exists('alignContent', $block['supports']))){
          if($block['supports']['alignContent']){
            if(!($block['supports']['alignContent'] === 'matrix')){
              $flex_classes = 'rmcc-flex rmcc-flex-' . $block['align_content'];
              if($block['align_content'] == 'center') $flex_classes = 'rmcc-flex rmcc-flex-middle';
              $classes[] = $flex_classes;
            }
          }
        }
      }
    }

    // finally....
    $html = 'class="' . implode(' ', $classes) . '" style="' . implode(';', $styles) . '"';
    
    // and return!
    return $html;

  }
  public function block_content_wrap($block) {
    $classes = ['rmcc-width-1-1'];

    if((array_key_exists('align_content', $block))){
      if((array_key_exists('supports', $block))){
        if((array_key_exists('alignContent', $block['supports']))){
          if($block['supports']['alignContent']){
            if($block['supports']['alignContent'] === 'matrix') $classes = ['rmcc-width-1-1','rmcc-inline'];
          }
        }
      }
    }

    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }
  public function block_content_position($block) {
    $classes = ['rmcc-position-none'];

    // matrix content positioning
    if((array_key_exists('align_content', $block))){
      if(!($block['align_content'] == 'center' || $block['align_content'] == 'top' || $block['align_content'] == 'bottom')){
        if($block['align_content'] == 'top right') $classes = ['rmcc-position-top-right'];
        if($block['align_content'] == 'top center') $classes = ['rmcc-position-top-center'];
        if($block['align_content'] == 'top left') $classes = ['rmcc-position-top-left'];
        if($block['align_content'] == 'center right') $classes = ['rmcc-position-center-right'];
        if($block['align_content'] == 'center center') $classes = ['rmcc-position-center'];
        if($block['align_content'] == 'center left') $classes = ['rmcc-position-center-left'];
        if($block['align_content'] == 'bottom right') $classes = ['rmcc-position-bottom-right'];
        if($block['align_content'] == 'bottom center') $classes = ['rmcc-position-bottom-center'];
        if($block['align_content'] == 'bottom left') $classes = ['rmcc-position-bottom-left'];
      }
    }

    $html = 'class="' . implode(' ', $classes) . '"';
    return $html;
  }
  public function block_preview($block){
    $html = '';
    if(array_key_exists('backgroundColor', $block)) $html = 'style="background-color: var(--wp--preset--color--' . $block['backgroundColor']  . ') !important;"';
    if(array_key_exists('gradient', $block)) $html = 'style="background: var(--wp--preset--gradient--' . $block['gradient'] . ') !important;"';
    if(array_key_exists('style', $block)){
      if(array_key_exists('color', $block['style'])){
        if(array_key_exists('background', $block['style']['color'])) $html = 'style="background-color: ' . $block['style']['color']['background'] . ';"';
        if(array_key_exists('gradient', $block['style']['color'])) $html = 'style="background: ' . $block['style']['color']['gradient'] . ';"';
      }
    }
    return $html;
  }

}