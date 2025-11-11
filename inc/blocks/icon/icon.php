<?php
/**
 * RMcC Icon template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Icon($context['block']);
Theme::render('icon/block.twig', $context);