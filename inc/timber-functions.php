<?php
// namespace Rmcc;
// use Timber\Site;

/**
 * Timber theme class & other functions for Twig.
 *
 * @package Cautious_Octo_Fiesta
 */

// Define paths to Twig templates
Timber::$dirname = array(
  'views',
  
  'views/parts',
  // 'views/parts/comments',
  'views/parts/header',
  'views/parts/footer',
  
  'views/type/page',
  'views/type/post',
  'views/type/product',
  'views/type/product/tease',
  
  // modified woocommerce php->twig templates (see main wooocommerce folder)
  'views/woocommerce',
);

// set the $autoescape value
Timber::$autoescape = false;

// Define Cautious_Octo_Fiesta Child Class
class CautiousOctoFiesta extends Timber\Site
{
  public function __construct() {
    // timber stuff
    add_filter('timber_context', array( $this, 'add_to_context' ));
    add_filter('get_twig', array( $this, 'add_to_twig' ));
    add_action('wp_enqueue_scripts', array( $this, 'cautious_octo_fiesta_enqueue_assets'));
    add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
    add_filter( 'timber/context', array( $this, 'add_to_context' ) );
    add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action('init', array( $this, 'register_widget_areas' ));
    add_action('init', array( $this, 'register_navigation_menus' ));
    parent::__construct();
  }

  public function register_post_types() {
    // do something
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
      'footer_menu_1' => 'Footer Menu 1',
      'footer_menu_2' => 'Footer Menu 2',
      'footer_menu_3' => 'Footer Menu 3',
      'footer_menu_4' => 'Footer Menu 4',
    ));
  }

  public function add_to_context($context) {
    // global site context
    $context['site'] = $this;
    
    // general conditionals
    $context['is_shop'] = is_shop();
    $context['is_category'] = is_category();
    $context['is_single_product'] = is_singular( 'product' );
    $context['is_product_category'] = is_product_category();

    // get the wp logo
    $theme_logo_id = get_theme_mod( 'custom_logo' );
    $theme_logo_url = wp_get_attachment_image_url( $theme_logo_id , 'full' );
    $context['theme_logo_url'] = $theme_logo_url;
    
    // menu register & args
    $main_menu_args = array( 'depth' => 3 );
    $context['menu_main'] = new Timber\Menu( 'main_menu', $main_menu_args );
    $context['menu_mobile'] = new Timber\Menu( 'mobile_menu', $main_menu_args );
    $context['has_menu_main'] = has_nav_menu( 'main_menu' );
    $context['has_menu_mobile'] = has_nav_menu( 'mobile_menu' );
    $footer_menu_args = array( 'depth' => 1 );
    $context['footer_menu_1'] = new Timber\Menu( 'footer_menu_1', $footer_menu_args );
    $context['footer_menu_2'] = new Timber\Menu( 'footer_menu_2', $footer_menu_args );
    $context['footer_menu_3'] = new Timber\Menu( 'footer_menu_3', $footer_menu_args );
    $context['footer_menu_4'] = new Timber\Menu( 'footer_menu_4', $footer_menu_args );
    $context['has_footer_menu_1'] = has_nav_menu( 'footer_menu_1' );
    $context['has_footer_menu_2'] = has_nav_menu( 'footer_menu_2' );
    $context['has_footer_menu_3'] = has_nav_menu( 'footer_menu_3' );
    $context['has_footer_menu_4'] = has_nav_menu( 'footer_menu_4' );

    // woo endpoints
    $context['dashboard_endpoint'] = wc_get_account_endpoint_url( 'dashboard' );
    $context['address_endpoint'] = wc_get_account_endpoint_url( 'edit-address' );
    $context['edit_endpoint'] = wc_get_account_endpoint_url( 'edit-account' );
    $context['payment_endpoint'] = wc_get_account_endpoint_url( 'payment-methods' );
    $context['lost_endpoint'] = wc_get_account_endpoint_url( 'lost-password' );
    $context['orders_endpoint'] = wc_get_account_endpoint_url( 'orders' );
    $context['logout_endpoint'] = wc_get_account_endpoint_url( 'customer-logout' );
    $context['shop_endpoint'] = get_permalink(woocommerce_get_page_id('shop'));
    
    // return context
    return $context;    
  }
  
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
    
    load_theme_textdomain('cautious-octo-fiesta', get_template_directory() . '/languages');
  }
  
  public function cautious_octo_fiesta_enqueue_assets() {
    // theme base scripts
    wp_enqueue_script(
      'cautious-octo-fiesta',
      get_template_directory_uri() . '/assets/js/base.js',
      '',
      '',
      false
    );
    
    // enqueue wp jquery
    wp_enqueue_script('jquery');
    
    // global (site wide) scripts; uses jquery
    wp_enqueue_script(
      'global',
      get_template_directory_uri() . '/assets/js/global.js',
      'jquery',
      '1.0.0',
      true
    );
    
    // theme base css
    wp_enqueue_style(
      'cautious-octo-fiesta',
      get_template_directory_uri() . '/assets/css/base.css'
    );
    
    // theme stylesheet
    wp_enqueue_style(
      'cautious-octo-fiesta-styles', get_stylesheet_uri()
    );
    
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

  public function add_to_twig($twig) {
    /* this is where you can add your own functions to twig */
    // $twig->addExtension(new Twig_Extension_StringLoader());
    
    // competition-related filters. see theme-functions.php
    $twig->addFilter( new Timber\Twig_Filter('days_left', 'days_left'));
    $twig->addFilter( new Timber\Twig_Filter('hours_left', 'hours_left'));
    $twig->addFilter( new Timber\Twig_Filter('time_left', 'time_left'));
    $twig->addFunction( new Timber\Twig_Function('tickets_left', 'tickets_left', array($max_tickets, $participants_count)));
    
    return $twig;
  }
}
new CautiousOctoFiesta();