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

/*
finally
we
render
templates
and
context
*/

Theme::render($templates, $context);