<?php 

$output = '';

$output .= '[madang_programselect_item id="c1" class="'.$instance['icon1'].'" select_program_categories="'.$instance['category1'].'" select_program_titles="'.$instance['title1'].'"   /]';
$output .= '[madang_programselect_item id="c2" class="'.$instance['icon2'].'" select_program_categories="'.$instance['category2'].'" select_program_titles="'.$instance['title2'].'"  /]';
$output .= '[madang_programselect_item id="c3" class="'.$instance['icon3'].'" select_program_categories="'.$instance['category3'].'" select_program_titles="'.$instance['title3'].'"  /]';

$image_url = "";
if ( $instance['image'] != '' ){
    $image_url = wp_get_attachment_image_src($instance['image'],"full",false);
}
$background_url = "";
if ( $instance['background'] != '' ){
    $background_url = wp_get_attachment_image_src($instance['background'],"full",false);
}
echo do_shortcode( '[madang_programselect class="'.$instance['class'].'" title="'.$instance['title'].'" subtitle="'.$instance['subtitle'].'" relation="'.$instance['relation'].'" button_text="'.$instance['button_text'].'" action="'.$instance['action'].'" background="'.$background_url[0].'" image="'.$image_url[0].'" ]'.$output.'[/madang_programselect]' );
