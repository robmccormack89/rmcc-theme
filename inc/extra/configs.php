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

// $configs['maintenance_mode'] = 'all';
// $configs['redirect_all_traffic_to_page'] = 2;
// $configs['maintenance_template'] = 'coming_soon.twig'; // only applies when redirect_all_traffic_to_page doesnt exist or is set to false. defaults to maintenance.twig downstream

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

/*
Meta Gallerys
nanogallery
Stuff
*/

// $configs['meta_galleries'] = false;

/*
ACF Fields
Stuff
*/

// $configs['acf_local_json'] = false;
// $configs['acf_blocks'] = false;
// $configs['acf_template_settings'] = false;
// $configs['acf_options_page'] = false;

/*
Default
Stuff
*/

// $configs['theme_defaults'] = (object) [
//   "thumbnail" => [
//     "src" => _x( 'https://picsum.photos/1920/1200', 'Theme Featured Image - src', 'rmcc-theme' ),
//     "alt" => _x( 'Alt', 'Theme Featured Image - alt', 'rmcc-theme' ),
//     "caption" => _x( 'Caption', 'Theme Featured Image - caption', 'rmcc-theme' )
//   ]
// ];

/*
Logo
Stuff
*/

$configs['logo_width'] = '223';
$configs['logo_height'] = '36';

return $configs;
