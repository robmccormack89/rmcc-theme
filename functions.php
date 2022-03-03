<?php
/**
*
* Rmcc Theme functions and definitions
*
* @package Rmcc_Theme
*
*/

/* global theme configs 

  to enable & disable various shit 

*/
$theme_config['theme_preloader'] = false;
$theme_config['theme_post_comments'] = true;
$theme_config['theme_post_share'] = true;
$theme_config['theme_post_paging'] = true;

$theme_config['acf_local_json'] = false;
$theme_config['acf_template_settings'] = false;
$theme_config['acf_options_page'] = false;
$theme_config['acf_blocks'] = false;

/* plugin activation 

  using tgm-plugin-activation

*/
require_once get_template_directory() . '/inc/lib/plugin-activation.php';

/* composer autoloader of classes 

  timber should be included in packages

*/
if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

/* require any extra files/fucntions 

  1. text strings for php (translation strings)

*/
require get_template_directory() . '/inc/extra/snippets.php';

/* init the main theme class 

  Timber should be available via composer autoload

*/
if (class_exists('Timber\Timber')) new Rmcc\Theme;

/* if ACF is available (plugin is installed), do the Theme ACF class 

  ACf should be installed via required plugins

*/
if(class_exists('ACF')) new Rmcc\Fields;