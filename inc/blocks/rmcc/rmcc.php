<?php
/**
 * Rmcc Block template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['fields'] = get_fields();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['extra'] = new Block($context['block']);

$template = array(
  array('core/heading', array(
    'level' => 2,
    'content' => 'Primary',
    'className' => 'rmcc-card-title',
  )),
  array( 'core/paragraph', array(
    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    'className' => 'rmcc-margin-remove',
  ))
);
$context['block']['template'] = $template;

Theme::render('rmcc.twig', $context);