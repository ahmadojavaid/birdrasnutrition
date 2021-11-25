<?php 
$icon1 = $icon3 = $icon2 = $icon4 = "";
if ( $instance['icon1'] != '' ){
    $icon1 = wp_get_attachment_image_src($instance['icon1'],"madang-gallery",false);
}
if ( $instance['icon3'] != '' ){
    $icon3 = wp_get_attachment_image_src($instance['icon3'],"madang-gallery",false);
}
if ( $instance['icon2'] != '' ){
    $icon2 = wp_get_attachment_image_src($instance['icon2'],"madang-gallery",false);
}
if ( $instance['icon4'] != '' ){
    $icon4 = wp_get_attachment_image_src($instance['icon4'],"madang-gallery",false);
}

echo do_shortcode( '[madang_howitworks title="'.esc_attr($instance['title']).'" subtitle1="'.esc_attr($instance['subtitle1']).'" text1="'.esc_attr($instance['text1']).'" subtitle2="'.esc_attr($instance['subtitle2']).'" text2="'.esc_attr($instance['text2']).'" subtitle3="'.esc_attr($instance['subtitle3']).'" text3="'.esc_attr($instance['text3']).'" subtitle4="'.esc_attr($instance['subtitle4']).'" text4="'.esc_attr($instance['text4']).'" icon1="'.$icon1[0].'"  icon2="'.$icon2[0].'"  icon3="'.$icon3[0].'"  icon4="'.$icon4[0].'" ]' ); ?>