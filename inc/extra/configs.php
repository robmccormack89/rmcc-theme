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

$configs['maintenance_mode'] = true; // set to true (for logged-out users) or 'all' (for all users)
// $configs['redirect_all_traffic_to_page'] = 2; // use page or post ID here. or slug?
// $configs['maintenance_template'] = 'hello.twig'; // only applies when redirect_all_traffic_to_page is unset. default: maintenance.twig

/*
Configs &
Settings
*/

$configs['logo_width'] = '270';
$configs['logo_height'] = '90';

/*
Enable
Disable
Stuff
*/

$configs['enable_post_tags'] = true;
$configs['enable_page_excerpts'] = false;
$configs['enable_post_comments'] = false;
$configs['enable_post_sharing'] = false;
$configs['enable_post_paging'] = false;
$configs['enable_post_author'] = false;

/*
ACF
Stuff
*/

$configs['enable_acf'] = true;
$configs['hide_acf_menus'] = true;


return $configs;