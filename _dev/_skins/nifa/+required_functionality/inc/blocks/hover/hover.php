<?php
/**
 * RMcC Hover template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Hover($context['block']);
$context['block']['fields'] = $context['block']['controls']->block_get_fields();
$context['block']['template'] = array(
  array(
    'core/paragraph',
    array(
      'content' => 'About',
      'className' => 'rmcc-text-meta rmcc-text-lead rmcc-text-uppercase rmcc-margin-small-bottom'
    ),
    array()
  ),
  array(
    'core/heading',
    array(
      'level' => 4,
      'content' => 'Who We Are & What We Do',
      'className' => 'rmcc-margin-remove rmcc-text-bold rmcc-text-capitalize rmcc-h1'
    ),
    array()
  ),
  array(
    'core/paragraph',
    array(
      'content' => 'Kilbeggan Community Group represents 24 community and voluntary groups across South Westmeath',
      'className' => 'rmcc-text-large'
    ),
    array()
  ),
  array(
    'core/paragraph',
    array(
      'content' => 'Learn more',
      'fontSize' => 'large'
    ),
    array()
  ),
);
Theme::render('hover/block.twig', $context);