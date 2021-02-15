<?php

/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 *
 * @package    Easy_Slider
 * @subpackage Easy_Slider/includes
 * @author     Damien Courtier
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Easy_Slider
 * @subpackage Easy_Slider/includes
 * @author     Damien Courtier <email@example.com>
 */
class Easy_Slyder_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        $min_php = '5.6.0';

        // Check PHP Version and deactivate & die if it doesn't meet minimum requirements.
        if ( version_compare( PHP_VERSION, $min_php, '<' ) ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( 'This plugin requires a minmum PHP Version of ' . $min_php );
        }

        global $wpdb;
        $easy_slider_db_version = '1.0';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE ".$wpdb->prefix."es_sliders ( `id_slider` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `slug` VARCHAR(255) NOT NULL , `params` TEXT NOT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NULL , PRIMARY KEY (`id_slider`), UNIQUE `slug` (`slug`)) $charset_collate;";
        $sql .= "CREATE TABLE ".$wpdb->prefix."es_sliders_items ( `id_item` INT NOT NULL AUTO_INCREMENT , `id_slider` INT NOT NULL , `post_id` INT NOT NULL , `order_item` INT NOT NULL , `created_at` DATETIME NOT NULL , PRIMARY KEY (`id_item`), INDEX `id_slider` (`id_slider`)) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        add_option( 'easy_slider_db_version', $easy_slider_db_version );

	}

}
