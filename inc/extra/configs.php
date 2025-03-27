<?php

/**
*
* Global theme configs to enable & disable various shit
*
* @package Rmcc_Theme
*
*/

/*
Maintenance
Mode
*/

$configs['maintenance_mode'] = false; // set to true (for logged-out users) or 'all' (for all users)
// $configs['redirect_to_page'] = 'sample-page'; // use page or post slug/ID here
// $configs['maintenance_template'] = 'hello.twig'; // only applies when redirect_to_page is unset. defaults to maintenance.twig

/*
darklight
mode
*/

$configs['darklight_mode'] = true;

/*
Configs &
Settings
*/

$configs['logo_width'] = '80';
$configs['logo_height'] = '80';

/*
Enable
Disable
Stuff
*/

$configs['enable_post_tags'] = true;
$configs['enable_page_excerpts'] = true;
$configs['enable_post_comments'] = true;
$configs['enable_post_sharing'] = true;
$configs['enable_post_paging'] = true;
$configs['enable_post_author'] = true;

/*
ACF
Stuff
*/

$configs['enable_acf'] = true;
$configs['hide_acf_menus'] = true;

return $configs;