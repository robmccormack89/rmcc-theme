<?php
/**
 * Twig Block template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['fields'] = get_fields();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['extra']= new Block($context['block']);

Theme::render('twig.twig', $context);