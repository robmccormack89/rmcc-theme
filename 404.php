<?php
/**
 *
 * The 404 template. as simple as it gets
 *
 * @package Rmcc_Theme
 *
 */

namespace Rmcc;

/*
Set 
The
Base
Stuff
Same
As
404
*/

// set templates variable as an array. set as base.twig to start,
// in case anything goes wrong (wp wants display some template, but our conditionals below dont cover it).
// we will modify this within conditionals below for diffrent contexts etc...
$templates = array('base.twig');

// set the context
$context = Theme::context();

// set some context vars.
// set title & desc to start, in case anything goes wrong.
// we will modify these within conditionals below for diffrent contexts etc...
$context['title'] = _x('Error: Page not found', '404/Error pages', 'rmcc-theme');
$context['description'] = _x('Sorry, there has been an error locating a resource for your query. Try finding what you want using the search form below.', '404/Error pages', 'rmcc-theme');

/*
finally
we
render
templates
and
context
*/

Theme::render($templates, $context);