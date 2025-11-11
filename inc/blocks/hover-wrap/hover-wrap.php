<?php
/**
 * RMcC Hover Wrap template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new HoverWrap($context['block']);
$context['block']['template'] = array();
Theme::render('hover-wrap/block.twig', $context);