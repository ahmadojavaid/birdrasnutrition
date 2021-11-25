<?php

function madang_shortcode_map( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type"  => '',
        "url"   => '',
        "button_url" => '',
        "class" => ''
    ), $atts );

    ob_start();
    ?> 
    <!-- ============== Map block starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> map-block">
        <div class="container">
            <div class="map-wrap">
                <iframe src="<?php echo esc_url( $atts['url'] ); ?>" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </section>
    <!-- ============== Map block ends ============== -->
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}