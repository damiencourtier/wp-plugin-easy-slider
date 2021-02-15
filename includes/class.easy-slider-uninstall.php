<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin uninstall.
 *
 * This class defines all code necessary to run during the plugin's uninstall.
 *
 * @since      1.0.0
 * @package    Easy_Slider
 * @subpackage Easy_Slider/includes
 * @author     Damien Courtier
 */
class Easy_Slyder_Uninstall {

    /**
     * Uninstall function delete two tables in db
     *
     * @since    1.0.0
     */
    public static function uninstall() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'es_sliders_items' );
        $wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'es_sliders' );
    }

}
