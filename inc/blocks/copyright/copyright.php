<?php
/**
 * RMcC Copyright template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Copyright($context['block']);
Theme::render('copyright/block.twig', $context);