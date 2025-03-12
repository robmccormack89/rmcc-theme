<?php
/**
 * RMcC Block template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();

$context['block'] = $block;
$context['block']['fields'] = get_fields();
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Block($context['block']);
$context['block']['template'] = array(
  array(
    'core/group',
    array(
      'style' => array(
        'spacing' => array(
          'blockGap' => '20px'
        )
      ),
      'layout' => array(
        'type' => 'default'
      )
    ),
    array(
      array(
        'core/heading',
        array(
          'level' => 2,
          'content' => 'Primary',
          'className' => 'rmcc-card-title rmcc-margin-remove-bottom'
        ),
        array()
      ),
      array(
        'core/paragraph',
        array(
          'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
          'className' => 'rmcc-margin-remove-bottom'
        ),
        array()
      ),
    )
  )
);





Theme::render('block.twig', $context);