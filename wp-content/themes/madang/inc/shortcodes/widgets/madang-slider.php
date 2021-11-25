<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$image_url = '';
		if ( $item['image'] != '' ){
		    $image_url = wp_get_attachment_image_src($item['image'], "full", false);
		}
		$output .= '[madang_slide type="'.$item['type'].'" title="'.$item['title'].'" subtitle="'.$item['subtitle'].'" text="'.$item['text'].'" image="'.$image_url[0].'" button_text="'.$item['button_text'].'" button_url="'.$item['button_url'].'"   ]';
	}
}
echo do_shortcode( '[madang_banner class="'.$instance['class'].'" type="home" ]'.$output.'[/madang_banner]' ); 
