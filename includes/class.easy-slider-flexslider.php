<?php
class Easy_Slider_Flexslider{

    public static function basicSlider($slug, $items, $params){

        $content = '<div class="'.$slug.' flexslider carousel"><ul class="slides">';

        foreach($items as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'full' ) ) {
                $content .= '<li><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        $content .= "
        <script>
            jQuery( window ).load(function() {
                jQuery('." . $slug . "').flexslider({
                    animation: 'slide',
                    smoothHeight: true,
                    animationLoop: true,
                    pauseOnAction:false,
                    animationSpeed: " . ( $params->animationSpeed ? $params->animationSpeed : 600 ) . ",
                    slideshowSpeed: " . ( $params->animationSpeed ? $params->slideshowSpeed : 7000) . ",
                    slideshow: " . ($params->slideshow?'true':'false') . ",
                    randomize: " . ($params->randomize?'true':'false') . ",
                    controlNav: " . ($params->controlNav?'true':'false') . ",
                    directionNav: " . ($params->directionNav?'true':'false') . ",
                    maxItems: $params->maxItems,
                    itemWidth: " . ( $params->itemWidth ? $params->itemWidth : 150 ) . ",
                });
            });
        </script>";

        return $content;
    }

    public static function sliderWithThumbnail($slug, $items, $params){

        $content = '<div id="slider-'.$slug.'" class="flexslider"><ul class="slides">';

        foreach($items as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'full' ) ) {
                $content .= '<li><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        $content .= '<div id="carousel-'.$slug.'" class="flexslider"><ul class="slides">';
        foreach($items as $item){
            if( $image = wp_get_attachment_image_src( $item->post_id, 'thumbnail' ) ) {
                $content .= '<li><img src="' . $image[0] . '" /></li>';
            }
        }
        $content .= '</ul></div>';

        $content .= "
        <script>
            jQuery( window ).load(function() {
                jQuery('#carousel-".$slug."').flexslider({
                    animation: 'slide',
                    animationLoop: true,
                    controlNav: false,
                    slideshow: false,
                    pauseOnAction:false,
                    itemWidth: 150,
                    itemMargin: 0,
                    maxItems: $params->maxItemsThumbnail,
                    directionNav : " . ($params->directionNav?'true':'false') . ",
                    asNavFor: '#slider-" . $slug . "'
                });

                jQuery('#slider-".$slug."').flexslider({
                    animation: 'slide',
                    animationLoop: true,
                    controlNav: false,
                    smoothHeight: true,
                    animationSpeed: " . ($params->animationSpeed?$params->animationSpeed:600) . ",
                    slideshowSpeed: " . ($params->slideshowSpeed?$params->slideshowSpeed:7000) . ",
                    slideshow: " . ($params->slideshow?'true':'false') . ",
                    directionNav: " . ($params->directionNav?'true':'false') . ",
                    sync: '#carousel-".$slug."'
                });
            });
        </script>";


        return $content;
    }
}