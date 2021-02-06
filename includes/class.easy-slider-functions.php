<?php

class Easy_Slider_Functions{

    /**
     * Permet d'avoir la liste des sliders
     * @return array|object|null
     */
    public static function getSlidersList(){
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "es_sliders ORDER BY created_at DESC");
    }

    /**
     * Permet de récupérer un slider (sans les items)
     * @param $slug
     * @param $key
     * @return array|object|void|null
     */
    public static function getOneSlider($slug,$key){
        global $wpdb;
        return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "es_sliders WHERE ".esc_sql($key)." = '".esc_sql($slug)."'");
    }

    /**
     * Permet de récupérer les items d'un slider
     * @param $slider_id
     * @return array|object
     */
    public static function getItemsSlider($slider_id){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "es_sliders_items WHERE id_slider = ".esc_sql($slider_id)." ORDER BY order_item ASC");
        return ($result === NUlL?[]:$result);
    }

    /**
     * Permet de récupérer les items d'un slider avec le slug
     * @param $slider_id
     * @return array|object
     */
    public static function getItemsSliderBySlug($slug){
        global $wpdb;
        $result = $wpdb->get_results("SELECT si.* FROM " . $wpdb->prefix . "es_sliders_items si LEFT JOIN " . $wpdb->prefix . "es_sliders s ON si.id_slider = s.id_slider WHERE s.slug = '".esc_sql(sanitize_key($slug))."' ORDER BY si.order_item ASC");
        return ($result === NUlL?[]:$result);
    }

    /**
     * Permet de récupérer tous les sliders
     * @return array|object
     */
    public static function getAllSliders(){
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "es_sliders");
        return ($result === NUlL?[]:$result);
    }

    //public static function getFullSLiderBySlug

    /**
     * Permet de générer un slug unique pour un slider
     * @param $slug
     * @param bool $new
     * @param null $slider_id
     * @param int $index
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