<?php
namespace Rmcc;
use Timber\Timber;

// Define paths to Twig templates
Timber::$dirname = array(
  'views',
  'views/parts',
  'views/parts/blocks',
  'views/type',
  'views/type/page',
  'views/type/page/templates',
  'views/type/post',
  'views/type/post/archive',
  'views/type/post/parts',
  'views/type/post/templates',
);

// set the $autoescape value
Timber::$autoescape = false;

// Define Rmcc_Theme Child Class
class RmccTheme extends Timber {
  public function __construct() {
    parent::__construct();
    
    // theme & twig
    add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
    add_action('init', array($this, 'register_widget_areas'));
    add_action('init', array($this, 'register_navigation_menus'));
    add_action('wp_enqueue_scripts', array($this, 'rmcc_theme_enqueue_assets'));
    add_filter('body_class', function($classes){
    	$stack = $classes;
    	array_push($stack, 'no-overflow');
    	return $stack;
    });
    
    // svg
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
    
    // custom
    // add_shortcode('contact_section', array($this, 'contact_section')); // [contact_section]
    // add_shortcode('featured_content_item_section', array($this, 'featured_content_item_section')); // [featured_content_item_section]
  }
  
  // custom
  public function contact_section() {
    $context = Timber::context();
    $out = Timber::compile('contact-section.twig', $context);
    return $out;
  }
  public function featured_content_item_section() {
    $context = Timber::context();
    $out = Timber::compile('featured-item-section.twig', $context);
    return $out;
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
    // theme supports
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
    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    ));
    // Add support for core custom logo
    add_theme_support('custom-logo', array(
      'height' => 30,
      'width' => 261,
      'flex-width' => true,
      'flex-height' => true
    ));
    // woo supports
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    
    load_theme_textdomain('rmcc-theme', get_template_directory() . '/languages');
  }
  public function add_to_twig($twig) {
    $twig->addExtension(new \Twig_Extension_StringLoader());
		return $twig;
  }
  public function add_to_context($context) {
    $context['site'] = new \Timber\Site;

    // get the wp logo
    $theme_logo_id = get_theme_mod( 'custom_logo' );
    $theme_logo_url = wp_get_attachment_image_url( $theme_logo_id , 'full' );
    $context['theme_logo_url'] = $theme_logo_url;
    
    // menu register & args
    $main_menu_args = array( 'depth' => 3 );
    $context['menu_main'] = new \Timber\Menu( 'main_menu', $main_menu_args );
    $context['menu_mobile'] = new \Timber\Menu( 'mobile_menu', $main_menu_args );
    $context['has_menu_main'] = has_nav_menu( 'main_menu' );
    $context['has_menu_mobile'] = has_nav_menu( 'mobile_menu' );
    
    // acf options
    $context['options'] = get_fields('option');
    
    $context['testimonials_count'] = wp_count_posts('testimonials')->publish;
    
    // some nice image ids: 1015, 1036, 1038, 1041, 1042, 1044, 1045, 1051, 1056, 1057, 1067, 1069, 1068, 1078, 1080, 1083, 10
    $context['default_theme_img'] = 'https://picsum.photos/id/1036/1920/800';
    $context['default_theme_img_1080'] = 'https://picsum.photos/id/1/1080/675';
    $context['default_theme_img_1920_500'] = 'https://picsum.photos/1920/500';
    $context['default_theme_img_loading'] = '/wp-content/themes/rmcc-theme/assets/images/theme/internal-doors.jpg';
    
    // return context
    return $context;    
  }
  public function register_post_types() {
    $labels_testimonials = array(
      'name'                  => 'Testimonials',
      'singular_name'         => 'Testimonial',
      'menu_name'             => 'Testimonials',
      'name_admin_bar'        => 'Testimonial',
      'archives'              => 'Testimonials',
      'attributes'            => 'Item Attributes',
      'parent_item_colon'     => 'Parent Item:',
      'all_items'             => 'All Items',
      'add_new_item'          => 'Add New Item',
      'add_new'               => 'Add New',
      'new_item'              => 'New Item',
      'edit_item'             => 'Edit Item',
      'update_item'           => 'Update Item',
      'view_item'             => 'View Item',
      'view_items'            => 'View Items',
      'search_items'          => 'Search Item',
      'not_found'             => 'Not found',
      'not_found_in_trash'    => 'Not found in Trash',
      'featured_image'        => 'Featured Image',
      'set_featured_image'    => 'Set featured image',
      'remove_featured_image' => 'Remove featured image',
      'use_featured_image'    => 'Use as featured image',
      'insert_into_item'      => 'Insert into item',
      'uploaded_to_this_item' => 'Uploaded to this item',
      'items_list'            => 'Items list',
      'items_list_navigation' => 'Items list navigation',
      'filter_items_list'     => 'Filter items list',
    );
    $args_testimonials = array(
      'label'                 => 'Testimonials',
      'description'           => 'Competition Testimonial...',
      'labels'                => $labels_testimonials,
      'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 4,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'query_var'             => false,
      'capability_type'       => 'page',
    );
    register_post_type( 'testimonials', $args_testimonials );
  }
  public function register_taxonomies() {
    // do something
  }
  public function register_widget_areas() {
    if (function_exists('register_sidebar')) {
      // do something
    }
  }
  public function register_navigation_menus() {
    // This theme uses wp_nav_menu() in one locations.
    register_nav_menus(array(
      'main_menu' => 'Main Menu',
      'mobile_menu' => 'Mobile Menu',
    ));
  }
  public function rmcc_theme_enqueue_assets() {
    
    // theme base scripts  (uikit, lightgallery, fonts-awesome)
    wp_enqueue_script(
      'rmcc-theme',
      get_template_directory_uri() . '/assets/js/base.js',
      '',
      '',
      false
    );
    
    // enqueue wp jquery. inline scripts will require this
    wp_enqueue_script('jquery');
    
    // theme base css (uikit, lightgallery, fonts-awesome)
    wp_enqueue_style(
      'rmcc-theme',
      get_template_directory_uri() . '/assets/css/base.css'
    );
    
    // theme stylesheet (theme)
    wp_enqueue_style(
      'rmcc-theme-styles', get_stylesheet_uri()
    );
    
    // swiper, everywhere
    wp_enqueue_style(
      'swiper-js',
      get_template_directory_uri() . '/assets/css/lib/swiper-bundle.min.css'
    );
    wp_enqueue_script(
      'swiper-js',
      get_template_directory_uri() . '/assets/js/lib/swiper-bundle.min.js',
      '',
      '1.0.0',
      true
    );
  }

}