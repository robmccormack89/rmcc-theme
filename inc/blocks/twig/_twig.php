<?php
/**
 * Twig Block template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['fields'] = get_fields();
$context['is_preview'] = $is_preview;
$context['block'] = $block;
$context['_block'] = [];

$context['fields'] = false;

$context['__block'] = new Block($block);

/*
fullheight
fullheight_class
fullheight_img_class

block.full_height is boolean
*/
if(array_key_exists('full_height', $block)){
  $context['_block']['fullheight'] = $block['full_height'];
  $context['_block']['fullheight_class'] = ($context['_block']['fullheight']) ? 'rmcc-height-viewport': '';
  $context['_block']['fullheight_img_class'] = $context['_block']['fullheight'] ? 'cover-img home-cover-img' : 'cover-img';
}

/*
align_break
align_container
align_style
*/
if(array_key_exists('align', $block)){
  if(!$is_preview){

    // align_break
    $context['_block']['align_break'] = ($block['align'] == 'wide' || $block['align'] == 'full') ? 'rmcc-container-break' : '';
  
    // align_container
    $context['_block']['align_container'] = '';
    if($block['align'] == 'left' || $block['align'] == 'center' || $block['align'] == 'right') $context['_block']['align_container'] = 'rmcc-container rmcc-container-small';
    if($block['align'] == 'full') $context['_block']['align_container'] = 'rmcc-container rmcc-container-expand rmcc-padding-remove-horizontal';
    if($block['align'] == 'wide') $context['_block']['align_container'] = 'rmcc-container rmcc-container-xlarge';
  
    // align_style
    $context['_block']['align_style'] = '';
    if($block['align'] == 'right') $context['_block']['align_style'] = 'style="padding-right:0;margin-right:0;"';
    if($block['align'] == 'left') $context['_block']['align_style'] = 'style="padding-left:0;margin-left:0;"';
  
  }
}

/*
align_text

can be 'left', 'center' or 'right'; best use would be with rmcc-text/rmcc-flex
*/
if(array_key_exists('align_text', $block)) $context['_block']['align_text'] = $block['align_text'];

/*
align_content
align_content_pos

align_content can be false, default or 'matrix'
for non-matrix (default) we set align_content, can be top, center & bottom
for matrix, we set align_content_pos with rmcc-position
*/
if(array_key_exists('align_content', $block)){

  $context['_block']['align_content'] = '';
  $context['_block']['align_content_pos'] = '';

  // non-matrix
  $context['_block']['align'] = ($block['align_content'] == 'center') ? 'middle' : $block['align_content'];
  if($block['align_content'] == 'center' || $block['align_content'] == 'top' || $block['align_content'] == 'bottom') $context['_block']['align_content'] = 'rmcc-flex rmcc-flex-' . $align;

  // matrix: top
  if($block['align_content'] == 'top right') $context['_block']['align_content_pos'] = 'rmcc-position-top-right';
  if($block['align_content'] == 'top center') $context['_block']['align_content_pos'] = 'rmcc-position-top-center';
  if($block['align_content'] == 'top left') $context['_block']['align_content_pos'] = 'rmcc-position-top-left';

  // matrix: center
  if($block['align_content'] == 'center right') $context['_block']['align_content_pos'] = 'rmcc-position-center-right';
  if($block['align_content'] == 'center center') $context['_block']['align_content_pos'] = 'rmcc-position-center';
  if($block['align_content'] == 'center left') $context['_block']['align_content_pos'] = 'rmcc-position-center-left';

  // matrix: bottom
  if($block['align_content'] == 'bottom right') $context['_block']['align_content_pos'] = 'rmcc-position-bottom-right';
  if($block['align_content'] == 'bottom center') $context['_block']['align_content_pos'] = 'rmcc-position-bottom-center';
  if($block['align_content'] == 'bottom left') $context['_block']['align_content_pos'] = 'rmcc-position-bottom-left';
  
}

/*
fields

common ACF fields that (may) be added to blocks
*/
if($context['fields']){

  // content fields: text, textarea, url, image or gallery
  $heading = $fields['heading'];
  $message = $fields['msg'];
  $bottom_msg = $fields['bottom_msg'];
  $top_msg = $fields['top_msg'];
  $button_text = $fields['btn_txt'];
  $button_url = $fields['btn_url'];
  $embed_url = $fields['embed_url'];
  $block_img = ($fields['img']) ? get_image($fields['img']) : null;
  $gallery = $fields['gallery'];
  $icon_html = $fields['icon_html'];
  $rating = $fields['rating'];

  // layout/design: fields for adding css classes
  $custom_classes = $fields['block_custom_classes'];
  $button_classes = $fields['btn_classes'];
  $flex_first_class = ($fields['layout'] == 'right') ? 'rmcc-flex-first' : '';

  // layout/design: fields for changing design colour
  $bg_colour = $fields['bg_colour'];
  $light_mode_class = ($fields['light_mode'] == 'enabled') ? 'rmcc-light' : 'rmcc-dark';
  $overlay_class = ($fields['overlay'] == 'dark') ? 'rmcc-overlay rmcc-overlay-primary' : 'rmcc-overlay rmcc-overlay-default';

}

Theme::render('blocks/twig.twig', $context);