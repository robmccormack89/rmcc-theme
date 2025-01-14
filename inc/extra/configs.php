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

// $configs['maintenance_mode'] = 'all'; // set to true (for logged-out users) or 'all' (for all users)
// $configs['redirect_all_traffic_to_page'] = 2; // use page or post ID here. or slug?
// $configs['maintenance_template'] = 'hello.twig'; // only applies when redirect_all_traffic_to_page is unset. default: maintenance.twig

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

$configs['enable_post_tags'] = true;
$configs['enable_page_excerpts'] = true;
$configs['enable_post_comments'] = true;
$configs['enable_post_sharing'] = true;
$configs['enable_post_paging'] = true;
$configs['enable_post_author'] = true;

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

return $configs;