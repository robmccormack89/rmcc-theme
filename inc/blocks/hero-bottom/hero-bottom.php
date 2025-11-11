<?php
/**
 * RMcC Hero Bottom template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new HeroBottom($context['block']);
$context['block']['template'] = array();
Theme::render('hero-bottom/block.twig', $context);