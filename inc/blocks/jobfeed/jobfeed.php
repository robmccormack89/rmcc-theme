<?php
/**
 * RMcC Jobfeed template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new Jobfeed($context['block']);
Theme::render('jobfeed/block.twig', $context);