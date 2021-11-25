<?php 
$image_url = "";
if ( $instance['image'] != '' ){
    $image_url = wp_get_attachment_image_src($instance['image'],"full",false);
}
$source_url = "";
if ( $instance['source'] != '' ){
    $source_url = wp_get_attachment_url($instance['source']);
}

$instance['icon'] = 'play-btn.svg';
echo do_shortcode( '[madang_video type="nopopup" title="'.$instance['title'].'" icon="'.$instance['icon'].'" url="'.$instance['url'].'" source="'.$source_url.'"  image="'.$image_url[0].'" ]' ); ?>