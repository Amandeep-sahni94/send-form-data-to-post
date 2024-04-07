<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * This snippet has been updated to reflect the official supporting of options pages by CMB2
 * in version 2.2.5.
 *
 * If you are using the old version of the options-page registration,
 * it is recommended you swtich to this method.
 */
add_action( 'cmb2_admin_init', 'clp_register_settings' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function clp_register_settings() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'clp_settings_page',
		'title'        => esc_html__('Settings', 'clp1'),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'clp_options', // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		 'menu_title'      => "Settings", // Falls back to 'title' (above).
		 'parent_slug'     => 'edit.php?post_type=clp_coin_launcher', // Make options page a submenu item of the themes menu.
		 'capability'      => 'manage_options', // Cap required to view options-page.
		 'position'        => 44, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Settings', 'celp1' ), // The text for the options-page save button. Defaults to 'Save'.
	) );

    $cmb_options->add_field(array(
		'name' => __('Coin Single Page Slug', 'clp1'),
		'desc' =>'',
		'id' =>'clp_slug_name',
		'type' => 'text',
		'desc'=>'<strong style="color:red">Save permalink once if coin single page did not work</strong>',
		'default' => 'clp_coin_launcher',
	));
    $cmb_options->add_field(array(
		'name' => __('Coin Login Page', 'clp1'),
		'desc' =>'',
		'id' =>'clp_login_page',
		'type' => 'text',
		'default' => 'wp-login.php',
		'desc'=>home_url( ).'/<strong style="color:red">wp-login</strong',
	));
	$cmb_options->add_field(array(
    'name' => __('Chart Theme', 'clp1'),
    'id' => 'clp_chart_theme',
    'type' => 'select',
    'options' => array(
        'light' => __('Light'),
        'dark' => __('Dark'),
       
    ),
    'default' => 'light',
));


	$cmb_options->add_field( array(
		'name' => '<b>'.__( 'Coin Launcher Main Shortcode', 'clp1' ).'</b>',
		'id'   => 'clp_main_shorcode',
		'type' => 'title',	
		'desc'=>'<code>[coin-launcher-pro listed="all" rows="10" orderby="clp_mixed_marketcap" asc="false" enable_filters="no" watchlist="false"]</code> <br> listed="yes/no/all/presale" asc="true/false" rows="{number}" enable_filters="yes/no" watchlist="true/false"<br>orderby="clp_mixed_marketcap/clp_coin_name/clp_coin_chain/clp_mixed_price/clp_mixed_changes/clp_coin_datetime_timestamp/clp_coin_votes_total/clp_coin_votes_today"',
	
		) );
	$cmb_options->add_field( array(
		'name' => '<b>'.__( 'Coin Launcher Frontend Form', 'clp1' ).'</b>',
		'id'   => 'clp_frontend_form_shorcode',
		'type' => 'title',
		'desc' => '<code>[coin-launcher-pro-frontend-form]</code>',
		
		) );

		$cmb_options->add_field(array(
    'name' => 'Search Bar Shortcode',
    'desc' => '<code>[coin-launcher-searchs]</code>',
    'type' => 'title',
    'id' => 'clp_search_shortcode',
));
$cmb_options->add_field(array(
    'name' => 'Coins Stats Shortcode',
    'desc' => '<code>[coin-launcher-stats]</code>',
    'type' => 'title',
    'id' => 'clp_stats_shortcode',
));


    }