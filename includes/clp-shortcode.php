<?php
class clp_shortcodes
{
    /**
     * Registers our plugin with WordPress.
     */
    public static function register()
    {
        $postTypeCls = new self();


        add_shortcode('coin-launcher-pro-frontend-form', array($postTypeCls, 'clp_do_frontend_form_submission_shortcode'));

      
       

    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Setup your plugin object here
    }
    


    public function clp_do_frontend_form_submission_shortcode($atts = array())
    {
        wp_enqueue_style('clp-frontend-form-css', SFDTP_URL . 'assets/css/clp-frontend-form.css', array(), SFDTP_VERSION);
        wp_enqueue_script(
            'cmb2-front-conditional',
            SFDTP_URL . 'assets/js/cmb2-front-conditional.js',
            array('jquery', 'cmb2-scripts'),
            null,
            true
        );
        // Current user
        $user_id = get_current_user_id();
        // Use ID of metabox in wds_frontend_form_register
        $metabox_id = 'front-end-post-form';

        $object_id = "clp_object_" . rand();
       // $iddd=wp_insert_term('New Listed', 'category');


        // since post ID will not exist yet, just need to pass it something
        $new_listed=get_cat_ID('New Coins Listings');
      
         if($new_listed==0){
            wp_insert_term('New Coins Listings', 'category');
            $new_listed = get_cat_ID('New Coins Listings');

        } 
        // Get CMB2 metabox object
        $cmb = cmb2_get_metabox($metabox_id, $object_id);

        // Get $cmb object_types
        $post_types = $cmb->prop('object_types');

        // Parse attributes. These shortcode attributes can be optionally overridden.
        $atts = shortcode_atts(array(
            'post_author' => $user_id ? $user_id : 1, // Current user, or admin
            'post_status' => 'pending',
            'post_type' => reset($post_types), // Only use first object_type in array
            'post_category' => array($new_listed)
        ), $atts, 'cmb-frontend-form');

        // Initiate our output variable
        $output = '<div class="clp_front_end_form_wrap">';
        $new_id = $this->clp_handle_frontend_new_post_form_submission($cmb, $atts, $user_id);

        if ($new_id) {

            if (is_wp_error($new_id)) {

                // If there was an error with the submission, add it to our ouput.
                $output .= '<h3>' . sprintf(__('There was an error in the submission: %s', 'clp'), '<strong>' . $new_id->get_error_message() . '</strong>') . '</h3>';

            } else {

                // Get submitter's name
                $name = isset($_POST['submitted_author_name']) && $_POST['submitted_author_name']
                ? ' ' . $_POST['submitted_author_name']
                : '';

                // Add notice of submission
                $output .= '<h3>' . sprintf(__('Thank you %s, your new coin has been submitted and is pending review by a site administrator.', 'clp'), esc_html($name)) . '</h3>';
            }
        }

        $output .= cmb2_get_metabox_form($cmb, $object_id, array('save_button' => __('Submit Coin', 'clp')));
        $output .= "</div>";
        // Our CMB2 form stuff goes here

        return $output;
    }

    public function clp_handle_frontend_new_post_form_submission($cmb, $post_data = array(), $user_id = null)
    {

        if ($user_id == null) {
            return;
        }

        // If no form submission, bail
        if (empty($_POST)) {
            return false;
        }

        // check required $_POST variables and security nonce
        if (
            !isset($_POST['submit-cmb'], $_POST['object_id'], $_POST[$cmb->nonce()])
            || !wp_verify_nonce($_POST[$cmb->nonce()], $cmb->nonce())
        ) {
            return new WP_Error('security_fail', __('Security check failed.'));
        }

        // Do WordPress insert_post stuff
        // Fetch sanitized values
        $sanitized_values = $cmb->get_sanitized_values($_POST);
        $user_meta = get_user_meta($user_id, 'user_meta_object');

        if (isset($user_meta[0]) && $user_meta[0] == $_POST['object_id']) {
            return;
        }
        $post_data['post_title'] = $_POST['clp_coin_name'];
        // Create the new post
        $new_submission_id = wp_insert_post($post_data, true);
        update_user_meta($user_id, 'user_meta_object', $_POST['object_id']);
        // If we hit a snag, update the user
        if (is_wp_error($new_submission_id)) {
            return $new_submission_id;
        }

        foreach ($sanitized_values as $key => $value) {
            update_post_meta($new_submission_id, $key, $value);
        }
        return $new_submission_id;
    }
}
clp_shortcodes::register();