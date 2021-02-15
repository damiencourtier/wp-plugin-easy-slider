<?php

/**
 * Class Easy_Slider_Functions
 *
 * @since      1.0.0
 * @author     Damien Courtier
 */
class Easy_Slider_Functions{

    /**
     * Allows to have the sliders list
     *
     * @since 1.0.0
     * @return array|object|null
     */
    public static function getSlidersList(){
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "es_sliders ORDER BY created_at DESC");
    }

    /**
     * Allows to return a slider (without the slides)
     * @param $slug
     * @param $key
     *
     * @since 1.0.0
     * @return array|object|void|null
     */
    public static function getOneSlider($slug,$key){
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "es_sliders WHERE ".esc_sql($key)." = '".esc_sql($slug)."'");
    }

    /**
     * Allows to return the items of a slider
     * @param $slider_id
     *
     * @since 1.0.0
     * @return array|object
     */
    public static function getItemsSlider($slider_id){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "es_sliders_items WHERE id_slider = ".esc_sql($slider_id)." ORDER BY order_item ASC");
        return ($result === NUlL?[]:$result);
    }

    /**
     * Allows to return the items of a slider with the slug
     * @param $slider_id
     *
     * @since 1.0.0
     * @return array|object
     */
    public static function getItemsSliderBySlug($slug){
        global $wpdb;
        $result = $wpdb->get_results("SELECT si.* FROM " . $wpdb->prefix . "es_sliders_items si LEFT JOIN " . $wpdb->prefix . "es_sliders s ON si.id_slider = s.id_slider WHERE s.slug = '".esc_sql(sanitize_key($slug))."' ORDER BY si.order_item ASC");
        return ($result === NUlL?[]:$result);
    }

    /**
     * Allows to return all sliders
     *
     * @since 1.0.0
     * @return array|object
     */
    public static function getAllSliders(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "es_sliders");
        return ($result === NUlL?[]:$result);
    }

    /**
     * Allows to generate a unique slug for a slider
     * @param $slug
     * @param bool $new
     * @param null $slider_id
     * @param int $index
     *
     * @since 1.0.0
     * @return string
     */
    public static function generateSlug($slug , $new = true, $slider_id = null,$index = 0){
        global $wpdb;

        $slug   = sanitize_title($slug);
        $where  = '';

        if(!$new){
            $where = "AND id_slider != " . esc_sql($slider_id);
        }

        $result = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "es_sliders WHERE slug = '" . esc_sql($slug) . "' ".$where);
        if ($result) {
            $index++;
            $slug = $slug.'-'.$index;

            return self::generateSlug( $slug , $new , $slider_id , $index);
        }

        return $slug;
    }
}