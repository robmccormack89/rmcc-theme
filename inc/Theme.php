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
use Timber\Image;
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
    if (array_key_exists('enable_post_tags', $this->configs) && $this->configs['enable_post_tags'] != true) {
      add_action('init', function () {
        global $wp_taxonomies;
        unregister_taxonomy_for_object_type('post_tag', 'post');
        unset($wp_taxonomies['post_tag']);
        unregister_taxonomy('post_tag');
      });
    }

    // meta galleries
    if($this->configs['nanogallery']){
      
      // add taxonomies to media library
      add_action('init' , function(){

        // add current taxonomies to media library
        // register_taxonomy_for_object_type('category', 'attachment');
        // register_taxonomy_for_object_type( 'post_tag', 'attachment' );

        // add custom taxonomy ('media_category') to media library post type
        $labels_media_cats = array(
          'name' => _x('Media Categories', 'Custom taxonomy label: plural', 'base-theme'),
          'singular_name' => _x('Media Category', 'Custom taxonomy label: singular', 'base-theme'),
          'search_items' => _x('Search Media Categories', 'Custom taxonomy label: search', 'base-theme'),
          'all_items' => _x('All Media Categories', 'Custom taxonomy label: all', 'base-theme'),
          'parent_item' => _x('Parent Media Category', 'Custom taxonomy label: parent', 'base-theme'),
          'parent_item_colon' => _x('Parent Media Category', 'Custom taxonomy label: parent', 'base-theme') . ':',
          'edit_item' => _x('Edit Media Category', 'Custom taxonomy label: edit', 'base-theme'),
          'update_item' => _x('Update Media Category', 'Custom taxonomy label: update', 'base-theme'),
          'add_new_item' => _x('Add New Media Category', 'Custom taxonomy label: add', 'base-theme'),
          'new_item_name' => _x('New Media Category Name', 'Custom taxonomy label: new', 'base-theme'),
          'menu_name' => _x('Media Category', 'Custom taxonomy label: menu label', 'base-theme'),
        );
        $args_media_cats = array(
          'labels' => $labels_media_cats,
          'hierarchical' => true,
          'query_var' => 'true',
          'rewrite' => 'true',
          'show_admin_column' => 'true',
        );
        register_taxonomy('media_category', 'attachment', $args_media_cats);

        $labels_media_tags = array(
          'name' => _x('Media Tags', 'Custom taxonomy label: plural', 'base-theme'),
          'singular_name' => _x('Media Tag', 'Custom taxonomy label: singular', 'base-theme'),
          'search_items' => _x('Search Media Tags', 'Custom taxonomy label: search', 'base-theme'),
          'all_items' => _x('All Media Tags', 'Custom taxonomy label: all', 'base-theme'),
          'parent_item' => _x('Parent Media Tag', 'Custom taxonomy label: parent', 'base-theme'),
          'parent_item_colon' => _x('Parent Media Tag', 'Custom taxonomy label: parent', 'base-theme') . ':',
          'edit_item' => _x('Edit Media Tag', 'Custom taxonomy label: edit', 'base-theme'),
          'update_item' => _x('Update Media Tag', 'Custom taxonomy label: update', 'base-theme'),
          'add_new_item' => _x('Add New Media Tag', 'Custom taxonomy label: add', 'base-theme'),
          'new_item_name' => _x('New Media Tag Name', 'Custom taxonomy label: new', 'base-theme'),
          'menu_name' => _x('Media Tag', 'Custom taxonomy label: menu label', 'base-theme'),
        );
        $args_media_tags = array(
          'labels' => $labels_media_tags,
          'hierarchical' => false,
          'query_var' => 'true',
          'rewrite' => 'true',
          'show_admin_column' => 'true',
        );
        register_taxonomy('media_tag', 'attachment', $args_media_tags);

      });

      // shortcoded meta galleries
      add_shortcode('nanogallery', array($this, 'nanogallery'));

    }

  }

  public function nanogallery($atts) {
    $context = Timber::context();
    $template = 'nanogallery.twig';
    $context['gallery'] = null;
  
    if(is_array($atts)){
      if(array_key_exists('cats', $atts)) {
  
        // dealing with the input string for the cats. can be one cat e.g "driveways", or comma-separated string e.g "driveways,patios"
        $terms = $atts['cats']; 
    		$sep = ',';
    		if(strpos($terms, $sep) !== false) {
    			$exploded_array = explode($sep, $terms);
    			$terms = $exploded_array;
    		}
  
        // get the gallery posts (media attachments)
    		$args = array(
    			'post_type' => 'attachment',
    			'post_mime_type' => 'image', // Only bring back attachments that are images
    			'posts_per_page' => -1, // Show us the first three results
    			'post_status' => 'inherit', // Attachments default to "inherit", rather than published. Use "inherit" or "any".
    			'tax_query' => array(
    				array(
    					'taxonomy' => 'media_category',
    					'field'    => 'slug',
    					'terms'    => $terms,
    				),
    			)
      
    		);
    		$gallery_posts = Timber::get_posts($args);
  
    		if(!empty($gallery_posts)){
          $gallery = array();
          $context['gallery'] = (object) [];
    			foreach($gallery_posts as $item){
    				$img_obj = Timber::get_post($item->id);
    				$gallery[] = $img_obj;
    			};
          $context['gallery']->images = $gallery;
    		}
  
      }
  
      // assign all the other attributes for outputs, but only when we have images for the gallery
      if($context['gallery'] && property_exists($context['gallery'], 'images')){
  
        if(array_key_exists('id', $atts)) $context['gallery']->id = $atts['id']; 
        if(array_key_exists('container', $atts)) $context['gallery']->container = $atts['container']; 
        if(array_key_exists('layout', $atts)) $context['gallery']->layout = $atts['layout']; 
  
        // nano settings
        if(array_key_exists('gallerydisplaymode', $atts)) $context['gallery']->gallerydisplaymode = $atts['gallerydisplaymode'];
        if(array_key_exists('gallerymaxrows', $atts)) $context['gallery']->gallerymaxrows = $atts['gallerymaxrows'];
        if(array_key_exists('gallerysorting', $atts)) $context['gallery']->gallerysorting = $atts['gallerysorting'];
        if(array_key_exists('gallerydisplaymorestep', $atts)) $context['gallery']->gallerydisplaymorestep = $atts['gallerydisplaymorestep'];
        if(array_key_exists('thumbnailheight', $atts)) $context['gallery']->thumbnailheight = $atts['thumbnailheight'];
        if(array_key_exists('thumbnailwidth', $atts)) $context['gallery']->thumbnailwidth = $atts['thumbnailwidth'];
        if(array_key_exists('thumbnailalignment', $atts)) $context['gallery']->thumbnailalignment = $atts['thumbnailalignment'];
        if(array_key_exists('thumbnailgutterwidth', $atts)) $context['gallery']->thumbnailgutterwidth = $atts['thumbnailgutterwidth'];
        if(array_key_exists('thumbnailgutterheight', $atts)) $context['gallery']->thumbnailgutterheight = $atts['thumbnailgutterheight'];
      }
      
    }
  
    $out = Timber::compile($template, $context);
    return $out;
  }

  /**
   *
   * theme & twig setups
   *
   */

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

    // allowed html for wp kses post
    add_action('init', function () {
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
        'fuck' => array(),
        'rmcc-accordion' => array(),
        'rmcc-icon' => array(),
        'rmcc-slider' => array(),
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
        'uk-slider-parallax' => array(),
        'data-nanogallery2' => array(),
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

    // rmcc (uikit) js
    wp_enqueue_script(
      'rmcc-theme',
      get_template_directory_uri() . '/public/js/rmcc.min.js',
      '',
      '',
      false
    );

    // theme stylesheet (style.css)
    wp_enqueue_style(
      'rmcc-theme-style',
      get_stylesheet_uri()
    );

    // nanogallery resources
    if($this->configs['nanogallery']){

      // nano galleries css
      wp_enqueue_style(
        'nanogallery',
        get_template_directory_uri() . '/public/css/nanogallery2.min.css'
      );
      
      // nano galleries js
      wp_enqueue_script(
        'nanogallery',
        get_template_directory_uri() . '/public/js/jquery.nanogallery2.min.js',
        array('jquery'),
        '3.0.5',
        true
      );

    }

  }

  public function register_post_types() {
  }
  public function register_taxonomies() {
  }
  public function register_widget_areas() {
  }

  public function register_navigation_menus() {
    register_nav_menus(array(
      'main_menu' => _x('Main Menu', 'Menus', 'rmcc-theme'),
      'iconnav_menu' => _x('Iconnav Menu', 'Menus', 'rmcc-theme'),
    ));
  }

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
    $context['menu_iconnav'] = Timber::get_menu('iconnav_menu', array('depth' => 1));

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