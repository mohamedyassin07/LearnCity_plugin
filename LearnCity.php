<?php
/**
 * @link              https://learncity.co.uk/
 * @since             1.0.0
 * @package           Lc
 *
 * @wordpress-plugin
 * Plugin Name:       LearnCity
 * Plugin URI:        https://learncity.co.uk/
 * Description:       A SaaS LMS Provider.
 * Version:           1.0.0
 * Author:            LearnCity Team
 * Author URI:        https://learncity.co.uk/
 * Text Domain:       lc
 * Domain Path:       /languages
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define PLugin Files.
 */
if ( ! defined( 'LC_FILES' ) ) {
	define( 'LC_FILES', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'LC_URL' ) ) {
	define( 'LC_URL', plugin_dir_url( __FILE__ ) );
}


/**
 * The code that runs during plugin activation.
 */
function activate_lc() {
	require_once LC_FILES . 'includes/class-lc-activator.php';
	Lc_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_lc() {
	require_once LC_FILES . 'includes/class-lc-deactivator.php';
	Lc_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lc' );
register_deactivation_hook( __FILE__, 'deactivate_lc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require LC_FILES . 'includes/class-lc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lc() {
	$plugin = new Lc();
	$plugin->run();
}
run_lc();