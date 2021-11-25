<?php

function madang_shortcode_button( $atts, $content=null ) {

    shortcode_atts( array(
        "type" => '',
        "class" => '',
        "size" => '',
        "button_text" => '',
        "button_url" => '',
        "partner1_img" => '',
        "partner2_img" => '',
        "partner3_img" => '',
        "partner4_img" => '',
        "partner1_txt" => '',
        "partner2_txt" => '',
        "partner3_txt" => '',
        "partner4_txt" => ''
    ), $atts );

    ob_start();
    ?> 

    <div class="<?php echo esc_attr( $atts['class'] ); ?>">
        <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn border-btn-x-big hvr-wobble-horizontal"><?php echo esc_attr( $atts['button_text'] ); ?></a>
    </div>
 
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}