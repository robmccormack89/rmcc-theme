<?php
/**
 * RMcC Jobs template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Jobs($context['block']);
$context['block']['fields'] = $context['block']['controls']->block_get_fields();
Theme::render('jobs/block.twig', $context);