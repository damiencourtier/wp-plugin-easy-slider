<?php
class Easy_Slider_Flexslider{

    public static function basicSlider($slug,$slider){
        $content = '<div class="'.$slug.'"><ul class="slides">';

        foreach($slider as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'full' ) ) {
                $content .= '<li><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        ob_start();
        ?>
        <script>
            jQuery( window ).load(function() {
                jQuery('.<?=$slug?>').flexslider({
                    animation: "slide"
                });
            });
        </script>
        <?php
        $content .= ob_get_contents();
        ob_end_flush();

        return $content;
    }

    public static function sliderWithThumbail($slug,$slider){
        $content = '<div class="'.$slug.'"><ul class="slides">';

        foreach($slider as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'full' ) ) {
                $min = wp_get_attachment_image_src($item->post_id,'medium');
                $content .= '<li data-thumb="' . $min[0] . '" ><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        ob_start();
        ?>
        <script>
            jQuery( window ).load(function() {
                jQuery('.<?=$slug?>').flexslider({
                    animation: "slide",
                    controlNav: "thumbnails"
                });
            });
        </script>
        <?php
        $content .= ob_get_contents();
        ob_end_flush();

        return $content;
    }

    public static function sliderWithThumbailV2($slug,$slider){
        $content = '<div id="slider-'.$slug.'" class="flexslider"><ul class="slides">';

        foreach($slider as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'full' ) ) {
                $content .= '<li><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        $content .= '<div id="carousel-'.$slug.'" class="flexslider"><ul class="slides">';
        foreach($slider as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'thumbnail' ) ) {
                $content .= '<li><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        ob_start();
        ?>
        <script>
            jQuery( window ).load(function() {
                jQuery('#carousel-<?=$slug?>').flexslider({
                    animation: "slide",
                    controlNav: false,
                    animationLoop: true,
                    slideshow: false,
                    itemWidth: 150,
                    itemMargin: 0,
                    asNavFor: '#slider-<?=$slug?>'
                });

                jQuery('#slider-<?=$slug?>').flexslider({
                    animation: "slide",
                    controlNav: false,
                    animationLoop: true,
                    slideshow: true,
                    smoothHeight:true,
                    sync: '#carousel-<?=$slug?>'
                });
            });
        </script>
        <?php
        $content .= ob_get_contents();
        ob_end_flush();

        return $content;
    }
}