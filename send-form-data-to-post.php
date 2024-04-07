<?php defined( 'ABSPATH' ) || exit;

/**
 * Creates a front-end form for adding and editing Posts using a shortcode.
 *
 * Plugin Name:		Snd form data to post
 * Description:		Creates a front-end form for adding and editing Posts using a shortcode.
 * Version:		1.0
 * Plugin URI:		https://github.com/toongeeprime/toongeeprime-frontend-post-form
 * Author:		ToongeePrime
 * Author URI:		https://github.com/toongeeprime/
 * Text Domain:		toongeeprime-frontend-post-form
 * Domain Path:		/languages/
 * Requires PHP:	7.0
 * Requires at least:	5.8
 * Tested up to:	6.5
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */


/**
 *		DEFINE PLUGIN ROOT DIR CONSTANT
 */

 define('SFDTP_VERSION', '1.0');
define('SFDTP_FILE', __FILE__);
define('SFDTP_PATH', plugin_dir_path(SFDTP_FILE));
define('SFDTP_URL', plugin_dir_url(SFDTP_FILE));
/*** Send_form_data_to_post main class by Test project.net */
if (!class_exists('Send_form_data_to_post')) {
    final class Send_form_data_to_post
    {

        /**
         * The unique instance of the plugin.
         *
         */
        private static $instance;

        /**
         * Gets an instance of our plugin.
         *
         */
        public static function get_instance()
        {
            if (null === self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor.
         */
        private function __construct()
        {

        }

        // register all hooks
        public function registers()
        {
            register_activation_hook( SFDTP_FILE , array( $this,'sfdtp_activate'));
            register_deactivation_hook( SFDTP_FILE, array( $this, 'clp_deactivate' ) );
            /*** Installation and uninstallation hooks */
          $this->clp_load_files();
           
            add_action('save_post_clp_coin_launcher',array(self::$instance, 'clp_save_post_callback'));
            
        }


        public function sfdtp_activate(){
          

        }

        public function clp_deactivate(){
    
        }

        public function clp_load_files(){

            require_once SFDTP_PATH . 'admin/cmb2/init.php';
            include_once SFDTP_PATH . 'admin/cmb2/cmb2-conditionals.php';
            include_once SFDTP_PATH . 'admin/cmb2/cmb-field-select2/cmb-field-select2.php';
            require_once SFDTP_PATH . 'admin/post-type/clp-post-type.php';
            require_once SFDTP_PATH . 'admin/settings/clp-post-settings.php';
            require_once SFDTP_PATH . 'admin/settings/clp-option-page.php';
            require_once SFDTP_PATH . 'admin/settings/clp-frontend-form-setting.php'; 
           
            require_once SFDTP_PATH . 'includes/clp-shortcode.php';
        }


        public function clp_save_post_callback($post_id){
            global $post;
            if($post != null){
            if($post->post_type){
                $listed = isset($_POST['clp_coingecko_listed']) ? $_POST['clp_coingecko_listed'] : "no";
                $id = isset($_POST['clp_coin_id']) ? $_POST['clp_coin_id'] : "bitcoin";
                if($listed == "yes"){
                    api_handler($id,'single');
                    $db = new clp_database();
                    $data = $db->get_data($id);
                    $price = isset($data[0]->price) ? (float)$data[0]->price : null;
                    $percent_change_24h = isset($data[0]->percent_change_24h) ? (float)$data[0]->percent_change_24h : null;
                    $market_cap = isset($data[0]->market_cap) ? (float)$data[0]->market_cap : null;
                    update_post_meta($post_id,'clp_mixed_price',$price);
                    update_post_meta($post_id,'clp_mixed_marketcap',$market_cap);
                    update_post_meta($post_id,'clp_mixed_changes',$percent_change_24h);
                    
                }else{
                    $price = isset($_POST['clp_coin_price']) ? (float)$_POST['clp_coin_price'] : null;
                    $market_cap = isset($_POST['clp_coin_marketcap']) ? (float)$_POST['clp_coin_marketcap'] : null;
                    $percent_change_24h = isset($_POST['clp_coin_changes']) ? (float)$_POST['clp_coin_changes'] : null;
                    update_post_meta($post_id,'clp_mixed_price',$price);
                    update_post_meta($post_id,'clp_mixed_marketcap',$market_cap);
                    update_post_meta($post_id,'clp_mixed_changes',$percent_change_24h);
                }
            }
        }
        }
    }
}
    /*** Send_form_data_to_post main class - END */

/*** THANKS - Test project.net ) */
$clp = Send_form_data_to_post::get_instance();
$clp->registers();