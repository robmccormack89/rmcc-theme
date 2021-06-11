<?php
/**
 * Timber theme class & other functions for Twig.
 *
 * @package Cautious_Octo_Fiesta
 */

// Define paths to Twig templates
Timber::$dirname = array(
  'views',
  'views/parts',
  'views/parts/tease',
  'views/parts/comments',
  'views/woo',
  'views/wp',
  'views/wp/archive',
  'views/wp/single',
);

// set the $autoescape value
Timber::$autoescape = false;

// Define Cautious_Octo_Fiesta Child Class
class CautiousOctoFiesta extends Timber\Site
{
  public function __construct()
  {
    // timber stuff
    add_filter('timber_context', array( $this, 'add_to_context' ));
    add_filter('get_twig', array( $this, 'add_to_twig' ));
    add_filter( 'pre_get_posts', array($this, 'add_custom_types_to_tax') );
    add_action('after_setup_theme', array( $this, 'theme_supports' ));
    add_action('wp_enqueue_scripts', array( $this, 'cautious_octo_fiesta_enqueue_assets'));
    // add_action('widgets_init', array( $this, 'cautious_octo_fiesta_custom_uikit_widgets_init'));
    add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
    add_filter( 'timber/context', array( $this, 'add_to_context' ) );
    add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
    // add_filter( 'query_vars', array( $this, 'cautious_octo_fiesta_gridlist_query_vars_filter'));
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action('init', array( $this, 'register_widget_areas' ));
    add_action('init', array( $this, 'register_navigation_menus' ));
    parent::__construct();
  }
  
  // this makes custom taxonomy (status) work with archive.php->archive.twig templates with pre_get_post filter added to class construct above
  public function add_custom_types_to_tax( $query )
  {
    // if( is_category() || is_tax('status') || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
    //   // Get all your post types
    //   $post_types = get_post_types();
    //   $query->set( 'post_type', $post_types );
    //   return $query;
    // }
  }

  public function register_post_types()
  {
    $labels_winners = array(
      'name'                  => _x( 'Competition Winners', 'Post Type General Name', 'cautious-octo-fiesta' ),
  		'singular_name'         => _x( 'Competition Winner', 'Post Type Singular Name', 'cautious-octo-fiesta' ),
  		'menu_name'             => __( 'Competition Winners', 'cautious-octo-fiesta' ),
  		'name_admin_bar'        => __( 'Competition Winner', 'cautious-octo-fiesta' ),
  		'archives'              => __( 'Competition Winners', 'cautious-octo-fiesta' ),
  		'attributes'            => __( 'Winner Attributes', 'cautious-octo-fiesta' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'cautious-octo-fiesta' ),
  		'all_items'             => __( 'All Winners', 'cautious-octo-fiesta' ),
  		'add_new_item'          => __( 'Add New Winner', 'cautious-octo-fiesta' ),
  		'add_new'               => __( 'Add New', 'cautious-octo-fiesta' ),
  		'new_item'              => __( 'New Item', 'cautious-octo-fiesta' ),
  		'edit_item'             => __( 'Edit Item', 'cautious-octo-fiesta' ),
  		'update_item'           => __( 'Update Item', 'cautious-octo-fiesta' ),
  		'view_item'             => __( 'View Item', 'cautious-octo-fiesta' ),
  		'view_items'            => __( 'View Items', 'cautious-octo-fiesta' ),
  		'search_items'          => __( 'Search Item', 'cautious-octo-fiesta' ),
  		'not_found'             => __( 'Not found', 'cautious-octo-fiesta' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'cautious-octo-fiesta' ),
  		'featured_image'        => __( 'Featured Image', 'cautious-octo-fiesta' ),
  		'set_featured_image'    => __( 'Set featured image', 'cautious-octo-fiesta' ),
  		'remove_featured_image' => __( 'Remove featured image', 'cautious-octo-fiesta' ),
  		'use_featured_image'    => __( 'Use as featured image', 'cautious-octo-fiesta' ),
  		'insert_into_item'      => __( 'Insert into item', 'cautious-octo-fiesta' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'cautious-octo-fiesta' ),
  		'items_list'            => __( 'Items list', 'cautious-octo-fiesta' ),
  		'items_list_navigation' => __( 'Items list navigation', 'cautious-octo-fiesta' ),
  		'filter_items_list'     => __( 'Filter items list', 'cautious-octo-fiesta' ),
    );
  	$args_winners = array(
  		'label'                 => __( 'Winner', 'cautious-octo-fiesta' ),
  		'description'           => __( 'Winners content type', 'cautious-octo-fiesta' ),
  		'labels'                => $labels_winners,
  		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 3,
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => true,
  		'can_export'            => true,
  		'has_archive'           => 'competition-winners',
  		'exclude_from_search'   => true,
  		'publicly_queryable'    => true,
  		'query_var'             => false,
  		'capability_type'       => 'page',
  		'show_in_rest'          => false,
  	);
  	register_post_type( 'winners', $args_winners );

  	$labels_lists = array(
  		'name'                  => _x( 'Entry Lists', 'Post Type General Name', 'cautious-octo-fiesta' ),
  		'singular_name'         => _x( 'Entry List', 'Post Type Singular Name', 'cautious-octo-fiesta' ),
  		'menu_name'             => __( 'Entry Lists', 'cautious-octo-fiesta' ),
  		'name_admin_bar'        => __( 'Entry List', 'cautious-octo-fiesta' ),
  		'archives'              => __( 'Entry Lists', 'cautious-octo-fiesta' ),
  		'attributes'            => __( 'Entry List Attributes', 'cautious-octo-fiesta' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'cautious-octo-fiesta' ),
  		'all_items'             => __( 'All Entry Lists', 'cautious-octo-fiesta' ),
  		'add_new_item'          => __( 'Add New Item', 'cautious-octo-fiesta' ),
  		'add_new'               => __( 'Add New', 'cautious-octo-fiesta' ),
  		'new_item'              => __( 'New Item', 'cautious-octo-fiesta' ),
  		'edit_item'             => __( 'Edit Item', 'cautious-octo-fiesta' ),
  		'update_item'           => __( 'Update Item', 'cautious-octo-fiesta' ),
  		'view_item'             => __( 'View Item', 'cautious-octo-fiesta' ),
  		'view_items'            => __( 'View Items', 'cautious-octo-fiesta' ),
  		'search_items'          => __( 'Search Item', 'cautious-octo-fiesta' ),
  		'not_found'             => __( 'Not found', 'cautious-octo-fiesta' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'cautious-octo-fiesta' ),
  		'featured_image'        => __( 'Featured Image', 'cautious-octo-fiesta' ),
  		'set_featured_image'    => __( 'Set featured image', 'cautious-octo-fiesta' ),
  		'remove_featured_image' => __( 'Remove featured image', 'cautious-octo-fiesta' ),
  		'use_featured_image'    => __( 'Use as featured image', 'cautious-octo-fiesta' ),
  		'insert_into_item'      => __( 'Insert into item', 'cautious-octo-fiesta' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'cautious-octo-fiesta' ),
  		'items_list'            => __( 'Items list', 'cautious-octo-fiesta' ),
  		'items_list_navigation' => __( 'Items list navigation', 'cautious-octo-fiesta' ),
  		'filter_items_list'     => __( 'Filter items list', 'cautious-octo-fiesta' ),
  	);
  	$args_lists = array(
  		'label'                 => __( 'Entry List', 'cautious-octo-fiesta' ),
  		'description'           => __( 'Entry List Description', 'cautious-octo-fiesta' ),
  		'labels'                => $labels_lists,
  		'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields', 'page-attributes' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 4,
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => true,
  		'can_export'            => true,
  		'has_archive'           => 'entry-lists',
  		'exclude_from_search'   => true,
  		'publicly_queryable'    => true,
      'query_var'             => false,
    
  		'capability_type'       => 'page',
  	);
  	register_post_type( 'entry_lists', $args_lists );
      
  	// $labels_draws = array(
  	// 	'name'                  => _x( 'Competition Draws', 'Post Type General Name', 'cautious-octo-fiesta' ),
  	// 	'singular_name'         => _x( 'Competition Draw', 'Post Type Singular Name', 'cautious-octo-fiesta' ),
  	// 	'menu_name'             => __( 'Competition Draws', 'cautious-octo-fiesta' ),
  	// 	'name_admin_bar'        => __( 'Competition Draw', 'cautious-octo-fiesta' ),
  	// 	'archives'              => __( 'Competition Draws', 'cautious-octo-fiesta' ),
  	// 	'attributes'            => __( 'Competition Draw Attributes', 'cautious-octo-fiesta' ),
  	// 	'parent_item_colon'     => __( 'Parent Item:', 'cautious-octo-fiesta' ),
  	// 	'all_items'             => __( 'All Live Draws', 'cautious-octo-fiesta' ),
  	// 	'add_new_item'          => __( 'Add New Item', 'cautious-octo-fiesta' ),
  	// 	'add_new'               => __( 'Add New', 'cautious-octo-fiesta' ),
  	// 	'new_item'              => __( 'New Item', 'cautious-octo-fiesta' ),
  	// 	'edit_item'             => __( 'Edit Item', 'cautious-octo-fiesta' ),
  	// 	'update_item'           => __( 'Update Item', 'cautious-octo-fiesta' ),
  	// 	'view_item'             => __( 'View Item', 'cautious-octo-fiesta' ),
  	// 	'view_items'            => __( 'View Items', 'cautious-octo-fiesta' ),
  	// 	'search_items'          => __( 'Search Item', 'cautious-octo-fiesta' ),
  	// 	'not_found'             => __( 'Not found', 'cautious-octo-fiesta' ),
  	// 	'not_found_in_trash'    => __( 'Not found in Trash', 'cautious-octo-fiesta' ),
  	// 	'featured_image'        => __( 'Featured Image', 'cautious-octo-fiesta' ),
  	// 	'set_featured_image'    => __( 'Set featured image', 'cautious-octo-fiesta' ),
  	// 	'remove_featured_image' => __( 'Remove featured image', 'cautious-octo-fiesta' ),
  	// 	'use_featured_image'    => __( 'Use as featured image', 'cautious-octo-fiesta' ),
  	// 	'insert_into_item'      => __( 'Insert into item', 'cautious-octo-fiesta' ),
  	// 	'uploaded_to_this_item' => __( 'Uploaded to this item', 'cautious-octo-fiesta' ),
  	// 	'items_list'            => __( 'Items list', 'cautious-octo-fiesta' ),
  	// 	'items_list_navigation' => __( 'Items list navigation', 'cautious-octo-fiesta' ),
  	// 	'filter_items_list'     => __( 'Filter items list', 'cautious-octo-fiesta' ),
  	// );
  	// $args_draws = array(
  	// 	'label'                 => __( 'Competition Draw', 'cautious-octo-fiesta' ),
  	// 	'description'           => __( 'Competition Draws Description', 'cautious-octo-fiesta' ),
  	// 	'labels'                => $labels_draws,
  	// 	'supports'              => array( 'title', 'editor', 'custom-fields' ),
  	// 	'hierarchical'          => false,
  	// 	'public'                => true,
  	// 	'show_ui'               => true,
  	// 	'show_in_menu'          => true,
  	// 	'menu_position'         => 5,
  	// 	'show_in_admin_bar'     => true,
  	// 	'show_in_nav_menus'     => true,
  	// 	'can_export'            => true,
  	// 	'has_archive'           => 'competition-draws',
  	// 	'exclude_from_search'   => true,
    //   'publicly_queryable'    => true,
    //   'query_var'             => true,
  	// 	'capability_type'       => 'page',
  	// );
  	// register_post_type( 'live_draws', $args_draws );
  }

  public function register_taxonomies()
  {
    // $labels_status = array(
    //   'name'                       => _x( 'Draw Status', 'Taxonomy General Name', 'cautious-octo-fiesta' ),
    //   'singular_name'              => _x( 'Draw Status', 'Taxonomy Singular Name', 'cautious-octo-fiesta' ),
    //   'menu_name'                  => __( 'Draw Status', 'cautious-octo-fiesta' ),
    //   'all_items'                  => __( 'All Items', 'cautious-octo-fiesta' ),
    //   'parent_item'                => __( 'Parent Item', 'cautious-octo-fiesta' ),
    //   'parent_item_colon'          => __( 'Parent Item:', 'cautious-octo-fiesta' ),
    //   'new_item_name'              => __( 'New Item Name', 'cautious-octo-fiesta' ),
    //   'add_new_item'               => __( 'Add New Item', 'cautious-octo-fiesta' ),
    //   'edit_item'                  => __( 'Edit Item', 'cautious-octo-fiesta' ),
    //   'update_item'                => __( 'Update Item', 'cautious-octo-fiesta' ),
    //   'view_item'                  => __( 'View Item', 'cautious-octo-fiesta' ),
    //   'separate_items_with_commas' => __( 'Separate items with commas', 'cautious-octo-fiesta' ),
    //   'add_or_remove_items'        => __( 'Add or remove items', 'cautious-octo-fiesta' ),
    //   'choose_from_most_used'      => __( 'Choose from the most used', 'cautious-octo-fiesta' ),
    //   'popular_items'              => __( 'Popular Items', 'cautious-octo-fiesta' ),
    //   'search_items'               => __( 'Search Items', 'cautious-octo-fiesta' ),
    //   'not_found'                  => __( 'Not Found', 'cautious-octo-fiesta' ),
    //   'no_terms'                   => __( 'No items', 'cautious-octo-fiesta' ),
    //   'items_list'                 => __( 'Items list', 'cautious-octo-fiesta' ),
    //   'items_list_navigation'      => __( 'Items list navigation', 'cautious-octo-fiesta' ),
    // );
    // $rewrite_status = array(
    //   'slug'                       => 'competition-draws/status',
  	// 	'with_front'                 => true,
  	// 	'hierarchical'               => false,
    // );
  	// $args_status = array(
  	// 	'labels'                     => $labels_status,
  	// 	'hierarchical'               => true,
  	// 	'public'                     => true,
  	// 	'show_ui'                    => true,
  	// 	'show_admin_column'          => true,
  	// 	'show_in_nav_menus'          => true,
  	// 	'show_tagcloud'              => false,
  	// 	'rewrite'                    => $rewrite_status,
  	// );
  	// register_taxonomy( 'status', array( 'live_draws' ), $args_status );
  }

  public function register_widget_areas()
  {
    if (function_exists('register_sidebar')) {
      // register a sidebar
    }
  }

  public function register_navigation_menus()
  {
    // This theme uses wp_nav_menu() in one locations.
    register_nav_menus(array(
      'main_menu' => __( 'Main Menu', 'cautious-octo-fiesta' ),
      'mobile_menu' => __( 'Mobile Menu', 'cautious-octo-fiesta' ),
      'footer_menu_1' => __( 'Footer Menu 1', 'cautious-octo-fiesta' ),
      'footer_menu_2' => __( 'Footer Menu 2', 'cautious-octo-fiesta' ),
      'footer_menu_3' => __( 'Footer Menu 3', 'cautious-octo-fiesta' ),
      'footer_menu_4' => __( 'Footer Menu 4', 'cautious-octo-fiesta' ),
    ));
  }

  public function add_to_context( $context )
  {
    // global site context
    $context['site'] = $this;
    // general conditionals
    $context['is_shop'] = is_shop();
    $context['is_category'] = is_category();
    $context['is_single_product'] = is_singular( 'product' );
    $context['is_product_category'] = is_product_category();
    // check if is status page
    // $context['is_status'] = is_tax('status');
    /* check is post types */
    $context['is_posts'] = is_blog();
    $context['is_winners'] = is_post_type_archive( 'winners' );
    $context['is_entry_lists'] = is_post_type_archive( 'entry_lists' );
    // $context['is_live_draws'] = is_post_type_archive( 'live_draws' );
    // get the wp logo
    $theme_logo_id = get_theme_mod( 'custom_logo' );
    $theme_logo_url = wp_get_attachment_image_url( $theme_logo_id , 'full' );
    $context['theme_logo_url'] = $theme_logo_url;
    // menu register & args
    $main_menu_args = array( 'depth' => 3 );
    $context['menu_main'] = new Timber\Menu( 'main_menu', $main_menu_args );
    $context['has_menu_main'] = has_nav_menu( 'main_menu' );
    $context['menu_mobile'] = new Timber\Menu( 'mobile_menu', $main_menu_args );
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

    // woo my account endpoints
    $context['dashboard_endpoint'] = wc_get_account_endpoint_url( 'dashboard' );
    $context['address_endpoint'] = wc_get_account_endpoint_url( 'edit-address' );
    $context['edit_endpoint'] = wc_get_account_endpoint_url( 'edit-account' );
    $context['payment_endpoint'] = wc_get_account_endpoint_url( 'payment-methods' );
    $context['lost_endpoint'] = wc_get_account_endpoint_url( 'lost-password' );
    $context['orders_endpoint'] = wc_get_account_endpoint_url( 'orders' );
    $context['logout_endpoint'] = wc_get_account_endpoint_url( 'customer-logout' );
    //woo endpoints
    $context['shop_url'] = get_permalink(woocommerce_get_page_id('shop'));
    // the backend address
    $context['base_address'] = WC()->countries->get_base_address();
    $context['base_address_2'] = WC()->countries->get_base_address_2();
    $context['base_city'] = WC()->countries->get_base_city();
    $context['base_eircode'] = WC()->countries->get_base_postcode();
    $context['base_county'] = WC()->countries->get_base_state();
    $context['base_country'] = WC()->countries->get_base_country();
    // acf data globals
    $context['company_phone_number'] = get_field('company_phone_number', 'option');
    $context['facebook_link'] = get_field('facebook_link', 'option');
    $context['insta_link'] = get_field('facebook_link', 'option');
    $context['display_email'] = get_field('display_email', 'option');
    $context['above_footer_text'] = get_field('above_footer_text', 'option');
    $context['contact_page_link'] = get_field('contact_page_link', 'option');
    
    /* get acf options data */
    $context['options'] = get_fields('option');
    
    /* get pdf upload field - entry lists */
    // $file = get_field('pdf_upload');
    // $context['pdf_upload_url'] = $file['url'];
    
    // get the woo cart url
    global $woocommerce;
    $context['cart_url'] = $woocommerce->cart->get_cart_url();
    // return context
    return $context;    
  }
  
  public function theme_supports()
  {
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
    // stop the br tag madness in the content editor
    // remove_filter( 'the_content', 'wpautop' );
    // remove_filter( 'the_excerpt', 'wpautop' );
    load_theme_textdomain('cautious-octo-fiesta', get_template_directory() . '/languages');
  }
  
  public function cautious_octo_fiesta_enqueue_assets()
  {
    // theme base scripts
    wp_enqueue_script(
      'cautious-octo-fiesta',
      get_template_directory_uri() . '/assets/js/base.js',
      '',
      '',
      false
    );
    
    // enqueue wp jquery
    wp_enqueue_script( 'jquery' );
    
    // global (site wide) scripts; uses jquery
    wp_enqueue_script(
      'global',
      get_template_directory_uri() . '/assets/js/global.js',
      'jquery',
      '1.0.0',
      true
    );
    // localize theme scripts for ajax
    wp_localize_script(
      'global',
      'myAjax',
      array(
        'ajaxurl' => admin_url( 'admin-ajax.php')
      )
    );
    
    // theme base scripts
    wp_enqueue_script(
      'inf-scroll',
      get_template_directory_uri() . '/assets/js/lib/infinite-scroll.pkgd.min.js',
      '',
      '',
      false
    );
    
    // theme base scripts
    wp_enqueue_script(
      'theme-woo',
      get_template_directory_uri() . '/assets/js/woo.js',
      '',
      '',
      true
    );
    
    // theme base scripts
    // wp_enqueue_script(
    //   'theme-quickload',
    //   get_template_directory_uri() . '/assets/js/quickload.js',
    //   '',
    //   '',
    //   true
    // );
    
    // font awesome
    wp_enqueue_style(
      'fontawesome-theme',
      get_template_directory_uri() . '/assets/css/lib/all.min.css'
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
      'cautious-octo-fiesta-woo',
      get_template_directory_uri() . '/assets/css/woo.css'
    );
  }
  
  // public function cautious_octo_fiesta_custom_uikit_widgets_init()
  // {
  //   register_widget("Cautious_Octo_Fiesta_Custom_UIKIT_Widget_Class");
  // }

  public function add_to_twig($twig)
  {
    /* this is where you can add your own functions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    return $twig;
  }
  
}

new CautiousOctoFiesta();
