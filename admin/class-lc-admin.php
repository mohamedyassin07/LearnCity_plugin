<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://learncity.co.uk/
 * @since      1.0.0
 *
 * @package    Lc
 * @subpackage Lc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lc
 * @subpackage Lc/admin
 * @author     LearnCity <m.yassin@learncity.co.uk>
 */

class Lc_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_classes();
	}

	public function load_classes(){
		$dir = LC_FILES.'admin/';
		
		include_once($dir.'class-lc-admin-users.php');
		new LC_Admin_User;

		 include_once($dir.'class-admin-dashboard-menu.php');
		 new LC_Admin_Dashboard_Menu;

		include_once($dir.'class-lc-BuddyPress.php');
		new LC_BuddyPress;


		//  just for debuging 
		include_once($dir.'class-debug.php');
		new LC_Admin_Debug;
	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lc-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lc-admin.js', array( 'jquery' ), $this->version, false );

	}

}