<?php

/**
 *
 * the Theme main class
 *
 * @package Rmcc_Theme
 *
 */

 // namespace & extensions stuff
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

  public $configs;

  public function __construct() {
    parent::__construct();

    global $configs;
    $this->configs = $configs;

    add_action('after_setup_theme', array($this, 'theme_supports')); // theme supports
    add_action('enqueue_block_assets', array($this, 'theme_enqueue_assets')); // theme assets

    add_action('init', array($this, 'register_post_types')); // register post_types
    add_action('init', array($this, 'register_taxonomies')); // register taxonomies
    add_action('init', array($this, 'register_widget_areas')); // register widget_areas
    add_action('init', array($this, 'register_navigation_menus')); // register navigation_menus
    
    add_filter('timber/context', array($this, 'add_to_context')); // add stuff to theme context
    add_filter('timber/twig', array($this, 'add_to_twig')); // add twig itself

    // filter html tags & attrs allowed in wp kses post (content area)
    add_action('init', array($this, 'allowed_html_tags_attrs'), 10);

    // Remove tags support from posts
    if (array_key_exists('enable_post_tags', $this->configs) && $this->configs['enable_post_tags'] != true) {
      add_action('init', function () {
        global $wp_taxonomies;
        unregister_taxonomy_for_object_type('post_tag', 'post');
        unset($wp_taxonomies['post_tag']);
        unregister_taxonomy('post_tag');
      });
    }

    // if maintenance_mode exists in the config
    if(array_key_exists('maintenance_mode', $this->configs) && !($this->configs['maintenance_mode'] == false)){

      // maintenance_mode is set for ALL users (logged in & not)
      if(is_string($this->configs['maintenance_mode']) && $this->configs['maintenance_mode'] == 'all'){
        add_action('template_redirect', array($this, 'maintenance_mode')); // do the redirect now
      }

      // regular maintenance_mode is on (only logged out users will be affected)
      if(is_bool($this->configs['maintenance_mode']) && $this->configs['maintenance_mode'] == true){
        if(!is_user_logged_in()) add_action('template_redirect', array($this, 'maintenance_mode')); // do the redirect now, but only for non logged in users!
      }

    }

  }

  // extra features & miscellaneous functionality
  public function allowed_html_tags_attrs() {
    global $allowedposttags;
    $allowed_atts = array(
      'align' => array(),
      'class' => array(),
      'type' => array(),
      'id' => array(),
      'dir' => array(),
      'lang' => array(),
      'style' => array(),
      'xml:lang' => array(),
      'src' => array(),
      'alt' => array(),
      'href' => array(),
      'rel' => array(),
      'rev' => array(),
      'target' => array(),
      'novalidate' => array(),
      'type' => array(),
      'value' => array(),
      'name' => array(),
      'tabindex' => array(),
      'action' => array(),
      'method' => array(),
      'for' => array(),
      'width' => array(),
      'height' => array(),
      'data' => array(),
      'title' => array(),
      'hidden' => array(),
      'role' => array(),
      'aria-live' => array(),
      'aria-atomic' => array(),
      'data-status' => array(),
      'data-template' => array(),
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
      'data-nanogallery2' => array(),
      'rmcc-slider-parallax' => array(),
      'rmcc-accordion' => array(),
      'rmcc-icon' => array(),
      'rmcc-slider' => array(),
      'rmcc-slideshow' => array(),
      'rmcc-scroll' => array(),
      'rmcc-slideshow-item' => array(),
      'rmcc-slidenav-previous' => array(),
      'rmcc-slidenav-next' => array(),
      'rmcc-cover' => array(),
      'rmcc-grid' => array(),
      'rmcc-form' => array(),
      'rmcc-modal' => array(),
      'rmcc-toggle' => array(),
      'rmcc-height-viewport' => array(),
      'mjf-grid' => array(),
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
    $allowedposttags['midland-jobs-feed'] = $allowed_atts;
  }
  public function maintenance_mode() {

    // set vars for conditionals
    $redirects_exists = (array_key_exists('redirect_to_page', $this->configs));
    $redirects_is_int = ($redirects_exists && is_int($this->configs['redirect_to_page']));
    $redirects_is_string = ($redirects_exists && is_string($this->configs['redirect_to_page']));
    $redirects_is_bool = ($redirects_exists && is_bool($this->configs['redirect_to_page']));
    $redirects_is_false = ($redirects_is_bool && $this->configs['redirect_to_page'] == false);
    $redirects_is_empty = ($redirects_is_string && $this->configs['redirect_to_page'] == '');
    
    // create the OFF conditional var
    $redirects_are_off = false;
    if(!$redirects_exists){
      $redirects_are_off = true;
    } else {
      if($redirects_is_false || $redirects_is_empty){
        $redirects_are_off = true;
      }
    }

    // create the ON conditional var
    $redirects_are_on = false;
    if($redirects_exists){
      if(($redirects_is_int || $redirects_is_string) && !$redirects_is_empty){
        $redirects_are_on = true;
      }
    }
    
    // now we do the maintenance_mode stuff for when redirects are OFF (redirects to a default template or one provided seperately)
    if($redirects_are_off){
      add_filter('template_include', function(){
        if(!is_front_page()){
          wp_redirect(esc_url_raw(home_url()));
          exit;
        }
        $templates = array('maintenance.twig');
        if(array_key_exists('maintenance_template', $this->configs)) array_unshift($templates, $this->configs['maintenance_template']);
        $context = Theme::context();
        Theme::render($templates, $context);
      }, 10, 1);
    }

    // now we do the maintenance_mode stuff for when redirects are ON (redirects to a seperate page or post)
    if($redirects_are_on){

      if($redirects_is_int){
        $_postObj = get_post($this->configs['redirect_to_page']);
        if(isset($_postObj) && $_postObj->post_type == 'page') $postObj = $_postObj;
      } elseif($redirects_is_string) {
        $postObj = get_page_by_slug($this->configs['redirect_to_page']);
      }

      if(isset($postObj)){
        $link = get_permalink($postObj);
        if(!(is_page($this->configs['redirect_to_page'])) ){
          wp_redirect(esc_url_raw($link));
          exit;
        }
      }

      return;
    }

  }
  // theme supports & assets
  public function theme_supports() {

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
      'height' => $this->configs['logo_height'],
      'width' => $this->configs['logo_width'],
      'flex-width' => true,
      'flex-height' => true
    ));

    // Add excerpts to pages
    if ($this->configs['enable_page_excerpts']) add_post_type_support('page', 'excerpt');

    // escaping on some stuff set to wpautop
    remove_filter('term_description', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('widget_text_content', 'wpautop');
    remove_filter('widget_custom_html', 'wpautop', 10, 3);

    // svg supports
    add_action('admin_head', 'fix_svg');
    add_filter('wp_check_filetype_and_ext', 'check_filetype', 10, 4);
    add_filter('upload_mimes', 'cc_mime_types');

    // uikit active nav items
    add_filter('nav_menu_css_class', 'rmcc_active_menu_items', 10, 2);

    // load theme's translations (to edit, use locoTranslate)
    load_textdomain('rmcc-theme', get_template_directory() . '/languages/en_GB.mo');

    // allow icon for yoast breads
    if (yoast_breadcrumb_enabled()) add_filter('wpseo_breadcrumb_separator', 'filter_wpseo_breadcrumb_separator', 10, 1);

    // post comments
    if (!$this->configs['enable_post_comments']) add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);
    if (!$this->configs['enable_post_comments']) add_action('admin_menu', 'disable_comments_admin_menu');
    if (!$this->configs['enable_post_comments']) add_action('admin_init', 'disable_comments_admin_menu_redirect');
    if (!$this->configs['enable_post_comments']) add_action('admin_init', 'disable_comments_dashboard');
    if (!$this->configs['enable_post_comments']) add_action('init', 'disable_comments_admin_bar');

    // Removes sticky posts from main loop. this function fixes issue of duplicate posts on archives
    //see https://wordpress.stackexchange.com/questions/225015/sticky-post-from-page-2-and-on
    add_action('pre_get_posts', function ($q) {
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
            'post__in' => $stickies
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
      'rmcc-theme',
      get_template_directory_uri() . '/public/css/rmcc.min.css'
    );

    wp_enqueue_style(
      'kcg',
      get_template_directory_uri() . '/public/css/kcg.css'
    );

    // rmcc (uikit) js
    wp_enqueue_script(
      'rmcc-theme',
      get_template_directory_uri() . '/public/js/rmcc.min.js',
      '',
      '',
      false
    );

    // rmcc icons (uikit) js
    wp_enqueue_script(
      'rmcc-theme-icons',
      get_template_directory_uri() . '/public/js/rmcc-icons.min.js',
      '',
      '',
      false
    );

    // theme stylesheet (style.css)
    wp_enqueue_style(
      'rmcc-theme-style',
      get_stylesheet_uri()
    );

    // feed
    // wp_enqueue_style(
    //   'mjf-feed',
    //   get_template_directory_uri() . '/public/feed/css/mjf.min.css'
    // );

  }
  // register the wp stuff (post_types, taxonomies, widget_areas & navigation_menus)
  public function register_post_types() {
  }
  public function register_taxonomies() {
  }
  public function register_widget_areas() {
  }
  public function register_navigation_menus() {
    register_nav_menus(array(
      'main_menu' => _x('Main Menu', 'Menus', 'rmcc-theme'),
      'secondary_menu' => _x('Secondary Menu', 'Menus', 'rmcc-theme'),
      'socials_menu' => _x('Socials Menu', 'Menus', 'rmcc-theme'),
      'company_menu' => _x('Company Menu', 'Menus', 'rmcc-theme'),
      'footer_menu_1' => _x('Footer Menu 1', 'Menus', 'rmcc-theme'),
      'footer_menu_2' => _x('Footer Menu 2', 'Menus', 'rmcc-theme'),
      'footer_menu_3' => _x('Footer Menu 3', 'Menus', 'rmcc-theme'),
      'footer_menu_4' => _x('Footer Menu 4', 'Menus', 'rmcc-theme'),
      'buttons_menu' => _x('Buttons Menu', 'Menus', 'rmcc-theme'),
    ));
  }
  // add stuff to the context & to twig itself
  public function add_to_context($context) {

    // globals for twig
    $context['site'] = new Site;
    $context['configs'] = $this->configs;

    // wp customizer logo
    $theme_logo_src = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
    if ($theme_logo_src) {
      $context['theme']->logo = (object) [];
      $context['theme']->logo->src = $theme_logo_src;
      $context['theme']->logo->alt = '';
      $context['theme']->logo->w = $this->configs['logo_width'];
      $context['theme']->logo->h = $this->configs['logo_height'];
    }

    // theme default featured image
    $context['theme']->featured_img = (object) [];
    $context['theme']->featured_img->src = _x( 'https://picsum.photos/1920/1200', 'Theme Featured Image - src', 'rmcc-theme' );
    $context['theme']->featured_img->alt = _x( 'Alt', 'Theme Featured Image - alt', 'rmcc-theme' );
    $context['theme']->featured_img->caption = _x( 'Caption', 'Theme Featured Image - caption', 'rmcc-theme' );

    // add menus to the context
    $context['menu_main'] = Timber::get_menu('main_menu', array('depth' => 3));
    $context['menu_secondary'] = Timber::get_menu('secondary_menu', array('depth' => 1));
    $context['menu_socials'] = Timber::get_menu('socials_menu', array('depth' => 1));
    $context['menu_company'] = Timber::get_menu('company_menu', array('depth' => 1));
    $context['menu_footer_1'] = Timber::get_menu('footer_menu_1', array('depth' => 1));
    $context['menu_footer_2'] = Timber::get_menu('footer_menu_2', array('depth' => 1));
    $context['menu_footer_3'] = Timber::get_menu('footer_menu_3', array('depth' => 1));
    $context['menu_footer_4'] = Timber::get_menu('footer_menu_4', array('depth' => 1));
    $context['menu_buttons'] = Timber::get_menu('buttons_menu', array('depth' => 1));

    // set title & desc to start, in case anything goes wrong.
    $context['title'] = _x('Error: Page not found', '404/Error pages', 'rmcc-theme');
    $context['description'] = _x('Sorry, there has been an error locating a resource for your query. Try finding what you want using the search form below.', '404/Error pages', 'rmcc-theme');

    // return the context
    return $context;

  }
  public function add_to_twig($twig) {
    $twig->addExtension(new StringLoaderExtension());
    $twig->addExtension(new StringExtension());
    return $twig;
  }

}