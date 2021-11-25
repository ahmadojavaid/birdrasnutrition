<?php

function madang_shortcode_menufeatured( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "show_header" => '',
        "class" => '',
        "text" => ''
    ), $atts );

    ob_start();
    ?> 
    <!-- ============== featured menu block starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> featured-menu-block">
        <?php if ( 'true' == $atts['show_header'] ) : ?>
        <div class="container">
            <!-- == top text header starts == -->
            <div class="wow fadeInUp top-text-header text-center">
                <h4 class="text-uppercase text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h4>
            </div>
            <!-- == top text header ends == -->
        </div>
        <?php endif; ?>
        <!-- == featured menu slider starts == -->
        <div class="wow fadeInUp featured-menu-slider">
            <div class="container">
                <ul class="bxslider1 row">
                    <?php echo madang_fix_shortcode($content); ?>  
                </ul>
            </div>
        </div>
        <!-- == featured menu slider ends == -->
    </section>
    <!-- ============== featured menu block ends ============== -->
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_menufeatured_item( $atts, $content = null ) {
    $atts = shortcode_atts(array(
         "type" => '',
         "class" => '',
         "title" => '',
         "image" => '',
         "title" => '',
         "text" => '',
         "button_text" => '',
         "link" => '',
         ), $atts);
         
        ob_start();
        ?>
        <li class="col-xs-12 col-sm-3">
            <a href="<?php echo esc_url( $atts['link'] ); ?>" class="bghcolor">
                <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
                <div class="menu-info">
                    <h6 class="text-capitalize text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h6>
                    <span><?php echo esc_attr( $atts['text'] ); ?></span>
                </div>
            </a>
        </li>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
}
