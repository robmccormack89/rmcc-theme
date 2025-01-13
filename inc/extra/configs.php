<?php

/**
*
* Global theme configs to enable & disable various shit
*
* @package Rmcc_Theme
*
*/

/*
Maintenance Mode
Stuff
*/

$configs['maintenance_mode'] = 'all';
// $configs['redirect_all_traffic_to_page'] = 2;
// $configs['maintenance_template'] = 'coming_soon.twig'; // only applies when redirect_all_traffic_to_page doesnt exist or is set to false. defaults to maintenance.twig downstream

/*
Logo
Stuff
*/

$configs['logo_width'] = '223';//
$configs['logo_height'] = '36';//

/*
Disable
Stuff
*/

$configs['disable_post_tags'] = false;//

/*
Singular
Stuff
*/

$configs['enable_page_excerpts'] = true;//
$configs['enable_post_comments'] = true;//
$configs['enable_post_sharing'] = true;//
$configs['enable_post_paging'] = true;//
$configs['enable_post_author'] = true;//

return $configs;
