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
Global
Stuff
*/

$configs['animated_preloader'] = true;//

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
Archives
Stuff
*/

$configs['infinite_pagination'] = true;//

/*
Blog Filters
Stuff
*/

$configs['blog_filters'] = true;
$configs['blog_filters_properties'] = (object) [
  "types" => array(
    (object) [
      "parentGroupId" => 'post_cat_group',
      "subGroupId" => 'post_subcat_group',
      "subId" => 'post_cat_sub',
      "formQueryKey" => 'category_name',
      "taxKey" => 'category',
      "altQueryKey" => 'cat',
      "currentQueryVar" => ''
    ],
    (object) [
      "formQueryKey" => 'tag',
      "taxKey" => 'post_tag',
      "altQueryKey" => 'tag_id',
      "currentQueryVar" => ''
    ]
  )
];
// $configs['blog_filters'] = false; // disable

/*
Live Search
Stuff
*/

$configs['live_search'] = true;
$configs['live_search_types'] = array('post', 'page');
$configs['live_search_taxes'] = array('category', 'post_tag');
$configs['live_search_types_in_taxes'] = array('post');

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
