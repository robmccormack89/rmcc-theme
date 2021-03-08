<?php
/**
 * Timber theme class & other functions for Twig.
 *
 * @package Urban_Carnival_Theme
 */

// Define paths to Twig templates
Timber::$dirname = array(
  'views',
  'views/templates',
  'views/wp',
  'views/wp/archive',
  'views/wp/parts',
  'views/wp/parts/tease',
  'views/wp/parts/footer',
  'views/wp/parts/header',
  'views/wp/singular',
  'views/woo',
  'views/woo/parts',
  'views/woo/parts/tease',
);

// set the $autoescape value
Timber::$autoescape = false;

// Define Urban_Carnival_Theme Child Class
class UrbanCarnivalTheme extends Timber\Site
{
  public function __construct()
  {
    // timber stuff
    add_filter('timber_context', array( $this, 'add_to_context' ));
    add_filter('get_twig', array( $this, 'add_to_twig' ));
    add_filter( 'pre_get_posts', array($this, 'add_custom_types_to_tax') );
    add_action('after_setup_theme', array( $this, 'theme_supports' ));
    add_action('wp_enqueue_scripts', array( $this, 'urban_carnival_theme_enqueue_assets'));
    add_action('widgets_init', array( $this, 'urban_carnival_theme_custom_uikit_widgets_init'));
    add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
    add_filter( 'timber/context', array( $this, 'add_to_context' ) );
    add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
    add_filter( 'query_vars', array( $this, 'urban_carnival_theme_gridlist_query_vars_filter'));
    add_action( 'init', array( $this, 'register_post_types' ) );
    add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action('init', array( $this, 'register_widget_areas' ));
    add_action('init', array( $this, 'register_navigation_menus' ));
    parent::__construct();
  }
  
  // this makes custom taxonomy (status) work with archive.php->archive.twig templates with pre_get_post filter added to class construct above
  public function add_custom_types_to_tax( $query )
  {
    if( is_category() || is_tax('status') || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
      // Get all your post types
      $post_types = get_post_types();
      $query->set( 'post_type', $post_types );
      return $query;
    }
  }

  public function register_post_types()
  {
    $labels_winners = array(
      'name'                  => _x( 'Competition Winners', 'Post Type General Name', 'urban-carnival-theme' ),
  		'singular_name'         => _x( 'Competition Winner', 'Post Type Singular Name', 'urban-carnival-theme' ),
  		'menu_name'             => __( 'Competition Winners', 'urban-carnival-theme' ),
  		'name_admin_bar'        => __( 'Competition Winner', 'urban-carnival-theme' ),
  		'archives'              => __( 'Competition Winners', 'urban-carnival-theme' ),
  		'attributes'            => __( 'Winner Attributes', 'urban-carnival-theme' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'urban-carnival-theme' ),
  		'all_items'             => __( 'All Winners', 'urban-carnival-theme' ),
  		'add_new_item'          => __( 'Add New Winner', 'urban-carnival-theme' ),
  		'add_new'               => __( 'Add New', 'urban-carnival-theme' ),
  		'new_item'              => __( 'New Item', 'urban-carnival-theme' ),
  		'edit_item'             => __( 'Edit Item', 'urban-carnival-theme' ),
  		'update_item'           => __( 'Update Item', 'urban-carnival-theme' ),
  		'view_item'             => __( 'View Item', 'urban-carnival-theme' ),
  		'view_items'            => __( 'View Items', 'urban-carnival-theme' ),
  		'search_items'          => __( 'Search Item', 'urban-carnival-theme' ),
  		'not_found'             => __( 'Not found', 'urban-carnival-theme' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'urban-carnival-theme' ),
  		'featured_image'        => __( 'Featured Image', 'urban-carnival-theme' ),
  		'set_featured_image'    => __( 'Set featured image', 'urban-carnival-theme' ),
  		'remove_featured_image' => __( 'Remove featured image', 'urban-carnival-theme' ),
  		'use_featured_image'    => __( 'Use as featured image', 'urban-carnival-theme' ),
  		'insert_into_item'      => __( 'Insert into item', 'urban-carnival-theme' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'urban-carnival-theme' ),
  		'items_list'            => __( 'Items list', 'urban-carnival-theme' ),
  		'items_list_navigation' => __( 'Items list navigation', 'urban-carnival-theme' ),
  		'filter_items_list'     => __( 'Filter items list', 'urban-carnival-theme' ),
    );
  	$args_winners = array(
  		'label'                 => __( 'Winner', 'urban-carnival-theme' ),
  		'description'           => __( 'Winners content type', 'urban-carnival-theme' ),
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
  		'name'                  => _x( 'Entry Lists', 'Post Type General Name', 'urban-carnival-theme' ),
  		'singular_name'         => _x( 'Entry List', 'Post Type Singular Name', 'urban-carnival-theme' ),
  		'menu_name'             => __( 'Entry Lists', 'urban-carnival-theme' ),
  		'name_admin_bar'        => __( 'Entry List', 'urban-carnival-theme' ),
  		'archives'              => __( 'Entry Lists', 'urban-carnival-theme' ),
  		'attributes'            => __( 'Entry List Attributes', 'urban-carnival-theme' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'urban-carnival-theme' ),
  		'all_items'             => __( 'All Entry Lists', 'urban-carnival-theme' ),
  		'add_new_item'          => __( 'Add New Item', 'urban-carnival-theme' ),
  		'add_new'               => __( 'Add New', 'urban-carnival-theme' ),
  		'new_item'              => __( 'New Item', 'urban-carnival-theme' ),
  		'edit_item'             => __( 'Edit Item', 'urban-carnival-theme' ),
  		'update_item'           => __( 'Update Item', 'urban-carnival-theme' ),
  		'view_item'             => __( 'View Item', 'urban-carnival-theme' ),
  		'view_items'            => __( 'View Items', 'urban-carnival-theme' ),
  		'search_items'          => __( 'Search Item', 'urban-carnival-theme' ),
  		'not_found'             => __( 'Not found', 'urban-carnival-theme' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'urban-carnival-theme' ),
  		'featured_image'        => __( 'Featured Image', 'urban-carnival-theme' ),
  		'set_featured_image'    => __( 'Set featured image', 'urban-carnival-theme' ),
  		'remove_featured_image' => __( 'Remove featured image', 'urban-carnival-theme' ),
  		'use_featured_image'    => __( 'Use as featured image', 'urban-carnival-theme' ),
  		'insert_into_item'      => __( 'Insert into item', 'urban-carnival-theme' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'urban-carnival-theme' ),
  		'items_list'            => __( 'Items list', 'urban-carnival-theme' ),
  		'items_list_navigation' => __( 'Items list navigation', 'urban-carnival-theme' ),
  		'filter_items_list'     => __( 'Filter items list', 'urban-carnival-theme' ),
  	);
  	$args_lists = array(
  		'label'                 => __( 'Entry List', 'urban-carnival-theme' ),
  		'description'           => __( 'Entry List Description', 'urban-carnival-theme' ),
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
      
  	$labels_draws = array(
  		'name'                  => _x( 'Competition Draws', 'Post Type General Name', 'urban-carnival-theme' ),
  		'singular_name'         => _x( 'Competition Draw', 'Post Type Singular Name', 'urban-carnival-theme' ),
  		'menu_name'             => __( 'Competition Draws', 'urban-carnival-theme' ),
  		'name_admin_bar'        => __( 'Competition Draw', 'urban-carnival-theme' ),
  		'archives'              => __( 'Competition Draws', 'urban-carnival-theme' ),
  		'attributes'            => __( 'Competition Draw Attributes', 'urban-carnival-theme' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'urban-carnival-theme' ),
  		'all_items'             => __( 'All Live Draws', 'urban-carnival-theme' ),
  		'add_new_item'          => __( 'Add New Item', 'urban-carnival-theme' ),
  		'add_new'               => __( 'Add New', 'urban-carnival-theme' ),
  		'new_item'              => __( 'New Item', 'urban-carnival-theme' ),
  		'edit_item'             => __( 'Edit Item', 'urban-carnival-theme' ),
  		'update_item'           => __( 'Update Item', 'urban-carnival-theme' ),
  		'view_item'             => __( 'View Item', 'urban-carnival-theme' ),
  		'view_items'            => __( 'View Items', 'urban-carnival-theme' ),
  		'search_items'          => __( 'Search Item', 'urban-carnival-theme' ),
  		'not_found'             => __( 'Not found', 'urban-carnival-theme' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'urban-carnival-theme' ),
  		'featured_image'        => __( 'Featured Image', 'urban-carnival-theme' ),
  		'set_featured_image'    => __( 'Set featured image', 'urban-carnival-theme' ),
  		'remove_featured_image' => __( 'Remove featured image', 'urban-carnival-theme' ),
  		'use_featured_image'    => __( 'Use as featured image', 'urban-carnival-theme' ),
  		'insert_into_item'      => __( 'Insert into item', 'urban-carnival-theme' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'urban-carnival-theme' ),
  		'items_list'            => __( 'Items list', 'urban-carnival-theme' ),
  		'items_list_navigation' => __( 'Items list navigation', 'urban-carnival-theme' ),
  		'filter_items_list'     => __( 'Filter items list', 'urban-carnival-theme' ),
  	);
  	$args_draws = array(
  		'label'                 => __( 'Competition Draw', 'urban-carnival-theme' ),
  		'description'           => __( 'Competition Draws Description', 'urban-carnival-theme' ),
  		'labels'                => $labels_draws,
  		'supports'              => array( 'title', 'editor', 'custom-fields' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 5,
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => true,
  		'can_export'            => true,
  		'has_archive'           => 'competition-draws',
  		'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'query_var'             => true,
  		'capability_type'       => 'page',
  	);
  	register_post_type( 'live_draws', $args_draws );
    
    $labels_banner = array(
      'name'                  => _x( 'Banner Slides', 'Post Type General Name', 'urban-carnival-theme' ),
  		'singular_name'         => _x( 'Banner Slide', 'Post Type Singular Name', 'urban-carnival-theme' ),
  		'menu_name'             => __( 'Home Banner Slides', 'urban-carnival-theme' ),
  		'name_admin_bar'        => __( 'Banner Slide', 'urban-carnival-theme' ),
  		'archives'              => __( 'Banner Slide Archives', 'urban-carnival-theme' ),
  		'attributes'            => __( 'Item Attributes', 'urban-carnival-theme' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'urban-carnival-theme' ),
  		'all_items'             => __( 'All Slides', 'urban-carnival-theme' ),
  		'add_new_item'          => __( 'Add New Item', 'urban-carnival-theme' ),
  		'add_new'               => __( 'Add New', 'urban-carnival-theme' ),
  		'new_item'              => __( 'New Item', 'urban-carnival-theme' ),
  		'edit_item'             => __( 'Edit Item', 'urban-carnival-theme' ),
  		'update_item'           => __( 'Update Item', 'urban-carnival-theme' ),
  		'view_item'             => __( 'View Item', 'urban-carnival-theme' ),
  		'view_items'            => __( 'View Items', 'urban-carnival-theme' ),
  		'search_items'          => __( 'Search Item', 'urban-carnival-theme' ),
  		'not_found'             => __( 'Not found', 'urban-carnival-theme' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'urban-carnival-theme' ),
  		'featured_image'        => __( 'Featured Image', 'urban-carnival-theme' ),
  		'set_featured_image'    => __( 'Set featured image', 'urban-carnival-theme' ),
  		'remove_featured_image' => __( 'Remove featured image', 'urban-carnival-theme' ),
  		'use_featured_image'    => __( 'Use as featured image', 'urban-carnival-theme' ),
  		'insert_into_item'      => __( 'Insert into item', 'urban-carnival-theme' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'urban-carnival-theme' ),
  		'items_list'            => __( 'Items list', 'urban-carnival-theme' ),
  		'items_list_navigation' => __( 'Items list navigation', 'urban-carnival-theme' ),
  		'filter_items_list'     => __( 'Filter items list', 'urban-carnival-theme' ),
    );
    $args_banner = array(
      'label'                 => __( 'Banner Slide', 'urban-carnival-theme' ),
  		'description'           => __( 'Banner Slides for the Home Page Banner', 'urban-carnival-theme' ),
  		'labels'                => $labels_banner,
  		'supports'              => array( 'title', 'editor', 'thumbnail' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 2,
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => false,
  		'can_export'            => true,
  		'has_archive'           => false,
  		'exclude_from_search'   => true,
  		'publicly_queryable'    => false,
  		'capability_type'       => 'page',
  		'show_in_rest'          => false,
    );
  	register_post_type( 'slide', $args_banner );
    
    $labels_info = array(
      'name'                  => _x( 'Info Slides', 'Post Type General Name', 'urban-carnival-theme' ),
  		'singular_name'         => _x( 'Info Slide', 'Post Type Singular Name', 'urban-carnival-theme' ),
  		'menu_name'             => __( 'Home Info Slides', 'urban-carnival-theme' ),
  		'name_admin_bar'        => __( 'Info Slide', 'urban-carnival-theme' ),
  		'archives'              => __( 'Info Slides Archives', 'urban-carnival-theme' ),
  		'attributes'            => __( 'Item Attributes', 'urban-carnival-theme' ),
  		'parent_item_colon'     => __( 'Parent Item:', 'urban-carnival-theme' ),
  		'all_items'             => __( 'All Items', 'urban-carnival-theme' ),
  		'add_new_item'          => __( 'Add New Item', 'urban-carnival-theme' ),
  		'add_new'               => __( 'Add New', 'urban-carnival-theme' ),
  		'new_item'              => __( 'New Item', 'urban-carnival-theme' ),
  		'edit_item'             => __( 'Edit Item', 'urban-carnival-theme' ),
  		'update_item'           => __( 'Update Item', 'urban-carnival-theme' ),
  		'view_item'             => __( 'View Item', 'urban-carnival-theme' ),
  		'view_items'            => __( 'View Items', 'urban-carnival-theme' ),
  		'search_items'          => __( 'Search Item', 'urban-carnival-theme' ),
  		'not_found'             => __( 'Not found', 'urban-carnival-theme' ),
  		'not_found_in_trash'    => __( 'Not found in Trash', 'urban-carnival-theme' ),
  		'featured_image'        => __( 'Featured Image', 'urban-carnival-theme' ),
  		'set_featured_image'    => __( 'Set featured image', 'urban-carnival-theme' ),
  		'remove_featured_image' => __( 'Remove featured image', 'urban-carnival-theme' ),
  		'use_featured_image'    => __( 'Use as featured image', 'urban-carnival-theme' ),
  		'insert_into_item'      => __( 'Insert into item', 'urban-carnival-theme' ),
  		'uploaded_to_this_item' => __( 'Uploaded to this item', 'urban-carnival-theme' ),
  		'items_list'            => __( 'Items list', 'urban-carnival-theme' ),
  		'items_list_navigation' => __( 'Items list navigation', 'urban-carnival-theme' ),
  		'filter_items_list'     => __( 'Filter items list', 'urban-carnival-theme' ),
    );
    $args_info = array(
      'label'                 => __( 'Home Info Slide', 'urban-carnival-theme' ),
  		'description'           => __( 'Home Info Slides for Homepage (under banner)', 'urban-carnival-theme' ),
  		'labels'                => $labels_info,
  		'supports'              => array( 'title', 'editor' ),
  		'hierarchical'          => false,
  		'public'                => true,
  		'show_ui'               => true,
  		'show_in_menu'          => true,
  		'menu_position'         => 2,
  		'show_in_admin_bar'     => true,
  		'show_in_nav_menus'     => false,
  		'can_export'            => true,
  		'has_archive'           => false,
  		'exclude_from_search'   => true,
  		'publicly_queryable'    => false,
  		'capability_type'       => 'page',
  		'show_in_rest'          => false,
    );
  	register_post_type( 'info_slide', $args_info );
  }

  public function register_taxonomies()
  {
    $labels_status = array(
      'name'                       => _x( 'Draw Status', 'Taxonomy General Name', 'urban-carnival-theme' ),
      'singular_name'              => _x( 'Draw Status', 'Taxonomy Singular Name', 'urban-carnival-theme' ),
      'menu_name'                  => __( 'Draw Status', 'urban-carnival-theme' ),
      'all_items'                  => __( 'All Items', 'urban-carnival-theme' ),
      'parent_item'                => __( 'Parent Item', 'urban-carnival-theme' ),
      'parent_item_colon'          => __( 'Parent Item:', 'urban-carnival-theme' ),
      'new_item_name'              => __( 'New Item Name', 'urban-carnival-theme' ),
      'add_new_item'               => __( 'Add New Item', 'urban-carnival-theme' ),
      'edit_item'                  => __( 'Edit Item', 'urban-carnival-theme' ),
      'update_item'                => __( 'Update Item', 'urban-carnival-theme' ),
      'view_item'                  => __( 'View Item', 'urban-carnival-theme' ),
      'separate_items_with_commas' => __( 'Separate items with commas', 'urban-carnival-theme' ),
      'add_or_remove_items'        => __( 'Add or remove items', 'urban-carnival-theme' ),
      'choose_from_most_used'      => __( 'Choose from the most used', 'urban-carnival-theme' ),
      'popular_items'              => __( 'Popular Items', 'urban-carnival-theme' ),
      'search_items'               => __( 'Search Items', 'urban-carnival-theme' ),
      'not_found'                  => __( 'Not Found', 'urban-carnival-theme' ),
      'no_terms'                   => __( 'No items', 'urban-carnival-theme' ),
      'items_list'                 => __( 'Items list', 'urban-carnival-theme' ),
      'items_list_navigation'      => __( 'Items list navigation', 'urban-carnival-theme' ),
    );
    $rewrite_status = array(
      'slug'                       => 'competition-draws/status',
  		'with_front'                 => true,
  		'hierarchical'               => false,
    );
  	$args_status = array(
  		'labels'                     => $labels_status,
  		'hierarchical'               => true,
  		'public'                     => true,
  		'show_ui'                    => true,
  		'show_admin_column'          => true,
  		'show_in_nav_menus'          => true,
  		'show_tagcloud'              => false,
  		'rewrite'                    => $rewrite_status,
  	);
  	register_taxonomy( 'status', array( 'live_draws' ), $args_status );
  }

  public function register_widget_areas()
  {
    if (function_exists('register_sidebar')) {
      register_sidebar(array(
        'name' => esc_html__('Footer Left Area', 'urban-carnival-theme'),
        'id' => 'sidebar-footer-left',
        'description' => esc_html__('Main Footer Widget Area; works best with the current widget only.', 'urban-carnival-theme'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<span hidden>',
        'after_title' => '</span>'
      ));
    }
  }

  public function register_navigation_menus()
  {
    // This theme uses wp_nav_menu() in one locations.
    register_nav_menus(array(
      'categories' => __('Categories Menu', 'urban-carnival-theme'),
      'main_menu' => __('Main Menu', 'urban-carnival-theme'),
      'mobile_menu' => __('Mobile Menu', 'urban-carnival-theme'),
      'accessories_menu' => __('Accessories Menu', 'urban-carnival-theme'),
      'parts_menu' => __('Parts Menu', 'urban-carnival-theme'),
      'footer_nav_menu' => __('Footer Nav Menu', 'urban-carnival-theme'),
      'footer_customers_menu' => __('Footer Customers Menu', 'urban-carnival-theme'),
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
    $context['is_status'] = is_tax('status');
    /* check is post types */
    $context['is_posts'] = is_blog();
    $context['is_winners'] = is_post_type_archive( 'winners' );
    $context['is_entry_lists'] = is_post_type_archive( 'entry_lists' );
    $context['is_live_draws'] = is_post_type_archive( 'live_draws' );
    // get the wp logo
    $theme_logo_id = get_theme_mod( 'custom_logo' );
    $theme_logo_url = wp_get_attachment_image_url( $theme_logo_id , 'full' );
    $context['theme_logo_url'] = $theme_logo_url;
    // menu register & args
    $main_menu_args = array( 'depth' => 3 );
    $context['menu_cats'] = new \Timber\Menu( 'categories' );
    $context['has_menu_cats'] = has_nav_menu( 'categories' );
    $context['menu_main'] = new Timber\Menu( 'main_menu' );
    $context['has_menu_main'] = has_nav_menu( 'main_menu' );
    $context['menu_mobile'] = new Timber\Menu('mobile_menu');
    $context['has_menu_mobile'] = has_nav_menu( 'mobile_menu' );
    $context['footer_nav_menu'] = new Timber\Menu( 'footer_nav_menu' );
    $context['has_footer_nav_menu'] = has_nav_menu( 'footer_nav_menu' );
    $context['footer_customers_menu'] = new Timber\Menu( 'footer_customers_menu' );
    $context['has_footer_customers_menu'] = has_nav_menu( 'footer_customers_menu' );
    // sidebar areas
    $context['sidebar_footer_left'] = Timber::get_widgets('Footer Left Area');
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
    
    /* get acf options data */
    $context['options'] = get_fields('option');
    
    /* get pdf upload field - entry lists */
    $file = get_field('pdf_upload');
    $context['pdf_upload_url'] = $file['url'];
    
    // for disabling theme-preload on live_draws archive
    $context['overflow_class'] = 'no-overflow';
    if (is_tax('live_draws')) {
      $context['overflow_class'] = 'overflow-off';
    };
    
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
    // add custom thumbs sizes.
    add_image_size('sixstar-theme-featured-image-archive', 800, 300, true);
    add_image_size('sixstar-theme-featured-image-single-post', 1200, 450, true);
    add_image_size('sixstar-theme-product-main-image', 1200, 700, true);
    add_image_size('sixstar-theme-cart-image', 80, 80, true);
    // custom thumbnail sizes (new)
    add_image_size('urban-carnival-theme-featured-image-archive', 800, 300, true);
    add_image_size('urban-carnival-theme-featured-image-single-post', 1200, 450, true);
    add_image_size('urban-carnival-theme-product-main-image', 1200, 700, true);
    add_image_size('urban-carnival-theme-cart-image', 80, 80, true);
    // stop the br tag madness in the content editor
    // remove_filter( 'the_content', 'wpautop' );
    // remove_filter( 'the_excerpt', 'wpautop' );
  }
  
  // add grid-list url paramater key
  public function urban_carnival_theme_gridlist_query_vars_filter($vars)
  {
    $vars[] .= 'grid_list';
    return $vars;
  }
  
  public function urban_carnival_theme_enqueue_assets()
  {
    // theme base scripts
    wp_enqueue_script(
      'urban-carnival-theme',
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
      get_template_directory_uri() . '/assets/js/woo/woo.js',
      '',
      '',
      true
    );
    
    // theme base scripts
    wp_enqueue_script(
      'theme-quickload',
      get_template_directory_uri() . '/assets/js/quickload.js',
      '',
      '',
      true
    );
    
    wp_enqueue_style(
      'theme-google-fonts',
      'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap',
      false
    );
    
    // font awesome
    wp_enqueue_style(
      'fontawesome-theme',
      get_template_directory_uri() . '/assets/css/lib/all.min.css'
    );
    // theme base css
    wp_enqueue_style(
      'urban-carnival-theme',
      get_template_directory_uri() . '/assets/css/base.css'
    );
    // theme stylesheet
    wp_enqueue_style(
      'urban-carnival-theme-styles', get_stylesheet_uri()
    );
  }
  
  public function urban_carnival_theme_custom_uikit_widgets_init()
  {
    register_widget("Urban_Carnival_Theme_Custom_UIKIT_Widget_Class");
  }

  public function add_to_twig($twig)
  {
    /* this is where you can add your own functions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    return $twig;
  }
  
}

new UrbanCarnivalTheme();
