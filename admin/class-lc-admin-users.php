<?php
class LC_Admin_User {
    public function __construct() {
        add_action('current_screen', array($this, 'redirect_user_once_subscribed') );
        add_action('wp_dashboard_setup', array($this,'remove_dashboard_boxes'), 9999 );
        add_action('admin_bar_menu', array($this,'clear_admin_bar'), 999 );
        add_action('admin_bar_menu', array($this,'remove_from_admin_bar'), 999);
        add_filter('login_redirect', array($this,'redirect_client_on_login'));

        add_filter('wu_signup_payment_step_text', array($this,'wu_signup_payment_step_text'));
        add_filter('wu_signup_payment_step_title', array($this,'wu_signup_payment_step_title'));

        add_filter('wpcfto_options_page_setup',array($this, 'stm_lms_settings'), 10 , 1);
        add_filter('wpcfto_enable_export_import',array($this, 'stm_lms_settings'), 10 , 1);
        
    }

    public function redirect_user_once_subscribed() {
        $currentScreen = get_current_screen();
        if( ! is_super_admin() && (($currentScreen->id == 'toplevel_page_wu-my-account' && isset($_GET['action']) && $_GET['action'] == 'success') || ($currentScreen->id == 'dashboard' && empty($_GET)) ) ){
            header('Location:'.get_home_url().'/user-account/');
            exit;
        }
    }
    
    public function remove_dashboard_boxes(){
        global $wp_meta_boxes;
        $wp_meta_boxes['dashboard']['normal']['core'] = array();
        $wp_meta_boxes['dashboard']['side']['core'] = array();
    }

    public function redirect_client_on_login() {
        return get_current_blog_id() > 1 ? '/user-account/' :  '/';
    }
    
    public function clear_admin_bar( $wp_admin_bar ) {
        $all_toolbar_nodes = $wp_admin_bar->get_nodes();
        //pre($all_toolbar_nodes);

        // Create an array of node ID's we'd like to remove
        $clear_titles = array(
            'my-sites',
            'about',
        );
        
        foreach ( $all_toolbar_nodes as $key => $node ) {
        
            // Run an if check to see if a node is in the array to clear_titles
            if ( in_array($node->id, $clear_titles) && in_array($node->parent, $clear_titles)    ) {
                // unset($all_toolbar_nodes[$key]);
            }
        }
    }
    
    
    public function remove_from_admin_bar($wp_admin_bar) {
        if ( ! is_super_admin()  ) {
            $wp_admin_bar->remove_node('si_menu');
            $wp_admin_bar->remove_node('updates');
            $wp_admin_bar->remove_node('comments');
            $wp_admin_bar->remove_node('new-content');
            $wp_admin_bar->remove_node('wp-logo');
            $wp_admin_bar->remove_node('my-sites');
            $wp_admin_bar->remove_node('about');
        }
        
        $nodes = $wp_admin_bar->get_nodes();
        if(isset($nodes['stm_lms_settings'])){
                $lms_menu = $nodes['stm_lms_settings'];
                $lms_menu->title    = 'LearnCity LMS';
                $lms_menu->id       = 'lc_lms';
                $wp_admin_bar->add_node($lms_menu);
    
                foreach($nodes as $key => $node ){
                    if($node->parent == 'stm_lms_settings' ){
                        $wp_admin_bar->add_node($node);
                        $node->parent = 'lc_lms';
                        $wp_admin_bar->add_node($node);                        
                    }
                }
                
        }
        $wp_admin_bar->remove_node('stm_lms_settings');
    }

    public function wu_signup_payment_step_text($text){
        return __('the new wu_signup_payment_step_text message','lc');
    }

    public function wu_signup_payment_step_title($text){
        return __('the new wu_signup_payment_step_title message','lc');
    }
    
    public function stm_lms_settings($setups){
        $setups = array();
        $setups[] = array(
            'option_name' => 'stm_lms_settings',
            'title' => esc_html__('LMS settings', 'masterstudy-lms-learning-management-system'),
            'logo' => LC_URL .'admin/images/icon1.png',
            'sub_title' => esc_html__('', 'masterstudy-lms-learning-management-system'),
            'admin_bar_title' => esc_html__('LMS Options', 'masterstudy-lms-learning-management-system'),
            'page' => array(
                'page_title' => 'LMS Settings',
                'menu_title' => 'STM LMS',
                'menu_slug' => 'stm-lms-settings',
                'icon' => 'dashicons-welcome-learn-more',
                'position' => 5,
            ),
            'fields' => array(
                'section_1' => stm_lms_settings_general_section(),
                'section_2' => stm_lms_settings_courses_section(),
                'section_course' => stm_lms_settings_course_section(),
                'section_quiz' => stm_lms_settings_quiz_section(),
                'section_routes' => stm_lms_settings_route_section(),
                'section_3' => stm_lms_settings_payments_section(),
                'section_5' => stm_lms_settings_google_api_section(),
                'section_4' => stm_lms_settings_profiles_section(),
                'section_6' => stm_lms_settings_certificates_section(),
                //'addons' => stm_lms_settings_addons_section(),
                'payout' => stm_lms_settings_payout_section(),
                'gdpr' => stm_lms_settings_gdpr_section(),
                'stm_lms_shortcodes' => stm_lms_settings_shortcodes_section(),
            )
        );

        return $setups;
    }

    public function wpcfto_enable_export_import($sections){
        $sections['wpcfto_import_export'] = array();
        return $sections;
    }

}