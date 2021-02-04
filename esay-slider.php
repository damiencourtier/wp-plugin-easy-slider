<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Easy_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Slider
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Damien Courtier
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-slider
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'PLUGIN_NAME', 'easy-slider' );
define( 'PLUGIN_VERSION', '1.0.0' );
define( 'PLUGIN_TEXT_DOMAIN', 'easy-slider' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate_easy_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class.easy-slider-activator.php';
	Easy_Slider_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate_easy_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class.easy-slider-deactivator.php';
    Easy_Slider_Deactivator::deactivate();
}

/**
 * The code that runs during plugin uninstall.
 * This action is documented in includes/class-uninstall.php
 */
function uninstall_easy_slider() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class.easy-slider-uninstall.php';
    Easy_Slider_Deactivator::uninstall();
}

register_activation_hook( __FILE__, 'activate_easy_slider' );
register_deactivation_hook( __FILE__, 'deactivate_easy_slider' );
register_uninstall_hook( __FILE__, 'uninstall_easy_slider' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class.easy-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easy_slider() {

	$plugin = new Easy_Slider();
	$plugin->run();

}

$min_php = '5.6.0';

// Check the minimum required PHP version and run the plugin.
if ( version_compare( PHP_VERSION, $min_php, '>=' ) ) {
    run_easy_slider();
}
