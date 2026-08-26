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
$configs['redirect_to_page'] = false; // use page or post slug/ID here
$configs['maintenance_template'] = false; // template slug, defaults to maintenance.twig. only applies when redirect_to_page is unset

/*
Configs &
Settings
*/

$configs['logo_width'] = '223';
$configs['logo_height'] = '36';

/*
Enable
Disable
Stuff
*/

$configs['enable_post_tags'] = false;
$configs['enable_page_excerpts'] = false;
$configs['enable_post_comments'] = false;
$configs['enable_post_sharing'] = false;
$configs['enable_post_paging'] = false;
$configs['enable_post_author'] = false;

/*
ACF
*/

$configs['enable_acf'] = true;
$configs['hide_acf_menus'] = true;

return $configs;