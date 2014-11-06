<?php

/**
 * WP Quick Image
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://oikos.org.uk/wp-quick-image
 * @since             0.1.0
 * @package           WP_Quick_Image
 *
 * @wordpress-plugin
 * Plugin Name:       WP Quick Image
 * Plugin URI:        http://oikos.org.uk/wp-quick-image/
 * Description:       This plugin adds a WordPress Dashboard widget that allows you to quickly post an image.
 * Version:           0.1
 * Author:            Ross Wintle / Oikos
 * Author URI:        http://oikos.org.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-quick-image
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-quick-image-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-quick-image-deactivator.php';

/** This action is documented in includes/class-plugin-name-activator.php */
register_activation_hook( __FILE__, array( 'WP_Quick_Image_Activator', 'activate' ) );

/** This action is documented in includes/class-plugin-name-deactivator.php */
register_deactivation_hook( __FILE__, array( 'WP_Quick_Image_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-quick-image.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_wp_quick_image() {

	$plugin = new WP_Quick_Image();
	$plugin->run();

}
run_wp_quick_image();
