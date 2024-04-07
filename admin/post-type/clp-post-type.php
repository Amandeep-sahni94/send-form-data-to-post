<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    
    class clp_posttype
    {
        /**
         * Registers our plugin with WordPress.
         */
        public static function register()
    {
        $postTypeCls = new self();

        // register hooks
        add_action('init', array($postTypeCls, 'clp_custom_post_type'));   
    } 
      // Register Custom Coin
      public function clp_custom_post_type()
      {

        $post_slug = get_option( 'clp_options' );
        if(isset($post_slug['clp_slug_name']) && !empty($post_slug['clp_slug_name']) ){
            $post_slug = $post_slug['clp_slug_name'];
        }
          
            else  {
            $post_slug = 'clp_coin_launcher';
        }
          $labels = array(
              'name' => _x('Coins Launcher Pro', 'Post Type General Name', 'clp'),
              'singular_name' => _x('Coins Launcher Pro', 'Post Type Singular Name', 'clp'),
              'menu_name' => __('Coins Launcher Pro', 'clp'),
              'name_admin_bar' => __('Coins Launcher Pro', 'clp'),
              'parent_item_colon' => __('Parent Item:', 'clp'),
              'all_items' => __('All Coins', 'clp'),
              'add_new_item'          => __( 'Add New Coin', 'clp' ),
              'update_item' => __('Update Coin', 'clp'),
  
              'search_items' => __('Search Coin', 'clp'),
              'not_found' => __('Not found', 'clp'),
              'not_found_in_trash' => __('Not found in Trash', 'clp'),
          );
          $args = array(
              'label' => __('Coins Launcher Pro', 'clp'),
              'description' => __('Custom Coin Description', 'clp'),
              'labels' => $labels,
              'supports' => array('title'),
              'taxonomies' => array('category'),
              'hierarchical' => false,
              'public' => true,
              'show_ui' => true,
              'show_in_menu'  => true,
              'menu_position' => 5,
              'show_in_admin_bar' => false,
              'show_in_nav_menus' => false,
              'can_export' => true,
              'has_archive' => false,
              'exclude_from_search' => false,
              'show_in_rest' => true,
              'publicly_queryable' => true,
              'rewrite' => array('slug' => $post_slug ),
              'capability_type' => 'page',
               'menu_icon'=>'dashicons-chart-pie',
          );
          register_post_type('clp_coin_launcher', $args);
      }


      
}
clp_posttype::register();
