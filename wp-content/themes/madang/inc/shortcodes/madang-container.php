<?php

function madang_shortcode_container( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "class" => ''
    ), $atts );

    ob_start();
    ?> 

    <div class="<?php echo esc_attr( $atts['class'] ); ?>">
        <?php echo madang_fix_shortcode($content); ?>      
    </div>

    <?php

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}