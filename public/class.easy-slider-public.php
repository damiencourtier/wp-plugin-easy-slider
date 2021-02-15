<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 *
 * @package    Easy_Slider
 * @subpackage Easy_Slider/public
 * @since    1.0.0
 * @author     Damien Courtier
 */
class Easy_Slider_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

        wp_enqueue_style( 'flexslider', plugin_dir_url( __FILE__ ) . 'css/flexslider.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-slider-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        wp_enqueue_script( 'jquery-flexslider-min', plugin_dir_url( __FILE__ ) . 'js/jquery.flexslider-min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-slider-public.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * Shortcode content
     * @param $atts
     *
     * @since 1.0.0
     * @return string
     */
    public function shortcode_content($atts){

        $atts = shortcode_atts(array('name' => null), $atts);

        if($atts['name'] == null){
            return '';
        }

        $slider = Easy_Slider_Functions::getOneSlider($atts['name'],'slug');

        if(!$slider){
            return '';
        }

        $params = json_decode($slider->params);
        $slides = Easy_Slider_Functions::getItemsSliderBySlug($atts['name']);

        if($params->controlNavThumbnail == 1){
            return Easy_Slider_Flexslider::sliderWithThumbnail($atts['name'], $slides, $params);
        }else{
            return Easy_Slider_Flexslider::basicSlider($atts['name'], $slides, $params);
        }

    }
}
