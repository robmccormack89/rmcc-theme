<?php
/**
 * RMcC Card Block template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['fields'] = get_fields();
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Block($context['block']);
// $template = array(
//   array('core/image', array()),
// );
$template = array(
  array('core/heading', array(
    'level' => 2,
    'content' => 'Primary',
    'className' => 'rmcc-card-title',
  )),
  array('core/paragraph', array(
    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    'className' => 'rmcc-margin-remove',
  ))
);
// $template = array(
//   array( 'core/paragraph', array(
//       'placeholder' => 'Add a root-level paragraph',
//   ) ),
//   array( 'core/columns', array(), array(
//       array( 'core/column', array(), array(
//           array( 'core/image', array() ),
//       ) ),
//       array( 'core/column', array(), array(
//           array( 'core/paragraph', array(
//               'placeholder' => 'Add a inner paragraph'
//           ) ),
//       ) ),
//   ) )
// );


$context['block']['template'] = $template;

Theme::render('card.twig', $context);