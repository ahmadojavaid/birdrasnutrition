<?php 
$image_url = "";
if ( $instance['partner1_img'] != '' ){
    $partner1_img = wp_get_attachment_image_src($instance['partner1_img'],"madang-gallery",false);
}
if ( $instance['partner3_img'] != '' ){
    $partner3_img = wp_get_attachment_image_src($instance['partner3_img'],"madang-gallery",false);
}
if ( $instance['partner2_img'] != '' ){
    $partner2_img = wp_get_attachment_image_src($instance['partner2_img'],"madang-gallery",false);
}
if ( $instance['partner4_img'] != '' ){
    $partner4_img = wp_get_attachment_image_src($instance['partner4_img'],"madang-gallery",false);
}

echo do_shortcode( '[madang_partner partner1_txt="'.$instance['partner1_txt'].'" partner2_txt="'.$instance['partner2_txt'].'" partner3_txt="'.$instance['partner3_txt'].'" partner4_txt="'.$instance['partner4_txt'].'" partner1_img="'.$partner1_img[0].'"  partner2_img="'.$partner2_img[0].'"  partner3_img="'.$partner3_img[0].'"  partner4_img="'.$partner4_img[0].'"  ]' ); ?>