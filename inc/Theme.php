<?php
namespace Rmcc;
use Timber\Timber;
use Twig\Extra\String\StringExtension;

// Define paths to Twig templates
Timber::$dirname = array(
  'views',
  'views/archive',
  'views/macros',
  'views/single',
);

// set the $autoescape value
Timber::$autoescape = false;

// Define Theme Child Class
class Theme extends Timber {
  
  public function __construct() {
    parent::__construct();
    
    // theme & twig stuff
    add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
    add_action('init', array($this, 'register_widget_areas'));
    add_action('init', array($this, 'register_navigation_menus'));
    add_action('enqueue_block_assets', array($this, 'theme_enqueue_assets')); // use 'theme_enqueue_assets' for frontend-only
    
    // adds svg support to theme
    add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    
      global $wp_version;
      if ($wp_version !== '4.7.1') {
        return $data;
      }
    
      $filetype = wp_check_filetype($filename, $mimes);
    
      return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
      ];
    
    }, 10, 4 );
    add_filter('upload_mimes', array($this, 'cc_mime_types'));
    add_action('admin_head', array($this, 'fix_svg'));
    
    global $theme_config;
    if($theme_config['theme_preloader']){
      // add custom classes to the body classes, the WP way
      add_filter('body_class', function($classes){
      	$stack = $classes;
      	array_push($stack, 'no-overflow');
      	return $stack;
      });
    }
    
    // removes sticky posts from main loop, this function fixes issue of duplicate posts on archive. see https://wordpress.stackexchange.com/questions/225015/sticky-post-from-page-2-and-on
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
  
  // svg
  public function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  public function fix_svg() {
    echo '<style type="text/css"> .attachment-266x266, .thumbnail img { width: 100%!important; height: auto!important; } </style>';
  }
  
  // theme & twig
  public function theme_supports() {
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
      'height' => 30,
      'width' => 261,
      'flex-width' => true,
      'flex-height' => true
    ));
    load_theme_textdomain('rmcc-theme', get_template_directory() . '/languages');
  }
  public function add_to_twig($twig) {
    $twig->addExtension(new \Twig_Extension_StringLoader());
    $twig->addExtension(new StringExtension());
		return $twig;
  }
  public function add_to_context($context) {
    $context['site'] = new \Timber\Site;

    // get the wp logo
    $theme_logo_id = get_theme_mod( 'custom_logo' );
    $theme_logo_url = wp_get_attachment_image_url( $theme_logo_id , 'full' );
    $context['theme_logo_src'] = $theme_logo_url;
    
    // menu register & args
    $main_menu_args = array( 'depth' => 3 );
    $context['menu_main'] = new \Timber\Menu( 'main_menu', $main_menu_args );
    $context['menu_mobile'] = new \Timber\Menu( 'mobile_menu', $main_menu_args );
    $context['has_menu_main'] = has_nav_menu( 'main_menu' );
    $context['has_menu_mobile'] = has_nav_menu( 'mobile_menu' );
    
    // acf options
    $context['options'] = get_fields('option');
    
    global $snippets;
    // some nice image ids: 1015, 1036, 1038, 1041, 1042, 1044, 1045, 1051, 1056, 1057, 1067, 1069, 1068, 1078, 1080, 1083, 10
    $context['default_theme_img_id'] = $snippets['default_theme_img_id'];
    $context['default_theme_img'] = 'https://picsum.photos/id/' . $snippets['default_theme_img_id'] . '/1920/800';
    
    global $theme_config;
    $context['theme_config'] = $theme_config;
    
    // return context
    return $context;    
  }
  public function register_post_types() {}
  public function register_taxonomies() {}
  public function register_widget_areas() {}
  public function register_navigation_menus() {
    global $snippets;
    register_nav_menus(array(
      'main_menu' => $snippets['main_menu_location_title'],
      'mobile_menu' => $snippets['mobile_menu_location_title'],
    ));
  }
  public function theme_enqueue_assets() {
    
    // google fonts
    wp_enqueue_style(
      'noto-font',
      'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap'
    );
    
    // theme base scripts  (uikit, lightgallery, fonts-awesome)
    wp_enqueue_script(
      'rmcc-theme',
      get_template_directory_uri() . '/assets/js/base.js',
      '',
      '',
      false
    );
    
    // enqueue wp jquery. inline scripts will require this
    // wp_enqueue_script('jquery');
    
    // theme base css (uikit, lightgallery, fonts-awesome)
    wp_enqueue_style(
      'rmcc-theme',
      get_template_directory_uri() . '/assets/css/base.css'
    );
    
    // theme stylesheet (theme)
    wp_enqueue_style(
      'rmcc-theme-styles', get_stylesheet_uri()
    );
    
  }

}