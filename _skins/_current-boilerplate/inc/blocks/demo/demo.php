<?php
/**
 * RMcC Demo template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Demo($context['block']);
Theme::render('demo/block.twig', $context);