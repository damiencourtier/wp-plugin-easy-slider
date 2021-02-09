<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Slider
 * @subpackage Easy_Slider/admin
 * @author     Damien Courtier <email@example.com>
 */
class Easy_Slider_Admin{

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
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_text_domain    The text domain of this plugin.
     */
    private $plugin_text_domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name          = $plugin_name;
		$this->version              = $version;
        $this->plugin_text_domain   = $plugin_text_domain;
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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        // Style only for plugin page
        if ( strpos(get_current_screen()->base, 'easy-slider') !== false) {
           wp_enqueue_style('bootstrap-min', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
           wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-slider-admin.css', array(), $this->version, 'all' );
        }


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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        // Script only for plugin page
        if ( strpos(get_current_screen()->base, 'easy-slider') !== false) {
            wp_enqueue_script('bootstrap-min', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, true);
        }
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-slider-admin.js', array( 'jquery' ), $this->version, true );
        $params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
        wp_localize_script( $this->plugin_name, 'params', $params );
    }

    /**
     * Callback for the admin menu
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {
        add_menu_page(	__( 'Easy Slider', $this->plugin_text_domain ), //page title
            __( 'Easy Slider', $this->plugin_text_domain ), //menu title
            'manage_options', //capability
            $this->plugin_name, //menu_slug
            '',
        'dashicons-format-gallery'
        );

        // Add a submenu page and save the returned hook suffix.
        $html_form_page_hook = add_submenu_page(
            $this->plugin_name, //parent slug
            __( 'Easy Slider', $this->plugin_text_domain ), //page title
            __( 'Tous les sliders', $this->plugin_text_domain ), //menu title
            'manage_options', //capability
            $this->plugin_name, //menu_slug
            array( $this, 'slider_list_page_content' ) //callback for page content
        );

        // Add a submenu page and save the returned hook suffix.
        $slider_form_page_hook = add_submenu_page(
            $this->plugin_name, //parent slug
            __( 'Easy Slider', $this->plugin_text_domain ), //page title
            __( 'Ajouter', $this->plugin_text_domain ), //menu title
            'manage_options', //capability
            $this->plugin_name . '-form', //menu_slug
            array( $this, 'slider_form_page_content' ) //callback for page content
        );

        /*
         * The $page_hook_suffix can be combined with the load-($page_hook) action hook
         * https://codex.wordpress.org/Plugin_API/Action_Reference/load-(page)
         *
         * The callback below will be called when the respective page is loaded
         */
        add_action( 'load-'.$html_form_page_hook, array( $this, 'loaded_sliders_list_page' ) );
        add_action( 'load-'.$slider_form_page_hook, array( $this, 'loaded_slider_form_page' ) );
    }

    /**
	 * Callback for the add_submenu_page action hook
	 *
	 * The plugin's HTML form is loaded from here
	 *
	 * @since	1.0.0
	 */
    public function slider_list_page_content() {
        include_once( 'partials/sliders-list-view.php' );
    }

    /**
     * Callback for the add_submenu_page action hook
     *
     * The plugin's HTML Ajax is loaded from here
     *
     * @since	1.0.0
     */
    public function slider_form_page_content() {

        $this->new      = true;
        $this->index    = 0;
        $this->response = '';
        $this->params   = array();

        if(!empty($_GET['slider'])){
            $this->slider = Easy_Slider_Functions::getOneSlider($_GET['slider'],'id_slider');
            if($this->slider !== NULL){
                $this->params   = json_decode($this->slider->params);
                $this->items    = Easy_Slider_Functions::getItemsSlider($this->slider->id_slider);
                $this->index    = count($this->items);
                $this->new      = false;
            }
        }

        include_once( 'partials/slider-form-view.php' );
    }

    /**
     * Permet de supprimer un slider en ajax
     * @since	1.0.0
     */
    public function delete_slider(){

        if (isset($_POST['delete_slider_nonce']) && wp_verify_nonce($_POST['delete_slider_nonce'], 'delete_slider_nonce') && !empty($_POST['slider_id'])) {

            global $wpdb;

            $slider_id = sanitize_key($_POST['slider_id']);

            $wpdb->delete($wpdb->prefix . 'es_sliders', array('id_slider' => $slider_id));
            $wpdb->delete($wpdb->prefix . 'es_sliders_items', array('id_slider' => $slider_id));

            $response = '<div class="alert alert-success" role="alert" style="display: none;">Le slider a bien été supprimé !</div>';

            header('Content-Type: application/json');
            echo json_encode(array('response' => $response));
            wp_die();

        }else{
            wp_die( __( 'Invalid', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,
            ) );
        }
    }

    /**
     * Permet de créer ou de mettre à jour un slider
     * @since    1.0.0
     */
    public function slider_form_response()
    {
        if (isset($_POST['slider_nonce']) && wp_verify_nonce($_POST['slider_nonce'], 'easy_slider_form_nonce')) {

            global $wpdb;
            $new = true;
            $params = array();

            // POST
            $title                          = sanitize_text_field( $_POST[$this->plugin_name]['title'] );
            $slides                         = $_POST[$this->plugin_name]['slides'];
            $params['slideshowSpeed']       = ( empty( $_POST[$this->plugin_name]['slideshowSpeed'] ) ? '' : absint( $_POST[$this->plugin_name]['slideshowSpeed'] ) );
            $params['animationSpeed']       = ( empty( $_POST[$this->plugin_name]['animationSpeed'] ) ? '' : absint( $_POST[$this->plugin_name]['animationSpeed'] ) );
            $params['directionNav']         = ( isset( $_POST[$this->plugin_name]['directionNav'] ) ? 1 : 0 );
            $params['slideshow']            = ( isset( $_POST[$this->plugin_name]['slideshow'] ) ? 1 : 0 );
            $params['randomize']            = ( isset( $_POST[$this->plugin_name]['randomize'] ) ? 1 : 0 );
            $params['controlNavThumbnail']  = ( isset( $_POST[$this->plugin_name]['controlNavThumbnail'] ) ? 1 : 0 );

            if($params['controlNavThumbnail']){

                $params['controlNav']           = 0;
                $params['maxItems']             = 1;
                $params['itemWidth']            = '';
                $params['maxItemsThumbnail']    = absint( ( $_POST[$this->plugin_name]['maxItemsThumbnail'] <= 10 ? $_POST[$this->plugin_name]['maxItemsThumbnail'] : 10 ) );

            }else{
                $params['controlNav']           = ( isset( $_POST[$this->plugin_name]['controlNav'] ) ? 1 : 0 );
                $params['maxItems']             = absint( ( $_POST[$this->plugin_name]['maxItems'] <= 10 ? $_POST[$this->plugin_name]['maxItems'] : 10 ) );
                $params['itemWidth']            = ( empty( $_POST[$this->plugin_name]['itemWidth'] ) ? '' : absint( $_POST[$this->plugin_name]['itemWidth'] ) );
                $params['maxItemsThumbnail']    = 1;
            }

            // Update
            if(!empty($_POST['slider_id']) && Easy_Slider_Functions::getOneSlider($_POST['slider_id'],'id_slider') != NULL){

                $slug = Easy_Slider_Functions::generateSlug($title,false,$_POST['slider_id']);

                $data = array(
                    'title'         => $title,
                    'slug'          => $slug,
                    'params'        => json_encode($params),
                    'updated_at'    => date('Y-m-d H:i:s')
                );

                // Update slider
                $wpdb->update($wpdb->prefix . 'es_sliders', $data, array('id_slider' => $_POST['slider_id']));

                // Delete Items
                $wpdb->delete($wpdb->prefix . 'es_sliders_items',array('id_slider' => $_POST['slider_id']));

                $slider_id   = $_POST['slider_id'];
                $message    = 'Le slider a bien été modifié !';
            }
            // Create
            else{

                $slug = Easy_Slider_Functions::generateSlug($title);

                $data = array(
                    'title'         => $title,
                    'slug'          => $slug,
                    'params'        => json_encode($params),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => NULL
                );

                $wpdb->insert($wpdb->prefix.'es_sliders',$data);

                $slider_id   = $wpdb->insert_id;
                $message    = 'Le slider a bien été créé !';
            }

            // Slider Item
            $i = 1;
            foreach ($slides as $key => $item) {
                if(!empty($item)) {
                    $data = array(
                        'id_slider'     => $slider_id,
                        'post_id'       => (int) $item,
                        'order_item'    => (int) $key,
                        'created_at'    => date('Y-m-d H:i:s'),
                    );
                    $wpdb->insert($wpdb->prefix . 'es_sliders_items', $data);

                    if($i == 10) { // Limit à 10 slides
                        break;
                    }
                    $i++;
                }
            }

            // Confirmation message
            $response = '<div class="alert alert-success" role="alert" style="display: none;">'.$message.'</div>';

            header('Content-Type: application/json');
            echo json_encode(array('response' => $response,'slider_id' => $slider_id));
            wp_die();
        }
        else {
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,
            ) );
        }
    }

    /*
     * Callback for the load-($sliders_list_page_hook)
     * Called when the plugin's submenu HTML form page is loaded
     *
     * @since	1.0.0
     */
    public function loaded_sliders_list_page() {
        // called when the particular page is loaded.
    }

    /*
     * Callback for the load-($slider_form_page_hook)
     * Called when the plugin's submenu HTML form page is loaded
     *
     * @since	1.0.0
     */
    public function loaded_slider_form_page() {
        // called when the particular page is loaded.
    }

}
