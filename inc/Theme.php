<?php

/**
*
* the Theme main class
*
* @package Rmcc_Theme
*
*/

namespace Rmcc;
use Timber\Timber;
use Timber\Site;
use Twig\Extra\String\StringExtension;
use Twig\Extension\StringLoaderExtension;

// Define paths to Twig templates
Timber::$dirname = array(
  'views',
  'views/site',
);

// set the $autoescape value
Timber::$autoescape = false;

// Define Theme Child Class
class Theme extends Timber {

  public function __construct() {   
    parent::__construct();
    
    global $configs;

    // regular theme stuff. calling in the methods below into the wp activation contexts
    add_action('after_setup_theme', array($this, 'theme_supports'));
    add_filter('timber/context', array($this, 'add_to_context'));
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_action('init', array($this, 'register_post_types'));
    add_action('init', array($this, 'register_taxonomies'));
    add_action('init', array($this, 'register_widget_areas'));
    add_action('init', array($this, 'register_navigation_menus'));
    add_action('enqueue_block_assets', array($this, 'theme_enqueue_assets'));

    // Remove tags support from posts
    if($configs['disable_post_tags']){
      add_action('init', function(){
        global $wp_taxonomies;
        unregister_taxonomy_for_object_type('post_tag', 'post');
        unset($wp_taxonomies['post_tag']);
        unregister_taxonomy('post_tag');
      });
    }

  }

  /**
  *
  * theme & twig setups
  *
  */

  public function theme_supports() {

    global $configs;

    // usual theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('post-formats', array(
      'gallery',
      'quote',
      'video',
      'aside',
      'image',
      'link'
    ));
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    ));
    add_theme_support('custom-logo', array(
      'height' => $configs['logo_height'],
      'width' => $configs['logo_width'],
      'flex-width' => true,
      'flex-height' => true
    ));

    // Add excerpts to pages
    if($configs['enable_page_excerpts']) add_post_type_support('page', 'excerpt');

    // escaping on some stuff set to wpautop
    remove_filter('term_description', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('widget_text_content', 'wpautop');
    remove_filter('widget_custom_html', 'wpautop' , 10, 3 );

    // svg supports
    add_action('admin_head', 'fix_svg');
    add_filter('wp_check_filetype_and_ext', 'check_filetype', 10, 4);
    add_filter('upload_mimes', 'cc_mime_types');

    // uikit active nav items
    add_filter('nav_menu_css_class', 'rmcc_active_menu_items', 10, 2);

    // load theme's translations (to edit, use locoTranslate)
    load_textdomain('rmcc-theme', get_template_directory() . '/languages/en_GB.mo');
    
    // allow icon for yoast breads
    if(yoast_breadcrumb_enabled()) add_filter('wpseo_breadcrumb_separator', 'filter_wpseo_breadcrumb_separator', 10, 1);

    // post comments
    if(!$configs['enable_post_comments']) add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);
    if(!$configs['enable_post_comments']) add_action('admin_menu', 'disable_comments_admin_menu');
    if(!$configs['enable_post_comments']) add_action('admin_init', 'disable_comments_admin_menu_redirect');
    if(!$configs['enable_post_comments']) add_action('admin_init', 'disable_comments_dashboard');
    if(!$configs['enable_post_comments']) add_action('init', 'disable_comments_admin_bar');

    // allowed html for wp kses post
    add_action('init', function(){
      global $allowedposttags;
      $allowed_atts = array (
        'align'      => array(),
        'class'      => array(),
        'type'       => array(),
        'id'         => array(),
        'dir'        => array(),
        'lang'       => array(),
        'style'      => array(),
        'xml:lang'   => array(),
        'src'        => array(),
        'alt'        => array(),
        'href'       => array(),
        'rel'        => array(),
        'rev'        => array(),
        'target'     => array(),
        'novalidate' => array(),
        'type'       => array(),
        'value'      => array(),
        'name'       => array(),
        'tabindex'   => array(),
        'action'     => array(),
        'method'     => array(),
        'for'        => array(),
        'width'      => array(),
        'height'     => array(),
        'data'       => array(),
        'title'      => array(),
        'fuck'      => array(),
        'rmcc-accordion'      => array(),
        'rmcc-icon'      => array(),
        'rmcc-slider'      => array(),
        'rmcc-grid' => array(),
        'rmcc-form' => array(),
        'rmcc-modal' => array(),
        'rmcc-toggle' => array(),
        'hidden' => array(),
        'role' => array(),
        'aria-live' => array(),
        'aria-atomic' => array(),
        'data-status' => array(),
        'aria-required' => array(),
        'aria-invalid' => array(),
        'aria-describedby' => array(),
        'data-name' => array(),
        'size' => array(),
        'role' => array(),
        'aria-hidden' => array(),
        'focusable' => array(),
        'role' => array(),
        'viewBox' => array(),
        'fill' => array(),
        'd' => array(),
        'uk-slider-parallax'      => array(),
        'data-nanogallery2'      => array(),
      );
      $allowedposttags['form'] = $allowed_atts;
      $allowedposttags['button'] = $allowed_atts;
      $allowedposttags['cite'] = $allowed_atts;
      $allowedposttags['svg'] = $allowed_atts;
      $allowedposttags['path'] = $allowed_atts;
      $allowedposttags['label'] = $allowed_atts;
      $allowedposttags['input'] = $allowed_atts;
      $allowedposttags['textarea'] = $allowed_atts;
      $allowedposttags['iframe'] = $allowed_atts;
      $allowedposttags['script'] = $allowed_atts;
      $allowedposttags['style'] = $allowed_atts;
      $allowedposttags['strong'] = $allowed_atts;
      $allowedposttags['small'] = $allowed_atts;
      $allowedposttags['table'] = $allowed_atts;
      $allowedposttags['span'] = $allowed_atts;
      $allowedposttags['abbr'] = $allowed_atts;
      $allowedposttags['code'] = $allowed_atts;
      $allowedposttags['pre'] = $allowed_atts;
      $allowedposttags['div'] = $allowed_atts;
      $allowedposttags['img'] = $allowed_atts;
      $allowedposttags['h1'] = $allowed_atts;
      $allowedposttags['h2'] = $allowed_atts;
      $allowedposttags['h3'] = $allowed_atts;
      $allowedposttags['h4'] = $allowed_atts;
      $allowedposttags['h5'] = $allowed_atts;
      $allowedposttags['h6'] = $allowed_atts;
      $allowedposttags['ol'] = $allowed_atts;
      $allowedposttags['ul'] = $allowed_atts;
      $allowedposttags['li'] = $allowed_atts;
      $allowedposttags['em'] = $allowed_atts;
      $allowedposttags['hr'] = $allowed_atts;
      $allowedposttags['br'] = $allowed_atts;
      $allowedposttags['tr'] = $allowed_atts;
      $allowedposttags['td'] = $allowed_atts;
      $allowedposttags['p'] = $allowed_atts;
      $allowedposttags['a'] = $allowed_atts;
      $allowedposttags['b'] = $allowed_atts;
      $allowedposttags['i'] = $allowed_atts;
    }, 10);

    // Removes sticky posts from main loop. this function fixes issue of duplicate posts on archives
    //see https://wordpress.stackexchange.com/questions/225015/sticky-post-from-page-2-and-on
    add_action('pre_get_posts', function($q){
      // Only target the blog page // Only target the main query
      if ($q->is_home() && $q->is_main_query()) {

        // Remove sticky posts
        $q->set('ignore_sticky_posts', 1);

        // Get the sticky posts array
        $stickies = get_option('sticky_posts');

        // Make sure we have stickies before continuing, else, bail
        if (!$stickies) {
          return;
        }

        // Great, we have stickies, lets continue
        // Lets remove the stickies from the main query
        $q->set('post__not_in', $stickies);

        // Lets add the stickies to page one via the_posts filter
        if ($q->is_paged()) {
          return;
        }

        add_filter('the_posts', function ($posts, $q) use ($stickies) {

          // Make sure we only target the main query
          if (!$q->is_main_query()) {
            return $posts;
          }

          // Get the sticky posts
          $args = [
            'posts_per_page' => count($stickies),
            'post__in'       => $stickies
          ];
          $sticky_posts = get_posts($args);

          // Lets add the sticky posts in front of our normal posts
          $posts = array_merge($sticky_posts, $posts);

          return $posts;

        }, 10, 2);

      }
    });

  }

  public function theme_enqueue_assets() {

    // rmcc (uikit) css
    wp_enqueue_style(
      'rmcc-theme', get_template_directory_uri() . '/public/css/rmcc.min.css'
    );

    // rmcc (uikit) js
    wp_enqueue_script(
      'rmcc-theme', get_template_directory_uri() . '/public/js/rmcc.min.js', '', '', false
    );

    // theme stylesheet (style.css)
    wp_enqueue_style(
      'rmcc-theme-style', get_stylesheet_uri()
    );

  }

  public function register_post_types() {}
  public function register_taxonomies() {}
  public function register_widget_areas() {}

  public function register_navigation_menus() {
    register_nav_menus(array(
      'main_menu' => _x( 'Main Menu', 'Menus', 'rmcc-theme' ),
      'iconnav_menu' => _x( 'Iconnav Menu', 'Menus', 'rmcc-theme' ),
    ));
  }

  public function add_to_context($context) {

    global $configs;

    // globals for twig
    $context['site'] = new Site;
    $context['configs'] = $configs;

    // wp customizer logo
    $theme_logo_src = wp_get_attachment_image_url(get_theme_mod('custom_logo') , 'full');
    if($theme_logo_src){
      $context['theme']->logo = (object)[];
      $context['theme']->logo->src = $theme_logo_src;
      $context['theme']->logo->alt = '';
      $context['theme']->logo->w = $configs['logo_width'];
      $context['theme']->logo->h = $configs['logo_height'];
    }

    // add menus to the context
    $context['menu_main'] = Timber::get_menu('main_menu', array('depth' => 3));
    $context['menu_iconnav'] = Timber::get_menu('iconnav_menu', array('depth' => 1));

    // conditionals for checking menus
    $context['has_menu_main'] = has_nav_menu('main_menu');
    $context['has_menu_iconnav'] = has_nav_menu('iconnav_menu');

    // return context
    return $context;

  }
  
  public function add_to_twig($twig) {
    $twig->addExtension(new StringLoaderExtension());
    $twig->addExtension(new StringExtension());
		return $twig;
  }

}